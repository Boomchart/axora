@extends('onboarding.menu', ['title' => 'Register'])

@section('content')

@livewire('auth.team', ['settings' => $set, 'token' => $token])
@stop