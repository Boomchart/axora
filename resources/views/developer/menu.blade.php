<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$pageTitle ?? 'Developer'}} - Axora Cards API</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('doc/docs.css')}}">
</head>

<body>

    <nav class="navbar navbar-light sticky-top axora-doc-navbar">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{url('/')}}">
                <img src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{config('app.name')}}" class="navbar-logo">
            </a>

            <div class="d-none d-lg-flex align-items-center ms-auto">
                <ul class="navbar-nav flex-row align-items-center gap-4 me-4">
                    <li class="nav-item"><a class="nav-link active" href="{{url('/docs/introduction')}}">{{__('Developer')}}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('/api-reference/countries')}}">{{__('API Reference')}}</a></li>
                </ul>


                <div class="d-flex">
                    <a href="{{route('login')}}" target="_blank" class="btn btn-outline-primary me-2">{{__('Sign In')}}</a>
                    <a href="{{route('register')}}" target="_blank" class="btn btn-primary">{{__('Get Started')}}</a>
                </div>
            </div>

            <button class="axora-doc-menu-toggler d-lg-none" type="button" aria-label="{{__('Open menu')}}">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </nav>

    <div class="axora-doc-mobile-backdrop"></div>

    <aside class="axora-doc-mobile-drawer">
        <div class="axora-doc-mobile-drawer-header">
            <a class="navbar-brand d-flex align-items-center" href="{{url('/')}}">
                <img src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{config('app.name')}}" class="navbar-logo">
            </a>

            <button type="button" class="axora-doc-mobile-close" aria-label="{{__('Close menu')}}">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="axora-doc-mobile-drawer-body">
            <div class="axora-doc-mobile-section">
                <p class="axora-doc-mobile-title">{{__('Main Menu')}}</p>
                <ul class="axora-doc-mobile-nav">
                    <li><a href="{{url('/')}}">{{__('Home')}}</a></li>
                    <li><a class="active" href="{{url('/docs/introduction')}}">{{__('Developer')}}</a></li>
                    <li><a href="{{url('/api-reference/countries')}}">{{__('API Reference')}}</a></li>
                </ul>
            </div>

            <div class="axora-doc-mobile-section">
                <p class="axora-doc-mobile-title">{{__('Developer')}}</p>
                <ul class="axora-doc-mobile-nav">
                    <li><a class="{{ Request::is('docs/introduction') ? 'active' : '' }}" href="{{url('/docs/introduction')}}"><i class="bi bi-book"></i> {{__('Introduction')}}</a></li>
                    <li><a class="{{ Request::is('docs/environments') ? 'active' : '' }}" href="{{url('/docs/environments')}}"><i class="bi bi-gear"></i> {{__('Environment')}}</a></li>
                    <li><a class="{{ Request::is('docs/authentication') ? 'active' : '' }}" href="{{url('/docs/authentication')}}"><i class="bi bi-shield-lock"></i> {{__('Authentication')}}</a></li>
                    <li><a class="{{ Request::is('docs/errors') ? 'active' : '' }}" href="{{url('/docs/errors')}}"><i class="bi bi-exclamation-triangle"></i> {{__('Errors')}}</a></li>
                    <li><a class="{{ Request::is('docs/webhook') ? 'active' : '' }}" href="{{url('/docs/webhook')}}"><i class="bi bi-arrow-repeat"></i> {{__('Webhooks')}}</a></li>
                    <li><a class="{{ Request::is('docs/api-keys') ? 'active' : '' }}" href="{{url('/docs/api-keys')}}"><i class="bi bi-key"></i> {{__('Get API Keys')}}</a></li>
                </ul>
            </div>

            {{-- <div class="axora-doc-mobile-actions">--}}
            {{-- <a href="{{route('login')}}" target="_blank" class="btn btn-outline-primary w-100">{{__('Sign In')}}</a>--}}
            {{-- <a href="{{route('register')}}" target="_blank" class="btn btn-primary w-100">{{__('Get Started')}}</a>--}}
            {{-- </div>--}}
        </div>
    </aside>

    <div class="docs-container">
        <aside class="docs-sidebar">
            <div class="sidebar-content">
                <div class="sidebar-section">
                    <h3 class="sidebar-title">{{__('Developer')}}</h3>

                    <ul class="sidebar-menu">
                        <li class="sidebar-item {{ Request::is('docs/introduction') ? 'active' : '' }}"><a href="{{url('/docs/introduction')}}"><i class="bi bi-book"></i> {{__('Introduction')}}</a></li>
                        <li class="sidebar-item {{ Request::is('docs/environments') ? 'active' : '' }}"><a href="{{url('/docs/environments')}}"><i class="bi bi-gear"></i> {{__('Environment')}}</a></li>
                        <li class="sidebar-item {{ Request::is('docs/authentication') ? 'active' : '' }}"><a href="{{url('/docs/authentication')}}"><i class="bi bi-shield-lock"></i> {{__('Authentication')}}</a></li>
                        <li class="sidebar-item {{ Request::is('docs/errors') ? 'active' : '' }}"><a href="{{url('/docs/errors')}}"><i class="bi bi-exclamation-triangle"></i> {{__('Errors')}}</a></li>
                        <li class="sidebar-item {{ Request::is('docs/webhook') ? 'active' : '' }}"><a href="{{url('/docs/webhook')}}"><i class="bi bi-arrow-repeat"></i> {{__('Webhooks')}}</a></li>
                        <li class="sidebar-item {{ Request::is('docs/api-keys') ? 'active' : '' }}"><a href="{{url('/docs/api-keys')}}"><i class="bi bi-key"></i> {{__('Get API Keys')}}</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <main class="docs-main">
            <div class="docs-content">
                @yield('content')
            </div>

            <aside class="docs-toc">
                <div class="toc-content">
                    <h4 class="toc-title">{{__('On This Page')}}</h4>
                    <ul class="toc-list" id="tocList"></ul>
                </div>
            </aside>
        </main>
    </div>

    <footer class="axora-doc-footer">
        <div class="axora-doc-footer-container">
            <div class="axora-doc-footer-top">
                <div class="axora-doc-footer-brand">
                    <a href="{{url('/')}}" class="axora-doc-footer-logo">
                        <img src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{config('app.name')}}">
                    </a>
                    <p>{{__('Build, issue, and manage digital gift cards through a simple developer-friendly API.')}}</p>
                </div>

                <div class="axora-doc-footer-links">
                    <a href="{{route('pricing')}}">{{__('Pricing')}}</a>
                    <a href="{{route('terms')}}">{{__('Terms')}}</a>
                    <a href="{{route('privacy')}}">{{__('Privacy')}}</a>
                </div>
            </div>

            <div class="axora-doc-footer-bottom">
                <p>&copy; {{date('Y')}} {{config('app.name')}}. {{__('All rights reserved.')}}</p>
                <a href="{{route('login')}}" target="_blank">{{__('Sign in')}}</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="{{asset('doc/docs.js')}}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.querySelector('.axora-doc-menu-toggler');
            const closeBtn = document.querySelector('.axora-doc-mobile-close');
            const backdrop = document.querySelector('.axora-doc-mobile-backdrop');

            function openMenu() {
                document.body.classList.add('axora-doc-menu-open');
            }

            function closeMenu() {
                document.body.classList.remove('axora-doc-menu-open');
            }

            if (toggler) {
                toggler.addEventListener('click', openMenu);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeMenu);
            }

            if (backdrop) {
                backdrop.addEventListener('click', closeMenu);
            }
        });
    </script>
</body>

</html>