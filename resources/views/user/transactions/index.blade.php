@extends('user.menu')

@section('content')
@livewire('user.transactions.all', ['user' => $user])
@stop