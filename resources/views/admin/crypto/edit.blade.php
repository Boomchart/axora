@extends('admin.menu')
@section('content')
<div class="toolbar pb-0" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bolder my-1 fs-2">{{__('Manage Crypto currency')}}</h1>
            <ul class="breadcrumb fw-semibold fs-base my-1 mb-6">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin.crypto')}}" class="text-muted text-hover-primary">{{__('Crypto currencies')}}</a>
                </li>
                <li class="breadcrumb-item text-dark">{{ucwords($currency->name)}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid min-vh-100" id="kt_post">
    <div class="container">
        @livewire('admin.crypto.'.$type, ['val' => $currency, 'admin' => $admin, 'type' => $type, 'settings' => $set])
    </div>
</div>
@stop