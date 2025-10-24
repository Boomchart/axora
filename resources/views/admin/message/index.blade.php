@extends('admin.menu')
@section('content')
@livewire('admin.message.header', ['settings' => $set, 'type' => $type, 'admin' => $admin])
@livewire('admin.message.'.$type, ['settings' => $set, 'type' => $type, 'admin' => $admin])
@stop