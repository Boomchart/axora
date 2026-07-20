@extends('user.transactions.menu')
@section('content')
<div class="auth-logo-wrap auth-logo-outside">
    <a href="{{ route('home') }}" class="auth-logo-link">
        <img src="{{ asset('asset/images/' . getUi()->dashboard_logo . '.png') }}" alt="{{ $set->site_name }}" loading="lazy" class="auth-logo" @style(getUi()->light_css)>
    </a>
</div>

<div class="auth-card auth-login-card">
    <div class="auth-header">
        <h1 class="auth-title">{{ __('Send Crypto') }}</h1>
    </div>

    @livewire('user.transactions.crypto-payout', ['user' => $user, 'settings' => $set])
</div>
<div class="col-md-5">
    <div class="py-10">
        <div class="p-10 p-lg-15 mx-auto">

        </div>
    </div>
</div>
@stop