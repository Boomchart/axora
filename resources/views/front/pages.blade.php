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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <link rel="preload" href="{{asset('front/css/cookie.css')}}" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('front/css/toast.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('front/css/custom.css')}}">
    <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    @yield('css')
    @stack('css')
    @livewireStyles
</head>
<body>

@include('partials._nav')
@yield('page_header')

@yield('content')

<!-- CTA Section -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="cta-title">{{__('Ready to Get Started?')}}</h2>
        <p class="cta-subtitle">
            {{__('Join thousands of companies delivering instant rewards with our gift card API')}}
        </p>
        <div class="d-flex gap-3 justify-content-center mt-4">
            <a href="{{route('register')}}" class="btn btn-light btn-lg">{{__('Start Building')}}</a>
            <a href="{{route('contact')}}" class="btn btn-outline-light btn-lg">{{__('Contact Sales')}}</a>
        </div>
    </div>
</section>

@include('partials._footer')

@include('partials._foot')