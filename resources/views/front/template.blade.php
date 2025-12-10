<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generic Page Template | GiftAPI</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /**
         * Custom Color Theme - Leetchi-Inspired
         * This file overrides Bootstrap 5 default colors
         * Include this AFTER your Bootstrap CSS file
         */

        /* ===========================
           COLOR VARIABLES
           =========================== */
        :root {
            /* Primary Colors - Dark Teal/Forest Green (Leetchi style) */
            --primary-color: #0D7373;
            --primary-dark: #0A5F5F;
            --primary-light: #108B8B;
            --primary-lighter: #E6F5F5;

            /* Secondary Colors - Soft Peachy Pink */
            --secondary-color: #F4C2C2;
            --secondary-dark: #F0AEAE;
            --secondary-light: #F8D6D6;
            --secondary-lighter: #F8E7E4;

            /* Neutral Colors */
            --text-primary: #2D3436;
            --text-secondary: #636E72;
            --text-light: #B2BEC3;
            --background-primary: #FFFFFF;
            --background-secondary: #F8F9FA;
            --background-accent: #FFF9F5;

            /* Border & Shadow */
            --border-color: #DFE6E9;
            --shadow-sm: 0 2px 8px rgba(13, 115, 115, 0.1);
            --shadow-md: 0 4px 16px rgba(13, 115, 115, 0.15);
            --shadow-lg: 0 8px 32px rgba(13, 115, 115, 0.2);

            /* Status Colors - Using teal and pink variations */
            --success-color: #108B8B;
            --warning-color: #F0AEAE;
            --danger-color: #D63031;
            --info-color: var(--primary-color);
        }

        /* ===========================
           GLOBAL STYLES
           =========================== */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* ===========================
           NAVIGATION
           =========================== */
        .navbar {
            background-color: var(--background-primary);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 0.625rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 0.625rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* ===========================
           PAGE HEADER
           =========================== */
        .page-header {
            background: linear-gradient(135deg, var(--primary-lighter) 0%, var(--secondary-lighter) 100%);
            padding: 5rem 0 3rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 200%;
            background: radial-gradient(circle, rgba(244, 194, 194, 0.2) 0%, transparent 70%);
            z-index: 0;
        }

        .page-header .container {
            position: relative;
            z-index: 1;
        }

        .page-header-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .page-header-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 700px;
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
           CTA SECTION
           =========================== */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            z-index: 0;
        }

        .cta-section .container {
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta-subtitle {
            font-size: 1.125rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-light {
            background-color: white;
            color: var(--primary-color);
            font-weight: 700;
            padding: 0.875rem 2rem;
            font-size: 1.125rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            color: var(--primary-dark);
        }

        .btn-outline-light {
            color: white;
            border-color: white;
            font-weight: 700;
            padding: 0.875rem 2rem;
            font-size: 1.125rem;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background-color: white;
            color: var(--primary-color);
        }

        /* ===========================
           FOOTER
           =========================== */
        .footer {
            background-color: var(--primary-dark);
            color: white;
            padding: 3rem 0 1.5rem;
        }

        .footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.125rem;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 0.5rem;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 2rem;
            padding-top: 1.5rem;
            text-align: center;
            color: rgba(255,255,255,0.6);
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

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">GiftAPI</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">How It Works</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Use Cases</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Resources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
            </ul>
            <div class="d-flex ms-3">
                <button class="btn btn-outline-primary me-2">Sign In</button>
                <button class="btn btn-primary">Get Started</button>
            </div>
        </div>
    </div>
</nav>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Resources</li>
            </ol>
        </nav>
        <h1 class="page-header-title">Resources & Insights</h1>
        <p class="page-header-subtitle">
            Explore our collection of guides, case studies, and documentation to help you
            get the most out of our gift card API platform.
        </p>
    </div>
</section>

<!-- EXAMPLE: Info Cards Section -->
<section class="content-section">
    <div class="container">
        <h2 class="section-title text-center">Explore Our Resources</h2>
        <p class="section-subtitle text-center">
            Everything you need to succeed with our platform
        </p>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <h3 class="info-card-title">Documentation</h3>
                    <p class="info-card-description">
                        Comprehensive guides and API references to help you integrate quickly and efficiently.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h3 class="info-card-title">Best Practices</h3>
                    <p class="info-card-description">
                        Learn from industry experts about optimizing your reward and incentive programs.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h3 class="info-card-title">Case Studies</h3>
                    <p class="info-card-description">
                        See how leading companies are using our API to drive engagement and growth.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EXAMPLE: Resource Cards Section -->
<section class="content-section bg-light">
    <div class="container">
        <h2 class="section-title text-center">Latest Resources</h2>
        <div class="row g-4 mt-2">
            <div class="col-md-6 col-lg-4">
                <div class="resource-card">
                    <div class="resource-image">
                        <i class="bi bi-file-text"></i>
                    </div>
                    <div class="resource-content">
                        <span class="resource-category">Guide</span>
                        <h3 class="resource-title">Getting Started with Gift Card APIs</h3>
                        <p class="resource-description">
                            A comprehensive guide to integrating our API into your application in under 30 minutes.
                        </p>
                        <div class="resource-meta">
                            <span>10 min read</span>
                            <a href="#" class="resource-link">
                                Read More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="resource-card">
                    <div class="resource-image">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="resource-content">
                        <span class="resource-category">Case Study</span>
                        <h3 class="resource-title">How TechCorp Increased Engagement by 300%</h3>
                        <p class="resource-description">
                            Learn how TechCorp used our platform to revolutionize their employee rewards program.
                        </p>
                        <div class="resource-meta">
                            <span>15 min read</span>
                            <a href="#" class="resource-link">
                                Read More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="resource-card">
                    <div class="resource-image">
                        <i class="bi bi-code-square"></i>
                    </div>
                    <div class="resource-content">
                        <span class="resource-category">Tutorial</span>
                        <h3 class="resource-title">Building Custom Reward Experiences</h3>
                        <p class="resource-description">
                            Step-by-step tutorial on creating personalized gift card experiences for your users.
                        </p>
                        <div class="resource-meta">
                            <span>20 min read</span>
                            <a href="#" class="resource-link">
                                Read More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EXAMPLE: Image + Content Section (Can be used for About Us) -->
<section class="image-content-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400/E6F5F5/0D7373?text=Our+Mission" alt="Our Mission" class="img-fluid">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Our Mission</h2>
                <p class="content-text">
                    We believe that rewards and incentives should be simple, accessible, and meaningful.
                    That's why we've built the most comprehensive gift card API platform that connects businesses
                    with thousands of global brands.
                </p>
                <p class="content-text">
                    <strong>Our vision</strong> is to empower every organization to create memorable reward experiences
                    that drive engagement, loyalty, and growth. We're committed to providing the tools, support,
                    and partnerships that make this possible.
                </p>
                <button class="btn btn-primary mt-3">Learn More About Us</button>
            </div>
        </div>
    </div>
</section>

<!-- EXAMPLE: Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <span class="stat-number">20K+</span>
                    <span class="stat-label">Active Customers</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <span class="stat-number">3,000+</span>
                    <span class="stat-label">Global Brands</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <span class="stat-number">50M+</span>
                    <span class="stat-label">Payouts Delivered</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <span class="stat-number">99.99%</span>
                    <span class="stat-label">Uptime</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EXAMPLE: Team Section (For About Us page) -->
<section class="content-section">
    <div class="container">
        <h2 class="section-title text-center">Meet Our Team</h2>
        <p class="section-subtitle text-center">
            The talented people behind our platform
        </p>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">JD</div>
                    <h3 class="team-name">Jane Doe</h3>
                    <p class="team-role">CEO & Founder</p>
                    <div class="team-social">
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">JS</div>
                    <h3 class="team-name">John Smith</h3>
                    <p class="team-role">CTO</p>
                    <div class="team-social">
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-github"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">SK</div>
                    <h3 class="team-name">Sarah Kim</h3>
                    <p class="team-role">Head of Product</p>
                    <div class="team-social">
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">MP</div>
                    <h3 class="team-name">Mike Peterson</h3>
                    <p class="team-role">Head of Sales</p>
                    <div class="team-social">
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EXAMPLE: Timeline Section (For About Us / Company History) -->
<section class="content-section bg-light">
    <div class="container">
        <h2 class="section-title text-center">Our Journey</h2>
        <p class="section-subtitle text-center">
            How we became the leading gift card API platform
        </p>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">2018</div>
                    <h3 class="timeline-title">Company Founded</h3>
                    <p class="timeline-description">
                        Started with a vision to simplify digital rewards and make them accessible to everyone.
                    </p>
                </div>
                <div class="timeline-marker"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">2020</div>
                    <h3 class="timeline-title">Series A Funding</h3>
                    <p class="timeline-description">
                        Raised $10M to expand our brand partnerships and improve our platform capabilities.
                    </p>
                </div>
                <div class="timeline-marker"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">2022</div>
                    <h3 class="timeline-title">Global Expansion</h3>
                    <p class="timeline-description">
                        Expanded to 40+ countries with support for 25 currencies and 3,000+ brands.
                    </p>
                </div>
                <div class="timeline-marker"></div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-year">2025</div>
                    <h3 class="timeline-title">Industry Leader</h3>
                    <p class="timeline-description">
                        Now serving 20,000+ customers and processing 50M+ payouts annually.
                    </p>
                </div>
                <div class="timeline-marker"></div>
            </div>
        </div>
    </div>
</section>

<!-- EXAMPLE: FAQ Section -->
<section class="content-section">
    <div class="container">
        <h2 class="section-title text-center">Frequently Asked Questions</h2>
        <p class="section-subtitle text-center">
            Find answers to common questions about our platform
        </p>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        How long does it take to integrate the API?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Most developers can complete a basic integration in under 30 minutes using our comprehensive
                        documentation and sandbox environment. Full production deployment typically takes 1-2 weeks
                        depending on your specific requirements and customization needs.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        What payment methods do you support?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We support multiple payment methods including credit cards, ACH transfers, wire transfers,
                        and digital wallets. For international transactions, we also support local payment methods
                        in various countries to make the process seamless for your users.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        Is there a minimum transaction volume required?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No, we don't have any minimum transaction volume requirements. Whether you're sending
                        10 gift cards or 10 million, our platform scales to meet your needs. You only pay for
                        what you use with our transparent, volume-based pricing.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        How do you ensure security and compliance?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We maintain the highest security standards with SOC 2 Type II compliance, PCI DSS certification,
                        and ISO 27001 accreditation. Our platform uses bank-level encryption, multi-factor authentication,
                        and advanced fraud detection to protect your data and transactions.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h3 class="footer-title">GiftAPI</h3>
                <p>The ultimate gift card API for delivering rewards and incentives instantly, globally, and securely.</p>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h4 class="footer-title">Product</h4>
                <ul>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">API Reference</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h4 class="footer-title">Company</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h4 class="footer-title">Resources</h4>
                <ul>
                    <li><a href="#">Case Studies</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Status</a></li>
                    <li><a href="#">Partners</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h4 class="footer-title">Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Security</a></li>
                    <li><a href="#">Compliance</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 GiftAPI. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>