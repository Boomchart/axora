<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">
                    {{__('Transaction Details')}}
                </h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.dashboard')}}" class="text-muted text-hover-info">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.transactions')}}" class="text-muted text-hover-info">{{__('Transactions')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Transaction Details')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="d-flex align-items-center mb-3 p-3 bg-white rounded-4">
                <div class="symbol symbol-45px symbol-circle me-2">
                    <div class="symbol-label fs-3 fw-bolder axora-dashboard-icon">
                        @if($val->trx_type == 'debit')
                        <i class="bi bi-dash-lg"></i>
                        @else
                        <i class="bi bi-plus-lg"></i>
                        @endif
                    </div>
                </div>
                <div class="ps-2">
                    <p class="text-dark fw-bold fs-7 mb-0">
                        {{ucwords(str_replace('_', ' ', $val->type))}}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <div class="fs-7 d-flex justify-content-between my-4">
                            <div class="">{{__('Transaction Reference')}}</div>
                            <div class="d-flex fw-bold">
                                {{substr($val?->ref_id, 0, 15)}}...
                                <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->ref_id}}" title="{{__('Copy')}}"></i>
                            </div>
                        </div>
                        <div class="separator separator-dashed"></div>
                        <div class="fs-7 d-flex justify-content-between my-4">
                            <div class="">{{__('Transaction Status')}}</div>
                            @include('partials.transactions.status', ['val' => $val])
                        </div>
                        <div class="separator separator-dashed"></div>
                        {!!trxDetails(__('Amount'), number_format($val->amount, 2).' '.$val->currency)!!}
                        {!!trxDetails(__('Charge'), number_format($val->charge, 2).' '.$val->currency)!!}
                        {!!trxDetails(__('Total'), number_format($val->amount + $val->charge, 2).' '.$val->currency)!!}

                        @if($val->type == 'agent_payment')
                        @php $agentTrx = $val->agentTransaction; @endphp
                        {!!trxDetails(__('Merchant Name'), $agentTrx->business->name)!!}
                        {!!trxDetails(__('Amount'), $agentTrx->amount.' '.$agentTrx->card_currency)!!}
                        @endif

                        @if($val->type == 'deposit')
                        {!!trxDetails(__('Payment Method'), $val->gateway->name)!!}
                        @endif

                        @if($val->type == 'payout')
                        {!!trxDetails(__('Payment Method'), $val->withdrawMethod->name)!!}
                        {!!trxDetails(__('Details'), $val->details)!!}
                        @endif

                        @if(in_array($val->type, ['crypto_payout', 'crypto_deposit']))
                        {!!trxDetails(__('Network Chain'), $val->cryptoBalance->network)!!}
                        @if($val->wallet_address)
                        {!!trxDetails(__('Wallet Address'), $val->wallet_address)!!}
                        @endif                   
                        @if($val->trx_hash)
                        {!!trxDetails(__('TX Hash'), $val->trx_hash)!!}
                        @endif
                        @endif

                        @if($val->type == 'bank_transfer')
                        {!!trxDetails(__('Bank Reference'), $val->bank_reference)!!}
                        @endif

                        @if($val->status == "declined")
                        {!!trxDetails(__('Decline Reason'), $val->decline_reason)!!}
                        @endif

                        {!!trxDetails(__('Date'), $val->created_at->setTimezone($user->user_timezone)->toDayDateTimeString())!!}

                        @if($val->type == 'giftcard_purchase')
                        <div class="mt-5">
                            @foreach($val->giftcardOrdersByExternalReference() as $data)
                            <div class="mb-5 p-5 bg-white rounded-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="symbol symbol-45px symbol-circle me-2">
                                        <div class="symbol-label fs-3 fw-bolder axora-dashboard-icon">
                                            <i class="bi bi-gift"></i>
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <p class="text-dark fw-bold fs-7 mb-0">
                                            {{__('Gift Card')}}: {{$data['card']['amount'].' '.$data['card']['currency']}} {{ucwords($data['card']['name'])}} (x{{$data['card']['quantity']}})
                                        </p>
                                        <p class="text-gray-600 fs-8 mb-0">
                                            {{__('External Reference')}}: {{$data['external_reference']}} 
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="symbol symbol-45px symbol-circle me-2">
                                        <div class="symbol-label fs-3 fw-bolder axora-dashboard-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <p class="text-dark fw-bold fs-7 mb-0">
                                            {{__('Recipient')}}: {{$data['customer']['name']}}
                                        </p>
                                        <p class="text-gray-600 fs-8 mb-0">
                                            {{__('Email')}}: {{$data['customer']['email']}} <span class="dot"></span> {{__('Phone')}}: {{$data['customer']['phone']}}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-0">
                                    <div class="symbol symbol-45px symbol-circle me-2">
                                        <div class="symbol-label fs-3 fw-bolder axora-dashboard-icon">
                                            <i class="bi bi-bank"></i>
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <p class="text-dark fw-bold fs-7 mb-0">
                                            {{__('Total')}}: {{$data['payment']['total'].' '.$data['payment']['currency']}} <span class="fs-8">(1 {{$data['card']['currency']}} = {{$data['payment']['rate'].' '.$data['payment']['currency']}})</span>
                                        </p>
                                        <p class="text-gray-600 fs-8 mb-0">
                                            {{__('Amount')}}: {{$data['payment']['amount'].' '.$data['payment']['currency']}} <span class="dot"></span> {{__('Fee')}}: {{$data['payment']['charge'].' '.$data['payment']['currency']}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        @if($val->type == 'airtime_purchase')
                        <div class="mt-5">
                            @foreach($val->airtimeOrdersByExternalReference() as $data)
                            <div class="mb-5 p-5 bg-white rounded-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="symbol symbol-45px symbol-circle me-2">
                                        <div class="symbol-label fs-3 fw-bolder axora-dashboard-icon">
                                            <i class="bi bi-gift"></i>
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <p class="text-dark fw-bold fs-7 mb-0">
                                            {{__('Operator')}}: {{ucwords($data['operator']['name'])}} - {{$data['operator']['amount'].' '.$data['operator']['currency']}}
                                        </p>
                                        <p class="text-gray-600 fs-8 mb-0">
                                            {{__('External Reference')}}: {{$data['external_reference']}} 
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="symbol symbol-45px symbol-circle me-2">
                                        <div class="symbol-label fs-3 fw-bolder axora-dashboard-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <p class="text-dark fw-bold fs-7 mb-0">
                                            {{__('Recipient')}}: {{$data['customer']['phone']}}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-0">
                                    <div class="symbol symbol-45px symbol-circle me-2">
                                        <div class="symbol-label fs-3 fw-bolder axora-dashboard-icon">
                                            <i class="bi bi-bank"></i>
                                        </div>
                                    </div>
                                    <div class="ps-2">
                                        <p class="text-dark fw-bold fs-7 mb-0">
                                            {{__('Total')}}: {{$data['payment']['total'].' '.$data['payment']['currency']}} <span class="fs-8">(1 {{$data['operator']['currency']}} = {{$data['payment']['rate'].' '.$data['payment']['currency']}})</span>
                                        </p>
                                        <p class="text-gray-600 fs-8 mb-0">
                                            {{__('Amount')}}: {{$data['payment']['amount'].' '.$data['payment']['currency']}} <span class="dot"></span> {{__('Fee')}}: {{$data['payment']['charge'].' '.$data['payment']['currency']}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>