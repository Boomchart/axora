<div>
    @error('added')
    <div class="alert alert-danger">
        <div class="d-flex flex-column">
            <span>{{$message}}</span>
        </div>
    </div>
    @enderror

    <form class="auth-form" wire:submit.prevent="submitLogin" method="post">
        @csrf
        <div class="form-group">
            <label for="email" class="form-label">{{__('Email Address')}}</label>
            <input type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   wire:model.defer="email"
                   autocomplete="email"
                   required
                   placeholder="name@email.com"
                   autofocus>
            @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
        </div>

        <div class="form-group">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label for="password" class="form-label mb-0">{{__('Password')}}</label>
                @if (Route::has('user.password.request'))
                    <a href="{{route('user.password.request')}}" class="forgot-link">{{__('Forgot password?')}}</a>
                @endif
            </div>

            <div class="password-input-wrapper position-relative" x-data="{ show: false }" wire:key="password-field-toggle">
                <input
                        :type="show ? 'text' : 'password'"
                        wire:model.defer="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="XXXXXXXXX"
                        required
                        autocomplete="current-password"
                >

                <button type="button"
                        class="password-toggle position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent"
                        x-on:click="show = !show"
                        style="z-index: 10; cursor: pointer;">
                    <i class="bi" :class="show ? 'bi-eye' : 'bi-eye-slash'"></i>
                </button>
            </div>

            @error('password')<div class="invalid-feedback d-block">{{$message}}</div>@enderror
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="remember_me" wire:model.defer="remember_me">
            <label class="form-check-label" for="remember_me">
                {{__('Stayed signed in for 30 days')}}
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submitLogin">{{__('Sign In')}}</span>
            <span wire:loading wire:target="submitLogin">{{__('Signing In...')}}</span>
        </button>
    </form>
</div>