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
                    <div class="symbol symbol-100px symbol-circle okay mb-5">
                        <div class="symbol-label fi fi-{{strtolower($val->iso2)}}"></div>
                    </div>
                    <p class="fs-7 fw-bold">{{$val->name}}</p>
                </div>

                <div class="p-5 mt-10 position-relative zindex-1 border border-secondary bg-secondary rounded-5">
                    <a href="{{route('admin.giftcard.cards', ['country' => $val->id])}}" target="_blank">
                        <div class="d-flex align-items-center cursor-pointer">
                            <div class="symbol symbol-35px symbol-circle okay me-4">
                                <span class="symbol-label bg-white fw-bold fs-4">
                                    <i class="bi bi-gift text-dark fs-5"></i>
                                </span>
                            </div>
                            <div class="ps-2">
                                <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Gift Cards')}} ({{number_format_short($this->giftcardsCount)}})</p>
                            </div>
                        </div>
                    </a>
                    <hr class="bg-light-border">
                    <a href="{{route('admin.airtime.providers', ['country' => $val->id])}}" target="_blank">
                        <div class="d-flex align-items-center cursor-pointer">
                            <div class="symbol symbol-35px symbol-circle okay me-4">
                                <span class="symbol-label bg-white fw-bold fs-4">
                                    <i class="bi bi-phone text-dark fs-5"></i>
                                </span>
                            </div>
                            <div class="ps-2">
                                <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Airtime Operators')}} ({{number_format_short($this->airtimeProvidersCount)}})</p>
                            </div>
                        </div>
                    </a>
                    <hr class="bg-light-border"> 
                    <a href="{{route('admin.data.providers', ['country' => $val->id])}}" target="_blank">
                        <div class="d-flex align-items-center cursor-pointer">
                            <div class="symbol symbol-35px symbol-circle okay me-4">
                                <span class="symbol-label bg-white fw-bold fs-4">
                                    <i class="bi bi-phone text-dark fs-5"></i>
                                </span>
                            </div>
                            <div class="ps-2">
                                <p class="fs-7 text-dark text-hover-danger mb-0">{{__('Mobile Operators')}} ({{number_format_short($this->dataProvidersCount)}})</p>
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
    <div wire:ignore.self class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Delete Country')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p>{{__('Are you sure you want to delete this Country')}}?</p>
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