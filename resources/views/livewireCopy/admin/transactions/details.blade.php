<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">
                    {{__('Transaction Details')}}
                </h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-info">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.transactions')}}" class="text-muted text-hover-info">{{__('Transactions')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Transaction Details')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="d-flex align-items-center mb-5 p-3 bg-white rounded-4">
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
            @if($val->business->watchlist == 1)
            <div class="card bg-danger mb-5">
                <div class="d-flex align-items-center p-3">
                    <div class="symbol symbol-45px me-4">
                        <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                            <i class="bi bi-bell-slash-fill text-dark"></i>
                        </div>
                    </div>
                    <div class="ps-1">
                        <p class="fs-7 text-white fw-bold mb-0">{{$val->business->name}} {{__('is on watchlist')}}</p>
                    </div>
                </div>
            </div>
            @endif
            @if($val->image != null)
            <div class="card bg-secondary mb-5">
                <a href="{{getPublicImage($val?->image)}}" target="_blank">
                    <div class="d-flex align-items-center p-3">
                        <div class="symbol symbol-45px me-4">
                            <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                                <i class="bi bi-receipt text-dark"></i>
                            </div>
                        </div>
                        <div class="ps-1">
                            <p class="fs-7 text-dark fw-bold mb-0">{{__('View receipt')}}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
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

                        @if($val->staff_id)
                        {!!trxDetails(__('Edited by'), $val->staff->first_name.' '.$val->staff->last_name)!!}
                        @endif

                        {!!trxDetails(__('Date'), $val->created_at->setTimezone($admin->timezone)->toDayDateTimeString())!!}

                        <a href="{{route('user.manage', ['client' => $val->user_id, 'type' => 'details'])}}" class="btn btn-whitelabel btn-block mt-5" target="_blank">{{__('Manage Account')}}</a>

                        @if($val->type == 'deposit')
                        <div>
                            @if($val->status == "pending")
                            <button class="btn btn-success btn-block mt-5" wire:click="approveDeposit"><i class="bi bi-check2-circle"></i>
                                <span wire:loading.remove wire:target="approveDeposit">{{__('Approve Deposit')}}</span>
                                <span wire:loading wire:target="approveDeposit">{{__('Processing Request...')}}</span>
                            </button>
                            <button class="btn btn-secondary btn-block mt-5" id="kt_decline_{{$val->id}}_button"><i class="bi bi-ban"></i> {{__('Decline Deposit')}}</button>
                            @endif
                            <div wire:ignore.self id="kt_decline_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_decline_{{$val->id}}_button" data-kt-drawer-close="#kt_decline_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
                                <div class="card w-100">
                                    <div class="card-header pe-5 border-0">
                                        <div class="card-title">
                                            <div class="d-flex justify-content-center flex-column me-3">
                                                <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Deposit')}}</div>
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_decline_close">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="bi bi-x-lg fs-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-wrap">
                                        <div class="btn-wrapper text-center mb-3">
                                            <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                                                <div class="symbol-label fs-1 text-dark">
                                                    <i class="bi bi-ban fa-2x"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark fs-7 fw-bold">{{__('Decline Deposit Request')}}</p>
                                        </div>
                                        <div class="pb-5 mt-10 position-relative zindex-1">
                                            <form class="form w-100 mb-10" wire:submit.prevent="declineDeposit">
                                                <div class="fv-row mb-6">
                                                    <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="reason" required placeholder="{{__('Give a reason for Deposit decline')}}"></textarea>
                                                    @error('reason')
                                                    <span class="form-text">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="text-center mt-10">
                                                    <button type="submit" class="btn btn-danger btn-block my-2" wire:loading.attr="disabled" wire:click.prevent="declineDeposit">
                                                        <span wire:loading.remove wire:target="declineDeposit">{{__('Decline Transaction')}}</span>
                                                        <span wire:loading wire:target="declineDeposit">{{__('Processing Request...')}}</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($val->type == 'payout')
                        <div>
                            @if($val->status == "pending")
                            <button class="btn btn-success btn-block mt-5" wire:click="approvePayout"><i class="bi bi-check2-circle"></i>
                                <span wire:loading.remove wire:target="approvePayout">{{__('Approve Payout')}}</span>
                                <span wire:loading wire:target="approvePayout">{{__('Processing Request...')}}</span>
                            </button>
                            <button class="btn btn-secondary btn-block mt-5" id="kt_decline_{{$val->id}}_button"><i class="bi bi-ban"></i> {{__('Decline Payout')}}</button>
                            @endif
                            <div wire:ignore.self id="kt_decline_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_decline_{{$val->id}}_button" data-kt-drawer-close="#kt_decline_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
                                <div class="card w-100">
                                    <div class="card-header pe-5 border-0">
                                        <div class="card-title">
                                            <div class="d-flex justify-content-center flex-column me-3">
                                                <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Payout')}}</div>
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_decline_close">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="bi bi-x-lg fs-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-wrap">
                                        <div class="btn-wrapper text-center mb-3">
                                            <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                                                <div class="symbol-label fs-1 text-dark">
                                                    <i class="bi bi-ban fa-2x"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark fs-7 fw-bold">{{__('Decline Payout Request')}}</p>
                                        </div>
                                        <div class="pb-5 mt-10 position-relative zindex-1">
                                            <form class="form w-100 mb-10" wire:submit.prevent="declinePayout">
                                                <div class="fv-row mb-6">
                                                    <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="reason" required placeholder="{{__('Give a reason for Payout decline')}}"></textarea>
                                                    @error('reason')
                                                    <span class="form-text">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="text-center mt-10">
                                                    <button type="submit" class="btn btn-danger btn-block my-2" wire:loading.attr="disabled" wire:click.prevent="declinePayout">
                                                        <span wire:loading.remove wire:target="declinePayout">{{__('Decline Transaction')}}</span>
                                                        <span wire:loading wire:target="declinePayout">{{__('Processing Request...')}}</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>