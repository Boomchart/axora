<div>
    <div class="xcontainer-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4 col-lg-4 col-12 d-none d-md-block d-lg-block ">
                <div class="py-5">
                    <div class="p-5 mx-auto">
                        <div class="text-center">
                            <a href="{{ route('home') }}" class="navbar-brand pe-3">
                                <img class="mb-6 text-center" src="{{asset('asset/images/dark_logo.png')}}" alt="{{ $set->site_name }}"
                                    loading="lazy" @style(getUi()->light_css)>
                            </a>
                        </div>
                        <div class="timeline mt-6">
                            <div class="timeline-item d-flex align-items-center">
                                <div class="timeline-line w-45px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                    <div class="symbol-label okay mb-7 bg-info text-white">
                                        <i class="bi bi-bank fs-2"></i>
                                    </div>
                                </div>
                                <div class="timeline-content mt-n1">
                                    <div class="bg-white p-4 rounded-4 d-flex align-items-center justify-content-between">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-dark fw-bold fs-8 mb-0">{{__('Business Onboarding')}}</p>
                                            <p class="text-dark fs-9 mb-0">{{__('Setup')}} {{$set->site_name}} {{__('Account')}}</p>
                                        </div>
                                        @if($stage == 'onboarding')
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-check2-circle text-success fs-5"></i>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item d-flex align-items-center">
                                <div class="timeline-line w-45px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                    <div class="symbol-label okay mb-7 @if($link['control_person']) bg-info text-white @else bg-white text-dark @endif">
                                        <i class="bi bi-person fs-2"></i>
                                    </div>
                                </div>
                                <div class="timeline-content mt-n1">
                                    <div class="bg-white p-4 rounded-4 d-flex align-items-center justify-content-between">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-dark fw-bold fs-8 mb-0">{{__('Control Person')}}</p>
                                            <p class="text-dark fs-9 mb-0">{{__('Account owner')}}</p>
                                        </div>
                                        @if($stage == 'control_person')
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-check2-circle text-success fs-5"></i>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item d-flex align-items-center">
                                <div class="timeline-line w-45px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                    <div class="symbol-label okay mb-7 @if($link['email_verify']) bg-info text-white @else bg-white text-dark @endif">
                                        <i class="bi bi-envelope fs-2"></i>
                                    </div>
                                </div>
                                <div class="timeline-content mt-n1">
                                    <div class="bg-white p-4 rounded-4 d-flex align-items-center justify-content-between">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-dark fw-bold fs-8 mb-0">{{__('Email Verification')}}</p>
                                            <p class="text-dark fs-9 mb-0">{{__('Verify email address')}}</p>
                                        </div>
                                        @if($stage == 'email_verify')
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-check2-circle text-success fs-5"></i>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item d-flex align-items-center">
                                <div class="timeline-line w-45px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                    <div class="symbol-label okay mb-7 @if($link['multi_factor']) bg-info text-white @else bg-white text-dark @endif">
                                        <i class="bi bi-lock fs-2"></i>
                                    </div>
                                </div>
                                <div class="timeline-content mt-n1">
                                    <div class="bg-white p-4 rounded-4 d-flex align-items-center justify-content-between">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-dark fw-bold fs-8 mb-0">{{__('Multi Factor Security')}}</p>
                                            <p class="text-dark fs-9 mb-0">{{__('Secure your business account')}}</p>
                                        </div>
                                        @if($stage == 'multi_factor')
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-check2-circle text-success fs-5"></i>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-8 col-12 bg-white min-vh-100">
                <div class="d-block d-md-none d-flex justify-content-center">
                    <nav class="navbar fixed-top bg-glass-dark shadow-lg px-1 rounded-4">
                        <div class="d-flex w-100 justify-content-between align-items-center timeline-container p-5">
                            <div class="step @if($link['onboarding'])active @endif"><i class="bi bi-bank"></i></div>
                            <div class="step @if($link['control_person'])active @endif"><i class="bi bi-person"></i></div>
                            <div class="step @if($link['email_verify'])active @endif"><i class="bi bi-envelope"></i></div>
                            <div class="step @if($link['multi_factor'])active @endif"><i class="bi bi-lock"></i></div>
                        </div>
                    </nav>
                </div>
                <div class="row justify-content-center mt-20 mt-md-0">
                    <div class="col-md-10 p-10">
                        @if ($set->maintenance)
                        <div class="alert alert-danger">
                            <div class="d-flex flex-column">
                                <span>{{ __('We are currently under maintenance, please try again later') }}</span>
                            </div>
                        </div>
                        @endif
                        @if ($set->registration == 0)
                        <div class="alert alert-danger">
                            <div class="d-flex flex-column">
                                <span>{{ __('We are currently not accepting new users, please try again later') }}</span>
                            </div>
                        </div>
                        @endif
                        <form class="form w-100" wire:submit.prevent="next">
                            <div x-data="{stage: @entangle('stage')}">
                                <div x-cloak x-show="stage === 'onboarding'">
                                    <div class="text-start mb-15 mt-10">
                                        <h1 class="text-dark mb-2 fs-2">{{ __('Business Onboarding') }}</h1>
                                        <div class="text-dark fs-7">{{ __('Already have an account?') }}
                                            <a href="{{ route('login') }}"
                                                class="link-success fw-bold"><u>{{ __('Sign in here') }}</u></a>
                                        </div>
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7 required">{{__('Legal Business Name')}}</label>
                                        <input class="form-control form-control-solid border-light" type="text" wire:model.debounce.1000ms="business_name" autocomplete="off" placeholder="Eg, Apple Inc" />
                                        @error('business_name')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7 required">{{ __('Country of Business Operation') }}</label>
                                        <div wire:ignore>
                                            <select class="form-select form-select-solid" id="country" wire:model="country">
                                                <option value="">{{ __('Select Country') }}</option>
                                                @foreach (regCountries() as $val)
                                                <option value="{{ $val->iso2 }}"
                                                    data-image="{{ 'https://flagcdn.com/h40/' . strtolower($val->iso2) . '.png' }}">
                                                    {{ $val?->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('country')
                                        <span class="form-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7 required">{{ __('Business MCC') }}</label>
                                        <select class="form-select form-select-solid" wire:model="mcc">
                                            <option value="">{{ __('Select options') }}</option>
                                            @foreach (mcc() as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('mcc')
                                        <span class="form-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7 col-xl-12 required">{{ __('Transaction Monthly Volume') }}</label>
                                        <select class="form-select form-select-solid" wire:model="business_monthly_limits">
                                            <option value="">{{ __('Select options') }}</option>
                                            @foreach ($monthly_limits as $val)
                                            <option value="{{ trim($val) }}">{{ ucwords($val) }}</option>
                                            @endforeach
                                        </select>
                                        @error('business_monthly_limits')
                                        <span class="form-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" id="terms" wire:model="terms" />
                                        <label class="form-check-label fs-8 text-gray-700" for="terms">
                                            {{__('I agree to our')}}
                                            <a target="_blank" href="{{route('terms')}}" class="text-info">{{$set->site_name}} {{__('Terms')}}</a>,
                                            <a target="_blank" href="{{route('privacy')}}" class="text-info">{{$set->site_name}} {{__('Privacy Policy')}}</a>
                                        </label>
                                    </div>
                                </div>
                                <div x-cloak x-show="stage === 'control_person'">
                                    <div class="text-start mb-15 mt-10">
                                        <h1 class="text-dark mb-2 fs-2">{{$business_name}}</h1>
                                        <p class="text-dark fs-7 mb-0">{{ __('Control Person') }}</p>
                                    </div>
                                    <div class="row fv-row">
                                        <div class="col-xl-6 mb-6">
                                            <label class="form-label text-dark fs-7 required">{{__('Legal First Name')}}</label>
                                            <input class="form-control form-control-solid border-light" type="text" wire:model.debounce.1000ms="first_name" autocomplete="off" placeholder="John" />
                                            @error('first_name')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-xl-6 mb-6">
                                            <label class="form-label text-dark fs-7 required">{{__('Legal Last Name')}}</label>
                                            <input class="form-control form-control-solid border-light" type="text" wire:model.debounce.1000ms="last_name" autocomplete="off" placeholder="Doe" />
                                            @error('last_name')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7 required">{{__('Work Email')}}</label>
                                        <input class="form-control form-control-solid border-light" type="email" wire:model.debounce.1000ms="email" autocomplete="email" placeholder="name@email.com" />
                                        @error('email')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7 required">{{__('Phone')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-right-0 fs-7"><span class="symbol-label fi fi-{{strtolower($country)}} me-2"></span> +{{str_replace('+', '', $countryReg->real->phonecode)}}</span>
                                            <input type="tel" wire:model.debounce.1000ms="phone" id="phone" class="form-control form-control-solid border-light" placeholder="XXXX-XXXX-XXXX">
                                        </div>
                                        @error('phone')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div x-data="{ show: false }">
                                        <div class="fv-row mb-6">
                                            <div class="d-flex flex-stack mb-2">
                                                <label class="form-label text-dark fs-7 mb-0 required">{{__('Password')}}</label>
                                            </div>
                                            <div class="position-relative">
                                                <input class="form-control form-control-solid border-light" :type="show ? 'text' : 'password'" wire:model.debounce.1000ms="password" autocomplete="one-time-code" data-toggle="password" placeholder="{{__('Account Password')}}" />
                                                <span @click="show = !show" :class="show ? 'input-password-show' : 'input-password-hide'" class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 cursor-pointer">
                                                    <i :class="show ? 'bi bi-eye-slash' : 'bi bi-eye'" class="fs-2 text-dark"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div x-cloak x-show="stage === 'email_verify'">
                                    @if(auth()->guard('user')->check())
                                    <div class="text-start mb-15 mt-10" wire:init="emailCountdown">
                                        <a href="{{route('user.logout')}}" class="btn p-0 border-0 bg-transparent mb-2" wire:ignore>
                                            <i class="bi bi-box-arrow-in-left fs-1"></i>
                                        </a>
                                        <h1 class="text-dark mb-2 fs-2">{{__('Verify Email address')}}</h1>
                                        <p class="text-dark fs-7 mb-0">{{__('Enter the code we sent to')}} {{$user->email}}</p>
                                    </div>
                                    @endif
                                    <div
                                        x-data="otpEmailInput()"
                                        class="d-flex gap-2 mt-5 justify-content-start">
                                        <template x-for="(digit, index) in otp" :key="index">
                                            <input
                                                autofocus
                                                type="text"
                                                maxlength="1"
                                                class="form-control form-control-solid text-center otp-input fs-1 fw-bold"
                                                x-model="otp[index]"
                                                x-bind:autofocus="index === 0"
                                                @input="onInput(index, $event)"
                                                @keydown.backspace="onBackspace(index, $event)"
                                                @paste="onPaste($event)" />
                                        </template>
                                    </div>
                                    @error('email_code')
                                    <span class="form-text">{{ $message}}</span>
                                    @enderror
                                </div>
                                <div x-cloak x-show="stage === 'multi_factor'">
                                    <div class="text-start mb-15 mt-10">
                                        <a href="{{route('user.logout')}}" class="btn p-0 border-0 bg-transparent mb-2" wire:ignore>
                                            <i class="bi bi-box-arrow-in-left fs-1"></i>
                                        </a>
                                        <h1 class="text-dark mb-2 fs-2">{{__('Two Factor Authentication')}}</h1>
                                        <p class="text-dark fs-7 mb-5">{{__('Two-factor authentication is a security measure used to safeguard your online accounts. When enabled, it requires you to enter not just your password but also a unique code. This code can be obtained through a mobile app. Even if someone manages to obtain your password, they cannot gain access without the accompanying code.')}}</p>
                                        <ul class="text-gray-800 fs-7 ps-0 mb-10">
                                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-info bullet-vertical"></span>{{__('Install an authentication app on your device. Any app that supports the Time-based One-Time Password (TOTP) protocol should work.')}}</li>
                                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-info bullet-vertical"></span>{{__('Use the authenticator app to scan the barcode below.')}}</li>
                                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-info bullet-vertical"></span>{{__('Enter the code generated by the authenticator app.')}}</li>
                                        </ul>
                                        <div class="text-start mb-10" wire:ignore.self>
                                            <img src="{{$fa_image}}">
                                        </div>
                                        <div class="fv-row mb-6 form-floating">
                                            <input wire:model.debounce.1000ms="fa_code" type="tel" minlength="6" maxlength="6" pattern="[0-9]+" class="form-control form-control-solid" placeholder="XXXXXX">
                                            <label class="form-label text-dark fs-7 mb-0 required" for="pin">{{__('Code')}}</label>
                                            @error('fa_code')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-10">
                                <button type="submit" class="btn btn-dark btn-block my-4" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50" wire:target="next">
                                    <span wire:loading.remove wire:target="next">{{ __('Next') }}</span>
                                    <span wire:loading
                                        wire:target="next">{{ __('Processing Request...') }}</span>
                                </button>
                                @if($stage == 'email_verify')
                                <p class="text-dark fs-8 mb-0">{{__('You can')}}
                                    <a wire:click="resendEmailVerify" class="text-info mb-5 cursor-pointer" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="resend">
                                        <u>{{__('Resend')}}</u>
                                    </a>
                                    {{__('Code after')}}
                                    <span wire:ignore>
                                        <span id="timer" class="fw-bold text-info"></span>
                                    </span>
                                </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('dashboard/js/moment.js')}}"></script>
<script src="{{asset('dashboard/js/moment-timezone-with-data.js')}}"></script>
<script>
    function otpEmailInput() {
        return {
            otp: Array(6).fill(''),
            onInput(index, event) {
                let input = event.target;
                let value = input.value.replace(/\D/g, '');
                if (value.length > 1) value = value[0];
                this.otp[index] = value;

                if (value && index < this.otp.length - 1) {
                    input.nextElementSibling?.focus();
                }

                this.syncToLivewire();
            },
            onBackspace(index, event) {
                if (!this.otp[index] && index > 0) {
                    event.target.previousElementSibling?.focus();
                }
                this.syncToLivewire();
            },
            onPaste(event) {
                event.preventDefault();
                const paste = (event.clipboardData || window.clipboardData).getData('text');
                const digits = paste.replace(/\D/g, '').slice(0, this.otp.length).split('');

                digits.forEach((char, i) => {
                    this.otp[i] = char;
                });

                const inputs = event.target.parentElement.querySelectorAll('input');
                const nextIndex = digits.length >= this.otp.length ? this.otp.length - 1 : digits.length;
                inputs[nextIndex]?.focus();

                this.syncToLivewire();
            },
            syncToLivewire() {
                const fullCode = this.otp.join('');
                if (fullCode.length === this.otp.length) {
                    @this.set('email_code', fullCode);
                }
            }
        };
    }

    function formatCountry(country) {
        if (!country.id) {
            return country.text;
        }
        var $country = $(
            '<span><img src="https://flagcdn.com/h40/' + country.id.split('*')[0].toLocaleLowerCase() +
            '.png" class="img-flag" /> ' + country.text + '</span>'
        );
        return $country;
    }

    document.addEventListener('livewire:load', function() {
        function initializeSelect2() {
            $('#country').select2({
                templateResult: formatCountry,
                templateSelection: formatCountry
            });
        }
        initializeSelect2();

        $('#country').on('change', function(e) {
            @this.set('country', $(this).val());
        });

        @this.set('timezone', moment.tz.guess());
    });

    let countdown; // Global reference

    window.livewire.on('countDown', function(data) {
        // Clear previous interval if any
        if (countdown) clearInterval(countdown);
        const parts = data.split(":");
        const minutes = parseInt(parts[0], 10);
        const seconds = parseInt(parts[1], 10);
        let totalSeconds = (minutes * 60) + seconds;

        // If time is already 0:00, set immediately and stop
        if (totalSeconds <= 0) {
            document.getElementById("timer").innerText = "00:00";
            return;
        }

        countdown = setInterval(function() {
            let displayMinutes = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
            let displaySeconds = (totalSeconds % 60).toString().padStart(2, '0');
            document.getElementById("timer").innerText = `${displayMinutes}:${displaySeconds}`;
            if (totalSeconds <= 0) {
                clearInterval(countdown);
                document.getElementById("timer").innerText = "00:00";
            }
            totalSeconds--;
        }, 1000);
    });
</script>
@endpush