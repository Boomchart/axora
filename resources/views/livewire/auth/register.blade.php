<div class="row g-0">
    <div class="col-lg-4 d-none d-lg-block axora-sidebar">
        <div class="d-flex flex-column justify-content-between h-100 p-10">
            <div class="text-center mt-5">
                <a href="{{ route('home') }}">
                    <img class="h-50px mb-5" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
                </a>
                <p class="text-white-50 fs-6">{{__('The modern standard for gift card issuing.')}}</p>
            </div>

            {{-- Timeline --}}
            <div class="timeline ps-5">

                {{-- Step 1 --}}
                <div class="timeline-item d-flex align-items-center mb-8">
                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                        <div class="symbol-label {{ $stage == 'onboarding' ? 'active-step' : 'okay' }}">
                            <i class="bi bi-bank fs-4 {{ $stage == 'onboarding' ? 'text-accent' : 'text-white' }}"></i>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <p class="fw-bold fs-6 mb-0 text-white">{{__('Business Setup')}}</p>
                        <p class="fs-8 text-white-50 mb-0">{{__('Company details')}}</p>
                    </div>
                    @if($stage == 'onboarding') <i class="bi bi-chevron-right text-white ms-auto opacity-50"></i> @endif
                </div>

                {{-- Step 2 --}}
                <div class="timeline-item d-flex align-items-center mb-8">
                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                        <div class="symbol-label {{ $stage == 'control_person' ? 'active-step' : 'okay' }}">
                            <i class="bi bi-person fs-4 {{ $stage == 'control_person' ? 'text-accent' : 'text-white' }}"></i>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <p class="fw-bold fs-6 mb-0 text-white">{{__('Account Owner')}}</p>
                        <p class="fs-8 text-white-50 mb-0">{{__('Personal details')}}</p>
                    </div>
                    @if($stage == 'control_person') <i class="bi bi-chevron-right text-white ms-auto opacity-50"></i> @endif
                </div>

                {{-- Step 3 --}}
                <div class="timeline-item d-flex align-items-center mb-8">
                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                        <div class="symbol-label {{ $stage == 'email_verify' ? 'active-step' : 'okay' }}">
                            <i class="bi bi-envelope fs-4 {{ $stage == 'email_verify' ? 'text-accent' : 'text-white' }}"></i>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <p class="fw-bold fs-6 mb-0 text-white">{{__('Verification')}}</p>
                        <p class="fs-8 text-white-50 mb-0">{{__('Secure contact info')}}</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="timeline-item d-flex align-items-center">
                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                        <div class="symbol-label {{ $stage == 'multi_factor' ? 'active-step' : 'okay' }}">
                            <i class="bi bi-shield-lock fs-4 {{ $stage == 'multi_factor' ? 'text-accent' : 'text-white' }}"></i>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <p class="fw-bold fs-6 mb-0 text-white">{{__('Security')}}</p>
                        <p class="fs-8 text-white-50 mb-0">{{__('2FA Protection')}}</p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center text-white-50 fs-8">
                &copy; {{ date('Y') }} {{$set->site_name}}.
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-12 bg-white min-vh-100 d-flex flex-column">

        {{-- Mobile Nav --}}
        <div class="d-lg-none p-4 text-center" style="background: var(--primary-color) !important;">
            <img class="h-40px" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
        </div>

        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
            <div class="w-100 w-md-600px p-5 p-md-10">

                {{-- Maintenance Alert --}}
                @if ($set->maintenance)
                    <div class="alert alert-danger d-flex align-items-center mb-10">
                        <i class="bi bi-exclamation-triangle-fill fs-3 text-danger me-3"></i>
                        <div>{{ __('We are currently under maintenance, please try again later') }}</div>
                    </div>
                @endif

                <form class="auth-form w-100" wire:submit.prevent="next">
                    <div x-data="{stage: @entangle('stage')}">

                        {{-- STAGE 1: ONBOARDING --}}
                        <div x-cloak x-show="stage === 'onboarding'" class="animate__animated animate__fadeIn">
                            <div class="auth-header text-start mb-10">
                                <h1 class="mb-3 auth-title">{{__('Welcome to')}} {{$set->site_name}}</h1>
                                <div class="auth-subtitle">{{ __('Already have an account?') }}
                                    <a href="{{ route('login') }}" class="link-primary">{{ __('Sign in here') }}</a>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="form-label required">{{__('Legal Business Name')}}</label>
                                <input class="form-control" type="text" wire:model.debounce.500ms="business_name" placeholder="Eg. Acme Corp" />
                                @error('business_name') <span class="text-danger small mt-1 d-block">{{$message}}</span> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="form-label required">{{ __('Operating Country') }}</label>
                                <select class="form-select" wire:model="country">
                                    <option value="">{{ __('Select Country') }}</option>
                                    @foreach (regCountries() as $val)
                                        <option value="{{ $val->iso2 }}">{{ $val?->name }}</option>
                                    @endforeach
                                </select>
                                @error('country') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label required">{{ __('Business MCC') }}</label>
                                    <select class="form-select" wire:model="mcc">
                                        <option value="">{{ __('Category') }}</option>
                                        @foreach (mcc() as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('mcc') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label required">{{ __('Monthly Volume') }}</label>
                                    <select class="form-select" wire:model="business_monthly_limits">
                                        <option value="">{{ __('Volume') }}</option>
                                        @foreach ($monthly_limits as $val)
                                            <option value="{{ trim($val) }}">{{ ucwords($val) }}</option>
                                        @endforeach
                                    </select>
                                    @error('business_monthly_limits') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-check mb-8">
                                <input class="form-check-input" type="checkbox" id="terms" wire:model="terms" />
                                <label class="form-check-label text-secondary small" for="terms">
                                    <span class="auth-subtitle">{{__('I agree to the')}}</span> <a href="{{route('terms')}}" class="link-primary">{{__('Terms')}}</a> <span class="auth-subtitle">{{__('and')}}</span> <a href="{{route('privacy')}}" class="link-primary">{{__('Privacy Policy')}}</a>
                                </label>
                            </div>
                        </div>

                        {{-- STAGE 2: CONTROL PERSON --}}
                        <div x-cloak x-show="stage === 'control_person'" class="animate__animated animate__fadeIn">
                            <div class="auth-header text-start mb-10">
                                <span class="badge bg-light text-primary mb-2 fw-bold px-3 py-2">{{$business_name}}</span>
                                <h1 class="mb-2">{{ __('Control Person') }}</h1>
                                <p class="text-secondary fs-6">{{ __('Who owns this account?') }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label class="form-label required">{{__('First Name')}}</label>
                                    <input class="form-control" type="text" wire:model.debounce.500ms="first_name" placeholder="John" />
                                    @error('first_name') <span class="text-danger small mt-1">{{$message}}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label class="form-label required">{{__('Last Name')}}</label>
                                    <input class="form-control" type="text" wire:model.debounce.500ms="last_name" placeholder="Doe" />
                                    @error('last_name') <span class="text-danger small mt-1">{{$message}}</span> @enderror
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="form-label required">{{__('Work Email')}}</label>
                                <input class="form-control" type="email" wire:model.debounce.500ms="email" placeholder="name@company.com" />
                                @error('email') <span class="text-danger small mt-1">{{$message}}</span> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="form-label required">{{__('Phone')}}</label>
                                <div class="input-group">
                                            <span class="input-group-text bg-white" style="border: 2px solid var(--border-color); border-right: none;">
                                                <span class="symbol-label fi fi-{{strtolower($country)}} me-2"></span>
                                                +{{str_replace('+', '', $countryReg->real->phonecode ?? '1')}}
                                            </span>
                                    <input type="tel" wire:model.debounce.500ms="phone" class="form-control border-start-0" placeholder="555-0125">
                                </div>
                                @error('phone') <span class="text-danger small mt-1">{{$message}}</span> @enderror
                            </div>

                            {{-- PASSWORD TOGGLE --}}
                            <div class="mb-6">
                                <label class="form-label required">{{__('Password')}}</label>

                                <div class="position-relative" x-data="{ show: false }" wire:key="pw-toggle-container">
                                    <input
                                            class="form-control"
                                            :type="show ? 'text' : 'password'"
                                            wire:model.debounce.500ms="password"
                                            placeholder="Min 8 characters"
                                    />
                                    <button type="button"
                                            class="position-absolute top-50 end-0 translate-middle-y me-3 btn btn-sm btn-icon bg-transparent password-toggle-btn"
                                            x-on:click="show = !show">
                                        <i class="bi fs-4" :class="show ? 'bi-eye' : 'bi-eye-slash'"></i>
                                    </button>
                                </div>
                                @error('password') <span class="text-danger small mt-1 d-block">{{$message}}</span> @enderror
                            </div>
                        </div>

                        {{-- STAGE 3: EMAIL VERIFY --}}
                        <div x-cloak x-show="stage === 'email_verify'" class="animate__animated animate__fadeIn">
                            <div class="text-center mb-10">
                                <div class="symbol symbol-circle symbol-60px bg-light mb-4 d-inline-flex align-items-center justify-content-center">
                                    <i class="bi bi-envelope-check fs-1 text-primary"></i>
                                </div>
                                <h1 class="mb-2">{{__('Verify Email')}}</h1>
                                <div class="text-secondary fw-bold fs-6">
                                    {{__('Code sent to')}} <span class="text-primary">{{$user->email ?? 'your email'}}</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mb-10">
                                <div x-data="otpEmailInput()" class="d-flex gap-3">
                                    <template x-for="(digit, index) in otp" :key="index">
                                        <input type="text" maxlength="1"
                                               class="form-control fs-2 fw-bolder text-center w-50px h-50px"
                                               x-model="otp[index]"
                                               x-bind:autofocus="index === 0"
                                               @input="onInput(index, $event)"
                                               @keydown.backspace="onBackspace(index, $event)"
                                               @paste="onPaste($event)"
                                        />
                                    </template>
                                </div>
                            </div>
                            @error('email_code') <div class="text-danger text-center small mb-4">{{ $message}}</div> @enderror
                        </div>

                        {{-- STAGE 4: 2FA --}}
                        <div x-cloak x-show="stage === 'multi_factor'" class="animate__animated animate__fadeIn">
                            <div class="auth-header text-start mb-10">
                                <h1 class="mb-2">{{__('Secure Account')}}</h1>
                                <p class="text-secondary fs-6">{{__('Scan the QR code with your authenticator app.')}}</p>
                            </div>

                            <div class="d-flex justify-content-center bg-light p-4 rounded mb-10" wire:ignore.self>
                                <img src="{{$fa_image}}" class="mw-100 rounded bg-white p-2 shadow-sm border">
                            </div>

                            <div class="form-floating mb-6">
                                <input wire:model.debounce.500ms="fa_code" type="tel" class="form-control text-center fw-bolder fs-3" style="letter-spacing: 5px;" placeholder="000000" maxlength="6">
                                <label for="fa_code" class="text-center w-100">{{__('Enter 6-digit Code')}}</label>
                            </div>
                            @error('fa_code') <span class="text-danger small d-block text-center">{{$message}}</span> @enderror
                        </div>

                    </div>

                    {{-- ACTIONS --}}
                    <div class="mt-10">
                        <button type="submit" class="btn btn-primary w-100 fs-5" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="next">{{ __('Continue') }}</span>
                            <span wire:loading wire:target="next">
                                        <span class="spinner-border spinner-border-sm me-2"></span> {{ __('Processing...') }}
                                    </span>
                        </button>

                        @if($stage == 'email_verify')
                            <div class="text-center mt-5">
                                <button type="button" wire:click="resendEmailVerify" class="btn btn-link btn-sm text-secondary text-decoration-none">
                                    {{__('Resend Code')}} <span id="timer" class="text-primary fw-bold"></span>
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Footer Text --}}
        <div class="text-center py-4 border-top">
            <p class="auth-subtitle fs-9 mb-0">
                <i class="bi bi-shield-check me-1 text-success"></i> {{__('Protected by AES-256 Encryption')}}
            </p>
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