@extends('user.menu')
@section('content')
@livewire('user.settings.api-log', ['user' => $user])
@stop