@extends('admin.menu')
@section('content')
@livewire('admin.staff.index', ['settings' => $set])
@stop