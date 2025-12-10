<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Models\User;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\Jobs\CustomEmail;
use App\Models\Devices;
use hisorange\BrowserDetect\Parser as Browser;

class Login extends Component
{
    public $settings;
    public $email;
    public $password;
    public $remember_me;


    public function submitLogin()
    {

        try {
            if ($this->settings->maintenance == 1) {
                return $this->addError('added', __('We are currently under maintenance, please try again later'));
            }

            $this->validate([
                'email' => 'required|email:rfc,dns',
                'password' => 'required',
            ]);

            $remember_me = ($this->remember_me != null) ? true : false;
            if (Auth::guard('user')->attempt(['email' => $this->email, 'password' => $this->password], $remember_me)) {
                $user = User::whereId(auth()->guard('user')->user()->id)->first();
                if ($user->status) {
                    Auth::guard('user')->logout();
                    return $this->addError('added', __('Account Suspended'));
                }

                $user->update([
                    'last_login' => Carbon::now(),
                    'ip_address' => user_ip(),
                    'otp_required' => 'off',
                    'email_time' => Carbon::now(),
                ]);

                Devices::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'business_id' => $user->business_id,
                    ],
                    [
                        'userAgent' => Browser::userAgent(),
                        'deviceType' => Browser::deviceType(),
                        'browserName' => Browser::browserName(),
                        'platformName' => Browser::platformName(),
                        'deviceFamily' => Browser::deviceFamily(),
                        'browserFamily' => Browser::browserFamily(),
                        'browserVersion' => Browser::browserVersion(),
                        'platformFamily' => Browser::platformFamily(),
                        'platformVersion' => Browser::platformVersion(),
                        'deviceModel' => Browser::deviceModel(),
                        'mobileGrade' => Browser::mobileGrade(),
                        'ip_address' => user_ip(),
                        'last_login' => Carbon::now(),
                    ]
                );

                App::setLocale($user->language);

                if (user_ip() != $user->ip_address && filter_var(user_ip(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) == true && $user->login_alert == 1) {
                    dispatch(new SendEmail($user->email, $user->business->name, __('Successful Sign-In from IP address ') . user_ip(), '<h3>' . __('Did You Login from a New Location') . '?</h3><br>' . __('We noticed your ') . $this->settings->site_name . __(' account ') . $user->email . __(' was just accessed from a new IP address') . ' <br><b> ' . user_ip() . '</b><br>' . __(' If this was you, please you can ignore this message or reset your account password') . '. <br><br><a href=' . route('user.password.request') . '>' . route('user.password.request') . '</a><br><br><i>' . __('This is an automated message please do not reply') . '.</i>', null, null, 1));
                }

                if (session()->has('url.intended')) {
                    if (strpos(session('url.intended'), 'user') !== false) {
                        return redirect()->intended();
                    } else {
                        return redirect()->route('user.dashboard');
                    }
                } else {
                    return redirect()->route('user.dashboard');
                }
                return redirect()->route('user.dashboard');
            } else {
                $this->emit('wrongPassword');
                return $this->addError('added', __('Oops! You have entered invalid credentials'));
            }
        } catch (\Exception $e) {
            return $this->emit('alert', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
