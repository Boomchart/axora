<?php

namespace App\Http\Livewire\Admin\Message;

use Livewire\Component;
use App\Models\SentEmail;

class SentMessage extends Component
{
    public $val;
    public $type;
    public $admin;
    public $subject;
    public $message;

    public function delete(SentEmail $message)
    {
        $message->delete();
        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Message Deleted'));
    }

    public function render()
    {
        return view('livewire.admin.message.sent-message');
    }
}
