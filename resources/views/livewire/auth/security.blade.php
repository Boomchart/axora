<div>
{{--    <div class="mb-10">--}}
{{--        <form class="form w-100" wire:submit.prevent="save" method="post">--}}
{{--            <div class="text-start mb-10">--}}
{{--                <p class="auth-title">{{__('Multi Factor Authentication')}}</p>--}}
{{--                <div class="auth-subtitle">{{__('Enter Code to unlock from your Authentication App')}}</div>--}}
{{--            </div>--}}
{{--            <div--}}
{{--                    x-data="otpInput()"--}}
{{--                    class="otp-container d-flex gap-2 mt-5 mb-10 justify-content-center">--}}
{{--                <template x-for="(digit, index) in otp" :key="index">--}}
{{--                    <input--}}
{{--                            autofocus--}}
{{--                            type="text"--}}
{{--                            maxlength="1"--}}
{{--                            class="form-control form-control-solid text-center otp-input-fa fs-1 fw-bold"--}}
{{--                            x-model="otp[index]"--}}
{{--                            x-bind:autofocus="index === 0"--}}
{{--                            @input="onInput(index, $event)"--}}
{{--                            @keydown.backspace="onBackspace(index, $event)"--}}
{{--                            @paste="onPaste($event)" />--}}
{{--                </template>--}}
{{--            </div>--}}
{{--            @error('pin')--}}
{{--            <span class="form-text">{{ $message}}</span>--}}
{{--            @enderror--}}
{{--            <div class="text-center">--}}
{{--                <button type="submit" class="btn btn-info btn-block my-2" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="save">--}}
{{--                    <span wire:loading.remove wire:target="save">{{__('Unlock Account')}}</span>--}}
{{--                    <span wire:loading wire:target="save">{{__('Processing request...')}}</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--    <a href="{{route('user.logout')}}" class="btn btn-dark btn-block mt-5">--}}
{{--        <i class="bi bi-box-arrow-in-right"></i> {{__('Logout')}}--}}
{{--    </a>--}}

    <form class="form w-100" wire:submit.prevent="save" method="post">

        {{-- Alpine OTP Inputs --}}
        <div x-data="otpInput()" class="d-flex justify-content-center gap-2 mb-2">
            <template x-for="(digit, index) in otp" :key="index">
                <input
                        autofocus
                        type="text"
                        maxlength="1"
                        class="form-control text-center fw-bold fs-2 text-primary"
                        style="width: 45px; height: 50px; padding: 0!important;"
                        x-model="otp[index]"
                        x-bind:autofocus="index === 0"
                        @input="onInput(index, $event)"
                        @keydown.backspace="onBackspace(index, $event)"
                        @paste="onPaste($event)"
                />
            </template>
        </div>

        {{-- Validation Error --}}
        <div class="text-center mb-4" style="min-height: 20px;">
            @error('pin')
            <span class="text-danger small fw-bold">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary w-100 py-3 mb-4" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">
                <i class="bi bi-unlock-fill me-2"></i> {{__('Unlock Account')}}
            </span>
            <span wire:loading wire:target="save">
                <span class="spinner-border spinner-border-sm me-2"></span> {{__('Verifying...')}}
            </span>
        </button>

    </form>
</div>
@push('scripts')
<script>
    function otpInput() {
        return {
            otp: Array(6).fill(''),
            onInput(index, event) {
                let input = event.target;
                let value = input.value.replace(/\D/g, '');
                if (value.length > 1) value = value[0];
                this.otp[index] = value;

                if (value && index < this.otp.length - 1) {
                    input.nextElementSibling?.focus();
                }

                this.syncToLivewire();
            },
            onBackspace(index, event) {
                if (!this.otp[index] && index > 0) {
                    event.target.previousElementSibling?.focus();
                }
                this.syncToLivewire();
            },
            onPaste(event) {
                event.preventDefault();
                const paste = (event.clipboardData || window.clipboardData).getData('text');
                const digits = paste.replace(/\D/g, '').slice(0, this.otp.length).split('');

                digits.forEach((char, i) => {
                    this.otp[i] = char;
                });

                const inputs = event.target.parentElement.querySelectorAll('input');
                const nextIndex = digits.length >= this.otp.length ? this.otp.length - 1 : digits.length;
                inputs[nextIndex]?.focus();

                this.syncToLivewire();
            },
            syncToLivewire() {
                const fullCode = this.otp.join('');
                if (fullCode.length === this.otp.length) {
                    @this.set('pin', fullCode);
                }
            }
        };
    }
</script>
@endpush