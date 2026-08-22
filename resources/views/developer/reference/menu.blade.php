<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'API Reference' }} - {{ config('app.name') }} {{ __('Cards API') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('asset/images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('doc/docs.css') }}">
</head>

<body class="axora-api-doc-body">

<nav class="navbar navbar-light sticky-top axora-doc-navbar">
    <div class="container-fluid axora-doc-navbar-inner">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('asset/images/'.getUi()->dashboard_logo.'.png') }}" alt="{{ config('app.name') }}" class="navbar-logo">
        </a>

        <div class="d-none d-lg-flex align-items-center ms-auto">
            <ul class="navbar-nav flex-row align-items-center gap-4 me-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/docs/introduction') }}">{{ __('Developer') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/api-reference/countries') }}">{{ __('API Reference') }}</a>
                </li>
            </ul>

            <div class="d-flex">
                <a href="{{ route('login') }}" target="_blank" class="btn btn-outline-primary me-2">{{ __('Sign In') }}</a>
                <a href="{{ route('register') }}" target="_blank" class="btn btn-primary">{{ __('Get Started') }}</a>
            </div>
        </div>

        <button class="axora-doc-menu-toggler d-lg-none" type="button" aria-label="{{ __('Open menu') }}">
            <i class="bi bi-list"></i>
        </button>
    </div>
</nav>

<div class="axora-doc-mobile-backdrop"></div>

<aside class="axora-doc-mobile-drawer" aria-hidden="true">
    <div class="axora-doc-mobile-drawer-header">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('asset/images/'.getUi()->dashboard_logo.'.png') }}" alt="{{ config('app.name') }}" class="navbar-logo">
        </a>

        <button type="button" class="axora-doc-mobile-close" aria-label="{{ __('Close menu') }}">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="axora-doc-mobile-drawer-body">
        <div class="axora-doc-mobile-section">
            <p class="axora-doc-mobile-title">{{ __('Main Menu') }}</p>

            <ul class="axora-doc-mobile-nav">
                <li>
                    <a href="{{ url('/') }}">
                        <span class="axora-doc-mobile-link-text">{{ __('Home') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/docs/introduction') }}">
                        <span class="axora-doc-mobile-link-text">{{ __('Developer') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/api-reference/countries') }}">
                        <span class="axora-doc-mobile-link-text">{{ __('API Reference') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('pricing') }}">
                        <span class="axora-doc-mobile-link-text">{{ __('Pricing') }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="axora-doc-mobile-section">
            <p class="axora-doc-mobile-title">{{ __('API Reference') }}</p>

            <ul class="axora-doc-mobile-nav axora-doc-mobile-api-nav">
                <li>
                    <a class="{{ Request::is('api-reference/countries') ? 'active' : '' }}" href="{{ url('/api-reference/countries') }}">
                        <i class="bi bi-globe"></i>
                        <span class="axora-doc-mobile-link-text">{{ __('Countries') }}</span>
                    </a>
                </li>
                <li>
                    <a class="{{ Request::is('api-reference/balance') ? 'active' : '' }}" href="{{ url('/api-reference/balance') }}">
                        <i class="bi bi-wallet2"></i>
                        <span class="axora-doc-mobile-link-text">{{ __('Account Balance') }}</span>
                    </a>
                </li>
                <li class="axora-doc-mobile-submenu-item {{ Request::is('api-reference/gift-cards*') ? 'is-open' : '' }}">
                    <button type="button" class="axora-doc-mobile-submenu-toggle {{ Request::is('api-reference/gift-cards*') ? 'active' : '' }}">
                            <span class="axora-dev-menu-font">
                                <i class="bi bi-gift"></i>
                                <span class="axora-doc-mobile-link-text">{{ __('Gift Card') }}</span>
                            </span>
                        <i class="bi bi-chevron-down axora-doc-mobile-submenu-arrow"></i>
                    </button>

                    <ul class="axora-doc-mobile-submenu">
                        <li><a class="{{ Request::is('api-reference/gift-cards/all') ? 'active' : '' }}" href="{{ url('/api-reference/gift-cards/all') }}">{{ __('List Gift Cards') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/gift-cards/single') ? 'active' : '' }}" href="{{ url('/api-reference/gift-cards/single') }}">{{ __('Get Gift Card') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/gift-cards/quote') ? 'active' : '' }}" href="{{ url('/api-reference/gift-cards/quote') }}">{{ __('Create Gift Card Quote') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/gift-cards/order') ? 'active' : '' }}" href="{{ url('/api-reference/gift-cards/order') }}">{{ __('Order Gift Card') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/gift-cards/transactions') ? 'active' : '' }}" href="{{ url('/api-reference/gift-cards/transactions') }}">{{ __('List Gift Card Transactions') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/gift-cards/transaction') ? 'active' : '' }}" href="{{ url('/api-reference/gift-cards/transaction') }}">{{ __('Get Gift Card Transaction') }}</a></li>
                    </ul>
                </li>

                <li class="axora-doc-mobile-submenu-item {{ Request::is('api-reference/airtime*') ? 'is-open' : '' }}">
                    <button type="button" class="axora-doc-mobile-submenu-toggle {{ Request::is('api-reference/airtime*') ? 'active' : '' }}">
                            <span class="axora-dev-menu-font">
                                <i class="bi bi-phone"></i>
                                <span class="axora-doc-mobile-link-text">{{ __('Airtime') }}</span>
                            </span>
                        <i class="bi bi-chevron-down axora-doc-mobile-submenu-arrow"></i>
                    </button>

                    <ul class="axora-doc-mobile-submenu">
                        <li><a class="{{ Request::is('api-reference/airtime/operators') ? 'active' : '' }}" href="{{ url('/api-reference/airtime/operators') }}">{{ __('List Airtime Operators') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/airtime/operator') ? 'active' : '' }}" href="{{ url('/api-reference/airtime/operator') }}">{{ __('Get airtime operator') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/airtime/quote') ? 'active' : '' }}" href="{{ url('/api-reference/airtime/quote') }}">{{ __('Create Airtime Quote') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/airtime/order') ? 'active' : '' }}" href="{{ url('/api-reference/airtime/order') }}">{{ __('Order Airtime') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/airtime/transactions') ? 'active' : '' }}" href="{{ url('/api-reference/airtime/transactions') }}">{{ __('List Airtime Transactions') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/airtime/lookup') ? 'active' : '' }}" href="{{ url('/api-reference/airtime/lookup') }}">{{ __('Airtime Lookup') }}</a></li>
                    </ul>
                </li>

                <li class="axora-doc-mobile-submenu-item {{ Request::is('api-reference/data*') ? 'is-open' : '' }}">
                    <button type="button" class="axora-doc-mobile-submenu-toggle {{ Request::is('api-reference/data*') ? 'active' : '' }}">
                            <span class="axora-dev-menu-font">
                                <i class="bi bi-phone"></i>
                                <span class="axora-doc-mobile-link-text">{{ __('Data Top-Up') }}</span>
                            </span>
                        <i class="bi bi-chevron-down axora-doc-mobile-submenu-arrow"></i>
                    </button>

                    <ul class="axora-doc-mobile-submenu">
                        <li><a class="{{ Request::is('api-reference/data/operators') ? 'active' : '' }}" href="{{ url('/api-reference/data/operators') }}">{{ __('List data operators') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/data/operator') ? 'active' : '' }}" href="{{ url('/api-reference/data/operator') }}">{{ __('Get data operator') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/data/quote') ? 'active' : '' }}" href="{{ url('/api-reference/data/quote') }}">{{ __('Create data top-up Quote') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/data/order') ? 'active' : '' }}" href="{{ url('/api-reference/data/order') }}">{{ __('Order data top-up') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/data/transactions') ? 'active' : '' }}" href="{{ url('/api-reference/data/transactions') }}">{{ __('List data top-up Transactions') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/data/lookup') ? 'active' : '' }}" href="{{ url('/api-reference/data/lookup') }}">{{ __('Data top-up Lookup') }}</a></li>
                    </ul>
                </li>

                <li class="axora-doc-mobile-submenu-item {{ Request::is('api-reference/crypto*') ? 'is-open' : '' }}">
                    <button type="button" class="axora-doc-mobile-submenu-toggle {{ Request::is('api-reference/crypto*') ? 'active' : '' }}">
                            <span class="axora-dev-menu-font">
                                <i class="bi bi-currency-bitcoin"></i>
                                <span class="axora-doc-mobile-link-text">{{ __('Crypto') }}</span>
                            </span>
                        <i class="bi bi-chevron-down axora-doc-mobile-submenu-arrow"></i>
                    </button>

                    <ul class="axora-doc-mobile-submenu">
                        <li><a class="{{ Request::is('api-reference/crypto/assets') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/assets') }}">{{ __('List Crypto Assets') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/crypto/asset') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/asset') }}">{{ __('Get Crypto Asset') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/crypto/addresses') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/addresses') }}">{{ __('List Crypto Addresses') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/crypto/address') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/address') }}">{{ __('Get Crypto Address') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/crypto/create-address') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/create-address') }}">{{ __('Create Crypto Address') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/crypto/payout-quote') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/payout-quote') }}">{{ __('Create Crypto Payout Quote') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/crypto/payout') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/payout') }}">{{ __('Create Crypto Payout') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/crypto/transactions') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/transactions') }}">{{ __('List Crypto Transactions') }}</a></li>
                        <li><a class="{{ Request::is('api-reference/crypto/transaction') ? 'active' : '' }}" href="{{ url('/api-reference/crypto/transaction') }}">{{ __('Get Crypto Transaction') }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="axora-doc-mobile-actions">
            <a href="{{ route('login') }}" target="_blank" class="btn btn-outline-primary w-100">{{ __('Sign In') }}</a>
            <a href="{{ route('register') }}" target="_blank" class="btn btn-primary w-100">{{ __('Get Started') }}</a>
        </div>
    </div>
</aside>

<div class="docs-container">
    <aside class="docs-sidebar">
        <div class="sidebar-content">
            <div class="sidebar-section">
                <h3 class="sidebar-title">{{ __('API Reference') }}</h3>

                <ul class="sidebar-menu">
                    <li class="sidebar-item {{ Request::is('api-reference/countries') ? 'active' : '' }}">
                        <a href="{{ url('/api-reference/countries') }}">
                            <i class="bi bi-globe"></i> {{ __('Countries') }}
                        </a>
                    </li>


                    <li class="sidebar-item {{ Request::is('api-reference/balance') ? 'active' : '' }}">
                        <a href="{{ url('/api-reference/balance') }}">
                            <i class="bi bi-wallet2"></i> {{ __('Account Balance') }}
                        </a>
                    </li>

                    <li class="sidebar-item has-submenu {{ Request::is('api-reference/gift-cards*') ? 'active open' : '' }}">
                        <button type="button" class="submenu-toggle">
                                <span class="axora-doc-mobile-link-text">
                                    <i class="bi bi-gift"></i>{{ __('Gift Card') }}
                                </span>
                            <i class="bi bi-chevron-down submenu-arrow"></i>
                        </button>

                        <ul class="sidebar-submenu {{ Request::is('api-reference/gift-cards*') ? 'show' : '' }}">
                            <li class="sidebar-item {{ Request::is('api-reference/gift-cards/all') ? 'active' : '' }}"><a href="{{ url('/api-reference/gift-cards/all') }}">{{ __('All Gift Cards') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/gift-cards/single') ? 'active' : '' }}"><a href="{{ url('/api-reference/gift-cards/single') }}">{{ __('Show a Gift Card') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/gift-cards/quote') ? 'active' : '' }}"><a href="{{ url('/api-reference/gift-cards/quote') }}">{{ __('Gift Card Quote') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/gift-cards/order') ? 'active' : '' }}"><a href="{{ url('/api-reference/gift-cards/order') }}">{{ __('Order Gift Card') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/gift-cards/transactions') ? 'active' : '' }}"><a href="{{ url('/api-reference/gift-cards/transactions') }}">{{ __('List Gift Card Transactions') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/gift-cards/transaction') ? 'active' : '' }}"><a href="{{ url('/api-reference/gift-cards/transaction') }}">{{ __('Get Gift Card Transaction') }}</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-item has-submenu {{ Request::is('api-reference/airtime*') ? 'active open' : '' }}">
                        <button type="button" class="submenu-toggle">
                                <span class="axora-doc-mobile-link-text">
                                    <i class="bi bi-phone"></i>
                                    {{ __('Airtime') }}
                                </span>
                            <i class="bi bi-chevron-down submenu-arrow"></i>
                        </button>

                        <ul class="sidebar-submenu {{ Request::is('api-reference/airtime*') ? 'show' : '' }}">
                            <li class="sidebar-item {{ Request::is('api-reference/airtime/operators') ? 'active' : '' }}"><a href="{{ url('/api-reference/airtime/operators') }}">{{ __('List Airtime Operators') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/airtime/operator') ? 'active' : '' }}"><a href="{{ url('/api-reference/airtime/operator') }}">{{ __('Get airtime operator') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/airtime/quote') ? 'active' : '' }}"><a href="{{ url('/api-reference/airtime/quote') }}">{{ __('Create Airtime Quote') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/airtime/order') ? 'active' : '' }}"><a href="{{ url('/api-reference/airtime/order') }}">{{ __('Order Airtime') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/airtime/transactions') ? 'active' : '' }}"><a href="{{ url('/api-reference/airtime/transactions') }}">{{ __('List Airtime Transactions') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/airtime/transaction') ? 'active' : '' }}"><a href="{{ url('/api-reference/airtime/transaction') }}">{{ __('Get Airtime Transaction') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/airtime/lookup') ? 'active' : '' }}"><a href="{{ url('/api-reference/airtime/lookup') }}">{{ __('Airtime Lookup') }}</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-item has-submenu {{ Request::is('api-reference/data*') ? 'active open' : '' }}">
                        <button type="button" class="submenu-toggle">
                                <span class="axora-doc-mobile-link-text">
                                    <i class="bi bi-wifi"></i>
                                    {{ __('Data Top-Up') }}
                                </span>
                            <i class="bi bi-chevron-down submenu-arrow"></i>
                        </button>

                        <ul class="sidebar-submenu {{ Request::is('api-reference/data*') ? 'show' : '' }}">
                            <li class="sidebar-item {{ Request::is('api-reference/data/operators') ? 'active' : '' }}"><a href="{{ url('/api-reference/data/operators') }}">{{ __('List data top-up operators') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/data/operator') ? 'active' : '' }}"><a href="{{ url('/api-reference/data/operator') }}">{{ __('Get data top-up operator') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/data/quote') ? 'active' : '' }}"><a href="{{ url('/api-reference/data/quote') }}">{{ __('Create data top-up quote') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/data/order') ? 'active' : '' }}"><a href="{{ url('/api-reference/data/order') }}">{{ __('Order data top-up') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/data/transactions') ? 'active' : '' }}"><a href="{{ url('/api-reference/data/transactions') }}">{{ __('List data top-up transactions') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/data/transaction') ? 'active' : '' }}"><a href="{{ url('/api-reference/data/transaction') }}">{{ __('Get data top-up transaction') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/data/lookup') ? 'active' : '' }}"><a href="{{ url('/api-reference/data/lookup') }}">{{ __('Data top-up Lookup') }}</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-item has-submenu {{ Request::is('api-reference/crypto*') ? 'active open' : '' }}">
                        <button type="button" class="submenu-toggle">
                                <span class="axora-doc-mobile-link-text">
                                    <i class="bi bi-currency-bitcoin"></i>
                                    {{ __('Crypto') }}
                                </span>
                            <i class="bi bi-chevron-down submenu-arrow"></i>
                        </button>

                        <ul class="sidebar-submenu {{ Request::is('api-reference/crypto*') ? 'show' : '' }}">
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/assets') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/assets') }}">{{ __('List Crypto Assets') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/asset') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/asset') }}">{{ __('Get Crypto Asset') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/addresses') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/addresses') }}">{{ __('List Crypto Addresses') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/address') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/address') }}">{{ __('Get Crypto Address') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/create-address') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/create-address') }}">{{ __('Create Crypto Address') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/payout-quote') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/payout-quote') }}">{{ __('Create Crypto Payout Quote') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/payout') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/payout') }}">{{ __('Create Crypto Payout') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/transactions') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/transactions') }}">{{ __('List Crypto Transactions') }}</a></li>
                            <li class="sidebar-item {{ Request::is('api-reference/crypto/transaction') ? 'active' : '' }}"><a href="{{ url('/api-reference/crypto/transaction') }}">{{ __('Get Crypto Transaction') }}</a></li>
                        </ul>
                    </li>
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
                <h4 class="toc-title">{{ __('On This Page') }}</h4>
                <ul class="toc-list" id="tocList"></ul>
            </div>
        </aside>
    </main>
</div>

<footer class="axora-doc-footer">
    <div class="axora-doc-footer-container">
        <div class="axora-doc-footer-top">
            <div class="axora-doc-footer-brand">
                <a href="{{ url('/') }}" class="axora-doc-footer-logo">
                    <img src="{{ asset('asset/images/'.getUi()->dashboard_logo.'.png') }}" alt="{{ config('app.name') }}">
                </a>
                <p>{{ __('Build, issue, and manage digital gift cards through a simple developer-friendly API.') }}</p>
            </div>

            <div class="axora-doc-footer-links">
                <a href="{{ route('pricing') }}">{{ __('Pricing') }}</a>
                <a href="{{ route('terms') }}">{{ __('Terms') }}</a>
                <a href="{{ route('privacy') }}">{{ __('Privacy') }}</a>
            </div>
        </div>

        <div class="axora-doc-footer-bottom">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            <a href="{{ route('login') }}" target="_blank">{{ __('Sign in') }}</a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
<script src="{{ asset('doc/docs.js') }}"></script>



</body>

</html>
