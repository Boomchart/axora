@extends('auth.menu')

@section('content')
  <div class="auth-card auth-login-card">
    <div class="auth-header">
      <div class="auth-logo-wrap">
        <a href="{{ route('home') }}" class="auth-logo-link">
          <img
                  src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}"
                  alt="{{ $set->site_name }}"
                  loading="lazy"
                  class="auth-logo"
                  @style(getUi()->light_css)
          >
        </a>
      </div>

      <span class="auth-badge">
                <i class="bi bi-shield-lock"></i>
                {{ __('Security Verification') }}
            </span>

      <h1 class="auth-title">
        {{ __('Verify Your Identity') }}
      </h1>

      <p class="auth-subtitle">
        {{ __('Enter the verification code from your authenticator app to continue securely.') }}
      </p>
    </div>

    <div class="auth-user-card">
      <div class="auth-user-avatar">
        {{ strtoupper(substr($user->first_name, 0, 1)) }}
      </div>

      <div class="auth-user-info">
        <h6>
          {{ $user->first_name }} {{ $user->last_name }}
        </h6>

        @if(!empty($user->business))
          <p>
            {{ $user->business->name }}
          </p>
        @endif
      </div>
    </div>

    @livewire('auth.security', ['set' => $set, 'user' => $user])

    <div class="auth-footer auth-security-footer">
      <p class="mb-3">
        {{ __('Lost your device?') }}
        <a href="{{ route('contact') }}" class="auth-link">
          {{ __('Contact Support') }}
        </a>
      </p>

      <a href="{{ route('user.logout') }}" class="auth-signout-link">
        <i class="bi bi-box-arrow-left"></i>
        {{ __('Sign out and switch account') }}
      </a>
    </div>
  </div>
@stop