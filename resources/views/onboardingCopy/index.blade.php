@extends('onboarding.menu', ['title' => 'Register'])

@section('content')

@livewire('auth.register', ['settings' => $set])
@stop