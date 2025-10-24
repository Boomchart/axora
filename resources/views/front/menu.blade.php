<!doctype html>
<html class="no-js" lang="en">

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
    <link rel="stylesheet" href="{{asset('front/css/theme.css')}}" type="text/css" media="all">
    <link rel="preload" media="screen" href="{{asset('front/vendor/boxicons/css/boxicons.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" media="screen" href="{{asset('front/vendor/lightgallery/css/lightgallery-bundle.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" media="screen" href="{{asset('front/vendor/swiper/swiper-bundle.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" href="{{asset('front/css/cookie.css')}}" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('front/css/toast.css')}}" type="text/css">
    <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    @yield('css')
    @include('partials.font')
</head>

<body>
    <main class="page-wrapper">
        <header class="header navbar navbar-expand-lg bg-light navbar-sticky">
            <div class="container px-3">
                <a href="{{route('home')}}" class="navbar-brand pe-3">
                    <img src="{{asset('asset/images/logo.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->home_light_css)>
                </a>
                <div id="navbarNav" class="offcanvas offcanvas-end">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title">{{__('Menu')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                       <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
                            <li class="nav-item">
                                <a href="{{route('login')}}" class="nav-link">{{__('Sign in')}}</a>
                            </li>                            
                            <li class="nav-item">
                                <a href="{{route('register')}}" class="nav-link">{{__('Register')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a href="{{route('login')}}" class="d-none d-lg-inline-flex me-4 text-decoration-none text-dark fw-500" rel="noopener">
                    {{__('Log In')}}
                </a>
                <a href="{{route('register')}}" class="btn btn-success rounded-pill d-none d-lg-inline-flex" rel="noopener">
                    {{__('Get Started')}} <i class="fal fa-angle-right mx-2"></i>
                </a>
            </div>
        </header>
        @yield('content')
        <footer class="footer light-mode border-top border-light py-5 bg-white" data-jarallax data-img-position="0% 100%" data-speed="0.5">
            <div class="container pt-lg-4">
                <div class="row pb-5">
                    <div class="col-xl-12 col-lg-12 col-md-12 pt-4 pt-md-1 pt-lg-0">
                        <div id="footer-links" class="row">
                            <div class="col-xl-3 col-lg-3 col-6">
                                <h6 class="mb-4 fs-5 fw-500">{{__('Available Cards')}}</h6>
                                <ul class="nav flex-column mb-2 mb-lg-0">
                                    @foreach(getCardCategory() as $card)
                                    <li class="nav-item"><a href="{{route('card.category', ['slug' => $card->slug])}}" class="footer-link d-inline-block px-0 pt-1 pb-2">{{$card->name}} {{__('Gift Cards')}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-6 pt-2 pt-lg-0">
                                <h6 class="mb-4 fs-5 fw-500">{{__('Resources')}}</h6>
                                <ul class="nav flex-column mb-2 mb-lg-0 mb-3">
                                    {{--<li class="nav-item"><a href="{{route('help.center')}}" class="footer-link d-inline-block px-0 pt-1 pb-2">{{__('Help Centre')}}</a></li>
                                    <li class="nav-item"><a href="{{route('blog')}}" class="footer-link d-inline-block px-0 pt-1 pb-2">{{__('Blog')}}</a></li>--}}
                                    <li class="nav-item"><a href="{{route('developer.index')}}" target="_blank" class="footer-link d-inline-block px-0 pt-1 pb-2">{{__('Developer API')}}</a></li>
                                    @if($set->career_url != null)
                                    <li class="nav-item"><a href="{{$set->career_url}}" target="_blank" class="footer-link d-inline-block px-0 pt-1 pb-2">{{__('Careers')}}</a></li>
                                    @endif
                                    @foreach(getPage() as $val)
                                    <li class="nav-item"><a href="{{route('page', ['page' => $val->slug])}}" class="footer-link d-inline-block px-0 pt-1 pb-2">{{$val->title}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-6 pt-2 pt-lg-0">
                                <h6 class="mb-4 fs-5 fw-500">{{__('Legal')}}</h6>
                                <ul class="nav flex-column mb-2 mb-lg-0">
                                    <li class="nav-item"><a href="{{route('terms')}}" class="footer-link d-inline-block px-0 pt-1 pb-2">{{__('Terms & Conditions')}}</a></li>
                                    <li class="nav-item"><a href="{{route('privacy')}}" class="footer-link d-inline-block px-0 pt-1 pb-2">{{__('Privacy Policy')}}</a></li>
                                </ul>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-6 pt-2 pt-lg-0">
                                <h6 class="mb-4 fs-5 fw-500">{{__('Contact')}}</h6>
                                <p class="fs-sm pb-lg-3 mb-0 text-dark"><a href="{{route('contact')}}" class="footer-link">{{__('Get in Touch')}}</a></p>
                                <p class="fs-sm pb-lg-3 mb-0 text-dark"><a class="footer-link" href="mailto:{{$set->email}}"><i class="bi bi-envelope"></i> {{$set->email}}</a></p>
                                <p class="fs-sm mb-3 text-dark"><a class="footer-link" href="tel:{{$set->mobile}}"><i class="fal fa-phone-volume"></i> {{$set->mobile}}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        @if($set->language)
                        <div class="btn-group dropdown my-5">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fi fi-{{strtolower(getDefaultLang()->iso2)}} me-2 fis fs-sm rounded-4 text-dark"></span> <span>{{ucwords(getDefaultLang()->name)}} ({{ucwords(getDefaultLang()->iso2)}})</span>
                            </button>
                            <div class="dropdown-menu my-1">
                                @foreach(getLang() as $val)
                                <a class="dropdown-item" href="{{route('lang', ['locale' => $val->code])}}"><span class="fi fi-{{strtolower($val->iso2)}} me-2 fis fs-sm rounded-4 text-dark"></span> {{ucwords($val->name)}} ({{$val->iso2}})</a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if(getUi()->address1_t)
                        <p class="fs-sm pb-lg-3 mb-1 text-dark"><span class="fi fi-{{strtolower(getUi()->address1_c)}} me-2 fis fs-sm rounded-4 text-dark"></span> {{getUi()->address1_t}}</p>
                        @endif
                        @if(getUi()->address2_t)
                        <p class="fs-sm pb-lg-3 mb-1 text-dark"><span class="fi fi-{{strtolower(getUi()->address2_c)}} me-2 fis fs-sm rounded-4 text-dark"></span> {{getUi()->address2_t}}</p>
                        @endif
                        @if(getUi()->address3_t)
                        <p class="fs-sm pb-lg-3 mb-1 text-dark"><span class="fi fi-{{strtolower(getUi()->address3_c)}} me-2 fis fs-sm rounded-4 text-dark"></span> {{getUi()->address3_t}}</p>
                        @endif
                        <div class="d-flex mb-5">
                            @foreach(getSocial() as $val)
                            @if(!empty($val->value))
                            <a href="{{$val->value}}" class="mx-2" target="_blank">
                                <i class="bi bi-{{($val->type != 'twitter') ? $val->type : 'twitter-x'}} fs-3 text-success"></i>
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="space-1">
                    <!-- Copyright -->
                    <div class="w-md-75 text-lg-center mx-lg-auto">
                        <p class="small text-dark">© {{$set->site_name}}. {{date('Y')}}. {{__('All rights reserved.')}}</p>
                        <p class="small text-dark">{{__('When you visit or interact with our sites, services or tools, we or our authorised service providers may use cookies for storing information to help provide you with a better, faster and safer experience and for marketing purposes.')}}</p>
                    </div>
                    <!-- End Copyright -->
                </div>
            </div>
        </footer>


        <!-- Back to top button -->
        <a href="#top" class="btn-scroll-top" data-scroll>
            <span class="btn-scroll-top-tooltip text-muted fs-sm me-2">{{__('Top')}}</span>
            <i class="btn-scroll-top-icon bx bx-chevron-up"></i>
        </a>
    </main>
    {!!$set->livechat!!}
    {!!$set->analytic_snippet!!}
    <script src="{{asset('front/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('front/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('front/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js')}}"></script>
    <script src="{{asset('front/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('front/vendor/jarallax/dist/jarallax.min.js')}}"></script>
    <script src="{{asset('front/vendor/cleave.js/dist/cleave.min.js')}}"></script>
    <script src="{{asset('front/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('front/vendor/parallax-js/dist/parallax.min.js')}}"></script>
    <script src="{{asset('front/vendor/rellax/rellax.min.js')}}"></script>
    <script src="{{asset('front/vendor/shufflejs/dist/shuffle.min.js')}}"></script>
    <script src="{{asset('front/vendor/lightgallery/lightgallery.min.js')}}"></script>
    <script src="{{asset('front/vendor/lightgallery/plugins/video/lg-video.min.js')}}"></script>
    <script src="{{asset('front/vendor/@lottiefiles/lottie-player/dist/lottie-player.js')}}"></script>
    <script src="{{asset('front/js/theme.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie_svg.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.8.9/dist/cookieconsent.js"></script>
    <script src="{{asset('front/js/cookie.js')}}"></script>
    <script src="{{asset('front/js/toast.js')}}"></script>
    <script src="{{asset('asset/fonts/fontawesome/js/all.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>
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

    @if($set->recaptcha==1)
    {!! RecaptchaV3::initJs() !!}
    @endif

</body>

</html>