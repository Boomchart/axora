<?php

namespace App\Http\Livewire\Admin\Transactions;

use Livewire\Component;
use App\Jobs\CustomEmail;
use App\Services\Hasapay\HasapayService;

class Details extends Component
{
    public $val;
    public $user;
    public $settings;
    public $admin;
    public $reason;

    public function approveDeposit()
    {
        if ($this->val->status != 'success') {
            $this->val->update([
                'status' => 'success',
                'staff_id' => $this->admin->id
            ]);

            $balance = $this->val->user->getFirstBalance();
            $balance->update(['amount' => $balance->amount + $this->val->amount]);

            dispatch(new CustomEmail('deposit_request_approve', $this->val->id));
            createAudit('Deposit request approved ' . $this->val->id, $this->val->user);
            $this->emit('saved');
            $this->emit('success', __('Transaction approved'));
            $this->emit('drawer');
        } else {
            $this->emit('alert', __('Already approved'));
        }
    }

    public function declineDeposit()
    {
        $this->validate([
            'reason' => ['required']
        ]);
        $this->val->update([
            'status' => 'declined',
            'decline_reason' => $this->reason,
            'staff_id' => $this->admin->id
        ]);

        dispatch(new CustomEmail('deposit_request_decline', $this->val->id, $this->reason));
        createAudit('Deposit request Declined ' . $this->val->id, $this->val->user);
        $this->reset(['reason']);
        $this->emit('saved');
        $this->emit('success', __('Transaction declined'));
        $this->emit('drawer');
    }

    public function approvePayout()
    {
        if ($this->val->status != 'success') {
            if ($this->val->type == 'crypto_payout') {
                $hasapay = new HasapayService($this->val->mode);
                $wallet = $hasapay->fetchWalletId($this->val?->cryptoBalance->token, $this->val?->cryptoBalance->network);
                $payout = $hasapay->payout($wallet['wallet_id'], $wallet['asset_id'], $this->val->wallet_address, $this->val->amount, $this->val->ref_id);
                if ($payout['success'] == true) {
                    $this->val->update([
                        'hasa_id' => $payout['data']['id'],
                        'status' => 'success',
                        'staff_id' => $this->admin->id
                    ]);
                } else {
                    return $this->emit('alert', __('An error occured, try again later'));
                }
            } else {
                $this->val->update([
                    'status' => 'success',
                    'staff_id' => $this->admin->id
                ]);
            }

            dispatch(new CustomEmail('withdraw_request_approve', $this->val->id));
            createAudit('Payout request approved ' . $this->val->id, $this->val->user);
            $this->emit('saved');
            $this->emit('success', __('Transaction approved'));
            $this->emit('drawer');
        } else {
            $this->emit('alert', __('Already approved'));
        }
    }

    public function declinePayout()
    {
        $this->validate([
            'reason' => ['required']
        ]);
        $this->val->update([
            'status' => 'declined',
            'decline_reason' => $this->reason,
            'staff_id' => $this->admin->id
        ]);

        $balance = $this->val->user->getFirstBalance();
        $balance->update(['amount' => $balance->amount + $this->val->amount + $this->val->charge]);

        dispatch(new CustomEmail('withdraw_request_decline', $this->val->id, $this->reason));
        createAudit('Payout request Declined ' . $this->val->id, $this->val->user);
        $this->reset(['reason']);
        $this->emit('saved');
        $this->emit('success', __('Transaction declined'));
        $this->emit('drawer');
    }

    public function render()
    {
        return view('livewire.admin.transactions.details');
    }
}
