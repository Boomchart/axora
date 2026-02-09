@extends('auth.menu')

@section('content')
<div class="auth-card">
  <div class="auth-header">
    <div class="text-center mb-3">
      <a href="{{route('home')}}" class="navbar-brand pe-3 justify-content-center">
        <img class="text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
      </a>
    </div>
    <h1 class="auth-title">{{__('Control Panel')}}</h1>
    <p class="auth-subtitle">{{__('Sign in to your ')}} {{$set->site_name}} {{__('administrator account')}}</p>
  </div>

  <form class="auth-form" action="{{route('admin.login')}}" method="post">
    @csrf
    <div class="form-group">
      <label for="username" class="form-label">{{__('Username')}}</label>
      <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required placeholder="Username" value="{{old('username')}}" autofocus>
      @error('username')<div class="invalid-feedback">{{$message}}</div>@enderror
    </div>

    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <label for="password" class="form-label mb-0">{{__('Password')}}</label>
        @if (Route::has('admin.reset'))
          <a href="{{route('admin.reset')}}" class="forgot-link">{{__('Forgot password?')}}</a>
        @endif
      </div>

      <div class="password-input-wrapper position-relative" x-data="{ show: false }" wire:key="password-field-toggle">
        <input :type="show ? 'text' : 'password'" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="XXXXXXXXX" required>

        <button type="button" class="password-toggle position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent"
                x-on:click="show = !show" style="z-index: 10; cursor: pointer;"><i class="bi" :class="show ? 'bi-eye' : 'bi-eye-slash'"></i>
        </button>
      </div>
      @error('password')<div class="invalid-feedback d-block">{{$message}}</div>@enderror
    </div>

    <div class="form-check mb-4">
      <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
      <label class="form-check-label" for="remember_me">{{__('Stayed signed in for 30 days')}}</label>
    </div>
    <button type="submit" class="btn btn-primary btn-block w-100">
      <span class="indicator-label">{{__('Sign In')}}</span>
    </button>
  </form>

</div>
@stop
