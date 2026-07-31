@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>
        (function () {
            function updateLivewireField(selector, value) {
                const field = document.querySelector(selector);

                if (!field) return;

                field.value = value;
                field.dispatchEvent(new Event('input', { bubbles: true }));
            }

            function initialiseContactPhone() {
                const input = document.querySelector('#phone');

                if (!input || !window.intlTelInput || input.dataset.itiInitialised === 'true') {
                    return;
                }

                input.dataset.itiInitialised = 'true';

                const phoneInput = window.intlTelInput(input, {
                    initialCountry: 'us',
                    utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js',
                });

                const syncCountry = () => {
                    const country = phoneInput.getSelectedCountryData();
                    const countryCode = country && country.iso2
                        ? country.iso2.toUpperCase()
                        : '';

                    updateLivewireField('#contact-country-code', countryCode);
                };

                const syncPhone = () => {
                    updateLivewireField('#contact-phone-value', input.value);
                };

                syncCountry();
                syncPhone();

                input.addEventListener('countrychange', syncCountry);
                input.addEventListener('input', syncPhone);
                input.addEventListener('change', syncPhone);

                window.addEventListener('contact-form-reset', () => {
                    phoneInput.setNumber('');
                    syncCountry();
                    syncPhone();
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initialiseContactPhone);
            } else {
                initialiseContactPhone();
            }
        })();
    </script>
@endsection
