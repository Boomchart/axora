<div>
    <div class="border border-secondary rounded-4 p-5 mb-10">
        <h3 class="fw-bold fs-5 mb-5"> {{__('Input & Select Fields')}}</h3>
        <div class="row g-xl-8">
            <div class="col-md-8">
                <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                    <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white"
                            wire:model="searchField" placeholder="{{__('Search KYC Input Fields')}}" />
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button id="kt_addkycinput_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add KYC
                Input Fields')}}</button>
            </div>
        </div>
        <div wire:ignore.self id="kt_addkycinput" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
            data-kt-drawer-toggle="#kt_addkycinput_button" data-kt-drawer-close="#kt_addkycinput_close"
            data-kt-drawer-width="{'md': '500px'}">
            <div class="card w-100">
                <div class="card-header pe-5 border-0">
                    <div class="card-title">
                        <div class="d-flex justify-content-center flex-column me-3">
                            <div class="fs-5 text-gray-900 text-hover-danger me-1 lh-1">{{__('Add KYC Input Fields')}}</div>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success"
                            data-kt-drawer-dismiss="true" id="kt_article_close">
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-x-lg fs-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body text-wrap">
                    <div class="pb-5 mt-10 position-relative zindex-1">
                        <form class="form w-100 mb-10" wire:submit.prevent="addKYC(0)" method="post">
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Input Type')}}</label>
                                <input class="form-control form-control-solid" type="text" wire:model.defer="title" required
                                    placeholder="{{__('Input Title')}}" />
                                @error('title')
                                <span class="form-text text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Input Placeholder')}}</label>
                                <input class="form-control form-control-solid" type="text" wire:model.defer="placeholder"
                                    required placeholder="{{__('Input Placeholder')}}" />
                                @error('placeholder')
                                <span class="form-text text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Input Required')}}</label>
                                <select class="form-select form-select-solid" required wire:model="required" required>
                                    <option value="">{{__('Select Option')}}</option>
                                    <option value="1">{{__('Yes')}}</option>
                                    <option value="0">{{__('No')}}</option>
                                </select>
                                @error('required')
                                <span class="form-text">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Input Field Type')}}</label>
                                <select class="form-select form-select-solid" required wire:model="type" required>
                                    <option value="">{{__('Select field type')}}</option>
                                    <option value="text">{{__('Text')}}</option>
                                    <option value="number">{{__('Number')}}</option>
                                    <option value="select">{{__('Select')}}</option>
                                </select>
                                @error('doc_type')
                                <span class="form-text">{{$message}}</span>
                                @enderror
                            </div>
                            @if($type == 'select')
                            <div class="p-5 border rounded-4 mb-10">
                                <h4 class="fw-bold fs-5 mb-6">{{__('Select Options')}}</h4>
                                @foreach($items as $index => $item)
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <p class="fs-9">{{__('Option')}} {{$loop->iteration}}</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        @if($index > 0)
                                        <a class="text-danger mb-0 cursor-pointer" wire:click.prevent="removeItem({{ $index }})"><i class="bi bi-trash text-danger"></i> <u>{{__('Remove')}}</u></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="fv-row mb-6 form-floating">
                                    <input type="text" class="form-control form-control-solid" autocomplete="off" wire:model.debounce.1000ms="items.{{$index}}.option">
                                    <label class="form-label text-dark fs-7 fw-bold">{{__('Option')}}</label>
                                    @error('items.'.$index.'.option')<p class="form-text text-danger">{{$message}}</p>@enderror
                                </div>
                                @endforeach
                                <div class="text-start mb-5">
                                    <a class="text-danger fw-bold cursor-pointer" wire:click.prevent="addItem"><i class="bi bi-plus-lg"></i> <u>{{__('Add additional option')}}</u></a>
                                </div>
                            </div>
                            @else
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Minimum Length')}}</label>
                                <input class="form-control form-control-solid" type="text" wire:model.defer="min" required
                                    placeholder="{{__('Minimum Length')}}" />
                                @error('min')
                                <span class="form-text text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Maximum Length')}}</label>
                                <input class="form-control form-control-solid" type="text" wire:model.defer="max" required
                                    placeholder="{{__('Maximum Length')}}" />
                                @error('max')
                                <span class="form-text text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            @endif
                            <div class="text-center mt-10">
                                <button type="submit" class="btn btn-dark btn-block me-3 my-2" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="addKYC(0)">{{__('Submit KYC')}}</span>
                                    <span wire:loading wire:target="addKYC(0)">{{__('Processing Request...')}}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($kycField->count() > 0)
        <div class="table-responsive">
            <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7"
                wire:loading.class.delay="opacity-50" wire:target="searchField, status, sortBy, orderBy, perPage, loadMore">
                <thead>
                    <tr class="fw-semibold fs-7">
                        <th class="min-w-20px">{{__('S/N')}}</th>
                        <th class="min-w-150px">{{__('Title')}}</th>
                        <th class="min-w-50px">{{__('Required')}}</th>
                        <th class="min-w-50px">{{__('Field Type')}}</th>
                        <th class="min-w-150px">{{__('Field length')}}</th>
                        <th class="min-w-50px">{{__('Status')}}</th>
                        <th class="scope"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kycField as $val)
                    <tr>
                        <td>{{$loop->iteration}}.</td>
                        <td>{{$val->title}}</td>
                        <td>{{($val->required == 1) ? __('Yes') : __('No')}}</td>
                        <td>{{$val->type}}</td>
                        <td>{{$val->min.'-'.$val->max}}</td>
                        <td>
                            @if($val->status==1)
                            <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                            @elseif($val->status==0)
                            <span class="badge badge-pill badge-danger">{{__('Disabled')}}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button id="kt_edit_{{$val->id}}_button"
                                class="btn btn-sm btn-dark rounded-pill">{{__('Edit')}}</button>
                            @if($val->status==1)
                            <a wire:click="disable('{{$val->id}}')"
                                class="btn btn-sm btn-danger rounded-pill">{{__('Disable')}}</a>
                            @else
                            <a wire:click="enable('{{$val->id}}')"
                                class="btn btn-sm btn-secondary rounded-pill">{{__('Enable')}}</a>
                            @endif
                            <a data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" href=""
                                class="btn btn-sm btn-danger rounded-pill">{{__('Delete')}}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center mt-20">
            <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                <div class="symbol-label fs-1 text-white bg-danger">
                    <i class="bi bi-file-earmark-person-fill text-white" style="font-size:66px;"></i>
                </div>
            </div>
            <h3 class="text-dark">{{__('No KYC Input Field Found')}}</h3>
        </div>
        @endif
        @foreach($kycField as $val)
        <div>
            <livewire:admin.kyc.edit :val=$val :wire:key="'kt_edit_'. $val->id"></livewire:admin.kyc.edit>
        </div>
        @endforeach
    </div>
</div>