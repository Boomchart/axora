@extends('user.menu')

@section('content')
@livewire('user.ticket.index', ['user' => $user, 'settings' => $set])
@stop