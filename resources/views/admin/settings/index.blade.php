@extends('admin.menu')
@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-10">{{__('Settings')}}</h1>
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'system'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.settings', ['type' => 'system'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('General Settings')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'security'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.settings', ['type' => 'security'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Security')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'deposit'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.settings', ['type' => 'deposit'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Deposit')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'payout'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.settings', ['type' => 'payout'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Withdrawal')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'country'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.settings', ['type' => 'country'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Country supported')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'policies'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.settings', ['type' => 'policies'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Legal Policies')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'logo'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.settings', ['type' => 'logo'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Logos & favicon')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'regtype'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.settings', ['type' => 'regtype'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Business Registration Types')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'mcc'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.settings', ['type' => 'mcc'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Business MCC')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('admin.settings', ['type' => 'file_types'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.settings', ['type' => 'file_types'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('File Types')}}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                @if(route('admin.settings', ['type' => 'payout'])==url()->current())
                @include('partials.admin.withdraw')
                @endif
                @if(route('admin.settings', ['type' => 'system'])==url()->current())
                @include('partials.admin.general')
                @endif
                @if(route('admin.settings', ['type' => 'country'])==url()->current())
                @livewire('admin.country.index', ['settings' => $set, 'admin' => $admin])
                @endif
                @if(route('admin.settings', ['type' => 'security'])==url()->current())
                @include('partials.admin.security')
                @endif
                @if(route('admin.settings', ['type' => 'policies'])==url()->current())
                @include('partials.admin.policy')
                @endif
                @if(route('admin.settings', ['type' => 'logo'])==url()->current())
                @livewire('admin.logo.index', ['settings' => $set, 'admin' => $admin])
                @endif
                @if(route('admin.settings', ['type' => 'regtype'])==url()->current())
                @livewire('admin.regtype.index', ['settings' => $set, 'admin' => $admin])
                @endif
                @if(route('admin.settings', ['type' => 'mcc'])==url()->current())
                @livewire('admin.mcc.index', ['settings' => $set, 'admin' => $admin])
                @endif
                @if(route('admin.settings', ['type' => 'file_types'])==url()->current())
                @include('partials.admin.file_types')
                @endif
                @if(route('admin.settings', ['type' => 'deposit'])==url()->current())
                @include('partials.admin.deposit')
                @endif
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
@if(route('admin.settings', ['type' => 'policies'])==url()->current())
<script src="{{asset('asset/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('asset/tinymce/init-tinymce.js')}}"></script>
<script>
    initializeTinymce('textarea.tinymce');
</script>
@endif

@if(route('admin.settings', ['type' => 'security'])==url()->current() || route('admin.settings', ['type' => 'system'])==url()->current())
<script>
    var input1 = document.querySelector("#kt_tagify_1");
    new Tagify(input1);
</script>
@endif
@endsection