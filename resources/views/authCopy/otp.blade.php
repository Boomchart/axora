@extends('auth.menu')

@section('content')
<div class="col-md-6">
    <div class="py-10">
        <div class="p-10 p-lg-15 mx-auto">
            <div class="text-center">
                <a href="{{route('home')}}" class="navbar-brand pe-3">
                    <img class="mb-6 text-center" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" alt="{{$set->site_name}}" loading="lazy" @style(getUi()->light_css)>
                </a>
            </div>
            <div class="card rounded-5">
                <div class="card-body m-5">
                    <form class="form w-100" action="{{route('confirm.otp')}}" method="post">
                        @csrf
                        <div class="text-start mb-10">
                            <h1 class="text-dark mb-2 fs-2">{{__('Enter your One Time Password')}}</h1>
                            <div class="text-dark fs-7">{{__('Input the OTP we sent to')}} {{($set->otp_type == 'email') ? $user->email : $user->phone}}</div>
                            <p class="text-muted">{{__('You can')}} <a href="{{route('resend.otp')}}" class="resend-sms text-success"><u>{{__('resend')}}</u></a> {{($set->otp_type == 'email') ? __('Email after') : __('SMS after')}} <span id="timer" class="font-weight-bold text-indigo text-lg"></span></p>
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label text-dark fs-7">{{__('Code')}}</label>
                            <input class="form-control form-control-solid border-light" name="code" type="tel" minlength="4" maxlength="6" pattern="[0-9]+" autocomplete="one-time-code" value="{{old('code')}}" required placeholder="XXXXXX" autofocus onkeyup="this.value=removeSpacesPin(this.value);" onmouseout="this.value=removeSpacesPin(this.value);" />
                            @error('code')
                            <span class="form-text">{{ $message}}</span>
                            @enderror
                        </div>
                        @if($set->recaptcha==1)
                        {!! RecaptchaV3::field('otp') !!}
                        @error('g-recaptcha-response')
                        <span class="form-text">{{$message}}</span>
                        @enderror
                        @endif
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block me-3 my-3">
                                <span class="indicator-label">{{__('Verify OTP')}}</span>
                            </button>
                            <a href="{{route('user.logout')}}" class="btn btn-warning btn-block text-dark">{{__('Logout')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@stop
@section('script')
<script>
    var countDownDate = moment("{{Carbon\Carbon::create($user->otp_time)->add($set->otp_resend_duration . ' ' . $set->otp_resend_time)->toDateTimeString()}}").valueOf();

    var x = setInterval(function() {
        var now = moment.utc().valueOf();
        var distance = countDownDate - now + (1 * 60 * 60 * 1000);
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
        var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
        document.getElementById("timer").innerHTML = minutes + ":" + seconds;
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "0:00";
            $('.resend-sms').attr('disabled', false);
        }
    }, 1);
</script>
@endsection