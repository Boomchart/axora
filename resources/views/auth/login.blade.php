@extends('auth.menu')

@section('content')
  <div class="auth-card">
    <div class="auth-header">
      <div class="text-center mb-3">
        <a href="{{route('home')}}" class="navbar-brand pe-3 justify-content-center">
          <img class="text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
        </a>
      </div>
      <h1 class="auth-title">{{__('Welcome back')}}</h1>
      <p class="auth-subtitle">{{__('Sign in to your')}} {{$set->site_name}} {{__('account')}}</p>
    </div>

    <div class="social-login">
      <button class="btn btn-social btn-google w-100">
        <i class="bi bi-google"></i>{{__('Continue with Google')}}
      </button>
    </div>

    <div class="divider"><span>{{__('Or sign in with email')}}</span></div>

    @livewire('auth.login', ['settings' => $set])

    <div class="auth-footer">
      <p class="text-center mb-0">
        {{__("New here?")}}
        <a href="{{route('register')}}" class="auth-link">{{__('Create an account')}}</a>
      </p>
    </div>
  </div>

@stop



