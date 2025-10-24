@extends('admin.menu')

@section('content')
@livewire('admin.dashboard', ['admin' => $admin])
@stop