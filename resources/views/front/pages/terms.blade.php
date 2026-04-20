@extends('front.menu')
@section('css')

@stop
@section('content')
    <section class="hero-section text-center py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold"
                          style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">
                    {{ __('Legal Agreement') }}
                </span>
                    <h1 class="hero-title mb-3">{{ __('Terms of Service') }}</h1>
                    <p class="hero-subtitle mx-auto">
                        {{ __('Please read our Terms and Conditions carefully. They explain the rules, responsibilities, and guidelines that apply when you access or use our gift card API platform and related services.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="image-content-section">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-9">
                    {!!$set->terms!!}
                </div>
            </div>
        </div>
    </section>
@stop