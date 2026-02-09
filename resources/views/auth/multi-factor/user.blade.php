@extends('auth.menu')

@section('content')
  <div class="auth-card">
    <div class="text-center mb-5">
      <a href="{{route('home')}}">
        <img class="text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
      </a>
    </div>

    <div class="text-center mb-4">
      <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 60px; height: 60px;">
        <i class="bi bi-shield-lock-fill fs-1 text-primary"></i>
      </div>
      <h1 class="auth-title fs-3">{{__('Security Verification')}}</h1>
      <p class="auth-subtitle">
        {{__('Please enter the OTP code from your authenticator app.')}}
      </p>
    </div>

    <div class="d-flex align-items-center justify-content-center bg-light p-3 rounded-3 mb-5 border border-dashed">
      <div class="symbol symbol-35px me-3">
        <div class="symbol-label bg-white text-primary fw-bold border border-primary">
          {{ strtoupper(substr($user->first_name, 0, 1)) }}
        </div>
      </div>
      <div class="text-start">
        <div class="fw-bold text-dark fs-6">{{ $user->first_name }} {{ $user->last_name }}</div>
        <div class="text-muted fs-8">{{ $user->business->name }}</div>
      </div>
    </div>
    @livewire('auth.security', ['set' => $set, 'user' => $user])


    {{-- 5. Footer Actions --}}
    <div class="auth-footer text-center border-0 pt-0 mt-0">
      <p class="text-secondary mb-3 small">{{__('Lost your device?')}} <a href="#" class="auth-link">{{__('Contact Support')}}</a></p>

      {{-- Logout is safer here than Register --}}
      <a href="{{route('user.logout')}}" class="btn btn-sm btn-outline-secondary border-0 text-muted">
        <i class="bi bi-box-arrow-left me-1"></i> {{__('Sign out and switch account')}}
      </a>
    </div>

  </div>

@stop
