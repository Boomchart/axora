<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Jobs\CustomEmail;
use App\Jobs\BlackList;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\MonitorUsers;
use App\Models\Admin;

class Compliance extends Component
{
    public $client;
    public $reason;
    public $kyc_expiry;
    public $g_expiry;
    public $issuing_fc;
    public $issuing_pc;
    public $watchlist;
    public $agent;
    public $admin;
    public $new_password;
    public $password;
    public $issuing_agents;

    protected $listeners = ['saved' => '$refresh'];

    public function getIssuingAgentData()
    {
        $data = [];
        foreach ($this->client->business->issuing_agents ? json_decode($this->client->business->issuing_agents, true) : [] as $key => $item) {
            $data[] = [
                'account_id' => $item['account_id'],
                'rev_pc' => $item['rev_pc'],
                'rev_fc' => $item['rev_fc'],
            ];
        }

        return $data;
    }

    public function removeIssuingAgent($index)
    {
        unset($this->issuing_agents[$index]);
        $this->issuing_agents = array_values($this->issuing_agents); // Reindex array
    }

    public function updatedIssuingAgents()
    {
        if (count($this->issuing_agents) == 20) {
            return $this->emit('alert', __('Max agents exceeded'));
        }
    }

    public function addIssuingAgent()
    {
        $this->issuing_agents[] = ['account_id' => null, 'rev_fc' => 0, 'rev_pc' => 0];
    }

    public function mount()
    {
        $this->watchlist = (bool) ($this->client->business->watchlist == 1) ? true : false;
        $this->agent = (bool) ($this->client->business->agent == 1) ? true : false;
        $this->issuing_fc = $this->client->business->issuing_fc;
        $this->issuing_pc = $this->client->business->issuing_pc;
        $this->issuing_agents = !empty($this->getIssuingAgentData()) ? $this->getIssuingAgentData() :  [['account_id' => null, 'rev_pc' => 0, 'rev_fc' => 0]];
    }

    public function save()
    {
        $this->client->business->update([
            'watchlist' => $this->watchlist,
            'agent' => $this->agent,
        ]);

        $this->emit('saved');
        $this->emit('success', __('Updated'));
    }

    public function updateIssuing()
    {
        if ($this->admin->rev_share == 0) {
            return $this->emit('alert', __('Permission denied'));
        }
        $this->validate([
            'issuing_fc' => ['required', 'numeric'],
            'issuing_pc' => ['required', 'numeric'],
        ]);
        $issuing_agents = [];
        foreach ($this->issuing_agents as $index => $item) {
            if (\App\Models\Business::whereReference($item['account_id'])->exists() == false) {
                return $this->emit('alert', __('Invalid Agent ID'));
            }
            $issuing_agents[] = $item;
        }

        $this->issuing_agents = collect($issuing_agents)
            ->unique(fn($item) => serialize($item))
            ->all();

        $this->client->business->update([
            'issuing_fc' => $this->issuing_fc,
            'issuing_pc' => $this->issuing_pc,
            'issuing_agents' => json_encode($issuing_agents)
        ]);

        createAudit('edited giftcard issuing & revshare', $this->client, null, $this->admin->id);

        $this->emit('saved');
        $this->emit('success', __('Updated'));
    }

    public function block()
    {
        if ($this->admin->block_user == 0) {
            return $this->emit('alert', __('Permission denied'));
        }
        $this->client->update(['status' => 1]);
        createAudit('blocked user', $this->client, null, $this->admin->id);
        $this->emit('success', __('User blocked'));
        $this->emit('saved');
    }

    public function unblock()
    {
        if ($this->admin->unblock_user == 0) {
            return $this->emit('alert', __('Permission denied'));
        }
        $this->client->update(['status' => 0]);
        createAudit('unblocked user', $this->client, null, $this->admin->id);
        $this->emit('success', __('User enabled'));
        $this->emit('saved');
    }

    public function ban()
    {
        if ($this->admin->ban_user == 0) {
            return $this->emit('alert', __('Permission denied'));
        }
        $this->client->update(['ban' => 1]);
        $this->client->business->update(['watchlist' => 1]);
        if (!MonitorUsers::whereEmail($this->client->email)->whereIpAddress($this->client->ip_address)->exists()) {
            MonitorUsers::create([
                'ip_address' => $this->client->ip_address,
                'email' => $this->client->email,
                'phone' => $this->client->phone,
                'country_id' => $this->client->country_id,
                'user_agent' => null,
            ]);
        }
        dispatch(new BlackList());
        createAudit('banned user', $this->client, null, $this->admin->id);
        $this->emit('success', __('User banned & added to watch list'));
        $this->emit('saved');
    }

    public function unban()
    {
        if ($this->admin->unban_user == 0) {
            return $this->emit('alert', __('Permission denied'));
        }
        $this->client->update(['ban' => 0]);
        foreach (MonitorUsers::whereEmail($this->client->email)->get() as $val) {
            $val->delete();
        }
        dispatch(new BlackList());
        createAudit('unbanned user', $this->client, null, $this->admin->id);
        $this->emit('success', __('User enabled'));
        $this->emit('saved');
    }

    public function approveKYC()
    {
        if ($this->admin->approve_compliance == 0) {
            return $this->emit('alert', __('Permission denied'));
        }
        $this->client->business->update([
            'kyc_status' => "APPROVED",
        ]);
        dispatch(new CustomEmail('compliance_approval', $this->client->id));
        createAudit('approved user compliance', $this->client, null, $this->admin->id);
        $this->emit('saved');
        $this->emit('success', __('Compliance Approved'));
    }

    public function declineKYC()
    {
        if ($this->admin->decline_compliance == 0) {
            return $this->emit('alert', __('Permission denied'));
        }
        $this->validate([
            'reason' => 'required'
        ]);
        $this->client->business->update([
            'kyc_status' => 'RESUBMIT',
        ]);
        createAudit('Compliance resubmit, reason:' . $this->reason, $this->client, null, $this->admin->id);
        dispatch(new CustomEmail('compliance_resubmit', $this->client->id, $this->reason));
        $this->reset(['reason']);
        $this->emit('success', __('Compliance Rejected'));
    }

    public function editPassword()
    {
        if ($this->admin->edit_password == 0) {
            return $this->emit('alert', __('Permission denied'));
        }
        $admin = Admin::whereRole('super')->first();
        $this->validate([
            'new_password' => ['required', Password::defaults()],
            'password' => 'required',
        ]);
        if (Hash::check($this->password, $admin->password)) {
            $this->client->update([
                'password' => Hash::make($this->new_password)
            ]);
            $this->emit('drawer');
            $this->emit('success', __('Password Updated'));
            createAudit('edited user password', $this->client, null, $this->admin->id);;
        } else {
            $this->emit('alert', __('Invalid password'));
        }
    }

    public function render()
    {
        return view('livewire.admin.users.compliance');
    }
}
