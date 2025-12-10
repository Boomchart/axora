<div>
    <div class="toolbar pb-0" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{__('Deposit')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-6">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Deposit')}}</li>
                    <li class="breadcrumb-item text-dark">{{ucwords($type)}}</li>
                </ul>
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.deposit', ['type' => 'pending'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.deposit', ['type' => 'pending'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Pending')}} ({{number_format_short_nc($pending)}})</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.deposit', ['type' => 'success'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.deposit', ['type' => 'success'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Success')}} ({{number_format_short_nc($success)}})</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.deposit', ['type' => 'declined'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.deposit', ['type' => 'declined'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Declined')}} ({{number_format_short_nc($declined)}})</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
