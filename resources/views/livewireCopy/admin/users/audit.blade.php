<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-md-8">
                    <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control form-control-solid rounded-4 bg-white" wire:model="search" placeholder="{{__('Search audit')}}" />
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                    <button data-bs-toggle="modal" data-bs-target="#export" class="btn btn-dark"><i class="bi bi-filetype-csv"></i> {{__('Export')}}</button>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{__('Export Transactions')}}</h3>
                            <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <form wire:submit.prevent="save">
                            <div class="modal-body">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Email Address')}}</label>
                                    <input class="form-control form-control-solid" type="email" wire:model="exportEmail" placeholder="name@example.com">
                                    @error('exportEmail')<span class="form-text">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-block btn-info" type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="save"><i class="bi bi-filetype-csv"></i>
                                    <span wire:loading.remove wire:target="save">{{__('Export')}}</span>
                                    <span wire:loading wire:target="save">{{__('Exporting file...')}}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{__('Filter Audit')}}</h3>
                            <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body">
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
            @if($audit->count() > 0)
            <div class="card-body" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage">
                @foreach($audit as $tt)
                <div class="d-flex flex-stack cursor-pointer" id="kt_message_{{$tt->id}}_button">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px symbol-circle me-4">
                            <div class="symbol-label fs-2 fw-bolder text-dark bg-warning">
                                <i class="bi bi-clipboard-data"></i>
                            </div>
                        </div>
                        <div class="ps-1">
                            <p href="#" class="fs-7 text-dark mb-2">{{str_replace('_', ' ', ucwords($tt->log))}}</p>
                            <p href="#" class="fs-7 text-dark mb-2">{{$tt->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</p>
                            @if($tt->admin_id)
                            <span class="badge badge-danger">{{$tt?->staff?->first_name.' '.$tt?->staff?->last_name}}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if(!$loop->last)
                <hr class="bg-light-border">
                @endif
                @endforeach
                <button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block mt-5">{{__('See more')}}</button>
            </div>
            @else
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-check2-circle text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark fw-bold">{{__('No Audit')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any audit to this account')}}</p>
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