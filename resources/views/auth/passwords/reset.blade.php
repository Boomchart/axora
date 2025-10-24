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
          <form class="form w-100" action="{{route('user.password.request')}}" method="post" id="kt_sign_up_form" novalidate="novalidate">
            @csrf
            <div class="text-center mb-10">
              <h1 class="text-dark fs-2 mb-3">{{__('Recover your account')}}</h1>
              <div class="text-dark fw-bold fs-7">{{__('New Here?')}}
                <a href="{{route('register')}}" class="link-success fw-bold"><u>{{__('Create an Account')}}</u></a>
              </div>
            </div>
            <div class="fv-row mb-10">
              <label class="form-label text-dark fs-7">{{__('Email')}}</label>
              <input class="form-control form-control-solid border-light" type="email" name="email" autocomplete="email" value="{{$email}}" required readonly />
              @error('email')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            <div class="fv-row mb-10" data-kt-password-meter="true">
              <div class="d-flex flex-stack mb-2">
                <label class="form-label text-dark fs-7 mb-0">{{__('Password')}}</label>
              </div>
              <div class="position-relative mb-3">
                <input class="form-control form-control-solid border-light" type="password" name="password" autocomplete="off" required data-toggle="password" id="password" value="{{old('password')}}" />
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 input-password" data-kt-password-meter-control="visibility">
                  <i class="bi bi-eye fs-2 text-dark"></i>
                </span>
              </div>

              <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
              </div>
              <div class="text-muted">{{__('Use 8 or more characters with a mix of letters, numbers & symbols')}}.</div>
              @error('password')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            <div class="fv-row mb-5">
              <label class="form-label text-dark fs-7">Confirm Password</label>
              <input class="form-control form-control-solid border-light" type="password" placeholder="" name="confirm-password" autocomplete="off" required value="{{old('confirm-password')}}" />
            </div>
            @if($set->recaptcha==1)
            {!! RecaptchaV3::field('new-password') !!}
            @error('g-recaptcha-response')
            <span class="form-text">{{$message}}</span>
            @enderror
            @endif
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="text-center">
              <button type="submit" class="btn btn-success btn-block me-3 my-2" id="kt_sign_up_submit">
                <span class="indicator-label">{{__('Continue')}}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
  </div>
</div>
@stop
@section('script')
<script src="{{asset('dashboard/js/custom/authentication/sign-up/password-reset.js')}}"></script>
<script>
  ! function($) {
    'use strict';
    $(function() {
      $('[data-toggle="password"]').each(function() {
        var input = $(this);
        var eye_btn = $(this).parent().find('.input-password');
        eye_btn.css('cursor', 'pointer').addClass('input-password-hide');
        eye_btn.on('click', function() {
          if (eye_btn.hasClass('input-password-hide')) {
            eye_btn.removeClass('input-password-hide').addClass('input-password-show');
            eye_btn.find('.bi').removeClass('bi-eye').addClass('bi-eye-slash')
            input.attr('type', 'text');
          } else {
            eye_btn.removeClass('input-password-show').addClass('input-password-hide');
            eye_btn.find('.bi').removeClass('bi-eye-slash').addClass('bi-eye')
            input.attr('type', 'password');
          }
        });
      });
    });
  }(window.jQuery);
</script>
@endsection