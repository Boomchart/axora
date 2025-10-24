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
          <form class="form w-100" action="{{route('admin.check')}}" method="post">
            @csrf
            <div class="text-start mb-10">
              <h1 class="text-dark mb-3 fs-2 fw-bold">{{__('Reset password')}}</h1>
            </div>
            <div class="fv-row mb-10">
              <div class="d-flex flex-stack mb-2">
                <label class="form-label text-dark fs-7 mb-0">{{__('Password')}}</label>
              </div>
              <div class="position-relative">
                <input class="form-control form-control-solid border-light" type="password" name="password" autocomplete="off" required data-toggle="password" id="password" placeholder="XXXXXX" required />
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 input-password" data-kt-password-meter-control="visibility">
                  <i class="bi bi-eye fs-2 text-dark"></i>
                </span>
              </div>
              @error('password')
              <span class="form-text">{{$message}}</span>
              @enderror
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-success btn-block me-3 my-2">
                <span class="indicator-label">{{__('Reset')}}</span>
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