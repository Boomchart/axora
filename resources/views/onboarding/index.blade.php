@extends('onboarding.menu', ['title' => 'Register'])

@section('content')
    <div class="container-fluid p-0">
        @livewire('auth.register', ['settings' => $set])
    </div>
@stop

