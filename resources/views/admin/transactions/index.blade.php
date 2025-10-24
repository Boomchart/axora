@extends('admin.menu')

@section('content')
@livewire('admin.transactions.all', ['admin' => $admin, 'settings' => $set])
@stop