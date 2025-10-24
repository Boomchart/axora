<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Carbon\Carbon;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;

class Security extends Component
{
    public $set;
    public $user;
    public $pin;

    public function save()
    {
        $this->validate([
            'pin' => ['numeric', 'required', 'min_digits:6', 'max_digits:6', 'regex:/[0-9]+/'],
        ]);
        $g = new GoogleAuthenticator();
        if($g->checkcode($this->user->business->fa_secret, $this->pin, 3)){
            $this->user->business->update(['fa_expiring' => Carbon::now()->addHours(2)]);
            return redirect()->route('user.dashboard');
        }else{
            return $this->addError('pin', __('Invalid code'));
        }
    }

    public function render()
    {
        return view('livewire.auth.security');
    }
}
