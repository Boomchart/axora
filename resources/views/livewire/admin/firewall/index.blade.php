<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{__('Firewall')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Firewall')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-lg-12 col-md-12">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="col-md-12">
                            <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search')}}" />
                            </div>
                        </div>
                    </div>
                    @if($wall->count() > 0)
                    <div class="table-responsive">
                        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                            <thead>
                                <tr class="fw-semibold fs-7">
                                    <th class="min-w-20px">{{__('S/N')}}</th>
                                    <th class="min-w-100px">{{__('IP address')}}</th>
                                    <th class="min-w-100px">{{__('Email')}}</th>
                                    <th class="min-w-100px">{{__('Phone')}}</th>
                                    <th class="min-w-50px">{{__('Status')}}</th>
                                    <th class="min-w-100px">{{__('Created')}}</th>
                                    <th class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wall as $val)
                                <tr>
                                    <td>{{$loop->iteration}}.</td>
                                    <td>{{$val->ip_address}}</td>
                                    <td>{{$val->email}}</td>
                                    <td>{{$val->phone}}</td>
                                    <td>
                                        @if($val->whitelist==1)
                                        <span class="badge badge-pill badge-success">{{__('Whitelisted')}}</span>
                                        @elseif($val->whitelist==0)
                                        <span class="badge badge-pill badge-danger">{{__('Blocked')}}</span>
                                        @endif
                                    </td>
                                    <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                                    <td class="">
                                        @if($val->user_agent != null)
                                        <button id="kt_message_{{$val->id}}_button" class="btn btn-sm btn-whitelabel rounded-pill">{{__('User Agent')}}</button>
                                        @endif
                                        @if($val->whitelist==1)
                                        <a wire:click="block('{{$val->id}}')" class="btn btn-sm btn-danger rounded-pill">{{__('Block')}}</a>
                                        @else
                                        <a wire:click="unblock('{{$val->id}}')" class="btn btn-sm btn-secondary rounded-pill">{{__('Whitelist')}}</a>
                                        @endif
                                    </td>
                                </tr>
                                <div wire:ignore id="kt_message_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_message_{{$val->id}}_button" data-kt-drawer-close="#kt_message_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
                                    <div class="card w-100">
                                        <div class="card-header pe-5 border-0">
                                            <div class="card-title">
                                                <div class="d-flex justify-content-center flex-column me-3">
                                                    <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('User Agent')}}</div>
                                                </div>
                                            </div>
                                            <div class="card-toolbar">
                                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_message__{{$val->id}}_close">
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
                                                        <i class="bi bi-fire text-dark" style="font-size:44px;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pb-5 mt-10 position-relative zindex-1">
                                                <div class="bg-light-primary px-6 py-5 mb-10 rounded">
                                                    {{$val->user_agent}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-bricks text-dark" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark">{{__('No User Found')}}</h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>