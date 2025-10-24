<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\CountryReg;
use App\Models\User;
use App\Models\Balance;
use App\Models\Business;
use App\Models\MonitorUsers;
use App\Models\Contact;
use App\Models\PasswordHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Jobs\CustomEmail;
use Illuminate\Validation\Rules\Password;
use App\Models\Devices;
use hisorange\BrowserDetect\Parser as Browser;
use Propaganistas\LaravelPhone\PhoneNumber;
use Carbon\Carbon;

class Register extends Component
{
    public $settings;
    public $account_type = 'business';
    public $countryReg;
    public $token;
    public $monthly_limits = [];
    public $mcc;
    public $link = [];
    public $stage;
    public $country;
    public $business_monthly_limits;
    public $business_name;
    public $timezone;
    public $terms = 1;
    public $twilio = 1;
    public $merchant;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $merchant_id;
    public $password;
    public $user;
    public $email_code;
    public $phone_code;
    public $channel = 'sms';
    public $fa_code;
    public $fa_image;
    public $fa_secret;

    public function mount()
    {
        $this->monthly_limits = [
            'below $10,000',
            '$10,000 - $100,000',
            '$100,000 - $250,000',
            '$250,000 - $1M',
            '> $1M',
        ];
        if (in_array(user_ip(), regCountries()->pluck('iso2')->toArray())) {
            $this->country = user_ip() ?? regCountries()->first()->iso2;
        } else {
            $this->country = regCountries()->first()->iso2;
        }

        $this->updatedCountry();

        if (auth()->guard('user')->check()) {
            $this->user = auth()->guard('user')->user();
            $this->link = [
                'onboarding' => true,
                'control_person' => true,
                'email_verify' => ($this->user->email_verify) ? true : false,
                'multi_factor' => ($this->user->business->fa_status) ? true : false,
            ];
            if ($this->link['multi_factor'] == true) {
                $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
                $this->fa_secret = $g->generateSecret();
                $this->fa_image = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($this->user->business->name, $this->fa_secret, $this->settings->site_name, 150);
            }

            if ($this->user->email_verify && $this->user->business->fa_status) {
                return redirect()->route('user.dashboard');
            }
        } else {
            $this->link = [
                'onboarding' => true,
                'control_person' => false,
                'email_verify' => false,
                'multi_factor' => false,
            ];
        }
        $this->switchStage();
    }

    public function emailCountdown()
    {
        $this->emit('countDown', ($this->user->email_time?->isPast()) ? '0:00 minute' : formatOtpTime($this->user->email_time));
    }

    public function resendEmailVerify()
    {
        if (Carbon::parse($this->user->email_time) > now()) {
            createAudit('Timeout limit for email verification');
            return $this->emit('alert', __('You can resend link after ') . gmdate('i:s', Carbon::parse($this->user->email_time)->diffInSeconds(now())) . __(' minutes'));
        } else {
            $code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $this->user->update(['email_time' => now()->addMinutes(5), 'email_auth' => $code]);
            createAudit('Resent verification email');
            dispatch(new CustomEmail('verify_email', $this->user->id));
            $this->emit('countDown', ($this->user->email_time->isPast()) ? '0:00 minute' : formatOtpTime($this->user->email_time));
            return $this->emit('success', __('Verification Code Sent'));
        }
    }

    public function switchStage()
    {
        if (auth()->guard('user')->check() == false) {
            $this->stage = ($this->stage == 'control_person') ? 'control_person' : 'onboarding';
        } else {
            if ($this->user->email_verify == 0) {
                $this->stage = 'email_verify';
            } elseif ($this->user->business->fa_status == 0) {
                $this->stage = 'multi_factor';
            }
        }
        $this->link[$this->stage] = true;
        if (auth()->guard('user')->check()) {
            if ($this->link['multi_factor'] == true) {

                $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
                $this->fa_secret = $g->generateSecret();
                $this->fa_image = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($this->user->business->name, $this->fa_secret, $this->settings->site_name, 150);
            }
            if ($this->user->email_verify && $this->user->business->fa_status) {
                return redirect()->route('user.dashboard');
            }
        }
    }

