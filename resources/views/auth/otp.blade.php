@extends('auth.menu')

@section('content')
    <div class="auth-card auth-login-card">
        <div class="auth-header">
            <div class="auth-logo-wrap">
                <a href="{{ route('home') }}" class="auth-logo-link">
                    <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-logo"@style(getUi()->light_css)>
                </a>
            </div>

            <span class="auth-badge">
                <i class="bi bi-shield-check"></i>
                {{ __('Account Verification') }}
            </span>
            <h1 class="auth-title">{{ __('Enter Your OTP') }}</h1>

            <p class="auth-subtitle">
                {{ __('We sent a one-time password to') }}
                <strong>{{ ($set->otp_type == 'email') ? $user->email : $user->phone }}</strong>
            </p>
        </div>

        <form class="form w-100" action="{{ route('confirm.otp') }}" method="post">
            @csrf

            @if($errors->any())
                <div class="auth-alert auth-alert-error">
                    <div class="auth-alert-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>

                    <div>
                        <strong>{{ __('Please check the form') }}</strong>

                        <ul class="mb-0 mt-2 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="auth-otp-info">
                <p class="mb-0">
                    {{ __('Didn’t receive the code?') }}
                    <a href="{{ route('resend.otp') }}" class="auth-link resend-sms">
                        {{ __('Resend') }}
                    </a>
                    {{ ($set->otp_type == 'email') ? __('email after') : __('SMS after') }}
                    <span id="timer" class="auth-timer"></span>
                </p>
            </div>

            <div class="fv-row">
                <label class="form-label" for="code">{{ __('Verification Code') }}</label>

                <input class="form-control auth-otp-input" name="code" id="code" type="tel" minlength="4" maxlength="6" pattern="[0-9]+" inputmode="numeric" autocomplete="one-time-code" value="{{ old('code') }}" required placeholder="XXXXXX" autofocus onkeyup="this.value=removeSpacesPin(this.value);" onmouseout="this.value=removeSpacesPin(this.value);">

                @error('code')
                <span class="text-danger small mt-2 d-block">{{ $message }}</span>
                @enderror
            </div>

            @if($set->recaptcha == 1)
                {!! RecaptchaV3::field('otp') !!}

                @error('g-recaptcha-response')
                <span class="text-danger small mt-2 d-block">{{ $message }}</span>
                @enderror
            @endif

            <div class="auth-action-stack">
                <button type="submit" class="btn btn-primary w-100">
                    <span class="indicator-label">
                        {{ __('Verify OTP') }}
                    </span>
                </button>

                <a href="{{ route('user.logout') }}" class="btn btn-outline-secondary w-100">
                    {{ __('Logout') }}
                </a>
            </div>
        </form>
    </div>
@stop

@section('script')
    <script>
        var countDownDate = moment("{{Carbon\Carbon::create($user->otp_time)->add($set->otp_resend_duration . ' ' . $set->otp_resend_time)->toDateTimeString()}}").valueOf();

        var x = setInterval(function() {
            var now = moment.utc().valueOf();
            var distance = countDownDate - now + (1 * 60 * 60 * 1000);
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)).toString().padStart(2, '0'));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');

            if (document.getElementById("timer")) {
                document.getElementById("timer").innerHTML = minutes + ":" + seconds;
            }

            if (distance < 0) {
                clearInterval(x);

                if (document.getElementById("timer")) {
                    document.getElementById("timer").innerHTML = "0:00";
                }

                $('.resend-sms').attr('disabled', false);
            }
        }, 1);
    </script>
@endsection