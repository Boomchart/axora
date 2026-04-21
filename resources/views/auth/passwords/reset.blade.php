@extends('auth.menu')

@section('content')
  <div class="auth-logo-wrap auth-logo-outside">
    <a href="{{ route('home') }}" class="auth-logo-link">
      <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-logo"@style(getUi()->light_css)>
    </a>
  </div>
  <div class="auth-card auth-login-card">
    <div class="auth-header">
      <span class="auth-badge"><i class="bi bi-lock"></i>{{ __('Account Recovery') }}</span>
      <h1 class="auth-title">{{ __('Create a New Password') }}</h1>
      <p class="auth-subtitle">{{ __('Choose a strong password to recover access to your account.') }}</p>
    </div>

    <form class="form w-100" action="{{ route('user.password.request') }}" method="post" id="kt_sign_up_form" novalidate="novalidate">
      @csrf

      <div class="form-group">
        <label class="form-label" for="email">{{ __('Email Address') }}</label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" autocomplete="email" value="{{ $email }}" required readonly>

        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group" data-kt-password-meter="true">
        <label class="form-label" for="password">{{ __('New Password') }}</label>

        <div class="position-relative">
          <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" autocomplete="new-password" required data-toggle="password" value="{{ old('password') }}">
          <button type="button" class="password-toggle-btn input-password" data-kt-password-meter-control="visibility" aria-label="{{ __('Toggle password visibility') }}">
            <i class="bi bi-eye"></i>
          </button>
        </div>

        <div class="auth-password-strength mt-3" data-kt-password-meter-control="highlight">
          <div class="auth-password-bar bg-secondary bg-active-success"></div>
          <div class="auth-password-bar bg-secondary bg-active-success"></div>
          <div class="auth-password-bar bg-secondary bg-active-success"></div>
          <div class="auth-password-bar bg-secondary bg-active-success"></div>
        </div>

        <p class="auth-password-hint">{{ __('Use 8 or more characters with a mix of letters, numbers, and symbols.') }}</p>

        @error('password')
        <span class="text-danger small mt-2 d-block">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="confirm-password">{{ __('Confirm Password') }}</label>
        <input class="form-control" type="password" name="confirm-password" id="confirm-password" autocomplete="new-password" required value="{{ old('confirm-password') }}">
      </div>

      @if($set->recaptcha == 1)
        {!! RecaptchaV3::field('new-password') !!}

        @error('g-recaptcha-response')
        <span class="text-danger small mt-2 d-block">{{ $message }}</span>
        @enderror
      @endif

      <input type="hidden" name="token" value="{{ $token }}">

      <button type="submit" class="btn btn-primary w-100" id="kt_sign_up_submit">
          <span class="indicator-label"><i class="bi bi-check-circle me-2"></i>{{ __('Reset Password') }}</span>
      </button>
    </form>

    <div class="auth-footer">
      <p class="text-center mb-0">{{ __('Remember your password?') }}
        <a href="{{ route('login') }}" class="auth-link">{{ __('Sign in here') }}</a>
      </p>
    </div>
  </div>
@stop

@section('script')
  <script src="{{ asset('dashboard/js/custom/authentication/sign-up/password-reset.js') }}"></script>

  <script>
    ! function($) {
      'use strict';
      $(function() {
        $('[data-toggle="password"]').each(function() {
          var input = $(this);
          var eye_btn = $(this).parent().find('.input-password');
          eye_btn.css('cursor', 'pointer').addClass('input-password-hide');
          eye_btn.on('click', function() {
            if (eye_btn.hasClass('input-password-hide')) {
              eye_btn.removeClass('input-password-hide').addClass('input-password-show');
              eye_btn.find('.bi').removeClass('bi-eye').addClass('bi-eye-slash')
              input.attr('type', 'text');
            } else {
              eye_btn.removeClass('input-password-show').addClass('input-password-hide');
              eye_btn.find('.bi').removeClass('bi-eye-slash').addClass('bi-eye')
              input.attr('type', 'password');
            }
          });
        });
      });
    }(window.jQuery);
  </script>
@endsection