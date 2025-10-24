<?php

namespace App\Http\Livewire\Admin\Message;

use Livewire\Component;
use App\Models\Messages;
use App\Models\Contact;
use App\Models\User;
use App\Models\SentEmail;
use App\Jobs\SendEmail;
use App\Jobs\DashNotify;

class Header extends Component
{
    private $unreadMessage;
    private $sentMessage;
    private $deletedMessage;
    private $contacts;
    public $type;
    public $subject;
    public $message;
    public $dashboard_subject;
    public $dashboard_message;
    public $admin;

    protected $listeners = ['saved' => '$refresh'];

    public function sendEmail()
    {
        $this->validate([
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);
        $collect = Contact::whereSubscribed(1)->get();
        if ($collect->count() > 0) {
            if($this->admin->promo == 0){
                $this->emit('alert', __('Permission denied'));
                return;
            }
            foreach ($collect as $contact) {
                SentEmail::create([
                    'subject' => $this->subject,
                    'message' => $this->message,
                    'contact_id' => $contact->id,
                    'admin_id' => $this->admin->id,
                ]);
                dispatch(new SendEmail($contact->email, $contact->first_name . ' ' . $contact->last_name, $this->subject, $this->message, null, null, 0));
            }
            $this->reset(['subject', 'message']);
            $this->emit('success', __('Email added to queue'));
            $this->emit('drawer');
        } else {
            $this->emit('alert', 'No subscribers');
        }
    }

    public function sendNotify()
    {
        $this->validate([
            'dashboard_subject' => 'required|string',
            'dashboard_message' => 'required|string'
        ]);
        if($this->admin->promo == 0){
            $this->emit('alert', __('Permission denied'));
            return;
        }
        $users = User::all();
        foreach ($users as $contact) {
            dispatch(new DashNotify($contact, $this->dashboard_subject, strip_tags($this->dashboard_message)));
        }
        $this->reset(['dashboard_subject', 'dashboard_message']);
        $this->emit('success', __('Notification added to queue'));
        $this->emit('drawer');
    }

    public function render()
    {
        $this->unreadMessage = Messages::whereSeen(0)->count();
        $this->contacts = Contact::all()->count();
        $this->deletedMessage = Messages::onlyTrashed()->count();
        $this->sentMessage = SentEmail::all()->count();
        return view('livewire.admin.message.header', [
            'unreadMessage' => $this->unreadMessage,
            'contacts' => $this->contacts,
            'deletedMessage' => $this->deletedMessage,
            'sentMessage' => $this->sentMessage
        ]);
    }
}
