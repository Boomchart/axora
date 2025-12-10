<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css) class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#features">{{__('Features')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="#how-it-works">{{__('How It Works')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="#use-cases">{{__('Use Cases')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('developer.index')}}" target="_blank">{{__('Documentation')}}</a></li>
            </ul>
            <div class="d-flex ms-3">
                <a href="{{route('login')}}" class="btn btn-outline-primary me-2">{{__('Sign In')}}</a>
                <a href="{{route('register')}}" class="btn btn-primary">{{__('Get Started')}}</a>
            </div>
        </div>
    </div>
</nav>