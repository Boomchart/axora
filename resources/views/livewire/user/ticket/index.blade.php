<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">{{__('Support')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Tickets')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                <button id="kt_ticket_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Open Ticket')}}</button>
                <div wire:ignore.self id="kt_ticket" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_ticket_button" data-kt-drawer-close="#kt_ticket_close" data-kt-drawer-width="{'md': '500px'}">
                    <div class="card w-100">
                        <div class="card-header pe-5 border-0">
                            <div class="card-title">
                                <div class="d-flex justify-content-center flex-column me-3">
                                    <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Open Ticket')}}</div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_ticket_close">
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-x-lg fs-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-wrap">
                            <div class="btn-wrapper text-center mb-3">
                                <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                                    <div class="symbol-label fs-1 bg-danger">
                                        <i class="bi bi-chat-square-text text-white" style="font-size:54px;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="pb-5 position-relative zindex-1">
                                <form class="form w-100 mb-10" wire:submit.prevent="addTicket" method="post">
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7">{{__('Title')}}</label>
                                        <input class="form-control form-control-solid" type="text" wire:model="subject" required placeholder="{{__('Title of complaint')}}" />
                                        @error('subject')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7">{{__('Priority')}}</label>
                                        <select class="form-select form-select-solid" wire:model="selectPriority" required>
                                            <option value="low">{{__('Low')}}</option>
                                            <option value="medium">{{__('Medium')}}</option>
                                            <option value="high">{{__('High')}}</option>
                                        </select>
                                        @error('selectPriority')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7">{{__('Description')}}</label>
                                        <textarea class="form-control form-control-solid preserveLines" rows="6" type="text" wire:model="details" required placeholder="Whats your complaint?"></textarea>
                                        @error('details')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7">{{__('Attachment - Optional')}}</label>
                                        <input class="form-control form-control-solid" type="file" wire:model="files" id="files" multiple />
                                        <div wire:loading wire:target="files">{{__('Uploading')}}...</div>
                                        @error('files.*')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="text-center mt-10">
                                        <button type="submit" class="btn btn-dark btn-block me-3 my-2" wire:loading.attr="disabled" wire:target="files">
                                            <span wire:loading.remove wire:target="addTicket">{{__('Submit Ticket')}}</span>
                                            <span wire:loading wire:target="addTicket">{{__('Processing Request...')}}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">{{__('Filter Ticket')}}</h3>
                                <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                    <span class="svg-icon svg-icon-1">
                                        <i class="bi bi-x-lg fs-2"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Type')}}</label>
                                    <select class="form-select form-select-solid" wire:model="status">
                                        <option value="">{{__('All')}}</option>
                                        <option value="0">{{__('Open')}}</option>
                                        <option value="1">{{__('Closed')}}</option>
                                    </select>
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Priority')}}</label>
                                    <select class="form-select form-select-solid" wire:model="priority">
                                        <option value="">{{__('All')}}</option>
                                        <option value="low">{{__('Low')}}</option>
                                        <option value="medium">{{__('Medium')}}</option>
                                        <option value="high">{{__('High')}}</option>
                                    </select>
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Sort by')}}</label>
                                    <select class="form-select form-select-solid" wire:model="orderBy">
                                        <option value="asc">{{__('ASC')}}</option>
                                        <option value="desc">{{__('DESC')}}</option>
                                    </select>
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Per page')}}</label>
                                    <select class="form-select form-select-solid" wire:model="perPage">
                                        <option value="10">{{__('10')}}</option>
                                        <option value="25">{{__('25')}}</option>
                                        <option value="50">{{__('50')}}</option>
                                        <option value="100">{{__('100')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="col-md-12">
                            <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control form-control-solid bg-white rounded-4" wire:model="search" placeholder="{{__('Search')}}" />
                            </div>
                        </div>
                    </div>
                    @if($ticket->count() > 0)
                    <div class="card-body" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage">
                        @foreach($ticket as $tt)
                        <div class="d-flex flex-stack cursor-pointer" id="kt_message_{{$tt->id}}_button">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px symbol-circle me-4">
                                    <div class="symbol-label fs-2 bg-danger">
                                        <i class="bi bi-chat-square-text text-white"></i>
                                    </div>
                                </div>
                                <div class="ps-1">
                                    <p class="fs-7 text-dark fw-bold mb-0">{{$tt->ticket_id}}</p>
                                    @if($tt->status == 0)
                                    <span class="badge badge-sm badge-success">{{__('Open')}} </span>
                                    @else
                                    <span class="badge badge-sm badge-danger">{{__('Closed')}} </span>
                                    @endif

                                    <span class="badge badge-sm badge-secondary">{{__('Priority: ').ucwords($tt->priority)}}</span>
                                    @if($tt->files != null)
                                    <span class="badge badge-sm badge-secondary"><i class="fal fa-paperclip"></i> Attachment</span>
                                    @endif
                                </div>
                            </div>
                            <div class="symbol symbol-50px symbol-circle me-3 cursor-pointer" data-bs-toggle="tooltip" data-bs-original-title="{{__('Settings')}}">
                                <span class="symbol-label bg-white fw-bold fs-4">
                                    <i class="bi bi-caret-down-square text-dark fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <livewire:user.ticket.reply :val=$tt :user=$user :settings=$set :wire:key="'kt_message_'. $tt->id"></livewire:user.ticket.reply>
                        @if(!$loop->last)
                        <hr class="bg-light-border">
                        @endif
                        @endforeach
                        @if($ticket->total() > 0 && $ticket->count() < $ticket->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
                    </div>
                    @else
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-chat-square-text" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark fw-bold">{{__('No Ticket')}}</h3>
                            <p class="text-dark">{{($search) ? __('We couldn\'t find').' "'.$search.'" '.__('Try again?') : __('Create a Support Ticket')}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    var element = $('#scrollToBottom');
    element.scrollTop(element[0].scrollHeight);

    window.livewire.on('newChat', function() {
        document.getElementById('files').value = null;
        var element = $('#scrollToBottom');
        element.scrollTop(element[0].scrollHeight);
    });
</script>
@endpush