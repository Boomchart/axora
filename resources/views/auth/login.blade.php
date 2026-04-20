@extends('auth.menu')

@section('content')
  <div class="auth-card auth-login-card">
    <div class="auth-header">
      <div class="auth-logo-wrap">
        <a href="{{ route('home') }}" class="auth-logo-link">
          <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-logo"@style(getUi()->light_css)>
        </a>
      </div>

      <span class="auth-badge"><i class="bi bi-shield-lock"></i>{{ __('Secure Login') }}</span>

      <h1 class="auth-title">{{ __('Welcome Back') }}</h1>

      <p class="auth-subtitle">
        {{ __('Sign in with your email address to access your') }} {{ $set->site_name }} {{ __('dashboard.') }}
      </p>
    </div>

    @livewire('auth.login', ['settings' => $set])

    <div class="auth-footer">
      <p class="text-center mb-0">
        {{ __("New here?") }}
        <a href="{{ route('register') }}" class="auth-link">
          {{ __('Create an account') }}
        </a>
      </p>
    </div>
  </div>
@stop