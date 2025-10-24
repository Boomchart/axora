@extends('user.menu')

@section('content')
@livewire('user.balance', ['user' => $user, 'settings' => $set, 'currency' => $currency])
@stop