@extends('front.pages')

@section('content')
    <section class="hero-section text-center py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold"
                          style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">
                    {{ __('Privacy Policy') }}
                </span>
                    <h1 class="hero-title mb-3">{{ __('How We Protect Your Privacy') }}</h1>
                    <p class="hero-subtitle mx-auto">
                        {{ __('Your privacy matters to us. Learn how we collect, use, and protect your data when you use our unified API platform for digital assets, global rewards, and crypto services.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="image-content-section">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-9">
                    {!!$set->privacy!!}
                </div>
            </div>
        </div>
    </section>
@stop