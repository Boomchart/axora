<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Business;
use App\Models\User;
use App\Models\Balance;
use App\Models\Beneficiary;
use App\Models\Devices;
use App\Models\Ticket;
use App\Models\Contact;
use App\Models\SentEmail;
use App\Models\Savings;
use App\Models\Transactions;
use App\Models\Reply;
use App\Models\Units;
use App\Models\UserBank;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmail;
use App\Jobs\CustomEmail;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Carbon\Carbon;

class Options extends Component
{
    public $user;
    public $password;
    public $pin;
    public $fa_pin;
    public $new_password;
    public $confirm_password;
    public $set;
    public $reason;
    public $secret;
    public $image;

    public function resetPassword()
    {
        try {
            $trans = [
                'password.current_password' => __('Invalid Password')
            ];
            $this->validate([
                'password' => ['required', 'current_password:user'],
                'new_password' => ['required', Password::defaults(), 'same:confirm_password'],
                'confirm_password' => ['required', Password::defaults(), 'same:new_password'],
            ], $trans);
            $this->user->update(['password' => Hash::make($this->new_password)]);
            createAudit('Changed Password', $this->user);
            return $this->emit('success', __('Password changed'));
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function resetPin()
    {
        try {
            $trans = [
                'password.current_password' => __('Invalid Password')
            ];
            $this->validate([
                'password' => [($this->set->social == 0) ? 'required' : 'nullable', 'current_password:user'],
                'pin' => ['numeric', 'required', 'min_digits:4', 'max_digits:6', 'regex:/[0-9]+/'],
            ], $trans);
            $this->user->business->update(['pin' => Hash::make($this->pin)]);
            createAudit('Changed Pin', $this->user);
            return $this->emit('success', __('Pin changed'));
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function secondSecurity()
    {
        try {
            $this->validate([
                'fa_pin' => ['numeric', 'required', 'min_digits:6', 'max_digits:6', 'regex:/[0-9]+/'],
            ]);
            $g = new GoogleAuthenticator();
            if ($this->user->business->fa_status == 1) {
                if ($g->checkcode($this->user->business->fa_secret, $this->fa_pin, 3)) {
                    $this->user->business->update([
                        'fa_status' => 0,
                        'fa_secret' => null,
                    ]);
                    createAudit('Deactivated 2fa', $this->user);
                    dispatch(new CustomEmail('2fa_disabled', $this->user->id));
                    return $this->emit('success', __('2fa disabled'));
                } else {
                    return $this->addError('fa_pin', __('Invalid code'));
                }
            } else {
                if ($g->checkcode($this->secret, $this->fa_pin, 3)) {
                    $this->user->business->update([
                        'fa_status' => 1,
                        'fa_secret' => $this->secret,
                        'fa_expiring' => Carbon::now()->addHours(2)
                    ]);
                    createAudit('Activated 2fa', $this->user);
                    dispatch(new CustomEmail('2fa_enabled', $this->user->id));
                    return $this->emit('success', __('2fa enabled'));
                } else {
                    return $this->addError('fa_pin', __('Invalid code'));
                }
            }
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function deactivateAccount()
    {
        try {
            $trans = [
                'password.current_password' => __('Invalid Password')
            ];
            $this->validate([
                'password' => [($this->set->social == 0) ? 'required' : 'nullable', 'current_password:user'],
                'reason' => ['string', 'required', 'max:255'],
            ], $trans);

            updateLocale('admin');
            dispatch(new SendEmail($this->set->email, $this->set->site_name, 'A user just left ' . $this->set->site_name, 'Reason:' . $this->reason, null, null, 1));
            updateLocale('user');
            dispatch(new CustomEmail('deactivation_email', $this->user->id, null, route('reactivate', ['user' => $this->user->id])));
            auth()->guard('user')->logout();
            session()->forget('fakey');

            User::whereId($this->user->id)->delete();
            Business::whereId($this->user->id)->delete();
            Balance::whereUserId($this->user->id)->delete();
            Beneficiary::whereUserId($this->user->id)->delete();
            Devices::whereUserId($this->user->id)->delete();
            Reply::whereUserId($this->user->id)->delete();
            UserBank::whereUserId($this->user->id)->delete();
            Transactions::whereUserId($this->user->id)->delete();
            Ticket::whereId($this->user->id)->delete();
            Contact::whereId($this->user->id)->delete();
            SentEmail::whereId($this->user->id)->delete();
            Auth::guard('user')->logout();
            return redirect()->route('login')->with('success', __('Account was successfully deactivated'));
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user.settings.options');
    }
}
