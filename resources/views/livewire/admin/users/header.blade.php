<div>
    <div class="toolbar pb-0" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{$client->business->name}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-6">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.users', ['type' => 'all'])}}" class="text-muted text-hover-success">{{__('Clients')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{ucwords($type)}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button id="kt_dashboard_button" class="btn btn-white me-4"><i class="bi bi-bell text-dark"></i> {{__('Dashboard notification')}}</button>
                <button id="kt_email_button" class="btn btn-dark"><i class="bi bi-envelope"></i> {{__('Send Email')}}</button>
            </div>
        </div>
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-8 border-gray-300" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'details'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'details'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Details')}}</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'compliance'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'compliance'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Compliance')}}</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'audit'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'audit'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Audit')}}</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'ticket'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'ticket'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Ticket')}} ({{number_format_short_nc($tickets)}})</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'sent-emails'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'sent-emails'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Sent Emails')}} ({{number_format_short_nc($sentMessage)}})</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'transactions'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'transactions'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Transactions')}} ({{number_format_short_nc($transactions)}})</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'orders'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'orders'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Sales')}} ({{number_format_short_nc($orders)}})</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'devices'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'devices'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Devices & Sessions')}}</a>
                </li>
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'webhook'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'webhook'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Webhook Logs')}}</a>
                </li>                
                <li class="nav-item">
                    <a wire:ignore.self class="nav-link text-dark @if(route('user.manage', ['client' => $client->id, 'type' => 'api-log'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('user.manage', ['client' => $client->id, 'type' => 'api-log'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('API Logs')}}</a>
                </li>
            </ul>
        </div>
    </div>
    <div wire:ignore.self id="kt_email" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_email_button" data-kt-drawer-close="#kt_email_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Send Email')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_email_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark">
                            <i class="bi bi-envelope fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="sendEmail" method="post">
                        <div class="fv-row mb-6">
                            <input class="form-control form-control-solid" type="text" wire:model.defer="subject" required placeholder="Subject" />
                            @error('subject')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="message" required placeholder="Message"></textarea>
                            @error('message')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="sendEmail">{{__('Add to Queue')}}</span>
                                <span wire:loading wire:target="sendEmail">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_dashboard" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_dashboard_button" data-kt-drawer-close="#kt_dashboard_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Send Dashboard Alert')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_dashboard_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark">
                            <i class="bi bi-bell fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="sendNotify" method="post">
                        <div class="fv-row mb-6">
                            <input class="form-control form-control-solid" type="text" wire:model.defer="dashboard_subject" required placeholder="Subject" />
                            @error('dashboard_subject')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="dashboard_message" required placeholder="Message"></textarea>
                            @error('dashboard_message')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="sendNotify">{{__('Add to Queue')}}</span>
                                <span wire:loading wire:target="sendNotify">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>