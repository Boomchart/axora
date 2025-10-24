<div>
    <div wire:ignore.self id="kt_edit_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_edit_{{$val->id}}_button" data-kt-drawer-close="#kt_edit_{{$val->id}}_close" data-kt-drawer-width="{'md': '900px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Edit Method')}}</div>
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
                <div class="pb-5 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="update">
                        <div class="row">
                        <div class="col-md-4">
                                <!--begin::Thumbnail settings-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card body-->
                                    <div class="card-body text-center pt-0">
                                        <!--begin::Image input-->
                                        <!--begin::Image input placeholder-->
                                        <style>
                                            .image-input-placeholder {
                                                background-image: url({{asset('dashboard/media/svg/files/blank-image.svg')}})
                                            }
                                        </style>
                                        <!--end::Image input placeholder-->

                                        <div wire:ignore class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-150px h-150px"></div>
                                            <!--end::Preview existing avatar-->

                                            <!--begin::Label-->
                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="{{__('Change avatar')}}" data-bs-original-title="{{__('Change avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-pencil-fill fs-7"></i>

                                                <!--begin::Inputs-->
                                                <input type="file" wire:model="image" id="image{{$val->id}}" accept=".png, .jpg, .jpeg, .svg">
                                                <input type="hidden" name="avatar_remove">
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Cancel-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="{{__('Cancel avatar')}}" data-bs-original-title="{{__('Cancel avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->

                                            <!--begin::Remove-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="{{__('Remove avatar')}}" data-bs-original-title="{{__('Remove avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->

                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{__('Set the thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted')}}</div>
                                        <div wire:loading wire:target="image" class="fs-7">{{__('Uploading')}}...</div>
                                        @error('val.image')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Name')}}</label>
                                    <input class="form-control form-control-solid" type="text" wire:model.defer="val.name" required placeholder="{{__('Name of Method')}}" />
                                    @error('val.name')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Requirements')}}</label>
                                    <textarea class="form-control form-control-solid" type="text" wire:model.defer="val.requirements" rows="5" required placeholder="{{__('Payout requirements')}}"></textarea>
                                    <span class="form-text">{{__('This will be showed to clients as placeholder to tell them, what they must provide for a successful withdrawal')}}</span>
                                    @error('val.requirements')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fs-7">{{__('Minimum')}}</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                                <input type="number" wire:model.defer="val.min" step="any" class="form-control form-control-solid" required placeholder="0.00">
                                            </div>
                                            @error('val.min')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fs-7">{{__('Maximum')}}</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                                <input type="number" wire:model.defer="val.max" step="any" class="form-control form-control-solid" required placeholder="0.00">
                                            </div>
                                            @error('val.max')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Charge type')}}</label>
                                    <select class="form-select form-select-solid" wire:model="val.pct" required>
                                        <option value="both">{{__('Percentage & Fiat')}}</option>
                                        <option value="percent">{{__('Percentage')}}</option>
                                        <option value="fiat">{{__('Fiat')}}</option>
                                        <option value="none">{{__('No fees')}}</option>
                                        <option value="min">{{__('Below')}}</option>
                                        <option value="max">{{__('Above')}}</option>
                                    </select>
                                </div>
                                <div class="fv-row mb-6 row">
                                    <div class="col-md-6">
                                        <label class="form-label text-dark fs-7">{{__('Percent charge')}}</label>
                                        <div class="input-group">
                                            <input type="number" step="any" wire:model.defer="val.pc" placeholder="{{__('Percent charge')}}" autocomplete="off" class="form-control form-control-solid" @if($pc_required==1) required @endif>
                                            <span class="input-group-text border-0">%</span>
                                        </div>
                                        @error('val.pc')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-dark fs-7">{{__('Fiat charge')}}</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                            <input type="number" step="any" wire:model.defer="val.fc" placeholder="{{__('Fiat charge')}}" autocomplete="off" class="form-control form-control-solid" @if($fc_required==1) required @endif>
                                        </div>
                                        @error('val.fc')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-center mt-10">
                                    <button type="submit" wire:click.prevent="update" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="update">{{__('Update method')}}</span>
                                        <span wire:loading wire:target="update">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </div>
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
                    <h3 class="modal-title">{{__('Delete Method')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p>{{__('Are you sure you want to delete this Method')}}?</p>
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