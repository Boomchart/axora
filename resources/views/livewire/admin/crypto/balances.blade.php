<div>
    @include('admin.crypto.header', ['currency' => $val, 'type' => $type])
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg text-dark"></i>
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
                        <label class="form-label text-dark fs-7">{{__('Per page')}}</label>
                        <select class="form-select form-select-solid" wire:model="perPage">
                            <option value="10">{{__('10')}}</option>
                            <option value="25">{{__('25')}}</option>
                            <option value="50">{{__('50')}}</option>
                            <option value="100">{{__('100')}}</option>
                            <option value="500">{{__('500')}}</option>
                            <option value="1000">{{__('1000')}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-xl-8">
        <div class="col-md-10">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model.debounce.1000ms="search" placeholder="{{__('Search')}}" />
                </div>
            </div>
        </div>
        <div class="col-md-2 text-end">
            <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
        </div>
    </div>
    @if($balances->count() > 0)
    <div class="table-responsive">
        <table class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" id="kt_datatable_example_5">
            <thead>
                <tr class="fw-semibold fs-7">
                    <th class="min-w-20px">{{__('S/N')}}</th>
                    <th class="min-w-150px">{{__('User')}}</th>
                    <th class="min-w-250px">{{__('Amount')}}</th>
                    <th class="min-w-300px"></th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-dark fs-7">
                @foreach($balances as $balance)
                <tr>
                    <td>{{$loop->iteration}}.</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px symbol-circle">
                                <div class="symbol-label fs-7 bg-light-primary text-primary">{{strtoupper(substr($balance?->business?->name, 0, 2))}}</div>
                            </div>
                            <div class="ms-5">
                                {{$balance?->business?->name}}
                            </div>
                        </div>
                    </td>
                    <td><b>{{$balance->amount.' '.$balance->token}}</b></td>
                    <td class="text-center">
                        <a href="{{route('user.manage', ['client' => $balance?->user_id, 'type' => 'balance'])}}" class="btn btn-sm btn-primary rounded-pill me-3" target="_blank"><i class="bi bi-gear-wide-connected"></i> {{__('Manage')}}</a>
                        <a href="{{route('user.manage', ['client' => $balance?->user_id, 'type' => 'transactions'])}}" class="btn btn-sm btn-primary rounded-pill" target="_blank"><i class="bi bi-clipboard-data"></i> {{__('Transactions')}}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($balances->total() > 0 && $balances->count() < $balances->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
    </div>
    @else
    <div class="text-center mt-20">
        <div class="symbol symbol-150px symbol-circle mb-10 border border-secondary">
            <div class="symbol-label fs-1 bg-light-primary">
                <i class="bi bi-bank text-primary" style="font-size:66px;"></i>
            </div>
        </div>
        <h3 class="text-dark">{{__('No Account Balance')}}</h3>
    </div>
    @endif
</div>