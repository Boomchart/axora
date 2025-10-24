@extends('user.compliance.menu', ['title' => 'Compliance'])

@section('content')
    @livewire('auth.compliance', ['settings' => $set, 'user' => $user])
@stop
