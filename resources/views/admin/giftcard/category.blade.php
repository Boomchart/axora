@extends('admin.menu')
@section('content')
@livewire('admin.giftcard.category.index', ['settings' => $set])
@stop