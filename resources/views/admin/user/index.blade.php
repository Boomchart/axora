@extends('admin.menu')

@section('content')
@livewire('admin.users.index', ['admin' => $admin, 'settings' => $set, 'type' => $type, 'title' => $title])
@stop