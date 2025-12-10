<div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter Contacts')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Subscribed')}}</label>
                        <select class="form-select form-select-solid" wire:model="subscribed">
                            <option value="">{{__('All')}}</option>
                            <option value="1">{{__('Yes')}}</option>
                            <option value="0">{{__('No')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('User')}}</label>
                        <select class="form-select form-select-solid" wire:model="customer">
                            <option value="">{{__('All')}}</option>
                            <option value="1">{{__('Yes')}}</option>
                            <option value="0">{{__('No')}}</option>
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
                        <label class="form-label text-dark fs-7">{{__('Order by')}}</label>
                        <select class="form-select form-select-solid" wire:model="orderBy">
                            <option value="first_name">{{__('Name')}}</option>
                            <option value="email">{{__('Email')}}</option>
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
                            <input type="search" class="form-control form-control-solid rounded-4 bg-white" wire:model="search" placeholder="{{__('Search ').ucwords($type)}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-8 text-end">
                    <button disabled id="kt_send_button" class="btn btn-white text-dark me-4"><i class="bi bi-envelope"></i> {{__('Send Email')}}</button>
                    <button data-bs-toggle="modal" data-bs-target="#deleteall" disabled id="deleteAll" class="btn btn-danger me-4"><i class="fal fa-trash"></i> {{__('Delete')}}</button>
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                    <button class="btn btn-whitelabel text-dark me-4" wire:click="csv">
                        <span wire:loading.remove wire:target="csv"><i class="fal fa-file"></i> {{__('Export CSV')}}</span>
                        <span wire:loading wire:target="csv">{{__('Exporting...')}}</span>
                    </button>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">{{__('Delete Contacts')}}</h3>
                            <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this, you won't be able to send email to this contact anymore?</p>
                            <div class="text-center">
                                <a wire:click="deleteAll" class="btn btn-danger btn-block">{{__('Delete')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div wire:ignore.self id="kt_send" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_send_button" data-kt-drawer-close="#kt_send_close" data-kt-drawer-width="{'md': '500px'}">
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
                                    <i class="bi bi-envelope text-dark" style="font-size:44px;"></i>
                                </div>
                            </div>
                            <p class="text-dark fs-7 fw-bold">{{__('Send Emails to selected contacts')}}</p>
                        </div>
                        <div class="pb-5 mt-10 position-relative zindex-1">
                            <form class="form w-100 mb-10" wire:submit.prevent="sendEmail" method="post">
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
                                        <span wire:loading.remove wire:target="sendEmail">{{__('Add to Queue')}}</span>
                                        <span wire:loading wire:target="sendEmail">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if($contacts->count() > 0)
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
                            <th class="min-w-150px">{{__('Name')}}</th>
                            <th class="min-w-150px">{{__('Email')}}</th>
                            <th class="min-w-100px">{{__('Mobile')}}</th>
                            <th class="min-w-20px">{{__('User')}}</th>
                            <th class="min-w-20px">{{__('Subscribed')}}</th>
                            <th class="min-w-50px">{{__('Created')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $val)
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="check{{$val->id}}" wire:model="archive.{{$val->id}}" wire:click="checked" />
                                </div>
                            </td>
                            <td>{{$loop->iteration}}.</td>
                            <td>{{$val->first_name.' '.$val->last_name}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->mobile}}</td>
                            <td>{{($val->user_id != null) ? 'Yes' : 'No'}}</td>
                            <td>{{($val->subscribed == 1) ? 'Yes' : 'No'}}</td>
                            <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($contacts->total() > 0 && $contacts->count() < $contacts->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
            </div>
            @else
            <div class="text-center mt-20">
            <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-people text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark">{{__('No Contact Found')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any contact')}}</p>
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
        $('#kt_send_button').attr('disabled', (data == 1) ? false : true);
        $('#deleteAll').attr('disabled', (data == 1) ? false : true);
    });
</script>
@endpush