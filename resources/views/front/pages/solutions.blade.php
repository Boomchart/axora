@extends('front.menu')

<meta name="description" content="Solutions" />

@section('content')
    <section class="hero-section text-center py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold" style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">{{ __('B2B Solutions') }}</span>
                    <h1 class="hero-title mb-3">{{ __('Gift Card API Solutions for Businesses') }}</h1>
                    <p class="hero-subtitle mx-auto">{{ __('Launch gift card, reward, and digital value experiences inside your product with flexible API infrastructure designed for modern business platforms.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="image-content-section mb-5">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-10">
                    <div class="axora-b2b-notice">
                        <div class="row align-items-center g-4">
                            <div class="col-lg-2 text-lg-center">
                                <div class="axora-solutions-icon mb-0">
                                    <i class="bi bi-building-check"></i>
                                </div>
                            </div>

                            <div class="col-lg-10">
                                <h3>{{ __('Built for Businesses') }}</h3>
                                <p>
                                    {{ __('We serve businesses, registered organizations, platforms, and approved developers that need reliable gift card API infrastructure for their products, teams, customers, and business operations. Our platform is designed for business use cases rather than direct individual consumer purchases.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-bank"></i></div>
                                <h4>{{ __('Fintech Platforms') }}</h4>
                                <p>{{ __('Enable gift card purchasing, distribution, or reward functionality directly inside your fintech product, wallet, payment platform, or digital financial service.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-gift"></i></div>
                                <h4>{{ __('Reward & Loyalty Platforms') }}</h4>
                                <p>{{ __('Power customer rewards, loyalty campaigns, referral incentives, cashback experiences, and promotional programs using flexible gift card API infrastructure.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-cart-check"></i></div>
                                <h4>{{ __('E-commerce Businesses') }}</h4>
                                <p>{{ __('Add gift card services to your commerce platform, marketplace, or customer engagement flow to support digital value distribution and business promotions.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-people"></i></div>
                                <h4>{{ __('Corporate Gifting & Team Incentives') }}</h4>
                                <p>{{ __('Support employee appreciation, team incentives, customer compensation, partner rewards, and corporate gifting programs through a reliable B2B gift card solution.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-code-slash"></i></div>
                                <h4>{{ __('Developer-Led Applications') }}</h4>
                                <p>{{ __('Give your development team the tools to integrate gift card functionality into internal tools, SaaS products, dashboards, and custom business applications.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-diagram-3"></i></div>
                                <h4>{{ __('Business API Integrations') }}</h4>
                                <p>{{ __('Connect gift card services into your existing business systems, workflows, and platforms using APIs designed for approved B2B use cases.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop