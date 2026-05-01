@extends('admin.menu')
@section('content')
@livewire('admin.country.data-provider', ['settings' => $set, 'country' => $country, 'admin' => $admin, 'currency' => $currency])
@stop