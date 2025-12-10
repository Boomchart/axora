<div>
    <div class="toolbar" id="kt_toolbar" wire:init="launchChart">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-success fw-bolder my-1 fs-2x mb-6">{{__('Hi').' '.$user->first_name}},</h1>
            </div>
        </div>
        <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
            <div class="container">
                <div class="row g-xl-8 mb-6">
                    @if($user->business->kyc_status == 'PROCESSING')
                    <div class="col-md-12">
                        <div class="alert alert-warning mb-0">
                            <div class="d-flex flex-column">
                                <p class="mb-0 text-dark fs-7"><i class="bi bi-info-circle text-dark"></i> {{__('We are currently reviewing your compliance information.')}}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($user->business->kyc_status==null || $user->business->kyc_status=="RESUBMIT" || $user->business->kyc_status=="PENDING")
                    <div class="col-md-12">
                        <div class="d-flex align-items-center bg-white rounded-4 p-4">
                            <div class="symbol symbol-45px me-5 symbol-circle">
                                <span class="symbol-label bg-warning">
                                    <i class="bi bi-globe fs-3"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap w-100">
                                <a href="{{route('user.compliance')}}">
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <div class="fs-7 text-dark text-hover-success fw-bold">{{__('Verify Business')}}</div>
                                        <div class="text-gray-800 fw-semibold">{{__('Kindly update your account information to enable gift card issuance for your customers through our API.')}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card bg-transparent h-md-100">
                        <div class="card-body p-0">
                            <div class="px-9 pt-6 card-rounded w-100 bg-success">
                                <div class="fw-bold fs-7 text-start pb-5 text-warning">
                                    <div class="mb-5"
                                        x-data="{ 
                                            show: @js($user->business->reveal_balance), 
                                            toggle() {
                                                this.show = !this.show;
                                                $wire.displayBalance(); // Call Livewire method
                                            }
                                        }">
                                        <p class="text-white">
                                            <span class="me-2">{{__('Available Balance')}}</span>
                                            <span class="ml-3 fs-3 cursor-pointer wallet-text" @click="toggle">
                                                <i class="bi bi-eye-slash text-white" x-show="show" x-transition></i>
                                                <i class="bi bi-eye text-white" x-show="!show" x-transition></i>
                                            </span>
                                        </p>
                                        <span class="fw-bold fs-7 text-start text-white">
                                            <span class="fw-bolder fs-2hx" x-cloak x-show="show" x-transition>
                                                {{$currency->currency_symbol.currencyFormat(number_format($user->getBalance($currency->id)->amount,2)).' '.$currency->currency}}
                                            </span>
                                            <span class="fw-bolder fs-2hx" x-cloak x-show="!show" x-transition>************</span>
                                        </span>
                                        @if($user->business->kyc_status=="APPROVED")
                                        <p class="text-white">
                                            <span class="fs-8">{{__('Issuing Fee')}}: {{$user->business->issuing_fc + collect(json_decode($user->business->issuing_agents, true) ?? [])->sum('rev_fc')}} {{$currency->currency}} + {{$user->business->issuing_pc + collect(json_decode($user->business->issuing_agents, true) ?? [])->sum('rev_pc')}}%</span>
                                        </p>
                                        @endif

                                        @if($user->business->kyc_status == 'APPROVED')
                                        @foreach(getGateways() as $gateway)
                                        <livewire:user.gateway :gateway=$gateway :user=$user :settings=$set :currency=$currency :wire:key="$gateway->id"></livewire:user.gateway>
                                        @endforeach
                                        <button id="kt_deposit_money_button" class="btn btn-dark me-3"><i class="bi bi-plus-lg"></i> {{__('Add Funds')}}</button>
                                        <button id="kt_withdraw_money_button" class="btn btn-dark"><i class="bi bi-bank"></i> {{__('Withdraw')}}</button>
                                        <div wire:ignore.self id="kt_deposit_money" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_deposit_money_button" data-kt-drawer-close="#kt_deposit_money_close" data-kt-drawer-width="{'md': '500px'}">
                                            <div class="card w-100">
                                                <div class="card-header pe-5 border-0">
                                                    <div class="card-title">
                                                        <div class="d-flex justify-content-center flex-column me-3">
                                                            <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Top up')}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_deposit_money_close">
                                                            <span class="svg-icon svg-icon-2">
                                                                <i class="bi bi-x-lg fs-2"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body text-wrap">
                                                    <div class="pb-5 mt-10 position-relative zindex-1">
                                                        <!--begin::Item-->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                @if($set->bk_status == 1)
                                                                <div class="d-flex flex-stack cursor-pointer bg-secondary rounded-4 p-3 mb-5" id="kt_bank_deposit_button">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="symbol symbol-45px symbol-circle me-4">
                                                                            <div class="symbol-label bg-danger">
                                                                                <i class="bi bi-bank text-white fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="ps-1">
                                                                            <p href="#" class="fs-7 text-dark fw-bold mb-0">{{__('ACH (Bank Transfer)')}}</p>
                                                                            <p class="fs-7 text-gray-600 mb-0">@if($set->deposit_percent_pc!=null){{$set->deposit_percent_pc}}% @else 0% @endif+ @if($set->deposit_fiat_pc!=null){{$set->deposit_fiat_pc}} @else 0 @endif{{$currency->currency}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div wire:ignore.self id="kt_bank_deposit" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_bank_deposit_button" data-kt-drawer-close="#kt_bank_deposit_close" data-kt-drawer-width="{'md': '500px'}">
                                                                    <div class="card w-100">
                                                                        <div class="card-header pe-5 border-0">
                                                                            <div class="card-title">
                                                                                <div class="d-flex justify-content-center flex-column me-3">
                                                                                    <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Bank Transfer')}}</div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-toolbar">
                                                                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_bank_deposit_close">
                                                                                    <span class="svg-icon svg-icon-2">
                                                                                        <i class="bi bi-x-lg fs-2"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-body text-wrap">
                                                                            <div class="pb-5 position-relative zindex-1">
                                                                                <form wire:submit.prevent="bankDeposit">
                                                                                    @csrf
                                                                                    <div class="fv-row mb-6">
                                                                                        <label class="form-label fs-7 text-dark">{{__('Amount')}} ({{$currency->currency}})</label>
                                                                                        <input class="form-control form-control-solid" type="text" step="any" wire:model.debounce.500ms="bank_amount" autocomplete="transaction-amount" id="amount" min="1" required placeholder="{{__('0.00')}}" autofocus />
                                                                                        @error('bank_amount')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="fv-row mb-6">
                                                                                        <label class="form-label text-dark fs-7" for="bank_reference">{{__('Bank Transaction Reference')}}</label>
                                                                                        <input class="form-control form-control-solid" type="text" wire:model.defer="bank_reference" required id="bank_reference" placeholder="{{__('Transaction Reference')}}" />
                                                                                        @error('bank_reference')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <div class="fv-row mb-6">
                                                                                        <label class="form-label fs-7 text-dark">{{__('Transaction Receipt')}}</label>
                                                                                        <input class="form-control form-control-solid" type="file" wire:model="image" required />
                                                                                        @error('image')
                                                                                        <span class="text-danger">{{$message}}</span>
                                                                                        @enderror
                                                                                        <div wire:loading wire:target="image">{{__('Uploading')}}...</div>
                                                                                    </div>
                                                                                    <div class="bg-light-warning px-6 py-5 mb-10 rounded-4">
                                                                                        <p class="text-dark fs-7 fw-bold">{{__('Account Details')}}</p>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Bank Name')}}: {{$set->dp_bank_name}} <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="{{$set->dp_bank_name}}" title="{{__('Copy')}}"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Routing Type')}}: {{$set->bk_routing_type}} <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="{{$set->bk_routing_type}}" title="{{__('Copy')}}"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Routing Code')}}: {{$set->bk_routing_code}} <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="{{$set->bk_routing_code}}" title="{{__('Copy')}}"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Account Number')}}: {{$set->bk_acct_no}} <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="{{$set->bk_acct_no}}" title="{{__('Copy')}}"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Account Name')}}: {{$set->bk_acct_name}} <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="{{$set->bk_acct_name}}" title="{{__('Copy')}}"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1" wire:ignore>
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Transaction Description')}}: {{$trx}} <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="{{$trx}}" title="{{__('Copy')}}"></i></span>
                                                                                        </li>
                                                                                    </div>
                                                                                    <div class="bg-light-primary px-6 py-5 mb-10 rounded-4">
                                                                                        <p class="text-dark fs-7 mb-0"><b>{{__('You will receive')}}</b>: {{$receive}}</span></p>
                                                                                        <p class="text-dark fs-7 mb-0"><b>{{__('Fee')}}</b>: {{$fee}}</span></p>
                                                                                    </div>
                                                                                    <div class="text-center mt-10">
                                                                                        <button class="btn btn-block btn-success" type="submit">
                                                                                            <span wire:loading.remove wire:target="bankDeposit">{{__('I\'hv made payment')}}</span>
                                                                                            <span wire:loading wire:target="bankDeposit">{{__('Submitting request...')}}</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            @foreach(getGateways() as $gateway)
                                                            <div class="col-md-12">
                                                                <div class="d-flex flex-stack cursor-pointer bg-secondary rounded-4 p-3 mb-5" data-bs-toggle="modal" data-bs-target="#gateway_deposit{{$gateway->id}}">
                                                                    <div class="d-flex align-items-center me-2">
                                                                        <div class="symbol symbol-45px me-5 symbol-circle">
                                                                            <span class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$gateway->image}});"></span>
                                                                        </div>
                                                                        <div class="me-5">
                                                                            <p class="fs-7 text-dark fw-bold mb-0">{{$gateway->name}}</p>
                                                                            <p class="fs-7 text-gray-600 mb-0">@if($gateway->percent_charge!=null){{$gateway->percent_charge}}% @else 0% @endif+ @if($gateway->fiat_charge!=null){{$gateway->fiat_charge}} @else 0 @endif{{$currency->currency}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @livewire('user.withdraw', ['user' => $user, 'settings' => $set, 'currency' => $currency])
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('developer.index')}}" target="_blank">
                        <div class="d-flex flex-stack cursor-pointer bg-white rounded-4 p-3">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px symbol-circle me-4">
                                    <div class="symbol-label bg-danger">
                                        <i class="bi bi-braces text-white fs-3"></i>
                                    </div>
                                </div>
                                <div class="ps-1">
                                    <p href="#" class="fs-7 text-dark fw-bold mb-0">{{__('API Documentation')}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <hr class="bg-secondary mb-0 mt-5">
                    <h4 class="mb-0 fw-bold mb-5">{{__('Sales')}} ({{__('Last 30 days')}})</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-5 mb-5">
                                <p class="fs-7">{{__('All Time Sales')}}</p>
                                <h3>{{$currency->currency_symbol.number_format($sales, 2)}}</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-5 mb-5">
                                <p class="fs-7">{{__('Total Card Issued')}}</p>
                                <h3>{{number_format_short($issued)}}</h3>
                            </div>
                        </div>
                    </div>
                    <hr class="bg-secondary mb-0 mt-5">
                    <h5 class="fw-bold mb-5">{{__('API Response Codes')}}</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="p-5 rounded-4 border border-secondary mb-5">
                                <p class="fs-7 mb-0"><span class="dot bg-success"></span>{{__('Success')}} (200)</p>
                                <p class="fs-5 fw-bold">{{$successLogs}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-5 rounded-4 border border-secondary mb-5">
                                <p class="fs-7 mb-0"><span class="dot bg-warning"></span>{{__('Client error')}} (400)</p>
                                <p class="fs-5 fw-bold">{{$clientLogs}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-5 rounded-4 border border-secondary mb-5">
                                <p class="fs-7 mb-0"><span class="dot bg-danger"></span>{{__('Server error')}} (500)</p>
                                <p class="fs-5 fw-bold">{{$serverLogs}}</p>
                            </div>
                        </div>
                    </div>
                    <div id="logChart" wire:ignore.self class="mb-10"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    let chart;
    window.livewire.on('loadChart', data => {
        const series = data.series;
        const categories = data.categories;
        const colorMap = data.colors;

        var options = {
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: false
                },
            },
            series: series,
            xaxis: {
                categories: categories
            },
            colors: series.map(s => colorMap[s.name] || '#000'), // JS logic here
            stroke: {
                width: 2 // or 1 if you want it thinner
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return Number.isInteger(val) ? val : parseInt(val);
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return Number.isInteger(val) ? val : parseInt(val);
                    }
                }
            },
            legend: {
                show: false,
                position: 'top'
            }
        };

        chart = new ApexCharts(document.querySelector("#logChart"), options);
        chart.render();
    });
</script>
@endpush