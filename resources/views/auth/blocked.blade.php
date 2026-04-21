@extends('auth.menu')

@section('content')
  <div class="auth-logo-wrap auth-logo-outside">
    <a href="{{ route('home') }}" class="auth-logo-link">
      <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-logo"@style(getUi()->light_css)>
    </a>
  </div>
  <div class="auth-card auth-login-card">
    <div class="auth-header">
      <span class="auth-badge"><i class="bi bi-exclamation-triangle"></i>{{ __('Account Suspended') }}</span>
      <h1 class="auth-title">{{ __('Your Account Has Been Suspended') }}</h1>

      <p class="auth-subtitle">
        {{ __('Your access is currently restricted. Please contact support for more information or assistance with your account.') }}
      </p>
    </div>

    <div class="auth-alert auth-alert-error">
      <div class="auth-alert-icon">
        <i class="bi bi-shield-exclamation"></i>
      </div>

      <div>
        <strong>{{ __('Access Restricted') }}</strong>
        <p class="mb-0 mt-1">{{ __('You may need to resolve an account, verification, security, or compliance issue before access can be restored.') }}</p>
      </div>
    </div>

    <div class="auth-action-stack">
      <a href="{{ route('contact') }}" class="btn btn-primary w-100">
        <i class="bi bi-chat-dots me-2"></i>
        {{ __('Contact Support') }}
      </a>

      <a href="{{ route('user.logout') }}" class="btn btn-outline-secondary w-100">
        <i class="bi bi-box-arrow-left me-2"></i>
        {{ __('Sign Out') }}
      </a>
    </div>
  </div>
@stop