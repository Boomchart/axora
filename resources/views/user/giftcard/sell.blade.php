@extends('user.menu')
@section('content')
@livewire('user.giftcard.sell', ['user' => $user, 'settings' => $set])
@stop