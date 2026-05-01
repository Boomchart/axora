@extends('admin.menu')
@section('content')
@livewire('admin.country.index', ['settings' => $set, 'admin' => $admin])
@stop