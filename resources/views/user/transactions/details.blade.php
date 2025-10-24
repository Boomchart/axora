@extends('user.menu')

@section('content')
@livewire('user.transactions.details', ['user'=> $user, 'settings' => $set, 'val' => $val])
@stop