<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\SentEmail;
use App\Models\Ticket;
use App\Models\Transactions;
use App\Models\CardIssued;
use App\Jobs\SendEmail;
use App\Jobs\DashNotify;

class Header extends Component
{
    public $client;
    public $type;
    public $subject;
    public $message;    
    public $dashboard_subject;
    public $dashboard_message;
    public $admin;

    protected $listeners = ['saved' => '$refresh'];

    public function sendEmail()
    {
        $contact = $this->client->contact;
        SentEmail::create([
            'subject' => $this->subject,
            'message' => $this->message,
            'contact_id' => $contact->id,
            'admin_id' => $this->admin->id,
        ]);
        dispatch(new SendEmail($contact->email, $contact->first_name . ' ' . $contact->last_name, $this->subject, $this->message, null, null, 0));
        $this->reset(['subject', 'message']);
        $this->emit('success', __('Email added to queue'));
        $this->emit('drawer');
    }

    public function sendNotify()
    {
        dispatch(new DashNotify($this->client, $this->dashboard_subject, strip_tags($this->dashboard_message)));
        $this->reset(['dashboard_subject', 'dashboard_message']);
        $this->emit('success', __('Notification added to queue'));
        $this->emit('drawer');
    }

    public function render()
    {
        return view('livewire.admin.users.header', [
            'tickets' => Ticket::whereUserId($this->client->id)->whereStatus(0)->count(),
            'sentMessage' => SentEmail::whereContactId($this->client->contact_id)->count(),
            'transactions' => Transactions::whereUserId($this->client->id)->count(),
            'orders' => CardIssued::whereUserId($this->client->id)->count(),
        ]);
    }
}
