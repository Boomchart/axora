@extends('auth.menu')

@section('content')
  <div class="auth-card">
    <div class="auth-header">
      <div class="text-center mb-3">
        <a href="{{route('home')}}" class="navbar-brand pe-3 justify-content-center">
          <img class="text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
        </a>
      </div>
      <h1 class="auth-title">{{__('Reset Password')}}</h1>
      <p class="auth-subtitle">{{__('Insert the email you created the account with and we\'ll send you a reset link.')}} </p>
    </div>

    <form action="{{route('user.password.email')}}" method="post">
      @csrf
      <div class="form-group">
        <label for="email" class="form-label">{{__('Email Address')}}</label>
        <input type="email"
               class="form-control @error('email') is-invalid @enderror"
               id="email"
               name="email"
               autocomplete="email"
               required
               placeholder="name@email.com"
               autofocus
               value="{{old('email')}}"
        >
        @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
      </div>

      @if($set->recaptcha==1)
        {!! RecaptchaV3::field('reset') !!}
        @error('g-recaptcha-response')
        <span class="invalid-feedback">{{$message}}</span>
        @enderror
      @endif

      <button type="submit" class="btn btn-primary btn-lg w-100">
        {{__('Send reset link')}}
      </button>
    </form>
    <div class="auth-footer">
      <p class="text-center mb-0">
        {{__("Already have an account??")}}
        <a href="{{route('login')}}" class="auth-link">{{__('Sign in here')}}</a>
      </p>
    </div>
  </div>

@stop



