@extends('admin.menu')
@section('content')
@livewire('admin.deposit.header', ['settings' => $set, 'type' => $type, 'admin' => $admin])
@livewire('admin.deposit.index', ['settings' => $set, 'base' => $type, 'admin' => $admin, 'set' => $set])
@stop