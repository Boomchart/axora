@extends('admin.menu')

@section('content')
@livewire('admin.crypto.index', ['admin' => $admin, 'settings' => $set])
@stop