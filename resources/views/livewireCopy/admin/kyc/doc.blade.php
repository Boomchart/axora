<div>
    <div class="border border-secondary rounded-4 p-5 mb-10">
        <h3 class="fs-5 fw-bold mb-5">{{__('Files Upload')}}</h3>
        <div class="row g-xl-8">
            <div class="col-md-8">
                <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                    <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white"
                            wire:model="search" placeholder="{{__('Search KYC Document')}}" />
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button id="kt_addkyc_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add KYC
                    Document')}}</button>
            </div>
        </div>
        <div wire:ignore.self id="kt_addkyc" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
            data-kt-drawer-toggle="#kt_addkyc_button" data-kt-drawer-close="#kt_addkyc_close"
            data-kt-drawer-width="{'md': '500px'}">
            <div class="card w-100">
                <div class="card-header pe-5 border-0">
                    <div class="card-title">
                        <div class="d-flex justify-content-center flex-column me-3">
                            <div class="fs-5 text-gray-900 text-hover-danger me-1 lh-1">{{__('Add KYC Document')}}</div>
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
                        <form class="form w-100 mb-10" wire:submit.prevent="addKYC(1)" method="post">
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Document Title')}}</label>
                                <input class="form-control form-control-solid" type="text" wire:model.defer="title"
                                    required placeholder="{{__('Document Title')}}" />
                                @error('title')
                                <span class="form-text text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="text-center mt-10">
                                <button type="submit" class="btn btn-dark btn-block me-3 my-2"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="addKYC(1)">{{__('Submit KYC')}}</span>
                                    <span wire:loading wire:target="addKYC(1)">{{__('Processing Request...')}}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($kycDoc->count() > 0)
        <div class="table-responsive">
            <table id="kt_datatable_example_5"
                class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7"
                wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                <thead>
                    <tr class="fw-semibold fs-7">
                        <th class="min-w-20px">{{__('S/N')}}</th>
                        <th class="min-w-150px">{{__('Document Title')}}</th>
                        <th class="min-w-50px">{{__('Status')}}</th>
                        <th class="scope"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kycDoc as $val)
                    <tr>
                        <td>{{$loop->iteration}}.</td>
                        <td>{{$val->title}}</td>
                        <td>
                            @if($val->status==1)
                            <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                            @elseif($val->status==0)
                            <span class="badge badge-pill badge-danger">{{__('Disabled')}}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button id="kt_edit_{{$val->id}}_button"
                                class="btn btn-sm btn-dark rounded-pill me-2">{{__('Edit')}}</button>
                            @if($val->status==1)
                            <a wire:click="disable('{{$val->id}}')"
                                class="btn btn-sm btn-danger rounded-pill me-2">{{__('Disable')}}</a>
                            @else
                            <a wire:click="enable('{{$val->id}}')"
                                class="btn btn-sm btn-secondary rounded-pill me-2">{{__('Enable')}}</a>
                            @endif
                            <a data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" href=""
                                class="btn btn-sm btn-danger rounded-pill me-2">{{__('Delete')}}</a>
                        </td>
                    </tr>
                    <livewire:admin.kyc.edit-doc :val=$val :wire:key="'kt_edit_'. $val->id">
                    </livewire:admin.kyc.edit-doc>
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
            <h3 class="text-dark">{{__('No KYC DOC Found')}}</h3>
        </div>
        @endif
    </div>
</div>