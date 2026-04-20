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
    <meta name="description" content="@yield('meta_description', $set->site_desc)" /
    <link rel="shortcut icon" href="{{asset('front/img/favicon.png')}}" />
    <!-- Google Fonts - Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

{!!$set->livechat!!}
{!!$set->analytic_snippet!!}

<script src="{{asset('front/js/bootstrap.bundle.min.js')}}"></script>

<!-- Prism.js for Syntax Highlighting -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-ruby.min.js"></script>

<script src="{{asset('front/vendor/@lottiefiles/lottie-player/dist/lottie-player.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie_svg.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.8.9/dist/cookieconsent.js"></script>
<script src="{{asset('front/js/cookie.js')}}"></script>
<script src="{{asset('front/js/toast.js')}}"></script>
{{--<script src="{{asset('asset/fonts/fontawesome/js/all.js')}}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>
@livewireScripts

<script src="{{asset('dashboard/js/alpine.js')}}"></script>
@yield('script')
@stack('script')
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




<!-- Code Snippet Tab Switcher -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const codeTabs = document.querySelectorAll('.code-tab');
        const codeBlocks = document.querySelectorAll('.code-block');

        codeTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');

                // Remove active class from all tabs and blocks
                codeTabs.forEach(t => t.classList.remove('active'));
                codeBlocks.forEach(b => b.classList.remove('active'));

                // Add active class to clicked tab
                this.classList.add('active');

                // Show corresponding code block
                const activeBlock = document.querySelector(`.code-block[data-lang="${lang}"]`);
                if (activeBlock) {
                    activeBlock.classList.add('active');

                    // Re-highlight with Prism if available
                    if (typeof Prism !== 'undefined') {
                        Prism.highlightAllUnder(activeBlock);
                    }
                }
            });
        });

        // Copy to clipboard functionality
        const copyBtn = document.querySelector('.code-copy-btn');

        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const activeBlock = document.querySelector('.code-block.active');
                const codeText = activeBlock.querySelector('code').textContent;

                // Copy to clipboard
                navigator.clipboard.writeText(codeText).then(() => {
                    // Change icon temporarily
                    const icon = this.querySelector('i');
                    const originalClass = icon.className;

                    icon.className = 'bi bi-check2';
                    this.classList.add('copied');

                    setTimeout(() => {
                        icon.className = originalClass;
                        this.classList.remove('copied');
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy:', err);
                });
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuToggler = document.querySelector('.axora-menu-toggler');
        const menuClose = document.querySelector('.axora-mobile-close');
        const backdrop = document.querySelector('.axora-mobile-backdrop');
        const mobileLinks = document.querySelectorAll('.axora-mobile-nav a');

        const openMenu = () => {
            document.body.classList.add('axora-menu-open');
        };

        const closeMenu = () => {
            document.body.classList.remove('axora-menu-open');
        };

        if (menuToggler) {
            menuToggler.addEventListener('click', openMenu);
        }

        if (menuClose) {
            menuClose.addEventListener('click', closeMenu);
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeMenu);
        }

        mobileLinks.forEach((link) => {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });
    });
</script>
@livewireScripts
</body>
</html>