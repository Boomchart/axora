@extends('auth.menu')

@section('content')
<div class="col-md-6">
  <div class="py-10">
    <div class="p-10 p-lg-15 mx-auto">
      <div class="text-center">
        <a href="{{route('home')}}" class="navbar-brand pe-3">
          <img class="mb-6 text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
        </a>
      </div>
      <div class="card rounded-5">
        <div class="card-body m-5">
          <form class="form w-100" action="{{route('admin.login')}}" method="post">
            @csrf
            <div class="text-start mb-10">
              <h1 class="text-dark mb-3 fs-2 fw-bold">{{__('Sign In to')}} {{$set->site_name}}</h1>
            </div>
            <div class="fv-row mb-10">
              <label class="form-label text-dark fs-7">{{__('Username')}}</label>
              <input class="form-control form-control-solid border-light" type="text" name="username" autocomplete="username" value="{{old('username')}}" required placeholder="Username" />
              @error('username')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            <div class="fv-row mb-10">
              <div class="d-flex flex-stack mb-2">
                <label class="form-label text-dark fs-7 mb-0">{{__('Password')}}</label>
                <a href="{{route('admin.reset')}}" class="link-success fs-7 fw-bold"><u>{{__('Forgot Password ?')}}</u></a>
              </div>
              <div class="position-relative">
                <input class="form-control form-control-solid border-light" type="password" name="password" value="{{old('password')}}" autocomplete="off" required data-toggle="password" id="password" placeholder="XXXXXX" />
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 input-password" data-kt-password-meter-control="visibility">
                  <i class="bi bi-eye fs-2 text-dark"></i>
                </span>
              </div>
              @error('password')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            <div class="form-check form-check-custom form-check-solid mb-6">
              <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="remember_me" checked />
              <label class="form-check-label" for="flexCheckDefault">{{__('Stayed signed in for 30 days')}}</label>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-success btn-block me-3 my-2">
                <span class="indicator-label">{{__('Sign In')}}</span>
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