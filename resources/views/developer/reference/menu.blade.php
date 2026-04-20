<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$pageTitle ?? 'API Reference'}} - {{config('app.name')}} {{__('Cards API')}}</title>

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
                    <li class="nav-item"><a class="nav-link" href="{{url('/docs/introduction')}}">{{__('Developer')}}</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{url('/api-reference/countries')}}">{{__('API Reference')}}</a></li>
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
                    <li><a href="{{url('/docs/introduction')}}">{{__('Developer')}}</a></li>
                    <li><a class="active" href="{{url('/api-reference/countries')}}">{{__('API Reference')}}</a></li>
                    <li><a href="{{route('pricing')}}">{{__('Pricing')}}</a></li>
                </ul>
            </div>

            <div class="axora-doc-mobile-section">
                <p class="axora-doc-mobile-title">{{__('API Reference')}}</p>
                <ul class="axora-doc-mobile-nav">
                    <li><a class="{{ Request::is('api-reference/countries') ? 'active' : '' }}" href="{{url('/api-reference/countries')}}"><i class="bi bi-globe"></i> {{__('Countries')}}</a></li>
                    <li><a class="{{ Request::is('api-reference/gift-cards*') ? 'active' : '' }}" href="{{url('/api-reference/gift-cards/all')}}"><i class="bi bi-gift"></i> {{__('Gift Cards')}}</a></li>
                    <li><a class="{{ Request::is('api-reference/transactions*') ? 'active' : '' }}" href="{{url('/api-reference/transactions/all')}}"><i class="bi bi-arrow-left-right"></i> {{__('Transactions')}}</a></li>
                    <li><a class="{{ Request::is('api-reference/quote') ? 'active' : '' }}" href="{{url('/api-reference/quote')}}"><i class="bi bi-receipt-cutoff"></i> {{__('Quote')}}</a></li>
                    <li><a class="{{ Request::is('api-reference/order') ? 'active' : '' }}" href="{{url('/api-reference/order')}}"><i class="bi bi-box-seam"></i> {{__('Order')}}</a></li>
                    <li><a class="{{ Request::is('api-reference/balance') ? 'active' : '' }}" href="{{url('/api-reference/balance')}}"><i class="bi bi-wallet2"></i> {{__('Balance')}}</a></li>
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
                    <h3 class="sidebar-title">{{__('API Reference')}}</h3>

                    <ul class="sidebar-menu">
                        <li class="sidebar-item {{ Request::is('api-reference/countries') ? 'active' : '' }}"><a href="{{url('/api-reference/countries')}}"><i class="bi bi-globe"></i> {{__('Countries')}}</a></li>
                        <li class="sidebar-item has-submenu {{ Request::is('api-reference/gift-cards*') ? 'active' : '' }}">
                            <a href="#" class="submenu-toggle" onclick="toggleSubmenu(event)">
                                <i class="bi bi-gift"></i> {{__('Gift Cards')}}
                                <i class="bi bi-chevron-down submenu-arrow"></i>
                            </a>

                            <ul class="sidebar-submenu {{ Request::is('api-reference/gift-cards*') ? 'show' : '' }}">
                                <li class="sidebar-item {{ Request::is('api-reference/gift-cards/all') ? 'active' : '' }}"><a href="{{url('/api-reference/gift-cards/all')}}">{{__('All Gift Cards')}}</a></li>
                                <li class="sidebar-item {{ Request::is('api-reference/gift-cards/single') ? 'active' : '' }}"><a href="{{url('/api-reference/gift-cards/single')}}">{{__('Show Gift Card')}}</a></li>
                            </ul>
                        </li>

                        <li class="sidebar-item has-submenu {{ Request::is('api-reference/transactions*') ? 'active' : '' }}">
                            <a href="#" class="submenu-toggle" onclick="toggleSubmenu(event)">
                                <i class="bi bi-arrow-left-right"></i> {{__('Transactions')}}
                                <i class="bi bi-chevron-down submenu-arrow"></i>
                            </a>

                            <ul class="sidebar-submenu {{ Request::is('api-reference/transactions*') ? 'show' : '' }}">
                                <li class="sidebar-item {{ Request::is('api-reference/transactions/all') ? 'active' : '' }}"><a href="{{url('/api-reference/transactions/all')}}">{{__('All Transactions')}}</a></li>
                                <li class="sidebar-item {{ Request::is('api-reference/transactions/single') ? 'active' : '' }}"><a href="{{url('/api-reference/transactions/single')}}">{{__('Single Transaction')}}</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ Request::is('api-reference/quote') ? 'active' : '' }}"><a href="{{url('/api-reference/quote')}}"><i class="bi bi-receipt-cutoff"></i> {{__('Quote')}}</a></li>
                        <li class="sidebar-item {{ Request::is('api-reference/order') ? 'active' : '' }}"><a href="{{url('/api-reference/order')}}"><i class="bi bi-box-seam"></i> {{__('Order')}}</a></li>
                        <li class="sidebar-item {{ Request::is('api-reference/balance') ? 'active' : '' }}"><a href="{{url('/api-reference/balance')}}"><i class="bi bi-wallet2"></i> {{__('Balance')}}</a></li>
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
        function toggleSubmenu(event) {
            event.preventDefault();

            const parent = event.currentTarget.closest('.has-submenu');
            const submenu = parent.querySelector('.sidebar-submenu');

            if (!parent || !submenu) return;

            parent.classList.toggle('open');
            submenu.classList.toggle('show');
        }

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