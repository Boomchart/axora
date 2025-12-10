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
    <link rel="shortcut icon" href="{{asset('front/img/favicon.png')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <link rel="preload" href="{{asset('front/css/cookie.css')}}" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('front/css/toast.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('front/css/custom.css')}}">
    <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    @yield('css')
    <style>
        /* ===========================
    CLEAN PAGE HEADER (RUNA STYLE)
    =========================== */
        .page-header-clean {
            background: linear-gradient(180deg, var(--primary-lighter) 0%, var(--background-primary) 100%);
            padding: 8rem 0 5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .page-header-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .page-header-clean .page-header-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            line-height: 1.2;
            letter-spacing: -0.03em;
        }

        .page-header-clean .page-header-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header-clean {
                padding: 5rem 0 3rem;
            }

            .page-header-clean .page-header-title {
                font-size: 2.5rem;
            }

            .page-header-clean .page-header-subtitle {
                font-size: 1.125rem;
            }
        }

        @media (max-width: 576px) {
            .page-header-clean {
                padding: 4rem 0 2.5rem;
            }

            .page-header-clean .page-header-title {
                font-size: 2rem;
            }
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-top: 1.5rem;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-secondary);
        }

        /* ===========================
           CONTENT SECTIONS
           =========================== */
        .content-section {
            padding: 5rem 0;
        }

        .content-section.bg-light {
            background-color: var(--background-secondary);
        }

        .content-section.bg-accent {
            background-color: var(--background-accent);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 3rem;
        }

        .content-text {
            font-size: 1.0625rem;
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .content-text strong {
            color: var(--primary-dark);
        }

        /* ===========================
           CARD COMPONENTS
           =========================== */
        .info-card {
            background-color: var(--background-primary);
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .info-card-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-lighter) 0%, var(--secondary-lighter) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: var(--primary-color);
        }

        .info-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.75rem;
        }

        .info-card-description {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            line-height: 1.6;
        }

        /* ===========================
           IMAGE CONTENT SECTION
           =========================== */
        .image-content-section {
            padding: 5rem 0;
        }

        .image-content-section img {
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
        }

        /* ===========================
           STATS SECTION
           =========================== */
        .stats-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
        }

        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.125rem;
            opacity: 0.9;
        }

        /* ===========================
           TEAM SECTION
           =========================== */
        .team-card {
            background-color: var(--background-primary);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .team-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .team-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
        }

        .team-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .team-role {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            margin-bottom: 1rem;
        }

        .team-social {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .team-social a {
            color: var(--text-secondary);
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .team-social a:hover {
            color: var(--primary-color);
        }

        /* ===========================
           TIMELINE COMPONENT
           =========================== */
        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
        }

        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
            margin-right: 0;
            text-align: left;
        }

        .timeline-item:nth-child(even) .timeline-content {
            margin-left: 0;
            margin-right: auto;
            text-align: right;
        }

        .timeline-content {
            width: 45%;
            background-color: var(--background-primary);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 2px solid var(--border-color);
        }

        .timeline-marker {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 24px;
            height: 24px;
            background-color: var(--primary-color);
            border: 4px solid var(--background-primary);
            border-radius: 50%;
            z-index: 2;
            box-shadow: var(--shadow-sm);
        }

        .timeline-year {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .timeline-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .timeline-description {
            color: var(--text-secondary);
            font-size: 0.9375rem;
        }

        @media (max-width: 768px) {
            .timeline::before {
                left: 20px;
            }

            .timeline-marker {
                left: 20px;
            }

            .timeline-content {
                width: calc(100% - 60px);
                margin-left: 60px !important;
                text-align: left !important;
            }
        }

        /* ===========================
           RESOURCE CARD
           =========================== */
        .resource-card {
            background-color: var(--background-primary);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .resource-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .resource-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--primary-lighter) 0%, var(--secondary-lighter) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary-color);
        }

        .resource-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .resource-category {
            display: inline-block;
            background-color: var(--primary-lighter);
            color: var(--primary-color);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .resource-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.75rem;
        }

        .resource-description {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .resource-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: var(--text-light);
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .resource-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .resource-link:hover {
            gap: 0.75rem;
        }

        /* ===========================
           FAQ SECTION
           =========================== */
        .accordion-item {
            background-color: var(--background-primary);
            border: 1px solid var(--border-color);
            margin-bottom: 1rem;
            border-radius: 12px !important;
            overflow: hidden;
        }

        .accordion-button {
            background-color: var(--background-primary);
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 1.0625rem;
            padding: 1.25rem 1.5rem;
            border: none;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--primary-lighter);
            color: var(--primary-dark);
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary-light);
        }

        .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230D7373'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }

        .accordion-body {
            padding: 1.5rem;
            color: var(--text-secondary);
            line-height: 1.7;
        }
        /* ===========================
           RESPONSIVE
           =========================== */
        @media (max-width: 768px) {
            .page-header-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .cta-title {
                font-size: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

@include('partials._nav')
@yield('page_header')

@yield('content')

<!-- CTA Section -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="cta-title">Ready to Get Started?</h2>
        <p class="cta-subtitle">
            Join thousands of companies delivering instant rewards with our gift card API
        </p>
        <div class="d-flex gap-3 justify-content-center mt-4">
            <button class="btn btn-light btn-lg">Start Building Free</button>
            <button class="btn btn-outline-light btn-lg">Contact Sales</button>
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