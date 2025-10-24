<div>
    <div class="text-center">
        <a href="{{route('home')}}" class="navbar-brand pe-3">
            <img class="mb-6 text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
        </a>
    </div>
    @error('added')
    <div class="alert alert-danger">
        <div class="d-flex flex-column">
            <span>{{$message}}</span>
        </div>
    </div>
    @enderror
    <div class="card rounded-5 mb-10">
        <div class="card-body">
            <form class="form" wire:submit.prevent="submitLogin" method="post">
                @csrf
                <div class="text-start mb-10">
                    <h1 class="text-dark mb-2 fs-2">{{__('Jump right back in')}}</h1>
                    <div class="text-dark fs-7">{{__('New Here?')}}
                        <a href="{{route('register')}}" class="link-success fw-bold"><u>{{__('Create an Account')}}</u></a>
                    </div>
                </div>
                <div class="fv-row mb-10">
                    <label class="form-label text-dark fs-7">{{__('Email address')}}</label>
                    <input class="form-control form-control-solid border-light" type="email" wire:model.defer="email" autocomplete="email" value="{{old('email')}}" required placeholder="name@email.com" />
                    @error('email')
                    <span class="form-text">{{$message}}</span>
                    @enderror
                </div>
                <div x-data="{ hidePassword: true, password: @entangle('password').defer }" class="fv-row mb-10">
                    <div class="d-flex flex-stack mb-2">
                        <label class="form-label text-dark fs-7 mb-0">{{ __('Password') }}</label>
                        <a href="{{ route('user.password.request') }}" class="link-success fs-8 fw-bold">
                            <u>{{ __('Forgot Password') }}</u>
                        </a>
                    </div>

                    <div class="position-relative">
                        <input
                            class="form-control form-control-solid border-light"
                            :type="hidePassword ? 'password' : 'text'"
                            x-model="password"
                            autocomplete="off"
                            required
                            id="password"
                            placeholder="XXXXXXXXX" />
                        <span
                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 cursor-pointer"
                            x-on:click="hidePassword = !hidePassword">
                            <i :class="hidePassword ? 'bi bi-eye fs-2 text-dark' : 'bi bi-eye-slash fs-2 text-dark'"></i>
                        </span>
                    </div>

                    @error('password')
                    <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-check form-check-custom form-check-solid mb-6">
                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" wire:model.defer="remember_me" checked />
                    <label class="form-check-label" for="flexCheckDefault">{{__('Stayed signed in for 30 days')}}</label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submitLogin">{{__('Sign In')}}</span>
                        <span wire:loading wire:target="submitLogin">{{__('Signing In...')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function initPasswordToggle() {
        $('[data-toggle="password"]').each(function() {
            var input = $(this);
            var eye_btn = $(this).parent().find('.input-password');
            eye_btn.css('cursor', 'pointer').addClass('input-password-hide');
            eye_btn.on('click', function() {
                if (eye_btn.hasClass('input-password-hide')) {
                    eye_btn.removeClass('input-password-hide').addClass('input-password-show');
                    eye_btn.find('.bi').removeClass('bi-eye').addClass('bi-eye-slash')
                    input.attr('type', 'text');
                } else {
                    eye_btn.removeClass('input-password-show').addClass('input-password-hide');
                    eye_btn.find('.bi').removeClass('bi-eye-slash').addClass('bi-eye')
                    input.attr('type', 'password');
                }
            });
        });
    }
    document.addEventListener('livewire:load', function() {
        initPasswordToggle();
    });
</script>
@endpush