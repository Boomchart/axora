<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Jobs\CustomEmail;

class TrxDetails extends Component
{
    public $val;
    public $type;
    public $admin;
    public $reason;

    protected $listeners = ['saved' => '$refresh'];

    public function approve()
    {
        $this->val->update([
            'status' => 'success',
            'staff_id' => $this->admin->id
        ]);
            
        if($this->val->type == "payout"){
            dispatch(new CustomEmail('withdraw_request_approve', $this->val->id));
            createAudit('Payout request approved ' . $this->val->id, $this->val->user);
        }else{
            $balance = $this->val->user->getFirstBalance();
            $balance->update(['amount' => $balance->amount + $this->val->amount - $this->val->charge]);
                
            dispatch(new CustomEmail('deposit_request_approve', $this->val->id));
            createAudit('Deposit request approved ' . $this->val->id, $this->val->user);
        }
        $this->emit('saved');
        $this->emit('success', __('Transaction approved'));
        $this->emit('drawer');
    }

    public function decline()
    {
        $this->validate([
            'reason' => ['required']
        ]);
        $this->val->update([
            'status' => 'declined', 
            'decline_reason' => $this->reason,
            'staff_id' => $this->admin->id
        ]);

        if($this->val->type == "payout"){
            $balance = $this->val->user->getFirstBalance();
            $balance->update(['amount' => $balance->amount + $this->val->amount + $this->val->charge]);
            dispatch(new CustomEmail('withdraw_request_decline', $this->val->id, $this->reason));
            createAudit('Payout request Declined ' . $this->val->id, $this->val->user);
        }else{
            dispatch(new CustomEmail('deposit_request_decline', $this->val->id, $this->reason));
            createAudit('Deposit request Declined ' . $this->val->id, $this->val->user);
        }

        $this->reset(['reason']);
        $this->emit('saved');
        $this->emit('success', __('Transaction declined'));
        $this->emit('drawer');
    }

    public function render()
    {
        return view('livewire.admin.users.trx-details');
    }
}
