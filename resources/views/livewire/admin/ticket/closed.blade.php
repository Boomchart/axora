<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-md-8">
                    <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control form-control-solid rounded-4 bg-white" wire:model="search" placeholder="{{__('Search ticket')}}" />
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                </div>
            </div>
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
                                <select class="form-select form-select-solid" wire:model="sortBy">
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
            @if($ticket->count() > 0)
            <div class="card-body" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage">
                @foreach($ticket as $tt)
                <div class="d-flex flex-stack cursor-pointer" id="kt_message_{{$tt->id}}_button">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px symbol-circle me-4">
                            <span class="symbol-label bg-danger text-white fw-boldest">{{substr(ucwords($tt?->user?->business?->name), 0, 1)}}</span>
                        </div>
                        <div class="ps-1">
                            <p href="#" class="fs-7 text-dark fw-bold mb-0">{{$tt?->user?->business?->name}}</p>
                            <p href="#" class="fs-7 text-dark mb-0">{{$tt->ticket_id}} @ {{$tt->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</p>
                            <p href="#" class="fs-7 text-dark mb-1">{{$tt->subject}}</p>
                            <span class="badge badge-sm badge-secondary">{{__('Priority').':'.ucwords($tt->priority)}}</span>
                            @if($tt->files != null)
                            <span class="badge badge-sm badge-secondary"><i class="bi bi-paperclip"></i> {{__('Attachment')}}</span>
                            @endif
                        </div>
                    </div>
                    <button class="btn btn-dark rounded-pill btn-sm px-5">{{__('Details')}}</button>
                </div>
                <div><livewire:admin.ticket.admin-reply :val=$tt :admin=$admin :settings=$set :wire:key="'kt_message_'. $tt->id"></livewire:admin.ticket.admin-reply></div>
                @if(!$loop->last)
                <hr class="bg-light-border">
                @endif
                @endforeach
                @if($ticket->total() > 0 && $ticket->count() < $ticket->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
            </div>
            @else
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-white bg-danger">
                        <i class="bi bi-check2-circle text-white" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark">{{__('No Ticket')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any ticket to this account')}}</p>
            </div>
            @endif

        </div>
    </div>
</div>
@push('scripts')
<script>
    var element = $('#scrollToBottom');
    element.scrollTop(element[0].scrollHeight);

    window.livewire.on('newChat', function() {
        var element = $('#scrollToBottom');
        element.scrollTop(element[0].scrollHeight);
    });
</script>
@endpush