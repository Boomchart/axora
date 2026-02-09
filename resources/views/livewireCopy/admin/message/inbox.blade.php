<div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter Messages')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Sort by')}}</label>
                        <select class="form-select form-select-solid" wire:model="sortBy">
                            <option value="asc">{{__('ASC')}}</option>
                            <option value="desc">{{__('DESC')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Order by')}}</label>
                        <select class="form-select form-select-solid" wire:model="orderBy">
                            <option value="created_at">{{__('Date')}}</option>
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
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-md-4">
                    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                        <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="search" class="form-control form-control-solid bg-white rounded-4" wire:model="search" placeholder="{{__('Search messages')}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-8 text-end">
                    <button wire:click="markAll(0)" disabled id="unreadAll" class="btn btn-white text-dark me-4"><i class="bi bi-hand-thumbs-up"></i> {{__('Unread')}}</button>
                    <button wire:click="markAll(1)" disabled id="readAll" class="btn btn-white text-dark me-4"><i class="bi bi-hand-thumbs-up"></i> {{__('Read all')}}</button>
                    <button data-bs-toggle="modal" data-bs-target="#deleteall" disabled id="deleteAll" class="btn btn-danger me-4"><i class="fal fa-trash"></i> {{__('Delete')}}</button>
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{__('Delete Message')}}</h3>
                            <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this?</p>
                            <div class="text-center">
                                <a wire:click="deleteAll" class="btn btn-danger btn-block">{{__('Delete')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($message->count() > 0)
            <div class="table-responsive">
                <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                    <thead>
                        <tr class="fw-semibold fs-7">
                            <th>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="all" wire:model="all" wire:click="setAll" />
                                </div>
                            </th>
                            <th class="min-w-20px">{{__('S/N')}}</th>
                            <th class="min-w-100px">{{__('Name')}}</th>
                            <th class="min-w-250px">{{__('Subject')}}</th>
                            <th class="min-w-50px">{{__('Read')}}</th>
                            <th class="min-w-200px">{{__('Created')}}</th>
                            <th class="scope"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($message as $val)
                        <tr class="fw-semibold fs-7">
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="check{{$val->id}}" wire:model="archive.{{$val->id}}" wire:click="checked" />
                                </div>
                            </td>
                            <td>{{$loop->iteration}}.</td>
                            <td>{{$val->first_name.' '.$val->last_name}}</td>
                            <td>{{substr($val->subject, 0, 60)}}...</td>
                            <td>
                                @if($val->seen==0)
                                <span class="badge badge-pill badge-danger">{{__('Unread')}}</span>
                                @else
                                <span class="badge badge-pill badge-success">{{__('Read')}}</span>
                                @endif
                            </td>
                            <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                            <td class="text-center">
                                <button id="kt_message_{{$val->id}}_button" class="btn btn-sm btn-whitelabel rounded-pill">Details</button>
                            </td>
                        </tr>
                        <div><livewire:admin.message.message :val=$val :type=$type :admin=$admin :wire:key="'kt_message_'. $val->id"></livewire:admin.message.message></div>
                        @endforeach
                    </tbody>
                </table>
                @if($message->total() > 0 && $message->count() < $message->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
            </div>
            @else
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-inbox text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark fw-bold">{{__('No Message Found')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any message in your inbox')}}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.livewire.on('clearMarkAll', function() {
        $('#add').val(0);
    });
    window.livewire.on('updatemarked', function(data) {
        $('#unreadAll').attr('disabled', (data == 1) ? false : true);
        $('#readAll').attr('disabled', (data == 1) ? false : true);
        $('#deleteAll').attr('disabled', (data == 1) ? false : true);
    });
</script>
@foreach($message as $val)
<script>
    $(document).on('click', '#readMore{{$val->id}}', function(e) {
        e.preventDefault();
        $('#main-data{{$val->id}}').hide();
        $('#main-data-hide{{$val->id}}').show();
    });
    $(document).on('click', '#readLess{{$val->id}}', function(e) {
        e.preventDefault();
        $('#main-data{{$val->id}}').show();
        $('#main-data-hide{{$val->id}}').hide();
    });
</script>
@endforeach
@endpush