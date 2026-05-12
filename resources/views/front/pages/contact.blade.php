@extends('front.pages')

@section('meta_description', "Contact our team for business inquiries, API support, onboarding, and digital asset integration questions.")

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

    <style>
        .iti {
            width: 100%;
            display: block;
        }

        .axora-contact-hero {
            padding: 5rem 0 3.5rem;
            background:
                    radial-gradient(circle at top left, var(--secondary-lighter), transparent 35%),
                    linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .axora-contact-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: var(--secondary-lighter);
            color: var(--primary-dark);
            padding: 0.55rem 1rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .axora-contact-title {
            color: var(--primary-dark);
            font-weight: 900;
            letter-spacing: -0.04em;
            line-height: 1.12;
            margin-bottom: 1rem;
        }

        .axora-contact-subtitle {
            color: #64748b;
            font-size: 1.08rem;
            line-height: 1.7;
            max-width: 720px;
            margin: 0 auto;
        }

        .axora-contact-section {
            padding: 4rem 0;
            background: #f8fafc;
        }

        .axora-contact-card {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 28px;
            padding: 2rem;
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.06);
        }

        .axora-contact-info-card {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.05);
        }

        .axora-contact-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            background-color: var(--secondary-lighter);
            color: var(--primary-dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .axora-contact-info-card h5 {
            color: var(--primary-dark);
            font-weight: 800;
            margin-bottom: 0.35rem;
        }

        .axora-contact-info-card p {
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }

        .axora-contact-info-card a {
            color: var(--primary-dark);
            font-weight: 800;
            text-decoration: none;
            word-break: break-word;
        }

        .axora-contact-info-card a:hover {
            text-decoration: underline;
        }

        .axora-contact-note {
            background: linear-gradient(135deg, var(--secondary-lighter), #ffffff);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 24px;
            padding: 1.5rem;
        }

        .axora-contact-note h5 {
            color: var(--primary-dark);
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .axora-contact-note p {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 0;
        }

        .axora-form-title {
            color: var(--primary-dark);
            font-weight: 900;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .axora-form-subtitle {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .axora-contact-card .form-label {
            color: #334155;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .axora-contact-card .form-control,
        .axora-contact-card .form-select {
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, 0.1);
            padding: 0.85rem 1rem;
            color: #0f172a;
            box-shadow: none;
        }

        .axora-contact-card .form-control:focus,
        .axora-contact-card .form-select:focus {
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 0.2rem rgba(15, 23, 42, 0.08);
        }

        .axora-contact-card textarea.form-control {
            resize: none;
        }

        .axora-contact-card .btn {
            border-radius: 999px;
            font-weight: 800;
        }

        .axora-help-strip {
            padding: 4rem 0;
            background: #ffffff;
        }

        .axora-help-strip-card {
            background: var(--primary-dark);
            color: #ffffff;
            border-radius: 28px;
            padding: 3rem;
            text-align: center;
        }

        .axora-help-strip-card h2 {
            font-weight: 900;
            margin-bottom: 0.75rem;
        }

        .axora-help-strip-card p {
            color: rgba(255, 255, 255, 0.76);
            max-width: 650px;
            margin: 0 auto 1.5rem;
            line-height: 1.7;
        }

        .axora-help-strip-card .btn {
            border-radius: 999px;
            padding: 0.85rem 1.5rem;
            font-weight: 800;
        }

        @media (max-width: 767.98px) {
            .axora-contact-hero {
                padding: 4rem 0 2.75rem;
            }

            .axora-contact-section,
            .axora-help-strip {
                padding: 3rem 0;
            }

            .axora-contact-card {
                padding: 1.5rem;
                border-radius: 24px;
            }

            .axora-help-strip-card {
                padding: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="axora-contact-hero text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="axora-contact-badge">
                        <i class="bi bi-chat-dots"></i>
                        {{ __('Contact Us') }}
                    </span>

                    <h1 class="axora-contact-title">{{ __('Let’s Talk About Your API Integration') }}</h1>

                    <p class="axora-contact-subtitle">{{ __('Have questions about our Unified API for airtime, crypto, and gift cards, business onboarding, pricing, or platform support? Send us a message and our team will get back to you.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="axora-contact-section">
        <div class="container">
            <div class="row g-5 align-items-start">

                <div class="col-lg-5">
                    <div class="d-flex flex-column gap-4">

                        <div class="axora-contact-info-card">
                            <div class="axora-contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            <div>
                                <h5>{{ __('Email Us') }}</h5>
                                <p>{{ __('For business inquiries, onboarding questions, and general platform support.') }}</p>
                                <a href="mailto:{{ $set->email }}">{{ $set->email }}</a>
                            </div>
                        </div>

                        <div class="axora-contact-info-card">
                            <div class="axora-contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>

                            <div>
                                <h5>{{ __('Phone') }}</h5>
                                <p>{{ __('Speak with us about your business needs, integration questions, or account support.') }}</p>
                                <a href="tel:{{ $set->mobile }}">{{ $set->mobile }}</a>
                            </div>
                        </div>

                        <div class="axora-contact-note">
                            <h5>{{ __('Built for Business Support') }}</h5>
                            <p>{{ __('We work with business platforms. For faster support, include your company name, expected use case (e.g., airtime top-ups, crypto wallets, global rewards), and any relevant integration details in your message.') }}</p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-7">
                    @livewire('contact-sales')
                </div>

            </div>
        </div>
    </section>

    <section class="axora-help-strip">
        <div class="container">
            <div class="axora-help-strip-card">
                <h2>{{ __('Looking for quick answers?') }}</h2>
                <p>{{ __('Visit our Help Center to browse common questions about API access, business onboarding, account support, and multi-asset platform usage.') }}</p>
                <a href="{{ route('help.center') }}" class="btn btn-light">{{ __('Visit Help Center') }}</a>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="{{ asset('front/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    {!! RecaptchaV3::initJs() !!}

    <script>
        const phoneInputField = document.querySelector("#phone");

        if (phoneInputField && window.intlTelInput) {
            const phoneInput = window.intlTelInput(phoneInputField, {
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            const oldCountry = "{{ old('code') }}";
            const codeInput = document.querySelector('#code');

            if (oldCountry.trim() !== '') {
                phoneInput.setCountry(oldCountry);
            }

            if (codeInput) {
                codeInput.value = phoneInput.getSelectedCountryData().iso2;
            }

            phoneInputField.addEventListener("countrychange", function () {
                if (codeInput) {
                    codeInput.value = phoneInput.getSelectedCountryData().iso2;
                }
            });
        }
    </script>
@endsection