<div class="auth-onboarding-layout">
    <aside class="auth-onboarding-sidebar d-none d-lg-flex">
        <div class="auth-onboarding-sidebar-inner">
            <div class="auth-onboarding-brand">
                <a href="{{ route('home') }}">
                    <img src="{{asset('asset/images/dark_logo.png')}}" alt="{{ $set->site_name }}" loading="lazy" class="auth-onboarding-logo" @style(getUi()->light_css)>
                </a>
                <p>{{ __('The modern standard for gift card, crypto, airtime & data. ') }}</p>
            </div>

            <div class="auth-onboarding-steps">
                <div class="auth-onboarding-step {{ $stage == 'onboarding' ? 'active' : '' }}">
                    <div class="auth-onboarding-step-icon">
                        <i class="bi bi-bank fs-4"></i>
                    </div>
                    <div class="auth-onboarding-step-content">
                        <h6>{{ __('Business Setup') }}</h6>
                        <p>{{ __('Company details') }}</p>
                    </div>
                    @if($stage == 'onboarding') <i class="bi bi-chevron-right auth-onboarding-step-arrow"></i> @endif
                </div>

                <div class="auth-onboarding-step {{ $stage == 'control_person' ? 'active' : '' }}">
                    <div class="auth-onboarding-step-icon">
                        <i class="bi bi-person fs-4"></i>
                    </div>
                    <div class="auth-onboarding-step-content">
                        <h6>{{ __('Account Owner') }}</h6>
                        <p>{{ __('Personal details') }}</p>
                    </div>
                    @if($stage == 'control_person') <i class="bi bi-chevron-right auth-onboarding-step-arrow"></i> @endif
                </div>

                <div class="auth-onboarding-step {{ $stage == 'email_verify' ? 'active' : '' }}">
                    <div class="auth-onboarding-step-icon">
                        <i class="bi bi-envelope fs-4"></i>
                    </div>
                    <div class="auth-onboarding-step-content">
                        <h6>{{ __('Verification') }}</h6>
                        <p>{{ __('Secure contact info') }}</p>
                    </div>
                    @if($stage == 'email_verify') <i class="bi bi-chevron-right auth-onboarding-step-arrow"></i> @endif
                </div>

                <div class="auth-onboarding-step {{ $stage == 'multi_factor' ? 'active' : '' }}">
                    <div class="auth-onboarding-step-icon">
                        <i class="bi bi-shield-lock fs-4"></i>
                    </div>
                    <div class="auth-onboarding-step-content">
                        <h6>{{ __('Security') }}</h6>
                        <p>{{ __('2FA protection') }}</p>
                    </div>
                    @if($stage == 'multi_factor') <i class="bi bi-chevron-right auth-onboarding-step-arrow"></i> @endif
                </div>
            </div>

            <div class="auth-onboarding-copyright">
                &copy; {{ date('Y') }} {{ $set->site_name }}.
            </div>
        </div>
    </aside>

    <main class="auth-onboarding-main">
        <div class="auth-onboarding-mobile-brand d-lg-none">
            <a href="{{ route('home') }}">
                <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-onboarding-mobile-logo" @style(getUi()->light_css)>
            </a>
        </div>

        <div class="auth-onboarding-content">
            <div class="auth-onboarding-card">
                @if($set->maintenance)
                <div class="auth-alert auth-alert-error">
                    <div class="auth-alert-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <strong>{{ __('Maintenance Mode') }}</strong>
                        <p class="mb-0 mt-1">{{ __('We are currently under maintenance, please try again later.') }}</p>
                    </div>
                </div>
                @endif

                <form class="auth-form w-100" wire:submit.prevent="next">
                    <div x-data="{stage: @entangle('stage')}">
                        <div x-cloak x-show="stage === 'onboarding'" class="animate__animated animate__fadeIn">
                            <div class="auth-header text-start">
                                <span class="auth-badge">
                                    <i class="bi bi-building-check"></i>
                                    {{ __('Business Setup') }}
                                </span>
                                <h1 class="auth-title">{{ __('Welcome to') }} {{ $set->site_name }}</h1>
                                <p class="auth-subtitle mx-0">
                                    {{ __('Already have an account?') }}
                                    <a href="{{ route('login') }}" class="auth-link">{{ __('Sign in here') }}</a>
                                </p>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">{{ __('Legal Business Name') }}</label>
                                <input class="form-control" type="text" wire:model.debounce.500ms="business_name" placeholder="{{ __('Eg. Acme Corp') }}">
                                @error('business_name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">{{ __('Operating Country') }}</label>
                                <select class="form-select" wire:model="country">
                                    <option value="">{{ __('Select Country') }}</option>
                                    @foreach(regCountries() as $val)
                                    <option value="{{ $val->iso2 }}">{{ $val?->name }}</option>
                                    @endforeach
                                </select>
                                @error('country') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required">{{ __('Business MCC') }}</label>
                                        <select class="form-select" wire:model="mcc">
                                            <option value="">{{ __('Category') }}</option>
                                            @foreach(mcc() as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('mcc') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required">{{ __('Monthly Volume') }}</label>
                                        <select class="form-select" wire:model="business_monthly_limits">
                                            <option value="">{{ __('Volume') }}</option>
                                            @foreach($monthly_limits as $val)
                                            <option value="{{ trim($val) }}">{{ ucwords($val) }}</option>
                                            @endforeach
                                        </select>
                                        @error('business_monthly_limits') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-check auth-terms-check">
                                <input class="form-check-input" type="checkbox" id="terms" wire:model="terms">
                                <label class="form-check-label" for="terms">
                                    {{ __('I agree to the') }}
                                    <a href="{{ route('terms') }}" class="auth-link">{{ __('Terms') }}</a>
                                    {{ __('and') }}
                                    <a href="{{ route('privacy') }}" class="auth-link">{{ __('Privacy Policy') }}</a>
                                </label>
                            </div>
                        </div>

                        <div x-cloak x-show="stage === 'control_person'" class="animate__animated animate__fadeIn">
                            <div class="auth-header text-start">
                                <span class="auth-badge">
                                    <i class="bi bi-person-check"></i>
                                    {{ $business_name }}
                                </span>
                                <h1 class="auth-title">{{ __('Account Owner') }}</h1>
                                <p class="auth-subtitle mx-0">{{ __('Tell us who owns and manages this account.') }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required">{{ __('First Name') }}</label>
                                        <input class="form-control" type="text" wire:model.debounce.500ms="first_name" placeholder="{{ __('John') }}">
                                        @error('first_name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required">{{ __('Last Name') }}</label>
                                        <input class="form-control" type="text" wire:model.debounce.500ms="last_name" placeholder="{{ __('Doe') }}">
                                        @error('last_name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">{{ __('Work Email') }}</label>
                                <input class="form-control" type="email" wire:model.debounce.500ms="email" placeholder="{{ __('name@company.com') }}">
                                @error('email') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">{{ __('Phone') }}</label>
                                <div class="auth-phone-group">
                                    <span class="auth-phone-prefix">
                                        <span class="symbol-label fi fi-{{ strtolower($country) }} me-2"></span>
                                        +{{ str_replace('+', '', $countryReg->real->phonecode ?? '1') }}
                                    </span>
                                    <input type="tel" wire:model.debounce.500ms="phone" class="form-control" placeholder="{{ __('555-0125') }}">
                                </div>
                                @error('phone') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">{{ __('Password') }}</label>
                                <div class="position-relative" x-data="{ show: false }" wire:key="pw-toggle-container">
                                    <input class="form-control" :type="show ? 'text' : 'password'" wire:model.debounce.500ms="password" placeholder="{{ __('Min 8 characters') }}">
                                    <button type="button" class="password-toggle-btn" x-on:click="show = !show" aria-label="{{ __('Toggle password visibility') }}">
                                        <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                                    </button>
                                </div>
                                @error('password') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div x-cloak x-show="stage === 'email_verify'" class="animate__animated animate__fadeIn">
                            <div class="auth-header">
                                <span class="auth-badge">
                                    <i class="bi bi-envelope-check"></i>
                                    {{ __('Email Verification') }}
                                </span>
                                <h1 class="auth-title">{{ __('Verify Your Email') }}</h1>
                                <p class="auth-subtitle">
                                    {{ __('We sent a verification code to') }}
                                    <strong>{{ $user->email ?? __('your email') }}</strong>
                                </p>
                            </div>

                            <div class="auth-code-group" x-data="otpEmailInput()">
                                <template x-for="(digit, index) in otp" :key="index">
                                    <input type="text" maxlength="1" class="form-control auth-code-input" x-model="otp[index]" x-bind:autofocus="index === 0" @input="onInput(index, $event)" @keydown.backspace="onBackspace(index, $event)" @paste="onPaste($event)">
                                </template>
                            </div>

                            <div class="auth-field-message">
                                @error('email_code') <span class="text-danger small fw-bold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div x-cloak x-show="stage === 'multi_factor'" class="animate__animated animate__fadeIn">
                            <div class="auth-header text-start">
                                <span class="auth-badge">
                                    <i class="bi bi-shield-lock"></i>
                                    {{ __('Two-Factor Security') }}
                                </span>
                                <h1 class="auth-title">{{ __('Secure Your Account') }}</h1>
                                <p class="auth-subtitle mx-0">{{ __('Scan the QR code with your authenticator app, then enter the 6-digit code.') }}</p>
                            </div>

                            <div class="auth-qr-box" wire:ignore.self>
                                <img src="{{ $fa_image }}" alt="{{ __('Authenticator QR Code') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label text-center d-block">{{ __('Enter 6-digit Code') }}</label>
                                <input wire:model.debounce.500ms="fa_code" type="tel" class="form-control auth-otp-input" placeholder="000000" maxlength="6">
                                @error('fa_code') <span class="text-danger small d-block text-center mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="auth-action-stack">
                        <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="next">{{ __('Continue') }}</span>
                            <span wire:loading wire:target="next">
                                <span class="spinner-border spinner-border-sm me-2"></span>{{ __('Processing...') }}
                            </span>
                        </button>

                        @if($stage == 'email_verify')
                        <button type="button" wire:click="resendEmailVerify" wire:loading.attr="disabled" class="btn btn-outline-secondary w-100">
                            <span wire:loading.remove wire:target="resendEmailVerify"> {{ __('Resend Code') }}</span>
                            <span wire:loading wire:target="resendEmailVerify">
                                <span class="spinner-border spinner-border-sm me-2"></span>{{ __('Processing...') }}
                            </span>
                        </button>
                        @endif
                        <span id="timer" class="auth-timer"></span>
                    </div>
                </form>
            </div>
        </div>

        <div class="auth-onboarding-footer">
            <p><i class="bi bi-shield-check me-1"></i>{{ __('Protected by AES-256 Encryption') }}</p>
        </div>
    </main>
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