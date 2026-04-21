@extends('auth.menu')

@section('content')
  <div class="auth-logo-wrap auth-logo-outside">
    <a href="{{ route('home') }}" class="auth-logo-link">
      <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-logo"@style(getUi()->light_css)>
    </a>
  </div>
  <div class="auth-card auth-login-card">
    <div class="auth-header">
      <span class="auth-badge">
            <i class="bi bi-shield-lock"></i>
            {{ __('Admin Access') }}
        </span>

      <h1 class="auth-title">{{ __('Control Panel') }}</h1>

      <p class="auth-subtitle">
        {{ __('Sign in securely to manage your') }} {{ $set->site_name }} {{ __('administrator account.') }}
      </p>
    </div>

    <form class="auth-form" action="{{ route('admin.login') }}" method="post">
      @csrf

      <div class="form-group">
        <label for="username" class="form-label">
          {{ __('Username') }}
        </label>

        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required placeholder="{{ __('Username') }}" value="{{ old('username') }}" autocomplete="username" autofocus>

        @error('username')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="form-group">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <label for="password" class="form-label mb-0">
            {{ __('Password') }}
          </label>

          @if (Route::has('admin.reset'))
            <a href="{{ route('admin.reset') }}" class="auth-link small">
              {{ __('Forgot password?') }}
            </a>
          @endif
        </div>

        <div class="password-input-wrapper position-relative" x-data="{ show: false }">
          <input :type="show ? 'text' : 'password'" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="XXXXXXXXX" required autocomplete="current-password">

          <button type="button" class="password-toggle-btn" x-on:click="show = !show" aria-label="{{ __('Toggle password visibility') }}">
            <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
          </button>
        </div>

        @error('password')
        <div class="invalid-feedback d-block">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="auth-form-options">
        <div class="form-check mb-0">
          <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
          <label class="form-check-label" for="remember_me">{{ __('Stay signed in for 30 days') }}</label>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">
          <span class="indicator-label">
              <i class="bi bi-box-arrow-in-right me-2"></i>
              {{ __('Sign In') }}
          </span>
      </button>
    </form>
  </div>
@stop