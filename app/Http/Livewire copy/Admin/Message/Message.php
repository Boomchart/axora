<?php

namespace App\Http\Livewire\Admin\Message;

use Livewire\Component;
use App\Jobs\SendEmail;
use App\Models\Contact;
use App\Models\Messages;
use App\Models\SentEmail;

class Message extends Component
{
    public $val;
    public $type;
    public $admin;
    public $subject;
    public $message;

    public function sendEmail($val)
    {
        $contact = Contact::find($val);
        SentEmail::create([
            'subject' => $this->subject,
            'message' => $this->message,
            'contact_id' => $contact->id,
            'admin_id' => $this->admin->id,
        ]);
        dispatch(new SendEmail($contact->email, $contact->first_name . ' ' . $contact->last_name, $this->subject, $this->message, null, $contact));
        $this->reset(['subject', 'message']);
        $this->emit('success', __('Email added to queue'));
        $this->emit('drawer');
    }

    public function delete(Messages $message)
    {
        $message->update([
            'admin_id' => $this->admin->id
        ]);
        $message->delete();
        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Message Deleted'));
    }

    public function forceDelete($message)
    {
        $message = Messages::whereId($message)->onlyTrashed()->first();
        $message->forceDelete();
        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Message Permanently Deleted'));
    }

    public function restore($message)
    {
        $message = Messages::whereId($message)->onlyTrashed()->first();
        $message->restore();
        $this->emit('drawer');
        $this->emit('saved');
        $this->emit('success', __('Message Restored'));
    }

    public function seen(Messages $message, $type)
    {
        $message->update([
            'seen' => $type,
            'admin_id' => $this->admin->id
        ]);

        $this->emit('saved');
        $this->emit('drawer');
        $this->emit('success', ($type == 1) ? __('Marked as Read') : __('Marked as Unread'));
    }

    public function render()
    {
        return view('livewire.admin.message.message');
    }
}
