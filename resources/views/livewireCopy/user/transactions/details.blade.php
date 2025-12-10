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
                    <div class="symbol-label fs-3 fw-bolder bg-dark text-white">
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

                        @if($val->type == 'giftcard_purchase')
                        {!!trxDetails(__('Gift Card Name'), ucwords($val->card_name).' - '.$val->card_country)!!}
                        {!!trxDetails(__('Gift Card Quantity'), $val->quantity)!!}
                        {!!trxDetails(__('Gift Card Amount'), $val->card_amount.' '.$val->card_currency)!!}
                        {!!trxDetails(__('Customer Name'), $val->name)!!}
                        {!!trxDetails(__('Customer Email'), $val->email)!!}
                        {!!trxDetails(__('Customer Phone'), \Propaganistas\LaravelPhone\PhoneNumber::make($val->phone, strtoupper($val->phone_code)))!!}
                        {!!trxDetails(__('Exchange Rate'), $val->rate.' '.$val->currency)!!}
                        @endif

                        @if($val->type == 'agent_payment')
                        @php $agentTrx = $val->agentTransaction; @endphp
                        {!!trxDetails(__('Merchant Name'), $agentTrx->business->name)!!}
                        {!!trxDetails(__('Gift Card Name'), ucwords($agentTrx->card_name).' - '.$agentTrx->card_country)!!}
                        {!!trxDetails(__('Gift Card Amount'), $agentTrx->card_amount.' '.$agentTrx->card_currency)!!}
                        @endif

                        @if($val->type == 'deposit')
                        {!!trxDetails(__('Payment Method'), $val->gateway->name)!!}
                        @endif

                        @if($val->type == 'payout')
                        {!!trxDetails(__('Payment Method'), $val->withdrawMethod->name)!!}
                        {!!trxDetails(__('Details'), $val->details)!!}
                        @endif

                        @if($val->type == 'bank_transfer')
                        {!!trxDetails(__('Bank Reference'), $val->bank_reference)!!}
                        @endif

                        @if($val->status == "declined")
                        {!!trxDetails(__('Decline Reason'), $val->decline_reason)!!}
                        @endif

                        {!!trxDetails(__('Date'), $val->created_at->setTimezone($user->user_timezone)->toDayDateTimeString())!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>