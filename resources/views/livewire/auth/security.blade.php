<div>
    <form class="form w-100" wire:submit.prevent="save" method="post">
        <div x-data="otpInput()" class="auth-code-group">
            <template x-for="(digit, index) in otp" :key="index">
                <input
                        autofocus
                        type="text"
                        maxlength="1"
                        class="form-control auth-code-input"
                        x-model="otp[index]"
                        x-bind:autofocus="index === 0"
                        @input="onInput(index, $event)"
                        @keydown.backspace="onBackspace(index, $event)"
                        @paste="onPaste($event)"
                />
            </template>
        </div>

        <div class="auth-field-message">
            @error('pin')
            <span class="text-danger small fw-bold">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">
                <i class="bi bi-unlock-fill me-2"></i> {{ __('Unlock Account') }}
            </span>

            <span wire:loading wire:target="save">
                <span class="spinner-border spinner-border-sm me-2"></span> {{ __('Verifying...') }}
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