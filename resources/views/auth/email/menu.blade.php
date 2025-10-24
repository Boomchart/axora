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
  <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('dashboard/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('dashboard/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
  @yield('css')
  @include('partials.font')
</head>

<body id="kt_body" class="bg-dark header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid">
      <!--begin::Aside-->
      @yield('content')
    </div>
    <!--end::Authentication - Sign-in-->
  </div>
  {!!$set->livechat!!}
  {!!$set->analytic_snippet!!}
  <script src="{{asset('dashboard/plugins/global/plugins.bundle.js')}}"></script>
  <script src="{{asset('dashboard/js/scripts.bundle.js')}}"></script>
  <script src="{{asset('asset/fonts/fontawesome/js/all.js')}}"></script>
</body>

</html>
@yield('script')
@if (session('success'))
<script>
  "use strict";
  toastr.success("{!! session('success') !!}");
</script>
@endif
@if (session('alert'))
<script>
  "use strict";
  toastr.warning("{!! session('alert') !!}");
</script>
@endif
@if($set->recaptcha==1)
{!! RecaptchaV3::initJs() !!}
@endif