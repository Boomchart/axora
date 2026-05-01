<div>
    <div wire:ignore.self id="kt_more{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_more{{$val->id}}_button" data-kt-drawer-close="#kt_more{{$val->id}}_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-danger me-1 lh-1">{{__('Settings')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_more{{$val->id}}_close">
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
                            <i class="bi bi-gift" style="font-size:56px;"></i>
                        </div>
                    </div>
                    <p class="fs-7 fw-bold">{{$val->title}}</p>
                </div>
                <div class="mt-10">
                    <div class="bg-secondary px-6 py-5 mb-7 rounded-4">
                        <img class="mb-6 rounded-5" src="{{getPublicImage($val->image)}}" alt="{{$set->site_name}}" loading="lazy" style="height:auto; max-width:100% !important;">

                        <li class="d-flex align-items-center py-1">
                            <span class="bullet me-5 bg-info bullet-vertical"></span> <span><b>{{__('Operator ID')}}</b>: {{$val->id}}</span>
                        </li>
                        <li class="d-flex align-items-center py-1">
                            <span class="bullet me-5 bg-info bullet-vertical"></span> <span><b>{{__('Vendor')}}</b>: {{ucwords($val->provider)}}</span>
                        </li>
                        <li class="d-flex align-items-center py-1">
                            <span class="bullet me-5 bg-info bullet-vertical"></span> <span><b>{{__('Currency')}}</b>: {{$val->currency}}</span>
                        </li>
                        <li class="d-flex align-items-center py-1">
                            <span class="bullet me-5 bg-info bullet-vertical"></span> <span><b>{{__('Min - Max')}}</b>: {{$val->min}} - {{$val->max}}</span>
                        </li>
                        <li class="d-flex align-items-center py-1">
                            <span class="bullet me-5 bg-info bullet-vertical"></span> <span><b>{{$set->site_name}} {{__('Commission')}}</b>: {{$val->discount}}%</span>
                        </li>
                        <li class="d-flex align-items-center py-1">
                            <span class="bullet me-5 bg-info bullet-vertical"></span> <span><b>{{__('Rate against')}} {{$currency->currency}}</b>: {{$val->rate}} {{$currency->currency}}</span>
                        </li>
                    </div>
                </div>
                <div class="p-5 mt-10 position-relative zindex-1 border border-secondary bg-secondary rounded-5">
                    <div class="d-flex align-items-center cursor-pointer" id="kt_vendor_{{$val->id}}_button">
                        <div class="symbol symbol-35px symbol-circle okay me-4">
                            <span class="symbol-label bg-white fw-bold fs-4">
                                <i class="bi bi-bank text-dark fs-5"></i>
                            </span>
                        </div>
                        <div class="ps-2">
                            <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Change Operator')}}</p>
                        </div>
                    </div>
                    <hr class="bg-light-border">
                    <div class="d-flex align-items-center cursor-pointer" id="kt_edit_{{$val->id}}_button">
                        <div class="symbol symbol-35px symbol-circle okay me-4">
                            <span class="symbol-label bg-white fw-bold fs-4">
                                <i class="bi bi-pen text-dark fs-5"></i>
                            </span>
                        </div>
                        <div class="ps-2">
                            <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Edit Operator')}}</p>
                        </div>
                    </div>
                    <hr class="bg-light-border">
                    <a href="{{route('admin.giftcard.orders.filter', ['card' => $val->id])}}" target="_blank">
                        <div class="d-flex align-items-center cursor-pointer">
                            <div class="symbol symbol-35px symbol-circle okay me-4">
                                <span class="symbol-label bg-white fw-bold fs-4">
                                    <i class="bi bi-clipboard-data text-dark fs-5"></i>
                                </span>
                            </div>
                            <div class="ps-2">
                                <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Orders')}} ({{number_format_short($this->salesCount)}})</p>
                            </div>
                        </div>
                    </a>
                    <hr class="bg-light-border">
                    @if($val->status)
                    <div class="d-flex align-items-center cursor-pointer" wire:click="block">
                        <div class="symbol symbol-35px symbol-circle okay me-4">
                            <span class="symbol-label bg-white fw-bold fs-4">
                                <i class="bi bi-slash-circle text-dark fs-5"></i>
                            </span>
                        </div>
                        <div class="ps-2">
                            <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Deactivate')}}</p>
                        </div>
                    </div>
                    @else
                    <div class="d-flex align-items-center cursor-pointer" wire:click="activate">
                        <div class="symbol symbol-35px symbol-circle okay me-4">
                            <span class="symbol-label bg-white fw-bold fs-4">
                                <i class="bi bi-check2-circle text-dark fs-5"></i>
                            </span>
                        </div>
                        <div class="ps-2">
                            <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Activate')}}</p>
                        </div>
                    </div>
                    @endif
                    <hr class="bg-light-border">
                    <div class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}">
                        <div class="symbol symbol-35px symbol-circle okay me-4">
                            <span class="symbol-label bg-white fw-bold fs-4">
                                <i class="bi bi-trash text-dark fs-5"></i>
                            </span>
                        </div>
                        <div class="ps-2">
                            <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Delete')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_edit_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_edit_{{$val->id}}_button" data-kt-drawer-close="#kt_edit_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-danger me-1 lh-1">{{__('Edit Operator')}}</div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Logo')}}</label>
                                    <input class="form-control form-control-solid" type="file" id="art{{$val->id}}" wire:model="image" accept="{{allowedImageTypes()}}" />
                                    <div wire:loading wire:target="image">{{__('Uploading logo')}}...</div>
                                    @error('image')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Operator')}}</label>
                                    <input class="form-control form-control-solid" type="text" wire:model="val.title" required placeholder="{{__('Title of card')}}" />
                                    @error('val.title')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6 row">
                                    <div class="col-md-6">
                                        <label class="form-label text-dark fs-7 required">{{__('Minimum Amount')}}</label>
                                        <input required type="number" step="any" wire:model.debounce.1000ms="val.min" placeholder="{{__('eg.,10')}}" autocomplete="off" class="form-control form-control-solid" @if($val->fixed_min) readonly @endif>
                                        @error('val.min')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-dark fs-7 required">{{__('Maximum Amount')}}</label>
                                        <input required type="number" step="any" wire:model.debounce.1000ms="val.max" placeholder="{{__('eg.,100')}}" autocomplete="off" class="form-control form-control-solid" @if($val->fixed_max) readonly @endif>
                                        @error('val.max')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="fw-row mb-6">
                                    <label class="form-label text-dark fs-7 required">{{$set->site_name}} {{__('Commission')}}</label>
                                    <div class="input-group">
                                        <input type="number" step="any" wire:model.debounce.1000ms="val.discount" placeholder="1" autocomplete="off" class="form-control form-control-solid">
                                        <span class="input-group-text border-0">%</span>
                                    </div>
                                    @error('val.discount')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <hr class="bg-secondary">
                                <div class="row mb-6">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input @if($pc_required==1) required @else readonly @endif type="number" step="any" wire:model="val.issuing_pc" placeholder="{{__('Percent charge')}}" autocomplete="off" class="form-control form-control-solid">
                                            <span class="input-group-text border-0">%</span>
                                        </div>
                                        @error('val.issuing_pc')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                            <input @if($fc_required==1) required @else readonly @endif type="number" step="any" wire:model="val.issuing_fc" placeholder="{{__('Fiat charge')}}" autocomplete="off" class="form-control form-control-solid">
                                        </div>
                                        @error('val.issuing_fc')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="bg-secondary">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Use only denominations')}}</label>
                                    <select class="form-select form-select-solid" wire:model="val.only_denominations">
                                        <option value="">{{__('Select an option')}}</option>
                                        <option value="1">{{__('Yes')}}</option>
                                        <option value="0">{{__('No')}}</option>
                                    </select>
                                    @error('val.only_denominations')
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
                                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled" wire:target="update">
                                        <span wire:loading.remove wire:target="update">{{__('Update Operator')}}</span>
                                        <span wire:loading wire:target="update">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </div>
                            @if($val->created_by != null)
                            <li class="d-flex align-items-center py-2">
                                <span class="bullet me-5 bg-warning bullet-vertical"></span> <span>{{__('Created by')}}: {{$val?->createdBy?->first_name.' '.$val?->createdBy?->last_name}}</span>
                            </li>
                            @endif
                            @if($val->edited_by != null)
                            <li class="d-flex align-items-center py-2">
                                <span class="bullet me-5 bg-warning bullet-vertical"></span> <span>{{__('Edited by')}}: {{$val?->editedBy?->first_name.' '.$val?->editedBy?->last_name}}</span>
                            </li>
                            @endif
                            <li class="d-flex align-items-center py-2">
                                <span class="bullet me-5 bg-warning bullet-vertical"></span> <span>{{__('Updated at')}}: {{$val->updated_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</span>
                            </li>
                            <li class="d-flex align-items-center py-2">
                                <span class="bullet me-5 bg-warning bullet-vertical"></span> <span>{{__('Created at')}}: {{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</span>
                            </li>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_vendor_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_vendor_{{$val->id}}_button" data-kt-drawer-close="#kt_vendor_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-danger me-1 lh-1">{{__('Edit Operator')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_vendor_{{$val->id}}_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="updateVendor">
                        <div class="row">
                            <div class="col-md-12">
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
                                    <label class="form-label text-dark fs-7">{{__('Operator')}}</label>
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
                                <div class="text-center my-10">
                                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled" wire:target="updateVendor">
                                        <span wire:loading.remove wire:target="updateVendor">{{__('Update Vendor')}}</span>
                                        <span wire:loading wire:target="updateVendor">{{__('Processing Request...')}}</span>
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
                    <h3 class="modal-title">{{__('Delete Operator')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p>{{__('Are you sure you want to delete this operator')}}?</p>
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
@push('scripts')
<script>
    window.livewire.on('newCard{{$val->id}}', function() {
        document.getElementById('art{{$val->id}}').value = null;
    });
</script>
@endpush