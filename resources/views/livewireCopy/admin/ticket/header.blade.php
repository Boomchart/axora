<div>
    <div class="toolbar pb-0" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">{{__('Support Ticket')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-6">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-danger">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{ucwords($type)}}</li>
                </ul>
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.ticket', ['type' => 'open'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.ticket', ['type' => 'open'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Open')}} ({{number_format_short_nc($open)}})</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.ticket', ['type' => 'closed'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.ticket', ['type' => 'closed'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Closed')}} ({{number_format_short_nc($closed)}})</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>