@extends('admin.menu')
@section('content')
@livewire('admin.ticket.header', ['type' => $type, 'settings' => $set, 'admin' => $admin])
@livewire('admin.ticket.'.$type, ['type' => $type, 'settings' => $set, 'admin' => $admin])
@stop