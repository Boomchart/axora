<div>
    <div wire:ignore.self id="kt_edit_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_edit_{{$val->id}}_button" data-kt-drawer-close="#kt_edit_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-danger me-1 lh-1">{{__('Edit KYC')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_edit_{{$val->id}}_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="update">
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{($val->doc) ? __('Document Title') :__('Input Title')}}</label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="val.title" required placeholder="{{($val->doc == 1) ? __('Document Title') : __('Field Title')}}" />
                            @error('val.title')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @if($val->doc == 0)
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Input Placeholder')}}</label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="val.placeholder" required placeholder="{{__('Input Placeholder')}}" />
                            @error('val.placeholder')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Input Required')}}</label>
                            <select class="form-select form-select-solid" required wire:model="val.required" required>
                                <option value="">{{__('Select Option')}}</option>
                                <option value="1">{{__('Yes')}}</option>
                                <option value="0">{{__('No')}}</option>
                            </select>
                            @error('val.required')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Input Field Type')}}</label>
                            <select class="form-select form-select-solid" required wire:model="val.type" required>
                                <option value="">{{__('Select field type')}}</option>
                                <option value="text">{{__('Text')}}</option>
                                <option value="number">{{__('Number')}}</option>
                            </select>
                            @error('val.doc_type')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Minimum Length')}}</label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="val.min" required placeholder="{{__('Minimum Document Number')}}" />
                            @error('val.min')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Maximum Length')}}</label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="val.max" required placeholder="{{__('Maximum Document Number')}}" />
                            @error('val.max')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="text-center mt-10">
                            <button type="submit" wire:click.prevent="update" class="btn btn-dark btn-block  me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="update">{{__('Update KYC')}}</span>
                                <span wire:loading wire:target="update">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Delete KYC')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p>{{__('Are you sure you want to delete this KYC')}}?</p>
                    <div class="text-center">
                        <button wire:click="delete" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete">{{__('Delete')}}</span>
                            <span wire:loading wire:target="delete">{{__('Processing Request...')}}</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>