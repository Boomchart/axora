<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2"> {{$country->name}} {{__('Mobile Data Operators')}} ({{number_format_short($cards->total())}})</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-danger">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.giftcard.country')}}" class="text-muted text-hover-danger">{{__('Countries')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{ucwords($country->name)}}</li>
                </ul>
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
                        <label class="form-label text-dark fs-7">{{__('Status')}}</label>
                        <select class="form-select form-select-solid" wire:model="status">
                            <option value="">{{__('All')}}</option>
                            <option value="1">{{__('Active')}}</option>
                            <option value="0">{{__('Disabled')}}</option>
                        </select>
                    </div>
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
                            <option value="title">{{__('Title')}}</option>
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
    <div wire:ignore.self id="kt_article" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_article_button" data-kt-drawer-close="#kt_article_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-danger me-1 lh-1">{{__('Create an Operator')}}</div>
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
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addCard" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Logo')}}</label>
                                    <input class="form-control form-control-solid" type="file" wire:model="image" id="art" accept="{{allowedImageTypes()}}" />
                                    <div wire:loading wire:target="image">{{__('Uploading logo')}}...</div>
                                    @error('image')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Provider')}}</label>
                                    <select class="form-select form-select-solid" wire:model="provider">
                                        <option value="">{{__('Select an option')}}</option>
                                        <option value="reloadly">{{__('Reloadly')}}</option>
                                    </select>
                                    @error('provider')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Operators')}}</label>
                                    <select class="form-select form-select-solid" wire:model="product">
                                        <option value="">{{__('Select an option')}}</option>
                                        @foreach($products as $gg)
                                        <option value="{{$gg['id']}}">{{$gg['title']}}</option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                    <div wire:loading wire:target="provider" class="axora-kyc-loading">{{ __('Fetching Operators') }}...</div>
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7 required">{{__('Title')}}</label>
                                    <input class="form-control form-control-solid" type="text" wire:model="title" required placeholder="{{__('Title of Operator')}}" />
                                    @error('title')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fw-row mb-6">
                                    <label class="form-label text-dark fs-7 required">{{$set->site_name}} {{__('Commission')}}</label>
                                    <div class="input-group">
                                        <input type="number" step="any" wire:model.debounce.1000ms="discount" placeholder="1" autocomplete="off" class="form-control form-control-solid">
                                        <span class="input-group-text border-0">%</span>
                                    </div>
                                    @error('discount')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6 row">
                                    <div class="col-md-6">
                                        <label class="form-label text-dark fs-7 required">{{__('Minimum Amount')}}</label>
                                        <input required type="number" step="any" wire:model.debounce.1000ms="min" placeholder="{{__('eg.,10')}}" autocomplete="off" class="form-control form-control-solid">
                                        @error('min')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-dark fs-7 required">{{__('Maximum Amount')}}</label>
                                        <input required type="number" step="any" wire:model.debounce.1000ms="max" placeholder="{{__('eg.,100')}}" autocomplete="off" class="form-control form-control-solid">
                                        @error('max')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="bg-secondary">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Use only denominations')}}</label>
                                    <select class="form-select form-select-solid" wire:model="only_denominations">
                                        <option value="">{{__('Select an option')}}</option>
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                    @error('only_denominations')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="p-5 border rounded-4 mb-10">
                                    <p class="fs-7 fw-bold mb-5">{{__('Denominations')}}</p>
                                    @foreach($items as $index => $item)
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <p class="fs-8 mb-0">{{__('Plan')}} {{$loop->iteration}}</p>
                                        </div>
                                    </div>
                                    <div class="fv-row mb-6">
                                        <input type="text" class="form-control form-control-solid" autocomplete="off" wire:model.debounce.1000ms="items.{{$index}}.plan" readonly>
                                        @error('items.'.$index.'.plan')<p class="form-text text-danger">{{$message}}</p>@enderror
                                    </div>
                                    <div class="fv-row mb-6">
                                        <input type="text" steps="any" class="form-control form-control-solid" autocomplete="off" placeholder="{{__('0.00')}}" wire:model.debounce.1000ms="items.{{$index}}.amount" readonly>
                                        @error('items.'.$index.'.amount')<p class="form-text text-danger">{{$message}}</p>@enderror
                                    </div>
                                    @endforeach
                                </div>
                                <div class="text-center my-10">
                                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled" wire:target="addCard">
                                        <span wire:loading.remove wire:target="addCard">{{__('Submit Operators')}}</span>
                                        <span wire:loading wire:target="addCard">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8 mb-6">
                <div class="col-md-6">
                    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                        <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search cards')}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                    <button id="kt_article_button" class="btn btn-dark me-4"><i class="bi bi-phone"></i> {{__('Add Operators')}}</button>
                </div>
            </div>
            @if($cards->count() > 0)
            <div class="" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage">
                @foreach($cards as $val)
                <div class="d-flex align-items-center cursor-pointer" id="kt_more{{$val->id}}_button">
                    <div class="symbol symbol-45px symbol-circle okay me-3">
                        <span class="symbol-label axora-dashboard-icon"><i class="bi bi-gift fs-5"></i></span>
                    </div>
                    <div class="ps-2">
                        <p class="fs-7 text-dark fw-bold mb-1">{{$val->title}}</p>
                        <p class="fs-7 text-gray-800 mb-0">
                            @if($val->status)
                            <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                            @else
                            <span class="badge badge-pill badge-danger">{{__('Disabled')}}</span>
                            @endif
                            <span class="dot"></span>
                            <span class="badge badge-pill badge-secondary text-dark">{{ucwords($val->provider)}}</span>
                        </p>
                    </div>
                </div>
                @if(!$loop->last)
                <hr class="bg-light-border">
                @endif
                <livewire:admin.country.edit-data-provider :val=$val :admin=$admin :wire:key="$val->id"></livewire:admin.country.edit-data-provider>
                @endforeach
                @if($cards->total() > 0 && ($cards->total() > $cards->count()))
                <button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>
                @endif
            </div>
            @else
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 axora-dashboard-icon">
                        <i class="bi bi-phone" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark">{{__('No Operators Found')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any operator')}}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('dashboard/js/sort.js')}}"></script>
<script>
    window.livewire.on('newCard', function() {
        document.getElementById('art').value = null;
    });
</script>
@endpush