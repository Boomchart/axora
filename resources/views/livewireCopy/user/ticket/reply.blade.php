<div>
    <div wire:ignore.self id="kt_message_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_message_{{$val->id}}_button" data-kt-drawer-close="#kt_message_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Manage Ticket')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_message_{{$val->id}}_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 position-relative zindex-1">
                    <div class="bg-secondary px-6 py-5 mb-10 rounded-4" wire:ignore>
                        <p class="text-dark fs-7 mb-0"><b>{{__('Ticket ID')}}</b>: {{$val->ticket_id}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->ticket_id}}" title="{{__('Copy')}}"></i></p>
                        <p class="text-dark fs-7 mb-0"><b>{{__('Subject')}}</b>: {{$val->subject}}</p>
                        <p class="text-dark fs-7 mb-0"><b>{{__('Created')}}</b>: {{date("Y/m/d h:i:A", strtotime($val->created_at))}}</p>
                        @if($val->files != null)
                        <div class="symbol-group symbol-hover mt-3">
                            @foreach(explode(',', $val->files) as $files)
                            <a href="{{getPublicImage($files)}}" target="_blank">
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip">
                                    <span class="symbol-label bg-danger fw-bold">
                                        <i class="bi bi-file-text fs-2 text-white"></i>
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="card-body" id="kt_chat_messenger_body" wire:poll.visible>
                        <div class="scroll-y me-n5 pe-5 h-400px h-lg-auto" id="scrollToBottom" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px" style="max-height: 266px;">
                            <div class="d-flex justify-content-end mb-10">
                                <div class="d-flex flex-column align-items-end">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-3">
                                            <a href="#" class="fs-7 fw-bold text-gray-900 text-hover-success me-1">{{$user->business->name}}</a>
                                            <span class="text-muted fs-8 mb-1">{{$val->created_at->diffForHumans()}}</span>
                                        </div>
                                        <div class="symbol symbol-50px symbol-circle">
                                            <div class="symbol-label fs-7 fw-bold text-white bg-danger">{{strtoupper(substr($user->business->name, 0, 2))}}</div>
                                        </div>
                                    </div>
                                    <div class="p-3 rounded bg-light-warning text-dark mw-lg-400px text-start preserveLines" data-kt-element="message-text">{{$val->message}}</div>
                                </div>
                            </div>
                            @if($val->reply->count()>0)
                            @foreach($val->reply as $reply)
                            <div class="d-flex {{($reply->status == 1) ? 'justify-content-start' : 'justify-content-end'}} mb-10">
                                <div class="d-flex flex-column {{($reply->status == 1) ? 'align-items-start' : 'align-items-end'}}">
                                    <div class="d-flex align-items-center mb-2">
                                        @if($reply->status == 0)
                                        <div class="me-3">
                                            <a href="#" class="fs-7 fw-bold text-gray-900 text-hover-success me-1">{{$user->business->name}}</a>
                                            <span class="text-muted fs-8 mb-1">{{$reply->created_at->setTimezone($user->user_timezone)->diffForHumans()}}</span>
                                        </div>
                                        <div class="symbol symbol-50px symbol-circle">
                                            <div class="symbol-label fs-7 fw-bold text-dark bg-light-warning">{{strtoupper(substr($user->business->name, 0, 2))}}</div>
                                        </div>
                                        @else
                                        <div class="me-3">
                                            <span class="text-muted fs-8 mb-1">{{$reply->created_at->setTimezone($user->user_timezone)->diffForHumans()}}</span>
                                            <a href="#" class="fs-7 fw-bold text-gray-900 text-hover-success ms-1">{{$reply->staff->first_name.' '.$reply->staff->last_name}}</a>
                                        </div>
                                        <div class="symbol symbol-50px symbol-circle bg-danger">
                                            <div class="symbol-label fs-7 fw-bold text-white"><i class="bi bi-bank"></i></div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="p-3 rounded text-dark mw-lg-400px preserveLines text-start {{($reply->status == 1) ? 'bg-light-primary' : 'bg-light-warning'}}" data-kt-element="message-text">{{$reply->reply}}</div>

                                    @if($reply->files != null)
                                    <div class="symbol-group symbol-hover mt-n2">
                                        @foreach(explode(',', $reply->files) as $files)
                                        <a href="{{getPublicImage($files)}}" target="_blank">
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip">
                                                <span class="symbol-label bg-danger fw-bold">
                                                    <i class="bi bi-file-text fs-2 text-white"></i>
                                                </span>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @if($val->status == 0)
                    <div class="card-footer p-0 pt-4" id="kt_chat_messenger_footer">
                        <form class="form w-100 mb-10" wire:submit.prevent="reply" method="post">
                            <textarea class="form-control form-control-flush mb-3 preserveLines" rows="3" wire:model.defer="message" placeholder="Type a message" required></textarea>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Attachment - Optional')}}</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" wire:model="files" id="files{{$val->id}}" multiple />
                                <div wire:loading wire:target="files">{{__('Uploading')}}...</div>
                                @error('files.*')
                                <span class="form-text text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <button class="btn btn-dark btn-block" type="submit" wire:loading.attr="disabled" wire:target="files">
                                <span wire:loading.remove wire:target="reply">{{__('Send')}}</span>
                                <span wire:loading wire:target="reply">{{__('Replying ticket...')}}</span>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.livewire.on('newChat', function() {
        const chatBody = document.getElementById('scrollToBottom');
        chatBody.scrollTop = chatBody.scrollHeight; // Scroll to the bottom
        document.getElementById('files{{$val->id}}').value = null;
    });

    // For initial load (if the page has existing messages)
    document.addEventListener("DOMContentLoaded", function() {
        const chatBody = document.getElementById('scrollToBottom');
        if (chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight; // Scroll to the bottom
        }
    });
</script>
@endpush