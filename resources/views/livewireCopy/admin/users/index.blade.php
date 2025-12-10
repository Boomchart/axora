<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{ucwords($title)}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Clients')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-dark"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
            </div>
        </div>
        @if(in_array($type, ['all', 'agents', 'businesses', 'deleted']))
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap mt-5">
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark @if($type == 'all') active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.users', ['type' => 'all'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('All Active Accounts')}} ({{$allusers}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if($type == 'businesses') active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.users', ['type' => 'businesses'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Businesses')}} ({{$businesses}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if($type == 'agents') active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.users', ['type' => 'agents'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Agents')}} ({{$agents}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if($type == 'deleted') active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.users', ['type' => 'deleted'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Deleted Accounts')}} ({{$deletedusers}})</a>
                </li>
            </ul>
        </div>
        @endif
    </div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter Client')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Sort by')}}</label>
                        <select class="form-select form-select-solid" wire:model="sortBy">
                            <option value="asc">{{__('ASC')}}</option>
                            <option value="desc">{{__('DESC')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Order by')}}</label>
                        <select class="form-select form-select-solid" wire:model="orderBy">
                            <option value="created_at">{{__('Date')}}</option>
                            <option value="first_name">{{__('Name')}}</option>
                            <option value="email">{{__('Email')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Status')}}</label>
                        <select class="form-select form-select-solid" wire:model="status">
                            <option value="">{{__('All')}}</option>
                            <option value="0">{{__('Active')}}</option>
                            <option value="1">{{__('Blocked')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Countries')}}</label>
                        <select class="form-select form-select-solid" wire:model="countries">
                            <option value="">{{__('All')}}</option>
                            @foreach(validCountries() as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Email verified')}}</label>
                        <select class="form-select form-select-solid" wire:model="email_verified">
                            <option value="">{{__('All')}}</option>
                            <option value="0">{{__('Pending')}}</option>
                            <option value="1">{{__('Verified')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Per page')}}</label>
                        <select class="form-select form-select-solid" wire:model="perPage">
                            <option value="10">{{__('10')}}</option>
                            <option value="25">{{__('25')}}</option>
                            <option value="50">{{__('50')}}</option>
                            <option value="100">{{__('100')}}</option>
                        </select>
                    </div>
                </div>
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
                                <input type="search" class="form-control form-control-solid rounded-4 bg-white" wire:model="search" placeholder="{{__('Search Clients, name, email, phone')}}" />
                            </div>
                        </div>
                    </div>
                    @if($clients->count() > 0)
                    <div class="table-responsive">
                        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                            <thead>
                                <tr class="fw-semibold fs-7">
                                    <th class="min-w-20px">{{__('S/N')}}</th>
                                    <th class="min-w-100px">{{__('Name')}}</th>
                                    <th class="min-w-100px">{{__('Account ID')}}</th>
                                    <th class="50px">{{__('Status')}}</th>
                                    <th class="50px">{{__('Firewall Ban')}}</th>
                                    <th class="min-w-50px">{{__('Created')}}</th>
                                    <th class="scope"></th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold fs-7">
                                @foreach($clients as $val)
                                <tr>
                                    <td>{{$loop->iteration}}.</td>
                                    <td class="fw-bold">
                                        <div class="symbol symbol-40px symbol-circle">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol-label fs-7 bg-warning text-dark">{{strtoupper(substr($val->business->name, 0, 2))}}</div>
                                                <div class="ps-2">
                                                    <p class="fs-7 text-dark text-hover-success fw-bold mb-0">{{$val->business->name}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$val->business_id}}</td>
                                    <td>
                                        @if($val->status==0)
                                        <span class="badge badge-pill badge-success badge-sm">{{__('Active')}}</span>
                                        @elseif($val->status==1)
                                        <span class="badge badge-pill badge-danger badge-sm">{{__('Blocked')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($val->ban==0)
                                        <span class="badge badge-pill badge-success badge-sm">{{__('No')}}</span>
                                        @elseif($val->ban==1)
                                        <span class="badge badge-pill badge-danger badge-sm">{{__('Yes')}}</span>
                                        @endif
                                    </td>
                                    <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                                    <td class="text-center">
                                        <a href="{{route('user.manage', ['client' => $val->id, 'type' => 'details'])}}" target="_blank" class="btn btn-sm btn-whitelabel rounded-pill me-3"><i class="bi bi-gear-wide-connected"></i> {{__('Manage')}}</a>
                                    </td>
                                </tr>
                                <div><livewire:admin.users.edit-users :val=$val :admin=$admin :wire:key="'kt_devices_'. $val->id"></livewire:admin.users.edit-users></div>
                                @endforeach
                            </tbody>
                        </table>
                        <button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>
                    </div>
                    @else
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-people text-dark" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark">{{__('No Client Found')}}</h3>
                        <p class="text-dark">{{__('We couldn\'t find any client')}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>