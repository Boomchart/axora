<div>
    <div class="toolbar" id="kt_toolbar">
        <div wire:ignore.self id="kt_filter" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_filter_button" data-kt-drawer-close="#kt_filter_close" data-kt-drawer-width="{'md': '500px'}">
            <div class="card w-100">
                <div class="card-header pe-5 border-0">
                    <div class="card-title">
                        <div class="d-flex justify-content-center flex-column me-3">
                            <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Filter')}}</div>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_filter_close">
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-x-lg fs-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body text-wrap">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Date Range')}}</label>
                        <input class="form-control form-control-solid" placeholder="{{__('Pick date rage')}}" value="{{$first.' - '.$last}}" id="range" wire:model="date">
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Status')}}</label>
                        <select class="form-select form-select-solid" wire:model="status">
                            <option value="">{{__('Select status')}}</option>
                            <option value="success">{{__('Completed')}}</option>
                            <option value="pending">{{__('Pending')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Mode')}}</label>
                        <select class="form-select form-select-solid" wire:model="mode">
                            <option value="">{{__('Select mode')}}</option>
                            <option value="live">{{__('Live')}}</option>
                            <option value="test">{{__('Test')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Sort by')}}</label>
                        <select class="form-select form-select-solid" wire:model="sortBy">
                            <option value="created_at">{{__('Date')}}</option>
                            <option value="amount">{{__('Amount')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Order by')}}</label>
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
        <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
            <div class="container">
                <div class="row g-xl-8">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-9">
                                <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                    <input type="search" class="form-control form-control-solid bg-white rounded-4" wire:model="search" placeholder="{{__('Search')}}" />
                                    <span class="input-group-text cursor-pointer" id="kt_filter_button"><i class="bi bi-filter"></i></span>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <button wire:click="save" class="btn btn-dark">
                                    <span wire:loading.remove wire:target="save"><i class="bi bi-filetype-xlsx"></i> {{__('Export')}}</span>
                                    <span wire:loading wire:target="save">{{__('Exporting...')}}</span>
                                </button>
                            </div>
                        </div>
                        @if($transactions->count() > 0)
                        <div class="" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage, date, loadMore">
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" id="kt_datatable_example_5">
                                        <thead>
                                            <tr class="fw-semibold fs-7">
                                                <th></th>
                                                <th class="min-w-250px">{{__('Name')}}</th>
                                                <th class="min-w-150px">{{__('Amount')}}</th>
                                                <th class="min-w-50px">{{__('Status')}}</th>
                                                <th class="min-w-250px">{{__('Reference ID')}}</th>
                                                <th class="min-w-250px">{{__('Created')}}</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <tbody class="fw-semibold fs-7">
                                            @foreach($transactions as $k=>$val)
                                            <tr class="cursor-pointer">
                                                <td>
                                                    <a href="{{route('admin.view.orders', ['order' => $val->id])}}" class="btn btn-info btn-sm rounded-pill" target="_blank">{{__('Manage')}}</a>
                                                </td>
                                                <td class="fw-bold">{{$val->transaction->card_name}} ({{$val->transaction->card_country}})</td>
                                                <td class="fw-bold">{{currencyFormat(number_format($val->amount, 2)).' '.$val->currency}}</td>
                                                <td>
                                                    @include('partials.transactions.status', ['val' => $val])
                                                </td>
                                                <td>{{$val->id}}</td>
                                                <td>{{$val->created_at->setTimezone($admin->timezone)->toDayDateTimeString()}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($total > $perPage)<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center mt-20">
                            <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                                <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                    <i class="bi bi-cart text-dark" style="font-size:66px;"></i>
                                </div>
                            </div>
                            <h3 class="text-dark fw-bold">{{__('No Orders Found')}}</h3>
                            <p class="text-dark">{{__('We couldn\'t find any orders to this account')}}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(function() {

        var start = '{{$first}}';
        var end = '{{$last}}';

        function cb(start, end) {
            @this.set('date', start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('input[id="range"]').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

    });
</script>
@endpush