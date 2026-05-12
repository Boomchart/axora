@extends('front.pages')

<meta name="description" content="Solutions" />

@section('content')
    <section class="hero-section text-center py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold" style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">{{ __('B2B Solutions') }}</span>
                    <h1 class="hero-title mb-3">{{ __('Digital Assets & Rewards Infrastructure') }}</h1>
                    <p class="hero-subtitle mx-auto">{{ __('Launch global airtime, data bundles, crypto wallets, and gift card experiences inside your product with a flexible Unified API designed for modern businesses.') }}</p>
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
                                    {{ __('We serve businesses, registered organizations, platforms, and approved developers that need reliable infrastructure for digital assets, global payouts, and rewards. Our platform is designed for scalable business use cases across airtime, data bundles, crypto, and gift cards rather than direct individual consumer purchases.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-bank"></i></div>
                                <h4>{{ __('Fintech Platforms') }}</h4>
                                <p>{{ __('Enable Web3 wallet generation, crypto off-ramping, cross-border airtime and data top-ups, or reward functionality directly inside your fintech product, digital wallet, or payment platform.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-gift"></i></div>
                                <h4>{{ __('Reward & Loyalty Programs') }}</h4>
                                <p>{{ __('Power customer rewards, loyalty campaigns, referral incentives, and promotional programs using our flexible catalog of 3,000+ global gift cards and digital assets.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-globe"></i></div>
                                <h4>{{ __('Global Marketplaces & E-commerce') }}</h4>
                                <p>{{ __('Add mobile airtime, data bundles, and gift card services to your commerce platform, marketplace, or customer engagement flow to support borderless digital value distribution.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-people"></i></div>
                                <h4>{{ __('Corporate & Team Incentives') }}</h4>
                                <p>{{ __('Support employee appreciation, team incentives, customer compensation, partner rewards, and corporate gifting programs through a reliable, globally accessible reward solution.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-code-slash"></i></div>
                                <h4>{{ __('Developer-Led Applications') }}</h4>
                                <p>{{ __('Give your development team the tools to integrate crypto wallets, airtime & data endpoints, and gift card functionality into internal tools, SaaS products, dashboards, and custom business applications.') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="axora-solutions-card">
                                <div class="axora-solutions-icon"><i class="bi bi-diagram-3"></i></div>
                                <h4>{{ __('Business API Integrations') }}</h4>
                                <p>{{ __('Connect global payouts and digital asset services into your existing business systems, CRM workflows, and platforms using unified APIs designed for approved B2B use cases.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop