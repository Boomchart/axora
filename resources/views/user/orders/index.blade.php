@extends('user.menu')

@section('content')
@livewire('user.orders.all', ['user' => $user])
@stop