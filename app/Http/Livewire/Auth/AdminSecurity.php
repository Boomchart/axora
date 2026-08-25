<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Traits\ThrottlesAttempts;
use Carbon\Carbon;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;

class AdminSecurity extends Component
{
    use ThrottlesAttempts;

    // The target is the session's own account, so lock the account, not the IP.
    protected function scopesAttemptsToIp()
    {
        return false;
    }

    public $set;
    public $admin;
    public $pin;

    public function save()
    {
        $this->validate([
            'pin' => ['numeric', 'required', 'min_digits:6', 'max_digits:6', 'regex:/[0-9]+/'],
        ]);
        $lockout = $this->attemptLockout('admin-2fa', $this->admin->id);
        if ($lockout !== null) {
            return $this->addError('pin', $this->attemptLockoutMessage($lockout));
        }

        $g = new GoogleAuthenticator();
        if($g->checkcode($this->admin->googlefa_secret, $this->pin, 0)){
            $this->clearAttempts('admin-2fa', $this->admin->id);
            $this->admin->update(['fa_expiring' => Carbon::now()->addHours(2)]);
            return redirect()->route('admin.dashboard');
        }else{
            $this->recordFailedAttempt('admin-2fa', $this->admin->id);
            return $this->addError('pin', __('Invalid code'));
        }
    }

    public function render()
    {
        return view('livewire.auth.security');
    }
}
