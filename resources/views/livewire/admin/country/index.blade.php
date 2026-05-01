<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">{{__('Gift Card & Bills Countries')}} ({{$countries->count()}})</h1>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter')}}</h3>
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
                            <option value="name">{{__('Name')}}</option>
                            <option value="created_at">{{__('Date')}}</option>
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
            <div class="row g-xl-8 mb-6">
                <div class="col-md-8">
                    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                        <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search Country')}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                    <button id="kt_addCountry_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add Country')}}</button>
                </div>
            </div>
            <div wire:ignore.self id="kt_addCountry" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_addCountry_button" data-kt-drawer-close="#kt_addCountry_close" data-kt-drawer-width="{'md': '500px'}">
                <div class="card w-100">
                    <div class="card-header pe-5 border-0">
                        <div class="card-title">
                            <div class="d-flex justify-content-center flex-column me-3">
                                <div class="fs-5 text-gray-900 text-hover-danger me-1 lh-1">{{__('Add a Country')}}</div>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_article_close">
                                <span class="svg-icon svg-icon-2">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-wrap">
                        <div class="text-center mb-3">
                            <div class="symbol symbol-100px symbol-circle mb-5">
                                <div class="symbol-label fs-1 axora-dashboard-icon">
                                    <i class="bi bi-globe" style="font-size:56px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 mt-10 position-relative zindex-1">
                            <form class="form w-100 mb-10" wire:submit.prevent="addCountry" method="post">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Country')}}</label>
                                    <select class="form-select form-select-solid" wire:model="country">
                                        <option value="">{{__('Select options')}}</option>
                                        @foreach($allCountries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                    <p class="form-text text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="text-center mt-10">
                                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled" wire:target="addCountry">
                                        <span wire:loading.remove wire:target="addCountry">{{__('Submit Country')}}</span>
                                        <span wire:loading wire:target="addCountry">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if($countries->count() > 0)
            <div class="" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage">
                @foreach($countries as $val)
                <div class="d-flex align-items-center cursor-pointer" id="kt_more{{$val->id}}_button">
                    <div class="symbol symbol-40px symbol-circle okay me-3">
                        <div class="symbol-label fi fi-{{strtolower($val->iso2)}}"></div>
                    </div>
                    <div class="ps-2">
                        <p class="fs-7 text-dark fw-bold mb-1">{{$val->name}} ({{$val->iso2}}) <span class="dot"></span> {{$val->currency}}</p>
                        <p class="fs-7 text-gray-800 mb-0">
                            @if($val->status)
                            <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                            @else
                            <span class="badge badge-pill badge-danger">{{__('Disabled')}}</span>
                            @endif
                            <span class="dot"></span>
                            <span class="badge badge-pill badge-secondary">{{$val->giftcards_count}} {{__('Giftcards')}}</span> <span class="dot"></span>
                            <span class="badge badge-pill badge-secondary">{{$val->airtime_providers_count}} {{__('Airtime Operators')}}</span>
                            <span class="badge badge-pill badge-secondary">{{$val->data_providers_count}} {{__('Mobile Data Operators')}}</span>
                        </p>
                    </div>
                </div>
                @if(!$loop->last)
                <hr class="bg-light-border">
                @endif
                <livewire:admin.country.edit :val=$val :admin=$admin :wire:key="'kt_edit_'. $val->id"></livewire:admin.country.edit>
                @endforeach
                @if($countries->total() > 0 && ($countries->total() > $countries->count()))
                <button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>
                @endif
            </div>
            @else
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 axora-dashboard-icon">
                        <i class="bi bi-globe" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark">{{__('No Country Found')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any Country')}}</p>
            </div>
            @endif
        </div>
    </div>
</div>