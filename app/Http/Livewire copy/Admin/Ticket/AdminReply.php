<?php

namespace App\Http\Livewire\Admin\Ticket;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\SendEmail;
use App\Jobs\CustomEmail;
use App\Models\Reply;

class AdminReply extends Component
{
    use WithFileUploads;
    public $admin;
    public $message;
    public $val;
    public $settings;

    public function close()
    {
        if ($this->admin->support == 0) {
            return $this->emit('alert', __('permission Denied'));
        }
        $this->val->update([
            'status' => 1
        ]);
        dispatch(new CustomEmail('ticket_close', $this->val->id));
        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Ticked closed'));
    }

    public function open()
    {
        if ($this->admin->support == 0) {
            return $this->emit('alert', __('permission Denied'));
        }
        $this->val->update([
            'status' => 0
        ]);
        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Ticked opened'));
    }

    public function reply()
    {
        if ($this->admin->support == 0) {
            return $this->emit('alert', __('permission Denied'));
        }

        $this->validate([
            'message' => ['required', 'string'],
        ]);

        $reply = Reply::create([
            'reply' => $this->message,
            'ticket_id' => $this->val->id,
            'status' => 1,
            'staff_id' => $this->admin->id,
            'user_id' => $this->val->user_id,
            'business_id' => $this->val->business_id,
        ]);

        dispatch(new CustomEmail('ticket_reply', $reply->id));
        $this->reset(['message']);
        $this->emit('newChat');
        $this->emit('success', __('Message Sent'));
    }

    public function render()
    {
        return view('livewire.admin.ticket.admin-reply');
    }
}
