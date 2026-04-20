@extends('auth.menu')

@section('content')
  <div class="auth-card auth-login-card">
    <div class="auth-header">
      <div class="auth-logo-wrap">
        <a href="{{ route('home') }}" class="auth-logo-link">
          <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-logo"@style(getUi()->light_css)>
        </a>
      </div>

      <span class="auth-badge"><i class="bi bi-key"></i>{{ __('Password Recovery') }}</span>

      <h1 class="auth-title">{{ __('Reset Your Password') }}</h1>

      <p class="auth-subtitle">
        {{ __('Enter the email address linked to your account and we will send you instructions to reset your password.') }}
      </p>
    </div>

    <form action="{{ route('user.password.email') }}" method="post">
      @csrf

      <div class="form-group">
        <label for="email" class="form-label">{{ __('Email Address') }}</label>

        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" autocomplete="email" required placeholder="{{ __('name@email.com') }}" autofocus value="{{ old('email') }}">

        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      @if($set->recaptcha == 1)
        {!! RecaptchaV3::field('reset') !!}

        @error('g-recaptcha-response')
        <span class="text-danger small mt-2 d-block">{{ $message }}</span>
        @enderror
      @endif

      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-send me-2"></i>
        {{ __('Send Reset Link') }}
      </button>
    </form>

    <div class="auth-footer">
      <p class="text-center mb-0">{{ __('Remember your password?') }}
        <a href="{{ route('login') }}" class="auth-link">{{ __('Sign in here') }}</a>
      </p>
    </div>
  </div>
@stop