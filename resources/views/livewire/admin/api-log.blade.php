<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">{{__('API Logs')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-info">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Logs')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1 mb-10">
                <button id="kt_filter_button" class="btn btn-dark"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
            </div>
        </div>
        <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
            <div class="container">
                <div wire:ignore.self id="kt_filter" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_filter_button" data-kt-drawer-close="#kt_filter_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
                    <div class="card w-100">
                        <div class="card-header pe-5 border-0">
                            <div class="card-title">
                                <div class="d-flex justify-content-center flex-column me-3">
                                    <div class="fs-4 text-gray-900 text-hover-info me-1 lh-1">{{__('Filter')}}</div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_filter_close">
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
                                <label class="form-label text-dark fs-7">{{__('Status Code')}}</label>
                                <select class="form-select form-select-solid" wire:model="code">
                                    <option value="">{{__('All')}}</option>
                                    <option value="200">200</option>
                                    <option value="400">400</option>
                                    <option value="401">401</option>
                                    <option value="402">402</option>
                                    <option value="403">403</option>
                                    <option value="404">404</option>
                                    <option value="422">422</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Environment')}}</label>
                                <select class="form-select form-select-solid" wire:model="mode">
                                    <option value="">{{__('All')}}</option>
                                    <option value="live">{{__('Live Environment')}}</option>
                                    <option value="test">{{__('Test Environment')}}</option>
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7">{{__('Sort by')}}</label>
                                <select class="form-select form-select-solid" wire:model="sortBy">
                                    <option value="created_at">{{__('Date')}}</option>
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
                                    <option value="500">{{__('500')}}</option>
                                    <option value="1000">{{__('1000')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-xl-8">
                    <div class="col-lg-12 col-md-12">
                        <div class="d-flex justify-content-center flex-column me-3">
                            <div class="col-md-12">
                                <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                    <input type="search" class="form-control form-control-solid bg-white rounded-4" wire:model.debounce.1000ms="search" placeholder="{{__('Search')}}" />
                                </div>
                            </div>
                        </div>
                        @if($transactions->count() > 0)
                        <div class="" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage, date, loadMore">
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-bordered table-row-gray-300 gy-3 gs-7" id="kt_datatable_example_5">
                                        <thead>
                                            <tr class="fw-semibold fs-7">
                                                <th></th>
                                                <th class="min-w-200px"></th>
                                                <th class="min-w-300px">{{__('Business')}}</th>
                                                <th class="min-w-50px">{{__('Code')}}</th>
                                                <th class="min-w-50px">{{__('Method')}}</th>
                                                <th class="min-w-100px">{{__('Message')}}</th>
                                                <th class="min-w-50px">{{__('Environment')}}</th>
                                                <th class="min-w-200px">{{__('Url')}}</th>
                                                <th class="min-w-200px">{{__('IP Address')}}</th>
                                                <th class="min-w-300px">{{__('Created')}}</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <tbody class="fw-semibold fs-7">
                                            @foreach($transactions as $k=>$val)
                                            <tr class="cursor-pointer">
                                                <td @if($val->message) id="kt_webhook{{$val->id}}_button" @endif>
                                                    <div class="symbol symbol-40px symbol-circle me-5 okay">
                                                        <div class="symbol-label fs-3 fw-bolder bg-white">
                                                            <i class="bi bi-code-square"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route('user.manage', ['client' => $val->business_id, 'type' => 'details'])}}" target="_blank" class="btn btn-sm btn-dark rounded-pill me-3"><i class="bi bi-gear-wide-connected"></i> {{__('Manage')}}</a>
                                                </td>
                                                <td>{{$val->business_name}}</td>
                                                <td>{{$val->status_code}}</td>
                                                <td>{{$val->method}}</td>
                                                <td>{{$val->message ? __('True') : __('False')}}</td>
                                                <td>{{$val->mode}}</td>
                                                <td>{{$val->url}}</td>
                                                <td>{{$val->ip_address}}</td>
                                                <td>{{\Carbon\Carbon::create($val->created_at)->setTimezone($admin->timezone)->toDayDateTimeString()}}</td>
                                            </tr>
                                            <div wire:ignore.self id="kt_webhook{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_webhook{{$val->id}}_button" data-kt-drawer-close="#kt_webhook{{$val->id}}_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
                                                <div class="card w-100">
                                                    <div class="card-header pe-5 border-0">
                                                        <div class="card-title">
                                                            <div class="d-flex justify-content-center flex-column me-3">
                                                                <div class="fs-5 text-gray-900 text-hover-info me-1 lh-1">{{__('Webhook Details')}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="card-toolbar">
                                                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_webhook{{$val->id}}_close">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <i class="bi bi-x-lg fs-2"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-body text-wrap">
                                                        <div class="text-center mb-3">
                                                            <div class="symbol symbol-100px symbol-circle okay mb-5">
                                                                <span class="symbol-label bg-secondary text-dark fw-bold fs-1">
                                                                    <i class="bi bi-code-square text-dark" style="font-size:56px;"></i>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="pb-5 mt-10 position-relative zindex-1">
                                                            <div class="row mb-5">
                                                                <div class="col-12" wire:ignore>
                                                                    <p class="mb-1 fs-7">{{__('Message')}}</p>
                                                                    @if(is_array($val->message) == false)
                                                                    <p class="mb-1 fs-7">{{$val->message}}</p>
                                                                    @else
                                                                    <pre class="rounded-4">
                                                                        <code class="language-json" style="font-size: 0.85rem !important;" data-lang="json">   
                                                                        {!! json_encode(json_decode($val->message, true), JSON_PRETTY_PRINT) !!}
                                                                        </code>
                                                                    </pre>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center mt-20">
                            <div class="symbol symbol-150px symbol-circle mb-10 border border-secondary">
                                <div class="symbol-label fs-1 bg-whitelabel">
                                    <i class="bi bi-code-square" style="font-size:66px;"></i>
                                </div>
                            </div>
                            <h3 class="text-dark fw-bold text-uppercase fs-5">{{($search) ? __('We couldn\'t find').' "'.$search.'" '.__('Try again?') : __('No API Log Found')}}</h3>
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

    window.livewire.on('drawer', function() {
        $('tr[data-href]').on("click", function() {
            window.location.href = $(this).data('href');
        });
    });
</script>
@endpush