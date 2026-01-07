<!doctype html>
<html class="no-js" lang="en">

<head>
    <title>{{ $title }} - {{ $set->site_name }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ getUi()->favicon }}" />

    {{-- Core Styles --}}
    <link href="{{ asset('dashboard/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dashboard/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/flag-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />

    @livewireStyles
    @yield('css')
    @include('partials.font')
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">

<div class="page-loading active">
    <div class="page-loading-inner">
        <div class="page-spinner"></div><span></span>
    </div>
</div>

@yield('content')
{!! $set->livechat !!}
{!! $set->analytic_snippet !!}
<script src="{{ asset('dashboard/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('dashboard/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('dashboard/js/pincode.js') }}"></script>
<script src="{{ asset('dashboard/js/custom/general.js') }}"></script>
<script src="{{ asset('asset/filepond/js/preview.js') }}"></script>
<script src="{{ asset('asset/filepond/js/crop.js') }}"></script>
<script src="{{ asset('asset/filepond/js/transform.js') }}"></script>
<script src="{{ asset('asset/filepond/js/validate-type.js') }}"></script>
<script src="{{ asset('asset/filepond/js/validate-size.js') }}"></script>
<script src="{{ asset('asset/filepond/js/filepond.js') }}"></script>
</body>
</html>

@livewireScripts
@stack('scripts')
<script src="{{ asset('dashboard/js/alpine.js') }}"></script>
@yield('script')


@if (session('success'))
    <script>
        "use strict";
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.closeButton = true;
        toastr.success("{!! session('success') !!}");
    </script>
@endif

@if (session('alert'))
    <script>
        "use strict";
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.closeButton = true;
        toastr.warning("{!! session('alert') !!}");
    </script>
@endif

@if ($set->recaptcha == 1)
    {!! RecaptchaV3::initJs() !!}
@endif

@include('partials.extra_scripts')