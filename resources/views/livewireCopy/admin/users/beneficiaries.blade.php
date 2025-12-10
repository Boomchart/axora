<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8 mb-6">
                <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">{{__('Filter Beneficiary')}}</h3>
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
                <div class="col-md-8">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="search" class="form-control form-control-solid bg-white rounded-4" wire:model="search" placeholder="{{__('Search Beneficiary')}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                </div>
            </div>
            @if($beneficiary->count() > 0)
            <div class="" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage, date">
                @foreach($beneficiary as $val)
                <div class="d-flex flex-stack">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40px symbol-circle" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$val->recipient->business->name}}">
                            @if($val->recipient->avatar == null)
                            <span class="symbol-label bg-warning text-dark fw-boldest">{{substr(ucwords($val->recipient->business->name), 0, 1)}}</span>
                            @else
                            <div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val->recipient->avatar}})"></div>
                            @endif
                        </div>
                        <div class="ps-2">
                            <p class="fs-7 text-dark text-hover-success fw-bold mb-0"><a href="{{route('user.manage', ['client' => $val->beneficiary_id, 'type' => 'details'])}}">{{$val->recipient->business->name}}</a></p>
                            <p class="fs-7 text-gray-800 text-hover-success mb-0">{{$val->merchant_id}}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{route('user.manage', ['client' => $val->beneficiary_id, 'type' => 'details'])}}" class="btn btn-sm rounded-pill btn-whitelabel me-3">{{__('Manage')}}</a>
                    </div>
                </div>
                @if(!$loop->last)
                <hr class="bg-light-border">
                @endif
                @endforeach
                @if($beneficiary->total() > 0 && $beneficiary->count() < $beneficiary->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
            </div>
            @else
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-people text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark fw-bold">{{__('No Beneficiary')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any beneficiary to this account')}}</p>
            </div>
            @endif
        </div>
    </div>
</div>