<div>
    <div wire:ignore id="kt_message_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_message_{{$val->id}}_button" data-kt-drawer-close="#kt_message_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Message')}}</div>
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
                    <p class="text-dark fs-4 fw-bold">{{$val->subject}}</p>
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
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <div class="bg-light-primary px-6 py-5 mb-10 rounded">
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Name')}}: {{$val->first_name.' '.$val->last_name}} </span>
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Email')}}: {{$val->email}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->email}}" title="{{__('Copy')}}"></i></span>
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Mobile')}}: {{$val->mobile}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->mobile}}" title="{{__('Copy')}}"></i></span>
                        </li>
                        @if($val->admin_id != null)
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Marked as Read by')}}: {{$val->user->first_name.' '.$val->user->last_name}}</span>
                        </li>
                        @endif
                    </div>
                    @if($val->deleted_at == null)
                    <button class="btn btn-secondary btn-block mt-5" id="kt_email_{{$val->id}}_button"><i class="bi bi-envelope"></i> {{__('Send Email')}}</button>
                    @if($val->seen == 0)
                    <button class="btn btn-success btn-block mt-5" wire:click="seen('{{$val->id}}', 1)"><i class="bi bi-hand-thumbs-up"></i> {{__('Mark as Read')}}</button>
                    @endif
                    <button class="btn btn-danger btn-block mt-5" wire:click="delete('{{$val->id}}')"><i class="fal fa-trash"></i> {{__('Delete')}}</button>
                    @else
                    <button class="btn btn-secondary btn-block mt-5" wire:click="restore('{{$val->id}}')"><i class="fal fa-trash-arrow-up"></i> {{__('Restore Message')}}</button>
                    <button class="btn btn-danger btn-block mt-5" wire:click="forceDelete('{{$val->id}}')"><i class="fal fa-trash"></i> {{__('Delete Permanently')}}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_email_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_email_{{$val->id}}_button" data-kt-drawer-close="#kt_email_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Send Email')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_send_close">
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
                    <p class="text-dark fs-7 fw-bold">{{__('Send Email to')}} {{$val->contact->first_name.' '.$val->contact->last_name}}</p>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="sendEmail('{{$val->contact->id}}')" method="post">
                        <div class="fv-row mb-6">
                            <input class="form-control form-control-solid" type="text" wire:model.defer="subject" required placeholder="Subject" />
                            @error('subject')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="message" required placeholder="Message"></textarea>
                            @error('message')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" id="filepond-upload" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="sendEmail('{{$val->contact->id}}')">{{__('Add to Queue')}}</span>
                                <span wire:loading wire:target="sendEmail('{{$val->contact->id}}')">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>