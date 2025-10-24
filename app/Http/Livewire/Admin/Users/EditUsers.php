<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\Business;
use App\Models\Ticket;
use App\Models\Contact;
use App\Models\SentEmail;
use App\Models\Balance;
use App\Models\Devices;
use App\Models\Reply;
use App\Models\Transactions;

class EditUsers extends Component
{
    public $val;
    public $admin;

    protected $listeners = ['saved' => '$refresh'];

    public function delete()
    {
        Business::whereId($this->val->id)->delete();
        Balance::whereUserId($this->val->id)->delete();
        Devices::whereUserId($this->val->id)->delete();
        Reply::whereUserId($this->val->id)->delete();
        Transactions::whereUserId($this->val->id)->delete();
        Ticket::whereId($this->val->id)->delete();
        Contact::whereId($this->val->id)->delete();
        SentEmail::whereId($this->val->id)->delete();
        createAudit('Admin Deleted Account', $this->val);
        $this->val->delete();
        $this->emit('success', __('User deleted'));
        $this->emit('saved');
        $this->emit('closeModal', 'delete'.$this->val->id);
    }    
    
    public function restore()
    {
        Business::whereId($this->val->id)->restore();
        Balance::whereUserId($this->val->id)->restore();
        Devices::whereUserId($this->val->id)->restore();
        Reply::whereUserId($this->val->id)->restore();
        Transactions::whereUserId($this->val->id)->restore();
        Ticket::whereId($this->val->id)->restore();
        Contact::whereId($this->val->id)->restore();
        SentEmail::whereId($this->val->id)->restore();
        $this->val->restore();
        createAudit('Admin Restored Deleted Account', $this->val);
        $this->emit('success', __('User restored'));
        $this->emit('saved');
        $this->emit('closeModal', 'restore'.$this->val->id);
    }

    public function render()
    {
        return view('livewire.admin.users.edit-users');
    }
}
