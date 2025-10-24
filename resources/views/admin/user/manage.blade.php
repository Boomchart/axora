@extends('admin.menu')

@section('content')
@livewire('admin.users.header', ['type' => $type, 'admin' => $admin, 'settings' => $set, 'client' => $client])
@livewire('admin.users.'.$type, ['type' => $type, 'admin' => $admin, 'settings' => $set, 'client' => $client])
@stop