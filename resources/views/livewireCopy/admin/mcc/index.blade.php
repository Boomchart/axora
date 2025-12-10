<div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-info ms-2" data-bs-dismiss="modal" aria-label="Close">
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
                        <option value="500">{{__('500')}}</option>
                        <option value="1000">{{__('1000')}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-xl-8">
        <div class="col-md-6">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model.debounce.1000ms="search" placeholder="{{__('Search')}}" />
                </div>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
            <button id="kt_addpage_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add MCC')}}</button>
        </div>
    </div>
    <div wire:ignore.self id="kt_addpage" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_addpage_button" data-kt-drawer-close="#kt_addpage_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-danger me-1 lh-1">{{__('Add MCC')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_addpage_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addPage" method="post">
                        <div class="fv-row mb-6 form-floating">
                            <label class="form-label text-dark fs-7 required">{{__('MCC Name')}}</label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="name" required placeholder="{{__('MCC')}}" />
                            @error('name')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6 form-floating">
                            <label class="form-label text-dark fs-7 required">{{__('MCC Code')}}</label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="mcc_code" required placeholder="{{__('Code')}}" />
                            @error('mcc_code')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-dark btn-block my-2" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                                <span wire:loading.remove wire:target="addPage">{{__('Submit')}}</span>
                                <span wire:loading wire:target="addPage">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($source->count() > 0)
    <div class="table-responsive">
        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
            <thead>
                <tr class="fw-semibold fs-7">
                    <th class="min-w-20px">{{__('S/N')}}</th>
                    <th class="min-w-250px">{{__('MCC')}}</th>
                    <th class="min-w-250px">{{__('Code')}}</th>
                    <th class="min-w-200px">{{__('Created')}}</th>
                    <th class="min-w-300px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($source as $val)
                <tr>
                    <td>{{$loop->iteration}}.</td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->mcc_code}}</td>
                    <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                    <td class="text-center">
                        <button id="kt_edit_{{$val->id}}_button" class="btn btn-sm btn-dark rounded-pill">{{__('Edit')}}</button>
                        <a data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" href="" class="btn btn-sm btn-danger rounded-pill">{{__('Delete')}}</a>
                    </td>
                </tr>
                <div>
                    <livewire:admin.mcc.edit :val=$val :wire:key="$val->id"></livewire:admin.mcc.edit>
                </div>
                @endforeach
            </tbody>
        </table>
        @if($source->total() > 0 && $source->count() < $source->total())
            <button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>
            @endif
    </div>
    @else
    <div class="text-center mt-20">
        <div class="symbol symbol-150px symbol-circle mb-10 border border-secondary">
            <div class="symbol-label fs-1 bg-danger">
                <i class="bi bi-briefcase text-white" style="font-size:66px;"></i>
            </div>
        </div>
        <h3 class="text-dark">{{__('No MCC Found')}}</h3>
    </div>
    @endif
</div>