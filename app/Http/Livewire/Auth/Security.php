<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Traits\ThrottlesAttempts;
use Carbon\Carbon;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;

class Security extends Component
{
    use ThrottlesAttempts;

    // The target is the session's own account, so lock the account, not the IP.
    protected function scopesAttemptsToIp()
    {
        return false;
    }

    public $set;
    public $user;
    public $pin;

    public function save()
    {
        $this->validate([
            'pin' => ['numeric', 'required', 'min_digits:6', 'max_digits:6', 'regex:/[0-9]+/'],
        ]);
        $lockout = $this->attemptLockout('user-2fa', $this->user->id);
        if ($lockout !== null) {
            return $this->addError('pin', $this->attemptLockoutMessage($lockout));
        }

        $g = new GoogleAuthenticator();

        if($g->checkcode($this->user->business->fa_secret, $this->pin, 0)){
            $this->clearAttempts('user-2fa', $this->user->id);
            $this->user->business->update(['fa_expiring' => Carbon::now()->addHours(2)]);
            return redirect()->route('user.dashboard');
        }else{
            $this->recordFailedAttempt('user-2fa', $this->user->id);
            return $this->addError('pin', __('Invalid code'));
        }
    }

    public function render()
    {
        return view('livewire.auth.security');
    }
}
