<div>
    <div class="toolbar pb-0" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{__('Messages')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-6">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{ucwords($type)}}</li>
                </ul>
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link text-dark @if(route('admin.message', ['type' => 'inbox'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.message', ['type' => 'inbox'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Inbox')}} ({{number_format_short_nc($unreadMessage)}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark @if(route('admin.message', ['type' => 'sent'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.message', ['type' => 'sent'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Sent')}} ({{number_format_short_nc($sentMessage)}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark @if(route('admin.message', ['type' => 'contacts'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.message', ['type' => 'contacts'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Contacts')}} ({{number_format_short_nc($contacts)}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark @if(route('admin.message', ['type' => 'deleted'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.message', ['type' => 'deleted'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Deleted')}} ({{number_format_short_nc($deletedMessage)}})</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button id="kt_dashboard_button" class="btn btn-white me-4"><i class="bi bi-bell text-dark"></i> {{__('Dashboard notification for all users')}}</button>
                <button id="kt_mass_email_button" class="btn btn-dark me-4"><i class="bi bi-envelope text-white"></i> {{__('Email all Subscribers')}}</button>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_mass_email" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_mass_email_button" data-kt-drawer-close="#kt_mass_email_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Send Email')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_mass_email_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark bg-whitelabel">
                            <i class="bi bi-envelope text-dark" style="font-size:44px;"></i>
                        </div>
                    </div>
                    <p class="text-dark fs-7 fw-bold">Send Emails to only active subscribers</p>
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
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" id="filepond-upload" wire:loading.attr="disabled">
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
                        <div class="symbol-label fs-1 text-dark bg-whitelabel">
                            <i class="bi bi-bell text-dark" style="font-size:44px;"></i>
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
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" id="filepond-upload" wire:loading.attr="disabled">
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