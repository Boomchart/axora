@extends('admin.menu')
@section('content')
@livewire('admin.country.card', ['settings' => $set, 'country' => $country, 'admin' => $admin, 'currency' => $currency])
@stop