@extends('admin.menu')
@section('content')
@livewire('admin.country.airtime-provider', ['settings' => $set, 'country' => $country, 'admin' => $admin, 'currency' => $currency])
@stop