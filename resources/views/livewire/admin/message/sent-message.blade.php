<div>
    <div wire:ignore id="kt_message_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_message_{{$val->id}}_button" data-kt-drawer-close="#kt_message_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Message')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_message__{{$val->id}}_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark bg-whitelabel">
                            <i class="bi bi-inbox text-dark" style="font-size:44px;"></i>
                        </div>
                    </div>
                    <p class="text-dark fs-1 fw-bolder">{{$val->subject}}</p>
                    @if($val->html == 0)
                    <div class="text-start text-dark fs-7 ">
                        @if(Str::length($val->message)>50)
                        <div id="main-data{{$val->id}}">
                            <p class="preserveLines">{{Str::words($val->message, 50)}}</p>
                            <a id="readMore{{$val->id}}" href="javascript:void;">{{__('Read more')}}</a>
                        </div>
                        @else
                        <p class="preserveLines">{{$val->message}}</p>
                        @endif
                        <div style="display:none;" id="main-data-hide{{$val->id}}">
                            <p class="preserveLines">{{$val->message}}</p>
                            <a id="readLess{{$val->id}}" href="javascript:void;">{{__('Read less')}}</a>
                        </div>
                    </div>
                    @else
                    <div class="iframe-container">
                        <iframe srcdoc="{{$val->message}}" style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                    @endif
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <div class="bg-light px-6 py-5 mb-10 rounded text-dark">
                        <p class="text-dark fs-7 fw-bolder">{{__('Contact Details')}}</p>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Name')}}: {{$val->contact->first_name.' '.$val->contact->last_name}} </span>
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Email')}}: {{$val->contact->email}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->contact->email}}" title="{{__('Copy')}}"></i></span>
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Mobile')}}: {{$val->contact->mobile}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->contact->mobile}}" title="{{__('Copy')}}"></i></span>
                        </li>
                        @if($val->admin_id != null)
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Sent by')}}: {{$val->admin->first_name.' '.$val->admin->last_name}}</span>
                        </li>
                        @endif
                    </div>
                    <button class="btn btn-danger btn-block mt-5" wire:click="delete('{{$val->id}}')"><i class="fal fa-trash"></i> {{__('Delete')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>