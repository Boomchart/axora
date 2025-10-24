@extends('admin.menu')
@section('content')
<div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
    <div class="container">
        <h3 class="mt-4"> {{$reg->name}}</h3>
        <ul class="breadcrumb fw-semibold fs-base my-1 mb-6">
            <li class="breadcrumb-item text-muted">
                <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-danger">{{__('Dashboard')}}</a>
            </li>
            <li class="breadcrumb-item text-muted">
                <a href="{{route('admin.settings', ['type' => 'regtype'])}}" class="text-muted text-hover-danger">{{__('Settings')}}</a>
            </li>
            <li class="breadcrumb-item text-dark">{{__('Kyc Files, Input & Select Options')}}</li>
        </ul>
        @livewire('admin.kyc.doc', ['settings' => $set, 'admin' => $admin, 'reg' => $reg])
        @livewire('admin.kyc.index', ['settings' => $set, 'admin' => $admin, 'reg' => $reg])
    </div>
</div>
@stop