<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('partials._seo')
    <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
    <meta name="application-name" content="{{$set->site_name}}" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <link rel="shortcut icon" href="{{asset('asset/images/favicon.png')}}" />
    <!-- Google Fonts - Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <link rel="preload" href="{{asset('front/css/cookie.css')}}" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('front/css/toast.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('front/css/custom.css')}}?v={{ filemtime(public_path('front/css/custom.css')) }}">
    <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    @yield('css')
    @stack('css')
    @livewireStyles
</head>
<body>

@include('partials._nav')

@yield('content')

<!-- CTA Section -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="cta-title">{{__('Get Started with')}} {{config('app.name')}} {{__('Today')}}</h2>
        <p class="cta-subtitle mb-4">{{__('Integrate with our Gift Card API and start building your rewards and incentives platform')}}</p>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="cta-card">
                    <div class="cta-icon"><i class="bi bi-code-square"></i></div>
                    <h3>{{__('Developers')}}</h3>
                    <p>{{__('Access our sandbox environment and start building with comprehensive documentation')}}</p>
                    <a href="{{route('developer.index')}}" target="_blank" class="btn btn-light mt-3">{{__('View Documentation')}}</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="cta-card">
                    <div class="cta-icon"><i class="bi bi-rocket-takeoff"></i></div>
                    <h3>{{__('Businesses')}}</h3>
                    <p>{{__('Scale your gift card operations with our enterprise-grade API platform')}}</p>
                    <a href="{{route('contact')}}" class="btn btn-light mt-3">{{__('Contact Sales')}}</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="cta-card">
                    <div class="cta-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h3>{{__('Need Help?')}}</h3>
                    <p>{{__('Our support team is ready to assist you with integration and setup')}}</p>
                    <a href="{{route('help.center')}}" class="btn btn-light mt-3">{{__('Contact Support')}}</a>
                </div>
            </div>
        </div>
        <div class="mt-5 pt-4 border-top border-white border-opacity-25">
            <p class="mb-3 opacity-75">{{__('Trusted by developers and businesses worldwide')}}</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{route('blog.index')}}" class="btn btn-outline-light"><i class="bi bi-discord me-2"></i>{{__('View blog')}}</a>
                <a href="{{route('developer.index')}}" target="_blank" class="btn btn-outline-light"><i class="bi bi-file-text me-2"></i>{{__('API Reference')}}</a>
            </div>
        </div>
    </div>
</section>

@include('partials._footer')

@include('partials._foot')