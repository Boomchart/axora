<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;

class EditBalance extends Component
{
    public $client;
    public $admin;
    public $val;
    public $crypto_wallet_ft = 'both';
    public $crypto_wallet_pc;
    public $crypto_wallet_fc;
    public $crypto_wallet_range;
    public $crypto_wallet_fc_required;
    public $crypto_wallet_pc_required;
    public $crypto_wallet_agents;
    public $crypto_wallet_payout_ft = 'both';
    public $crypto_wallet_payout_pc;
    public $crypto_wallet_payout_fc;
    public $crypto_wallet_payout_range;
    public $crypto_wallet_payout_agents;

    protected $listeners = ['saved' => '$refresh'];

    public function mount()
    {
        $this->crypto_wallet_ft = $this->val->crypto_wallet_ft;
        $this->crypto_wallet_pc = $this->val->crypto_wallet_pc;
        $this->crypto_wallet_fc = $this->val->crypto_wallet_fc;
        $this->crypto_wallet_range = $this->val->crypto_wallet_range;
        $this->crypto_wallet_range = $this->val->crypto_wallet_payout_range;
        $this->crypto_wallet_payout_ft = $this->val->crypto_wallet_payout_ft;
        $this->crypto_wallet_payout_pc = $this->val->crypto_wallet_payout_pc;
        $this->crypto_wallet_payout_fc = $this->val->crypto_wallet_payout_fc;
        $this->crypto_wallet_payout_range = $this->val->crypto_wallet_payout_range;
        $this->crypto_wallet_agents = !empty($this->getCryptoWalletAgentData()) ? $this->getCryptoWalletAgentData() :  [];
        $this->crypto_wallet_payout_agents = !empty($this->getCryptoWalletPayoutAgentData()) ? $this->getCryptoWalletPayoutAgentData() :  [];
    }

    public function getCryptoWalletAgentData()
    {
        $data = [];
        foreach ($this->val->crypto_wallet_agents ? json_decode($this->val->crypto_wallet_agents, true) : [] as $key => $item) {
            $data[] = [
                'account_id' => $item['account_id'],
                'rev_pc' => $item['rev_pc'],
                'rev_fc' => $item['rev_fc'],
            ];
        }

        return $data;
    }

    public function getCryptoWalletPayoutAgentData()
    {
        $data = [];
        foreach ($this->val->crypto_wallet_payout_agents ? json_decode($this->val->crypto_wallet_payout_agents, true) : [] as $key => $item) {
            $data[] = [
                'account_id' => $item['account_id'],
                'rev_pc' => $item['rev_pc'],
                'rev_fc' => $item['rev_fc'],
            ];
        }

        return $data;
    }

    public function removeCryptoWalletAgent($index)
    {
        unset($this->crypto_wallet_agents[$index]);
        $this->crypto_wallet_agents = array_values($this->crypto_wallet_agents); // Reindex array
    }

    public function updatedCryptoWalletAgents()
    {
        if (count($this->crypto_wallet_agents) == 20) {
            return $this->emit('alert', __('Max agents exceeded'));
        }
    }

    public function addCryptoWalletAgent()
    {
        $this->crypto_wallet_agents[] = ['account_id' => null, 'rev_fc' => 0, 'rev_pc' => 0];
    }

    public function removeCryptoWalletPayoutAgent($index)
    {
        unset($this->crypto_wallet_payout_agents[$index]);
        $this->crypto_wallet_payout_agents = array_values($this->crypto_wallet_payout_agents); // Reindex array
    }

    public function updatedCryptoWalletPayoutAgents()
    {
        if (count($this->crypto_wallet_payout_agents) == 20) {
            return $this->emit('alert', __('Max agents exceeded'));
        }
    }

    public function addCryptoWalletPayoutAgent()
    {
        $this->crypto_wallet_payout_agents[] = ['account_id' => null, 'rev_fc' => 0, 'rev_pc' => 0];
    }

