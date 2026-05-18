@extends('front.pages')

@section('content')
    <section class="hero-section text-center py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold" style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">
                        {{ __('About Us') }}
                    </span>

                    <h1 class="hero-title mb-3">{{ __('Powering Global Rewards & Digital Assets for Modern Businesses') }}</h1>

                    <p class="hero-subtitle mx-auto">
                        {{ __('Our platform is built to help businesses connect airtime, data bundles, crypto wallets, and gift card services to their products, reward systems, customer experiences, and internal operations with confidence.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="image-content-section">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-9">
                    {!!$set->about!!}
                </div>
            </div>
        </div>
    </section>
@stop