<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;

class Notifications extends Component
{
    public $user; 
    public $login_alert; 
    public $transaction_notification; 
    public $promotional_emails; 

    public function save(){
        $this->user->update([
            'login_alert' => $this->login_alert,
            'transaction_notification' => $this->transaction_notification,
        ]);
        $this->user->contact->update(['subscribed' => $this->promotional_emails]);

        $this->emit('success', __('Settings updated'));
    }

    public function render()
    {
        $this->login_alert = ($this->user->login_alert == 1) ? true : false;
        $this->transaction_notification = ($this->user->transaction_notification == 1) ? true : false;
        $this->promotional_emails = ($this->user->contact->subscribed == 1) ? true : false;
        return view('livewire.user.settings.notifications');
    }
}
