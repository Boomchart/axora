@extends('front.menu')
{!! RecaptchaV3::initJs() !!}
<meta name="description" content="We\'re available around the clock. Let us know how we can help!" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
@section('css')

@stop
@section('content')
<section class="position-relative py-lg-5 pt-5 dd-bg" data-jarallax data-img-position="0% 100%" data-speed="0.5">
    <div class="container position-relative zindex-2 pt-5 pb-2 pb-md-0 py-6">
        <div class="row justify-content-center pt-3 mt-3">
            <div class="col-xl-6 col-lg-7 col-md-8 col-sm-10 text-center">
                <h1 class="mb-4 text-success">{{__('Contact Support')}}</h1>
                <p class="fs-lg pb-3 mb-3 text-dark">{{__('We\'re available around the clock. Let us know how we can help!')}}</p>
            </div>
        </div>
    </div>
</section>
<section class="position-relative bg-secondary pt-5">
    <div class="container position-relative zindex-2 pt-5">
        <div class="row">
            <!-- Contact links -->
            <div class="col-xl-4 col-lg-5 pb-4 pb-sm-5 mb-2 mb-sm-0">
                <h2 class="pb-3 mb-1 mb-lg-3 text-success">{{__('Need a quick answer')}}?</h2>
                <p class="pb-3 mb-2 mb-lg-3 text-dark">{{__('The '.$set->site_name.' Help Desk has')}}:</p>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center fs-6 mb-2">
                        <i class="fa fa-check fs-xl text-success me-2"></i>
                        {{__('Detailed guides and instructions')}}
                    </li>
                    <li class="d-flex align-items-center fs-6 mb-2">
                        <i class="fa fa-check fs-xl text-success me-2"></i>
                        {{__('Answers to common questions')}}
                    </li>
                </ul>
                <a href="{{route('help.center')}}" class="btn btn-link px-0 mb-5 text-success">
                    {{__('Search Help Center')}}
                    <i class="bi bi-arrow-right fs-xl ms-2"></i>
                </a>
                <h2 class="pb-3 mb-1 mb-lg-3 text-success">{{__('Reach us')}}</h2>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center fs-6 mb-2">
                        <i class="fa fa-check fs-xl text-success me-2"></i>
                        <a href="mailto:{{$set->email}}" class="nav-link d-inline-block px-0 pt-1 pb-2">{{$set->email}}</a>
                    </li>
                    <li class="d-flex align-items-center fs-6 mb-2">
                        <i class="fa fa-check fs-xl text-success me-2"></i>
                        <a href="tel:{{$set->mobile}}" class="nav-link d-inline-block px-0 pt-1 pb-2">{{$set->mobile}}</a>
                    </li>
                </ul>
            </div>

            <!-- Contact form -->
            <div class="col-xl-6 col-lg-7 offset-xl-2">
                <div class="card border-light shadow-lg">
                    <div class="bg-dark position-absolute top-0 start-0 w-100 h-100 rounded-3 d-none d-dark-mode-block"></div>
                    <div class="card-body position-relative zindex-2">
                        <form class="row g-4" method="post" action="{{route('contact-submit')}}">
                            @csrf
                            <div class="col-6">
                                <label for="fn" class="form-label fs-base">{{__('First name')}}</label>
                                <input type="text" class="form-control form-control-lg" id="fn" value="{{old('first_name')}}" name="first_name" required placeholder="{{__('John')}}">
                                @error('first_name')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label for="fn" class="form-label fs-base">{{__('last name')}}</label>
                                <input type="text" class="form-control form-control-lg" id="fn" value="{{old('last_name')}}" name="last_name" required placeholder="{{__('Doe')}}">
                                @error('last_name')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label fs-base">{{__('Email address')}}</label>
                                <input type="email" class="form-control form-control-lg" value="{{old('email')}}" id="email" name="email" required placeholder="{{__('mail@mail.com')}}">
                                @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label fs-base">{{__('Phone')}}</label>
                                <input type="hidden" name="code" id="code" class="text-uppercase">
                                <input type="tel" name="phone" id="phone" value="{{old('phone')}}" class="form-control form-control-lg" required>
                                @error('phone')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label fs-base">{{__('Subject')}}</label>
                                <input type="text" class="form-control form-control-lg" value="{{old('subject')}}" id="subject" name="subject" required placeholder="{{__('Subject')}}">
                                @error('subject')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label fs-base">{{__('Message')}}</label>
                                <textarea class="form-control" id="message" name="message" rows="3" required placeholder="{{__('Hi there, I would like to ...')}}">{{old('message')}}</textarea>
                                @error('message')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            @if($set->recaptcha==1)
                            {!! RecaptchaV3::field('contact') !!}
                            @error('g-recaptcha-response')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                            @endif
                            <div class="col-12 pt-2 pt-sm-3">
                                <button type="submit" class="btn rounded-pill btn-success w-sm-auto">{{__('Send Message')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100 bg-light" style="height: 8rem;"></div>
</section>
@stop
@section('script')
<script src="{{asset('front/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
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