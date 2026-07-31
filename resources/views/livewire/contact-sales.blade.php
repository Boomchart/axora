<div class="axora-contact-card">
    <div class="mb-4">
        <h3 class="axora-form-title">{{ __('Send a Message') }}</h3>

        <p class="axora-form-subtitle">{{ __('Tell us what you need help with and we will respond as soon as possible.') }}</p>
    </div>

    <form
            x-data="{
            submitting: false,
            captchaEnabled: {{ $set->recaptcha == 1 ? 'true' : 'false' }},
            captchaSiteKey: '{{ config('recaptchav3.sitekey') }}',

            finishSubmission(request) {
                Promise.resolve(request).finally(() => {
                    this.submitting = false;
                });
            },

            submitForm() {
                if (this.submitting) return;

                this.submitting = true;

                if (!this.captchaEnabled) {
                    this.finishSubmission($wire.handleSubmit());
                    return;
                }

                if (typeof grecaptcha === 'undefined') {
                    this.finishSubmission($wire.handleSubmit(''));
                    return;
                }

                grecaptcha.ready(() => {
                    grecaptcha.execute(this.captchaSiteKey, { action: 'contact' })
                        .then(token => $wire.handleSubmit(token))
                        .catch(() => $wire.handleSubmit(''))
                        .finally(() => {
                            this.submitting = false;
                        });
                });
            }
        }"
            x-on:submit.prevent="submitForm"
    >
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
                <div wire:ignore>
                    <label class="form-label text-dark fs-7 required" for="phone">{{ __('Phone Number') }}</label>
                    <input required class="form-control form-control-solid" type="tel" id="phone" placeholder="{{ __('eg., 1234567890') }}">
                </div>

                <input type="hidden" id="contact-phone-value" wire:model.defer="phone">
                <input type="hidden" id="contact-country-code" wire:model.defer="code">
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label required" for="email">{{ __('Email Address') }}</label>
                <input type="email" class="form-control" placeholder="{{ __('name@company.com') }}" wire:model.defer="email" id="email" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label required" for="company_name">{{ __('Company Name') }}</label>
            <input type="text" class="form-control" placeholder="{{ __('Your company or platform name') }}" wire:model.defer="company_name" id="company_name" required>
        </div>

        <div class="mb-4">
            <label class="form-label required" for="subject">{{ __('Subject') }}</label>
            <input type="text" class="form-control" placeholder="{{ __('API access, pricing, onboarding, or support') }}" wire:model.defer="subject" id="subject" required>
        </div>

        <div class="mb-5">
            <label class="form-label required" for="message">{{ __('Message') }}</label>
            <textarea wire:model.defer="message" id="message" class="form-control" rows="5" placeholder="{{ __('Tell us about your business use case, expected gift card volume, integration needs, or support question.') }}" required></textarea>
        </div>

        <button
                type="submit"
                class="btn btn-primary w-100 py-3 fs-6"
                x-bind:disabled="submitting"
        >
            <span x-show="!submitting">{{ __('Send Message') }}</span>
            <span x-show="submitting" style="display: none;">{{ __('Sending...') }}</span>
        </button>
    </form>
</div>
