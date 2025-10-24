<div>
    <div class="text-center">
        <a href="{{route('home')}}" class="navbar-brand pe-3">
            <img class="mb-6 text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
        </a>
    </div>
    <div class="d-flex align-items-center mb-5 rounded-4 bg-white p-3 cursor-pointer">
        <div class="symbol symbol-40px symbol-circle me-2">
            <div class="symbol-label bg-secondary text-dark fw-bold">{{strtoupper(substr($user->business->name, 0, 2))}}</div>
        </div>
        <div class="ps-1">
            <p class="fs-7 text-dark text-hover-info fw-bold mb-0">
                {{$user?->business->name}}
            </p>
            <p class="fs-8 mb-0">{{$user?->first_name}} {{$user?->last_name}}</p>
        </div>
    </div>
    <div class="card mb-10">
        <div class="card-body">
            <form class="form w-100" wire:submit.prevent="save" method="post">
                <div class="text-start mb-10">
                    <h1 class="text-dark mb-2 fs-2">{{__('Multi Factor Authentication')}}</h1>
                    <div class="text-dark fs-7">{{__('Enter Code to unlock from your Authentication App')}}</div>
                </div>
                <div
                    x-data="otpInput()"
                    class="otp-container d-flex gap-2 mt-5 mb-10 justify-content-center">
                    <template x-for="(digit, index) in otp" :key="index">
                        <input
                            autofocus
                            type="text"
                            maxlength="1"
                            class="form-control form-control-solid text-center otp-input-fa fs-1 fw-bold"
                            x-model="otp[index]"
                            x-bind:autofocus="index === 0"
                            @input="onInput(index, $event)"
                            @keydown.backspace="onBackspace(index, $event)"
                            @paste="onPaste($event)" />
                    </template>
                </div>
                @error('pin')
                <span class="form-text">{{ $message}}</span>
                @enderror
                <div class="text-center">
                    <button type="submit" class="btn btn-info btn-block my-2" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="save">
                        <span wire:loading.remove wire:target="save">{{__('Unlock Account')}}</span>
                        <span wire:loading wire:target="save">{{__('Processing request...')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <a href="{{route('user.logout')}}" class="btn btn-dark btn-block mt-5">
        <i class="bi bi-box-arrow-in-right"></i> {{__('Logout')}}
    </a>
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