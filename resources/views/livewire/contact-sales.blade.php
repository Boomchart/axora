<div class="axora-contact-card">
    <div class="mb-4">
        <h3 class="axora-form-title">{{ __('Send a Message') }}</h3>

        <p class="axora-form-subtitle">{{ __('Tell us what you need help with and we will respond as soon as possible.') }}</p>
    </div>

    <form>
        @if($errors->any())
            <div class="axora-form-alert axora-form-alert-error mb-4">
                <div class="axora-form-alert-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>

                <div class="axora-form-alert-content">
                    <h6>{{ __('Please fix the following errors') }}</h6>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif


        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label required" for="first_name">{{ __('First Name') }}</label>
                <input type="text" class="form-control" placeholder="{{ __('John') }}" wire:model.defer="first_name" id="first_name" required autofocus>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label required" for="last_name">{{ __('Last Name') }}</label>
                <input type="text" class="form-control" placeholder="{{ __('Doe') }}" wire:model.defer="last_name" id="last_name" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div x-data="{
                                                    init() {
                                                        this.initPhoneToggle('#phone');
                                                    },

                                                    initPhoneToggle(input) {
                                                        const phoneInputField = document.querySelector(input);
                                                        if (!phoneInputField) return;

                                                        const phoneInput = window.intlTelInput(phoneInputField, {
                                                            loadUtils: '{{ asset('tel/js/tel-utils.js') }}',
                                                        });


                                                        phoneInputField.addEventListener('countrychange', () => {
                                                            $wire.set('code', phoneInput.getSelectedCountryData().iso2);
                                                        });
                                                    }
                                                }"></div>
                <div wire:ignore>
                    <label class="form-label text-dark fs-7 required">{{__('Phone Number')}}</label>
                    <input required class="form-control form-control-solid" type="tel" wire:model="phone" id="phone" placeholder="{{__('eg., 1234567890')}}">
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label required" for="email">{{ __('Email Address') }}</label>
                <input type="email" class="form-control" placeholder="{{ __('name@company.com') }}" wire:model.defer="email" id="email" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label" for="company_name">{{ __('Company Name') }}</label>
            <input type="text" class="form-control" placeholder="{{ __('Your company or platform name') }}" wire:model.defer="company_name" id="company_name">
        </div>

        <div class="mb-4">
            <label class="form-label required" for="subject">{{ __('Subject') }}</label>
            <input type="text" class="form-control" placeholder="{{ __('API access, pricing, onboarding, or support') }}" wire:model.defer="subject" id="subject" required>
        </div>

        <div class="mb-5">
            <label class="form-label required" for="message">{{ __('Message') }}</label>
            <textarea wire:model.defer="message" id="message" class="form-control" rows="5" placeholder="{{ __('Tell us about your business use case, expected gift card volume, integration needs, or support question.') }}" required>{{ old('message') }}</textarea>
        </div>

        {!! RecaptchaV3::field('contact') !!}

        <button type="submit" class="btn btn-primary w-100 py-3 fs-6" wire:click.prevent="handleSubmit">{{ __('Send Message') }}</button>
    </form>
</div>


@push('script')
    <script src="{{asset('front/vendor/jquery/dist/jquery.min.js')}}"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>--}}
    {!! RecaptchaV3::initJs() !!}
{{--    <script>--}}
{{--        const phoneInputField = document.querySelector("#phone");--}}
{{--        const phoneInput = window.intlTelInput(phoneInputField, {--}}
{{--            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--        });--}}
{{--        var old = "{{old('code')}}";--}}
{{--        if (old.trim() != '') {--}}
{{--            phoneInput.setCountry(old)--}}
{{--        }--}}
{{--        $('#code').val(phoneInput.getSelectedCountryData().iso2);--}}
{{--        phoneInputField.addEventListener("countrychange", function() {--}}
{{--            $('#code').val(phoneInput.getSelectedCountryData().iso2);--}}
{{--        });--}}
{{--    </script>--}}
{{--    <script>--}}
{{--        document.addEventListener('livewire:load', function () {--}}
{{--            const phoneInputField = document.querySelector("#phone");--}}

{{--            if (phoneInputField && window.intlTelInput) {--}}
{{--                const phoneInput = window.intlTelInput(phoneInputField, {--}}
{{--                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",--}}
{{--                });--}}

{{--                const updateCountryCode = () => {--}}
{{--                    @this.set('code', phoneInput.getSelectedCountryData().iso2);--}}
{{--                };--}}

{{--                updateCountryCode();--}}

{{--                phoneInputField.addEventListener("countrychange", updateCountryCode);--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
@endpush