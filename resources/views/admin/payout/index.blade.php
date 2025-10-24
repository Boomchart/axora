@extends('admin.menu')
@section('content')
@livewire('admin.payout.header', ['settings' => $set, 'type' => $type, 'admin' => $admin])
@livewire('admin.payout.index', ['settings' => $set, 'base' => $type, 'admin' => $admin, 'set' => $set])
@stop