@extends('admin.menu')

@section('content')
@livewire('admin.transactions.details', ['settings' => $set, 'val' => $val, 'admin' => $admin])
@stop