    public function update()
    {
        $this->validate([
            'crypto_wallet_ft' => ['nullable'],
            'crypto_wallet_pc' => [($this->crypto_wallet_pc_required == 1) ? 'required' : 'nullable', 'numeric'],
            'crypto_wallet_fc' => [($this->crypto_wallet_fc_required == 1) ? 'required' : 'nullable', 'numeric'],
            'crypto_wallet_range' => [in_array($this->val->crypto_wallet_ft, ['min', 'max']) ? 'required' : 'nullable', 'numeric'],
            'crypto_wallet_agents.*.account_id' => 'nullable|string|max:255',
            'crypto_wallet_agents.*.rev_pc' => 'nullable|numeric|min:0',
            'crypto_wallet_agents.*.rev_fc' => 'nullable|numeric|min:0',
            'crypto_wallet_payout_ft' => ['nullable'],
            'crypto_wallet_payout_pc' => ['required', 'numeric'],
            'crypto_wallet_payout_fc' => ['required', 'numeric'],
            'crypto_wallet_payout_range' => [in_array($this->val->crypto_wallet_payout_ft, ['min', 'max']) ? 'required' : 'nullable', 'numeric'],
            'crypto_wallet_payout_agents.*.account_id' => 'nullable|string|max:255',
            'crypto_wallet_payout_agents.*.rev_pc' => 'nullable|numeric|min:0',
            'crypto_wallet_payout_agents.*.rev_fc' => 'nullable|numeric|min:0',
        ]);

        $crypto_wallet_agents = [];
        foreach ($this->crypto_wallet_agents as $index => $item) {
            $business = \App\Models\Business::whereReference($item['account_id'])->first();
            if ($business == null) {
                return $this->addError('crypto_wallet_agents.' . $index . '.account_id', __('Invalid Agent ID'));
            }
            if ($business->kyc_status != 'APPROVED') {
                return $this->addError('crypto_wallet_agents.' . $index . '.account_id', __('Agent requires an approved compliance'));
            }
            if (\App\Models\CryptoBalance::whereBusinessId($item['account_id'])->whereToken($this->val->token)->whereNetwork($this->val->network)->exists() == false) {
                return $this->addError('crypto_wallet_agents.' . $index . '.account_id', __('Agent unable to receive this currency, ensure agent country has') . ' ' . $this->val->token . ' ' . __(' added'));
            }
            $crypto_wallet_agents[] = $item;
        }

        $this->crypto_wallet_agents = collect($crypto_wallet_agents)
            ->unique(fn($item) => serialize($item))
            ->all();

        $crypto_wallet_payout_agents = [];
        foreach ($this->crypto_wallet_payout_agents as $index => $item) {
            if (\App\Models\Business::whereReference($item['account_id'])->exists() == false) {
                return $this->addError('crypto_wallet_payout_agents.' . $index . '.account_id', __('Invalid Agent ID'));
            }
            if (\App\Models\CryptoBalance::whereBusinessId($item['account_id'])->whereToken($this->val->token)->whereNetwork($this->val->network)->exists() == false) {
                return $this->addError('crypto_wallet_payout_agents.' . $index . '.account_id', __('Agent unable to receive this currency, ensure agent country has') . ' ' . $this->val->token . ' ' . __(' added'));
            }
            $crypto_wallet_payout_agents[] = $item;
        }

        $this->crypto_wallet_payout_agents = collect($crypto_wallet_payout_agents)
            ->unique(fn($item) => serialize($item))
            ->all();

        $this->val->update([
            'crypto_wallet_ft' =>  $this->crypto_wallet_ft,
            'crypto_wallet_range' =>  $this->crypto_wallet_range,
            'crypto_wallet_pc' => (in_array($this->crypto_wallet_ft, ['both', 'percent', 'max', 'min'])) ? $this->crypto_wallet_pc : 0,
            'crypto_wallet_fc' => (in_array($this->crypto_wallet_ft, ['both', 'fiat', 'max', 'min'])) ? $this->crypto_wallet_fc : 0,
            'crypto_wallet_agents' => json_encode($crypto_wallet_agents),
            'crypto_wallet_payout_ft' =>  $this->crypto_wallet_payout_ft,
            'crypto_wallet_payout_range' =>  $this->crypto_wallet_payout_range,
            'crypto_wallet_payout_pc' => (in_array($this->crypto_wallet_payout_ft, ['both', 'percent', 'max', 'min'])) ? $this->crypto_wallet_payout_pc : 0,
            'crypto_wallet_payout_fc' => (in_array($this->crypto_wallet_payout_ft, ['both', 'fiat', 'max', 'min'])) ? $this->crypto_wallet_payout_fc : 0,
            'crypto_wallet_payout_agents' => json_encode($crypto_wallet_payout_agents),
        ]);

        $this->emit('success', __('Crypto wallet vendor updated'));
    }

    public function render()
    {
        return view('livewire.admin.users.edit-balance');
    }
}
