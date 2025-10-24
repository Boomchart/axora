@extends('admin.menu')
@section('content')
@livewire('admin.api-log', ['admin' => $admin])
@stop