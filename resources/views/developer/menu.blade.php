<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$pageTitle ?? 'Documentation'}} - Axora Cards API</title>

    <!-- Google Fonts - Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Prism.js for Code Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('doc/docs.css')}}">
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{url('/')}}">
            <img src="{{asset('front/img/logo.png')}}" alt="{{config('app.name')}}" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{url('/')}}">{{__('Home')}}</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{url('/docs/introduction')}}">{{__('Documentation')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/api-reference/countries')}}">{{__('API Reference')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="">{{__('Pricing')}}</a></li>
            </ul>
            <div class="d-flex ms-3">
                <a href="" class="btn btn-outline-primary me-2">{{__('Sign In')}}</a>
                <a href="" class="btn btn-primary">{{__('Get Started')}}</a>
            </div>
        </div>
    </div>
</nav>

<!-- Documentation Layout -->
<div class="docs-container">
    <!-- Sidebar -->
    <aside class="docs-sidebar">
        <div class="sidebar-content">
            <!-- Documentation Section -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">{{__('Documentation')}}</h3>
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

    <!-- Main Content Area -->
    <main class="docs-main">
        <div class="docs-content">
            @yield('content')
        </div>

        <!-- Table of Contents (Right Sidebar) -->
        <aside class="docs-toc">
            <div class="toc-content">
                <h4 class="toc-title">{{__('On This Page')}}</h4>
                <ul class="toc-list" id="tocList">
                    <!-- JavaScript will populate this -->
                </ul>
            </div>
        </aside>
    </main>
</div>

<!-- Footer -->
<footer class="docs-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>&copy; {{date('Y')}} {{config('app.name')}}. {{__('All rights reserved')}}.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{route('terms')}}">{{__('Terms')}}</a> •
                <a href="{{route('privacy')}}">{{__('Privacy')}}</a> •
                <a href="">{{__('Support')}}</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Prism.js for Syntax Highlighting -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

<!-- Custom JS -->
<script src="{{asset('doc/docs.js')}}"></script>
</body>
</html>