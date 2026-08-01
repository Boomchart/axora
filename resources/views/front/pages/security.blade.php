@extends('front.pages')

@section('meta_description', __('How Azora keeps your data and funds safe — encryption, HMAC-signed API requests, compliance controls, and infrastructure built for secure global rewards delivery.'))

@section('css')

@stop

@section('content')
    <section class="hero-section text-center py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold"
                          style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">
                        {{ __('Security') }}
                    </span>

                    <h1 class="hero-title mb-3">
                        {{ __('Security You Can Trust') }}
                    </h1>

                    <p class="hero-subtitle mx-auto">
                        {{ __('We use modern security practices to help protect your account, API access, transaction data, and platform activity when you use our unified API for digital assets, airtime, crypto, and global rewards.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="image-content-section mb-5">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-9">
                    <div class="security-content-card">

                        <div class="security-item">
                            <div class="security-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <h4>{{ __('Secure API Access') }}</h4>
                            <p>
                                {{ __('Our platform is designed to protect API access through secure authentication.') }}
                            </p>
                        </div>

                        <div class="security-item">
                            <div class="security-icon">
                                <i class="bi bi-key"></i>
                            </div>
                            <h4>{{ __('API Key Protection') }}</h4>
                            <p>
                                {{ __('API keys are sensitive credentials. We encourage every user to keep their keys private, rotate them when necessary, and avoid exposing them in public repositories, frontend code, or unsecured environments.') }}
                            </p>
                        </div>

                        <div class="security-item">
                            <div class="security-icon">
                                <i class="bi bi-lock"></i>
                            </div>
                            <h4>{{ __('Encrypted Communication') }}</h4>
                            <p>
                                {{ __('All platform access and API communication should be performed over secure HTTPS connections to help protect data while it moves between your systems and our services.') }}
                            </p>
                        </div>

                        <div class="security-item">
                            <div class="security-icon">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <h4>{{ __('Account & Wallet Protection') }}</h4>
                            <p>
                                {{ __('We apply strict access controls and account-level safeguards to help reduce unauthorized use of customer accounts, generated crypto wallets, dashboards, and sensitive platform actions.') }}
                            </p>
                        </div>

                        <div class="security-item">
                            <div class="security-icon">
                                <i class="bi bi-activity"></i>
                            </div>
                            <h4>{{ __('Multi-Asset Transaction Monitoring') }}</h4>
                            <p>
                                {{ __('We monitor platform activity and transaction patterns across fiat, digital rewards, and crypto assets to help detect suspicious behavior, prevent fraud, and maintain a safer environment for businesses and developers.') }}
                            </p>
                        </div>

                        <div class="security-item">
                            <div class="security-icon">
                                <i class="bi bi-database-lock"></i>
                            </div>
                            <h4>{{ __('Data Protection') }}</h4>
                            <p>
                                {{ __('We take reasonable steps to protect customer information, transaction records, and platform data from unauthorized access, misuse, alteration, or disclosure.') }}
                            </p>
                        </div>

                        <div class="security-item">
                            <div class="security-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <h4>{{ __('Responsible Security Reporting') }}</h4>
                            <p>
                                {{ __('If you discover a security issue or vulnerability, please contact our support team immediately so we can investigate and take appropriate action.') }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop