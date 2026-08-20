<!DOCTYPE html>
<html lang="en">

<head>
  <title>{{ $title }} - {{$set->site_name}}</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="index, follow">
  <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
  <meta name="application-name" content="{{$set->site_name}}" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="description" content="{{$set->site_desc}}" />
  <link rel="shortcut icon" href="{{asset('asset/images/favicon.png')}}" />
  <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
  <link rel="preload" href="{{asset('front/css/cookie.css')}}" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <link rel="stylesheet" href="{{asset('front/css/custom.css')}}">
  <link rel="stylesheet" href="{{asset('css/auth.css')}}">
  @livewireStyles
  @yield('css')
  @include('partials.font')
</head>

<body>


  <section class="auth-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          @yield('content')
        </div>
      </div>
    </div>
  </section>

  {!!$set->livechat!!}
  {!!$set->analytic_snippet!!}
  <script src="{{asset('front/js/jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('front/vendor/@lottiefiles/lottie-player/dist/lottie-player.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie_svg.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.8.9/dist/cookieconsent.js"></script>
  <script src="{{asset('front/js/cookie.js')}}"></script>
  <x-laralert />
</body>

</html>

@livewireScripts
@stack('scripts')
<script src="{{asset('dashboard/js/alpine.js')}}"></script>
@yield('script')

@if($set->recaptcha==1)
{!! RecaptchaV3::initJs() !!}
@endif

@include('partials.extra_scripts')