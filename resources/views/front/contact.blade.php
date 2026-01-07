@extends('front.menu')

@section('meta_description', "We're available around the clock. Let us know how we can help!")
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        /* Force the phone input container to take full width */
        .iti {
            width: 100%;
            display: block;
        }

        .feature-card .icon-circle-pink {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
            background-color: #FFF0F0;
            color: var(--secondary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ensure the left-side cards look clickable/interactive */
        .feature-card {
            cursor: default;
        }

        .feature-card a {
            text-decoration: none;
            transition: color 0.2s;
        }

        .feature-card a:hover {
            color: var(--secondary-vibrant);
        }

        /* Text area resize fix */
        textarea.form-control {
            resize: none;
        }

        /* Section Padding Utility */
        .section-padding {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }
    </style>
@endpush

@section('content')
    {{-- 1. Hero Section (Uses Axora Gradient) --}}
    <section class="hero-section text-center pt-5 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    {{-- Pink Badge for "Support" --}}
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold"
                          style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">
                    {{ __('Support Center') }}
                </span>
                    <h1 class="hero-title mb-3">{{ __('How can we help?') }}</h1>
                    <p class="hero-subtitle mx-auto">
                        {{ __('Have a question about your gift card or account? Our team is ready to help you.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. Main Content --}}
    <section class="section-padding pb-5" style="background-color: var(--bg-warm);">
        <div class="container">
            <div class="row g-5">

                {{-- LEFT: Contact Info (Clean Layout) --}}
                <div class="col-lg-5">
                    <div class="d-flex flex-column gap-4">

                        {{-- Info Item 1 --}}
                        <div class="d-flex align-items-start p-4 bg-white rounded-4 border border-light shadow-sm transition-hover">
                            <div class="icon-circle-pink me-4 flex-shrink-0">
                                <i class="bi bi-envelope-heart fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-primary mb-1">{{ __('Email Us') }}</h5>
                                <p class="text-secondary mb-2 small">{{ __('For general inquiries and support.') }}</p>
                                <a href="mailto:{{$set->email}}" class="auth-link fs-6">{{$set->email}}</a>
                            </div>
                        </div>

                        {{-- Info Item 2 --}}
                        <div class="d-flex align-items-start p-4 bg-white rounded-4 border border-light shadow-sm transition-hover">
                            <div class="icon-circle-pink me-4 flex-shrink-0">
                                <i class="bi bi-phone fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-primary mb-1">{{ __('Phone') }}</h5>
                                <p class="text-secondary mb-2 small">{{ __('For general inquiries and support.') }}</p>
                                <a href="#" class="auth-link fw-bold">{{ $set->mobile }}</a>
                            </div>
                        </div>

                        {{-- Info Item 3 --}}
{{--                        <div class="d-flex align-items-start p-4 bg-white rounded-4 border border-light shadow-sm transition-hover">--}}
{{--                            <div class="icon-circle-pink me-4 flex-shrink-0">--}}
{{--                                <i class="bi bi-geo-alt fs-3"></i>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <h5 class="fw-bold text-primary mb-1">{{ __('Our Office') }}</h5>--}}
{{--                                <p class="text-secondary mb-0 small">--}}
{{--                                    123 Innovation Drive<br>--}}
{{--                                    Tech City, TC 90210--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>

                {{-- RIGHT: The Form (AXORA CARD STYLE) --}}
                <div class="col-lg-7">
                    {{-- .auth-card applies the exact white bg, rounding, and shadow from login --}}
                    <div class="auth-card h-100">
                        <div class="auth-header text-start mb-4">
                            <h3 class="auth-title mb-2">{{ __('Send a message') }}</h3>
                            <p class="auth-subtitle">{{ __('Fill out the form below and we will get back to you shortly.') }}</p>
                        </div>

                        <form method="post" action="{{route('contact-submit')}}">
                            @csrf
                            <div class="row">
                                {{-- First Name --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label required">{{ __('First Name') }}</label>
                                    <input type="text" class="form-control" placeholder="John" value="{{old('first_name')}}" name="first_name" id="first_name" required autofocus>
                                    @error('first_name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Last Name --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label required">{{ __('Last Name') }}</label>
                                    <input type="text" class="form-control" placeholder="Doe" value="{{old('last_name')}}" name="last_name" id="last_name" required>
                                    @error('last_name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                {{-- Phone --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label required">{{ __('Phone') }}</label>
                                    <input type="tel" name="phone" id="phone" value="{{old('phone')}}" class="form-control" required>
                                    <input type="hidden" name="code" id="code" class="text-uppercase">
                                    @error('phone') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                {{-- Email --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label required">{{ __('Email Address') }}</label>
                                    <input type="email" class="form-control" placeholder="name@email.com" value="{{old('email')}}" name="email" id="email" required>
                                    @error('email') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="mb-4">
                                <label class="form-label required">{{ __('Subject') }}</label>
                                <input type="text" class="form-control" placeholder="{{__('subject')}}" value="{{old('subject')}}" name="subject" id="subject" required>
                                @error('subject') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Message --}}
                            <div class="mb-5">
                                <label class="form-label required">{{ __('Message') }}</label>
                                <textarea name="message" id="message"  class="form-control" rows="5" placeholder="{{__('Hi there, I would like to ...')}}" style="resize: none;">{{old('message')}}</textarea>
                                @error('message') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                            {!! RecaptchaV3::field('contact') !!}

                            {{-- Submit Button (Teal Primary) --}}
                            <button type="submit" class="btn btn-primary w-100 py-3 fs-6">
                                {{ __('Send Message') }}
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 3. FAQ Teaser --}}
    <section class="section-padding bg-white border-top border-light">
        <div class="container text-center">
            <h2 class="section-title mb-3">{{ __('Frequently Asked Questions') }}</h2>
            <p class="text-secondary mb-4">{{ __('Find quick answers to common questions about Axora.') }}</p>
            <a href="" class="btn btn-outline-secondary px-5">
                {{ __('Visit Help Center') }}
            </a>
        </div>
    </section>
@stop
@section('script')
<script src="{{asset('front/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
{!! RecaptchaV3::initJs() !!}
<script>
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
    var old = "{{old('code')}}";
    if (old.trim() != '') {
        phoneInput.setCountry(old)
    }
    $('#code').val(phoneInput.getSelectedCountryData().iso2);
    phoneInputField.addEventListener("countrychange", function() {
        $('#code').val(phoneInput.getSelectedCountryData().iso2);
    });
</script>
@endsection