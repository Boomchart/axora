<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{__('Staffs & Roles')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Staff')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                <button id="kt_staff_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add a Staff')}}</button>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter Staff')}}</h3>
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
    <div wire:ignore.self id="kt_staff" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_staff_button" data-kt-drawer-close="#kt_staff_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Create a Staff')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_staff_close">
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
                            <i class="bi bi-people text-dark" style="font-size:44px;"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addStaff" method="post">
                        <label class="form-label text-dark fs-7">{{__('Full name')}}</label>
                        <div class="row fv-row mb-6">
                            <div class="col-xl-6">
                                <input class="form-control form-control-solid" type="text" wire:model.defer="first_name" autocomplete="off" required placeholder="{{__('First Name')}}" />
                                @error('first_name')
                                <span class="form-text">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <input class="form-control form-control-solid" type="text" wire:model.defer="last_name" autocomplete="off" required placeholder="{{__('Last Name')}}" />
                                @error('last_name')
                                <span class="form-text">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Username')}}</label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="username" required placeholder="{{__('Username')}}" />
                            @error('username')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Password')}}</label>
                            <input class="form-control form-control-solid" type="password" wire:model.defer="password" required placeholder="{{__('Password')}}" />
                            @error('password')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Notification Email Address')}}</label>
                            <input class="form-control form-control-solid" type="email" wire:model.defer="email" required placeholder="{{__('Email Address')}}" />
                            @error('email')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6" wire:ignore>
                            <label class="form-label text-dark fs-7">{{__('Timezone')}}</label>
                            <select class="form-select form-select-solid" id="timezone" data-control="select2" data-placeholder="{{__('Select Timezone')}}" wire:model="timezone">
                                @foreach(config('timezones') as $key => $value)
                                <option value="{{$key}}">{{$key}} - {{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="form-label text-dark fs-7">{{__('Permissions')}}</label>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="profile" id="customCheckLogin1" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin1">
                                        <span class="text-muted">{{__('Customer')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="support" id="customCheckLogin2" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin2">
                                        <span class="text-muted">{{__('Ticket')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="promo" id="customCheckLogin3" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin3">
                                        <span class="text-muted">{{__('Promotion')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="message" id="customCheckLogin4" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin4">
                                        <span class="text-muted">{{__('Message')}}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="deposit" id="deposit" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="deposit">
                                        <span class="text-muted">{{__('Deposit')}}</span>
                                    </label>
                                </div>
                            </div>                            
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="payout" id="payout" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="payout">
                                        <span class="text-muted">{{__('Payout')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="email_configuration" id="customCheckLogin14" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin14">
                                        <span class="text-muted">{{__('Email Template')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="general_settings" id="customCheckLogin15" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin15">
                                        <span class="text-muted">{{__('General Settings')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="giftcard" id="giftcard" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="giftcard">
                                        <span class="text-muted">{{__('Giftcard')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="decline_compliance" id="decline_compliance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="decline_compliance">
                                        <span class="text-muted">{{__('Decline compliance')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="approve_compliance" id="approve_compliance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="approve_compliance">
                                        <span class="text-muted">{{__('Approve compliance')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="unblock_user" id="unblock_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="unblock_user">
                                        <span class="text-muted">{{__('Unblock user')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="block_user" id="block_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="block_user">
                                        <span class="text-muted">{{__('Block user')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="unban_user" id="unban_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="unban_user">
                                        <span class="text-muted">{{__('Unban user')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="ban_user" id="ban_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="ban_user">
                                        <span class="text-muted">{{__('Ban user')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="rev_share" id="rev_share" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="rev_share">
                                        <span class="text-muted">{{__('Rev share')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="edit_password" id="edit_password" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="edit_password">
                                        <span class="text-muted">{{__('Edit password')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="edit_balance" id="edit_balance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="edit_balance">
                                        <span class="text-muted">{{__('Edit balance')}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="api_error" id="api_error" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="api_error">
                                        <span class="text-muted">{{__('Receive API Error')}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="addStaff">{{__('Submit Request')}}</span>
                                <span wire:loading wire:target="addStaff">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
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
                                <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search Staff')}}" />
                            </div>
                        </div>
                    </div>
                    @if($staffs->count() > 0)
                    <div class="table-responsive">
                        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                            <thead>
                                <tr class="fw-semibold fs-7">
                                    <th class="min-w-20px">{{__('S/N')}}</th>
                                    <th class="min-w-100px">{{__('Name')}}</th>
                                    <th class="min-w-100px">{{__('Username')}}</th>
                                    <th class="min-w-50px">{{__('Status')}}</th>
                                    <th class="min-w-100px">{{__('Created')}}</th>
                                    <th class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffs as $val)
                                <tr>
                                    <td>{{$loop->iteration}}.</td>
                                    <td class="fw-bold">
                                        <div class="symbol symbol-40px symbol-circle">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol-label fs-7 bg-warning text-dark">{{strtoupper(substr($val->first_name, 0, 1).substr($val->last_name, 0, 1))}}</div>
                                                <div class="ps-2">
                                                    <p class="fs-7 text-dark text-hover-success fw-bold mb-0">{{$val->first_name.' '.$val->last_name}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$val->username}}</td>
                                    <td>
                                        @if($val->status==0)
                                        <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                                        @elseif($val->status==1)
                                        <span class="badge badge-pill badge-danger">{{__('Blocked')}}</span>
                                        @endif
                                    </td>
                                    <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                                    <td class="">
                                        <button id="kt_staff_{{$val->id}}_button" class="btn btn-sm btn-whitelabel rounded-pill"><i class="bi bi-pen"></i> {{__('Edit')}}</button>
                                        <button data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-trash"></i> {{__('Delete')}}</button>
                                        <button class="btn btn-secondary dropdown-toggle btn-sm rounded-pill" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{__('More')}}
                                        </button>
                                        <div wire:ignore.self class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#password{{$val->id}}">{{__('Change Password')}}</a>
                                            <a class="dropdown-item" href="#" id="kt_devices_{{$val->id}}_button">{{__('Devices')}}</a>
                                            @if($val->status==0)
                                            <a class="dropdown-item" href="#" wire:click="block('{{$val->id}}')">{{__('Block')}}</a>
                                            @else
                                            <a class="dropdown-item" href="#" wire:click="unblock('{{$val->id}}')">{{__('Unblock')}}</a>
                                            @endif
                                        </div>

                                    </td>
                                </tr>
                                <div>
                                    <livewire:admin.staff.edit :val=$val :wire:key="'kt_staff_'. $val->id"></livewire:admin.staff.edit>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-archive text-dark" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark">{{__('No Staff Found')}}</h3>
                        <p class="text-dark">{{__('We couldn\'t find any staff, create your first staff')}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @foreach($staffs as $val)
    <div wire:ignore.self id="kt_devices_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_devices_{{$val->id}}_button" data-kt-drawer-close="#kt_devices_{{$val->id}}_close" data-kt-drawer-width="{'md': '400px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Devices & Sessions')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_devices_{{$val->id}}_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    @foreach($val->devices() as $device)
                    <div class="d-flex flex-stack mb-6">
                        <div class="d-flex align-items-center me-2">
                            <div class="symbol symbol-45px me-5">
                                <span class="symbol-label bg-light-primary text-dark">
                                    <i class="fal fa-{{strtolower($device->deviceType)}}"></i>
                                </span>
                            </div>
                            <div>
                                <p class="fs-5 text-gray-800 fw-bold mb-0">{{$device->userAgent}}</p>
                                <div class="fs-7 text-gray-800 fw-semibold">{{__('Last login:')}} {{\Carbon\Carbon::create($device->last_login)->format('d M, Y h:i:A')}}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="password{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Change Password')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="resetPassword('{{$val->id}}')" method="post" class="mb-10">
                        @csrf
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="new_password" id="new_password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="new_password">{{__('New password')}}</label>
                            @error('new_password')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block">
                                <span wire:loading.remove wire:target="resetPassword('{{$val->id}}')">{{__('Change Password')}}</span>
                                <span wire:loading wire:target="resetPassword('{{$val->id}}')">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        $('#timezone').on('change', function(e) {
            @this.set('timezone', $(this).val());
        });
    });
</script>
@endpush