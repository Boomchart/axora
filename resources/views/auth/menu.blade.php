<!doctype html>
<html class="no-js" lang="en">

<head>
  <title>{{ $title }} - {{$set->site_name}}</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="robots" content="index, follow">
  <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
  <meta name="application-name" content="{{$set->site_name}}" />
  <meta name="description" content="{{$set->site_desc}}" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="{{asset('asset/images/favicon.png')}}" />
  <link href="{{asset('dashboard/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('dashboard/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
  <link rel="stylesheet" href="{{asset('asset/filepond/css/filepond.css')}}" />
  @livewireStyles
  @yield('css')
  @include('partials.font')
</head>

<body id="kt_body" class="bg-secondary header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
  <div class="page-loading active text-indigo">
    <div class="page-loading-inner">
      <div class="page-spinner"></div><span></span>
    </div>
  </div>
  <!--begin::Main-->
  <div class="row justify-content-center">
      @yield('content')
  </div>
  {!!$set->livechat!!}
  {!!$set->analytic_snippet!!}
  <script src="{{asset('dashboard/plugins/global/plugins.bundle.js')}}"></script>
  <script src="{{asset('dashboard/js/scripts.bundle.js')}}"></script>
  <script src="{{asset('dashboard/js/custom/general.js')}}"></script>
  <script src="{{asset('asset/filepond/js/preview.js')}}"></script>
  <script src="{{asset('asset/filepond/js/crop.js')}}"></script>
  <script src="{{asset('asset/filepond/js/transform.js')}}"></script>
  <script src="{{asset('asset/filepond/js/validate-type.js')}}"></script>
  <script src="{{asset('asset/filepond/js/validate-size.js')}}"></script>
  <script src="{{asset('asset/filepond/js/filepond.js')}}"></script>
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