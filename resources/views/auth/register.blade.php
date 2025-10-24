@extends('auth.menu', ['title' => 'Register'])

@section('content')
<div class="col-md-6">
  <div class="py-10">
    <div class="p-10 p-lg-15 mx-auto">
      @if($set->maintenance == 1)
      <div class="alert alert-danger">
        <div class="d-flex flex-column">
          <span>{{__('We are currently under maintenance, please try again later')}}</span>
        </div>
      </div>
      @endif
      @if($set->registration == 0)
      <div class="alert alert-danger">
        <div class="d-flex flex-column">
          <span>{{__('We are currently not accepting new users, please try again later')}}</span>
        </div>
      </div>
      @endif
      <div class="text-center">
        <a href="{{route('home')}}" class="navbar-brand pe-3">
          <img class="mb-6 text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
        </a>
      </div>
      <div class="card rounded-5">
        <div class="card-body m-5">
          <form class="form w-100" action="{{route('submitregister')}}" method="post" id="kt_sign_up_form" novalidate="novalidate">
            @csrf
            <div class="text-start mb-10">
              <h1 class="text-dark mb-2 fs-2">{{__('Create an Account')}}</h1>
              <div class="text-dark fs-7">{{__('Already have an account?')}}
                <a href="{{route('login')}}" class="link-success fw-bold"><u>{{__('Sign in here')}}</u></a>
              </div>
            </div>
            <div class="row fv-row mb-6">
              <div class="col-xl-6">
                <label class="form-label text-dark fs-7">{{__('Legal First Name')}}</label>
                <input class="form-control form-control-solid border-light" type="text" name="first_name" autocomplete="off" value="{{old('first_name')}}" required placeholder="John" />
                @error('first_name')
                <span class="form-text">{{$message}}</span>
                @enderror
              </div>
              <div class="col-xl-6">
                <label class="form-label text-dark fs-7">{{__('Legal Last Name')}}</label>
                <input class="form-control form-control-solid border-light" type="text" name="last_name" autocomplete="off" value="{{old('last_name')}}" required placeholder="Doe" />
                @error('last_name')
                <span class="form-text">{{$message}}</span>
                @enderror
              </div>
            </div>
            <div class="fv-row mb-6">
              <label class="form-label text-dark fs-7">{{__('Country')}}</label>
              <select class="form-select form-select-solid" id="country" data-control="select2" data-placeholder="{{__('Select Country')}}" name="country" required>
                @foreach(validCountries() as $val)
                <option value="{{$val->id}}" data-iso2="{{$val->real->iso2}}" data-phone-code="+{{str_replace('+', '', $val->real->phonecode)}}" @if($val->id == old('country'))selected @endif>{{$val?->real?->name}}</option>
                @endforeach
              </select>
              @error('country')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            <div class="fv-row mb-6">
              <label class="form-label text-dark fs-7">{{__('Email')}}</label>
              <input class="form-control form-control-solid border-light" type="email" name="email" autocomplete="email" value="{{old('email')}}" required placeholder="name@email.com" />
              @error('email')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            <div class="fv-row mb-6">
              <label class="form-label text-dark fs-7">{{__('Phone')}}</label>
              <div class="input-group">
                <span class="input-group-text border-0 fs-7"><span id="phoneCode"></span></span>
                <input type="tel" name="phone" id="phone" value="{{old('phone')}}" class="form-control form-control-solid border-light" placeholder="XXXX-XXXX-XXXX" required>
              </div>
              <input type="hidden" name="code" id="code" class="text-uppercase">
              @error('phone')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            @if($set->referral)
            <div class="fv-row mb-6">
              <label class="form-label text-dark fs-7">{{__('Referral Merchant ID')}}</label>
              @if($referral == null)
              <input class="form-control form-control-solid border-light" type="text" name="username" autocomplete="off" value="{{old('username')}}" placeholder="{{__('Optional')}}" />
              @else
              <input class="form-control form-control-solid border-light" type="text" name="username" autocomplete="off" value="{{(old('username') != null) ? old('username') : $referral}}" placeholder="{{__('Optional')}}" />
              @endif
              @error('username')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            @endif
            <div class="fv-row mb-10" data-kt-password-meter="true">
              <div class="d-flex flex-stack mb-2">
                <label class="form-label text-dark fs-7 mb-0">{{__('Password')}}</label>
              </div>
              <div class="position-relative mb-3">
                <input class="form-control form-control-solid border-light" type="password" name="password" autocomplete="one-time-code" required data-toggle="password" id="password" value="{{old('password')}}" />
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
            <div class="form-check form-check-custom form-check-solid mb-6">
              <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="terms" required />
              <label class="form-check-label fs-7" for="flexCheckDefault">{{__('I agree to our')}} <a target="_blank" href="{{route('terms')}}" class="text-success"><u>{{__('terms & conditions')}}</u></a></label>
            </div>
            @if($set->recaptcha==1)
            {!! RecaptchaV3::field('register') !!}
            @error('g-recaptcha-response')
            <span class="form-text">{{$message}}</span>
            @enderror
            @endif
            <div class="text-center">
              <button type="submit" class="btn btn-success btn-block me-3 my-2" id="kt_sign_up_submit">
                <span class="indicator-label">{{__('Submit')}}</span>
              </button>
              @if($set->google_sl == 1)
              <a href="{{route('redirect.login', ['type' => 'google'])}}" class="btn btn-secondary btn-block btn-lg fw-bold my-2">
                <img alt="Logo" src="{{asset('dashboard/media/svg/brand-logos/google-icon.svg')}}" class="h-20px me-3">{{__('Sign in with Google')}}
              </a>
              @endif
              @if($set->facebook_sl == 1)
              <a href="{{route('redirect.login', ['type' => 'facebook'])}}" class="btn btn-secondary btn-block btn-lg fw-bold my-2">
                <img alt="Logo" src="{{asset('dashboard/media/svg/brand-logos/facebook-icon.svg')}}" class="h-20px me-3">{{__('Sign in with Facebook')}}
              </a>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
    
  </div>
</div>
@stop
@section('script')
<script src="{{asset('dashboard/js/custom/authentication/sign-up/general.js')}}"></script>
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

  function countryChange() {
    var iso2 = $("#country").find(":selected").attr('data-iso2');
    var phoneCode = $("#country").find(":selected").attr('data-phone-code');
    $('#phoneCode').text(phoneCode);
    $('#code').val(iso2);
  }
  countryChange();
  $("#country").change(countryChange);
</script>
@endsection