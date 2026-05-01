@extends('admin.menu')
@section('content')
@livewire('admin.orders.all', ['admin' => $admin, 'settings' => $set, 'card' => $card])
@stop