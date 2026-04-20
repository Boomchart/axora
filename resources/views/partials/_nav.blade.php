
<nav class="navbar navbar-expand-xl navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="navbar-logo">
        </a>

        <button class="navbar-toggler axora-menu-toggler" type="button" aria-label="{{ __('Open menu') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop menu -->
        <div class="d-none d-xl-flex align-items-center flex-grow-1">
            <ul class="navbar-nav mx-auto gap-xl-4">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('solutions') ? 'active' : '' }}" href="{{ route('solutions') }}">{{ __('Solutions') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}" href="{{route('pricing')}}">{{ __('Pricing') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('developer.*') ? 'active' : '' }}" href="{{ route('developer.index') }}" target="_blank">{{ __('Developers') }}</a></li>
            </ul>

            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">{{ __('Sign In') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Get Started') }}</a>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Backdrop -->
<div class="axora-mobile-backdrop"></div>

<!-- Mobile Drawer -->
<aside class="axora-mobile-drawer">
    <div class="axora-mobile-drawer-header">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="navbar-logo">
        </a>

        <button type="button" class="axora-mobile-close" aria-label="{{ __('Close menu') }}">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="axora-mobile-drawer-body">
        <ul class="axora-mobile-nav">
            <li><a href="{{ route('solutions') }}" class="{{ request()->routeIs('solutions') ? 'active' : '' }}">{{ __('Solutions') }}</a></li>
            <li><a href="{{route('pricing')}}" class="{{ request()->routeIs('pricing') ? 'active' : '' }}">{{ __('Pricing') }}</a></li>
            <li><a href="{{ route('developer.index') }}" class="{{ request()->routeIs('developer.*') ? 'active' : '' }}" target="_blank">{{ __('Developers') }}</a></li>
        </ul>

        <div class="axora-mobile-actions">
            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">{{ __('Sign In') }}</a>
            <a href="{{ route('register') }}" class="btn btn-primary w-100">{{ __('Get Started') }}</a>
        </div>
    </div>
</aside>