    public function generateWebhookSecret()
    {
        $result = '';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 10;

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $result;
    }

    public function next()
    {
        if ($this->settings->maintenance == 1) {
            return $this->emit('alert', __('We are currently under maintenance, please try again later'));
        }
        if ($this->settings->registration == 0) {
            return $this->emit('alert', __('Registration is currently unavailable, please try again later'));
        }
        if ($this->stage == 'onboarding') {
            $this->validate([
                'country' => ['required'],
                'business_name' => ['required', 'string', 'max:255', 'not_regex:/^https?:\/\//i', 'not_regex:/^www\./i'],
                'terms' => 'required',
                'mcc' => 'required',
                'business_monthly_limits' => 'required',
            ], [
                'business_name.required' => __('Business name is required'),
                'country.required' => __('Select a country'),
                'terms.required' => __('Accept all terms & conditions'),
            ]);
            $this->stage = 'control_person';
            $this->switchStage();
        } elseif ($this->stage == 'control_person') {
            try {
                if (empty($this->phone)) {
                    return $this->addError('phone',  __('Phone number is required'));
                }
                $rules = [
                    'first_name' => ['required', 'string', 'max:255', 'not_regex:/^https?:\/\//i', 'not_regex:/^www\./i'],
                    'last_name' => ['required', 'string', 'max:255', 'not_regex:/^https?:\/\//i', 'not_regex:/^www\./i'],
                    'email' => 'required|email:rfc,dns',
                    'password' => ['required', Password::defaults()],
                    'phone' => 'required|phone:' . strtoupper($this->country),
                ];
                $this->validate($rules, [
                    'first_name.required' => __('Enter first name'),
                    'last_name.required' => __('Enter last name'),
                    'email.required' => __('Email address is required'),
                    'phone.required' => __('Phone number is required'),
                    'phone.phone' => __('Invalid phone number'),
                    'email.email' => __('Invalid email address'),
                    'password.required' => __('Password is required')
                ]);

                if (User::whereMode('live')->whereEmail($this->email)->exists()) {
                    return $this->addError('email', __('Email address is already in use'));
                }

                if ($this->country != PhoneNumber::make($this->phone, $this->country)->getCountry()) {
                    return $this->addError('phone',  __('Invalid phone number'));
                }

                if ($this->settings->email_banned != null) {
                    foreach (json_decode($this->settings->email_banned) as $regemail) {
                        if (explode('@', $this->email)[1] == $regemail->value) {
                            if (!MonitorUsers::whereEmail($this->email)->whereIpAddress(user_ip())->exists()) {
                                MonitorUsers::create([
                                    'ip_address' => user_ip(),
                                    'email' => $this->email,
                                    'phone' => PhoneNumber::make($this->phone, $this->country)->formatE164(),
                                    'country_id' => $this->countryReg->id,
                                    'user_agent' => Browser::userAgent(),
                                ]);
                            }
                            if (!MonitorUsers::whereEmail($this->email)->whereWhitelist(1)->exists() && !MonitorUsers::whereIpAddress(user_ip())->whereWhitelist(1)->exists()) {
                                return $this->emit('alert', __('An error occurred try again later'));
                            }
                        }
                    }
                }

                $phone = PhoneNumber::make($this->phone, $this->country)->formatE164();

                if (User::whereMode('live')->wherePhone($phone)->exists()) {
                    return $this->emit('alert', __('Phone number is already used by another account'));
                }

                $user = User::create([
                    'first_name' => ucwords(strtolower($this->first_name)),
                    'last_name' => ucwords(strtolower($this->last_name)),
                    'business_name' => $this->business_name,
                    'country_id' => $this->countryReg->id,
                    'ip_address' => user_ip(),
                    'last_login' => now(),
                    'email_time' => now()->addMinutes(5),
                    'email_verify_duration' =>  now(),
                    'user_timezone' => $this->timezone,
                    'phone' => $phone,
                    'email' => trim(strtolower($this->email)),
                    'email_verify' => 0,
                    'email_auth' => str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
                    'password' => Hash::make($this->password),
                ]);

                PasswordHistory::create([
                    'email' => $this->email,
                    'password' => hash('sha256', $this->password)
                ]);

                $contact = Contact::create([
                    'user_id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'mobile' => $user->phone,
                    'email' => $user->email,
                ]);
                $user->update(['contact_id' => $contact->id]);

                $business = Business::create([
                    'user_id' => $user->id,
                    'name' => $this->business_name,
                    'reference' => generateBusinessReference(),
                    'api_key' => Str::random(30),
                    'test_api_key' => Str::random(30),
                    'webhook_secret' => $this->generateWebhookSecret(),
                    'country' => $this->countryReg->id,
                    'mcc' => $this->mcc,
                    'business_monthly_limits' => $this->business_monthly_limits,
                    'account_mode' => 'live'
                ]);

                $user->update(['business_id' => $business->reference]);

                Balance::create([
                    'user_id' => $user->id,
                    'country_id' => $this->settings->currency,
                    'ref_id' => Str::uuid(),
                    'business_id' => $business->reference,
                    'main' => ($this->settings->currency == $user->country_id) ? 1 : 0,
                    'short_code' => $this->settings->real->currency,
                ]);

                try {
                    Devices::create(
                        [
                            'user_id' => $user->id,
                            'business_id' => $user->business_id,
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
                        ]
                    );
                } catch (\Exception $e) {
                    createAudit('Could not log Mac address', $business);
                }

                dispatch(new CustomEmail('verify_email', $user->id));
                if (Auth::guard('user')->attempt(['email' => $this->email, 'password' => $this->password])) {
                    $this->user = auth()->guard('user')->user();
                    $this->stage = 'email_verify';
                    $this->emailCountdown();
                    $this->switchStage();
                }
            } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                return $this->emit('alert', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\NumberFormatException $e) {
                return $this->emit('alert', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\InvalidParameterException $e) {
                return $this->emit('alert', $e->getMessage());
            } catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $e) {
                return $this->emit('alert', $e->getMessage());
            }
        } elseif ($this->stage == 'email_verify') {
            $this->validate(
                [
                    'email_code' => ['numeric', 'required', 'min_digits:6', 'max_digits:6'],
                ],
                [
                    'email_code.required' => __('Code is required'),
                    'email_code.min_digits' => __('Enter 6 digits'),
                    'email_code.max_digits' => __('Enter 6 digits'),
                ]
            );
            if ($this->email_code == $this->user->email_auth) {
                $this->user->update(['email_verify' => 1, 'otp_required' => 'off']);
                $this->emit('success', __('Email verified'));
                createAudit('Confirmed email address');
                $this->stage = 'multi_factor';
                $this->switchStage();
            } else {
                return $this->emit('alert', __('Invalid code'));
            }
        } elseif ($this->stage == 'multi_factor') {
            $this->validate(
                [
                    'fa_code' => ['numeric', 'required', 'min_digits:6', 'max_digits:6'],
                ],
                [
                    'fa_code.required' => __('Code is required'),
                    'fa_code.min_digits' => __('Enter 6 digits'),
                    'fa_code.max_digits' => __('Enter 6 digits'),
                ]
            );
            try {
                $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
                if ($g->checkcode($this->fa_secret, $this->fa_code, 3)) {
                    $this->user->business->update([
                        'fa_status' => 1,
                        'fa_secret' => $this->fa_secret,
                        'fa_expiring' => Carbon::now()->addHours(2)
                    ]);
                    $this->user->update(['otp_required' => 'off']);
                    createAudit('Activated 2fa');
                    return redirect()->route('user.dashboard');
                } else {
                    return $this->emit('alert', __('Invalid code'));
                }
            } catch (\Exception $e) {
                return $this->emit('alert', $e->getMessage());
            }
        }
    }

    public function resetOnboarding()
    {
        $this->stage = 'onboarding';
        $this->switchStage();
    }

    public function updatedCountry()
    {
        $this->countryReg = CountryReg::whereIso2($this->country)->first();
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
