@extends('auth.menu')

@section('content')
  <div class="auth-card auth-login-card">
    <div class="auth-header">
      <div class="auth-logo-wrap">
        <a href="{{ route('home') }}" class="auth-logo-link">
          <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-logo" @style(getUi()->light_css)>
        </a>
      </div>

      <span class="auth-badge">
                <i class="bi bi-shield-lock"></i>
                {{ __('Admin Security') }}
            </span>

      <h1 class="auth-title">
        {{ __('Reset Password') }}
      </h1>

      <p class="auth-subtitle">
        {{ __('Enter a new password to continue accessing the administrator control panel.') }}
      </p>
    </div>

    <form class="form w-100" action="{{ route('admin.check') }}" method="post">
      @csrf

      <div class="form-group">
        <label class="form-label" for="password">
          {{ __('Password') }}
        </label>

        <div class="position-relative">
          <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" autocomplete="new-password" required data-toggle="password" id="password" placeholder="XXXXXX">

          <button type="button" class="password-toggle-btn input-password" data-kt-password-meter-control="visibility" aria-label="{{ __('Toggle password visibility') }}">
            <i class="bi bi-eye"></i>
          </button>
        </div>

        @error('password')
        <span class="text-danger small mt-2 d-block">
                        {{ $message }}
                    </span>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary w-100">
                <span class="indicator-label">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ __('Reset Password') }}
                </span>
      </button>
    </form>
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