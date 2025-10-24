@extends('auth.menu')

@section('content')
<div class="col-md-5">
  <div class="py-10">
    <div class="p-10 p-lg-15 mx-auto">
      <div class="text-center">
        <a href="{{route('home')}}" class="navbar-brand pe-3">
          <img class="mb-6 text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
        </a>
      </div>
      <div class="card rounded-5">
        <div class="card-body">
          <form class="form w-100" action="{{route('user.password.email')}}" method="post">
            @csrf
            <div class="text-start mb-10">
              <h1 class="text-dark fs-2 mb-3">{{__('Reset Password')}}</h1>
              <div class="text-dark fs-7">{{__('Insert the email you created the account with and we\'ll send you a reset link.')}}</div>
              <div class="text-dark fs-7">{{__('Already have an account?')}}
                <a href="{{route('login')}}" class="link-success fw-bold"><u>{{__('Sign in here')}}</u></a>
              </div>
            </div>
            <div class="fv-row mb-10">
              <label class="form-label text-dark fs-7">{{__('Email')}}</label>
              <input class="form-control form-control-solid border-light" type="email" name="email" autocomplete="email" value="{{old('email')}}" required placeholder="name@email.com" />
              @error('email')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            @if($set->recaptcha==1)
            {!! RecaptchaV3::field('reset') !!}
            @error('g-recaptcha-response')
            <span class="form-text">{{$message}}</span>
            @enderror
            @endif
            <div class="text-center">
              <button type="submit" class="btn btn-success btn-block me-3 my-2">
                <span class="indicator-label">{{__('Send reset link')}}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
  </div>
</div>
@stop