<div wire:ignore.self id="kt_trx_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_trx_{{$val->id}}_button" data-kt-drawer-close="#kt_trx_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
    <div class="card w-100">
        <div class="card-header pe-5 border-0">
            <div class="card-title">
                <div class="d-flex justify-content-center flex-column me-3">
                    <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Transaction Details')}}</div>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_trx_{{$val->id}}_close">
                    <span class="svg-icon svg-icon-2">
                        <i class="bi bi-x-lg fs-2"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body text-wrap">
            <div class="btn-wrapper text-center mb-3">
                <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                    @include('partials.transactions.image')
                </div>
                <p class="text-dark fs-1 fw-bold">{{($val->trx_type == 'debit') ? '-' : '+'}} {{$currency->currency_symbol.currencyFormat(number_format($val->amount, 2)).' '.$currency->currency}}</p>
            </div>
            @if($val->type == 'giftcard_purchase')
            @if($val->status == 'success')
            <p>{{__('Your Gift Card Details')}}</p>
            <div class="bg-secondary px-6 py-5 mb-10 rounded">
                <div class="row">
                    <div class="col-md-12">
                        <p class="fw-bold fs-7 mb-0">{{__('See instruction')}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{route('giftcard.pin', ['card' => $val?->cardCode?->id])}}" title="{{__('Copy')}}"></i></p>
                        <p class="fs-7">{{route('giftcard.pin', ['card' => $val?->cardCode?->id])}} </p>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @if($val->type == 'giftcard_sale')
            @if($val->receipt != null)
            <div class="card bg-secondary mb-6">
                <a href="{{url('/').'/storage/app/'.$val?->receipt}}" target="_blank">
                    <div class="d-flex align-items-center p-3">
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                                <i class="bi bi-receipt text-dark"></i>
                            </div>
                        </div>
                        <div class="ps-1">
                            <p class="fs-7 text-dark fw-bold mb-0">{{__('View Receipt')}}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @if($val->image != null)
            <div class="card bg-secondary mb-6">
                <a href="{{url('/').'/storage/app/'.$val?->image}}" target="_blank">
                    <div class="d-flex align-items-center p-3">
                        <div class="symbol symbol-40px me-4">
                            <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                                <i class="bi bi-image text-dark"></i>
                            </div>
                        </div>
                        <div class="ps-1">
                            <p class="fs-7 text-dark fw-bold mb-0">{{__('View Card')}}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @endif
            <div class="d-flex flex-column">
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Reference')}}: {{$val->ref_id}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->ref_id}}" title="{{__('Copy')}}"></i></span>
                </li>
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Charge')}}: {{$currency->currency_symbol.currencyFormat(number_format($val->charge, 2)).' '.$currency->currency}}</span>
                </li>
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Date')}}: {{$val->created_at->setTimezone($user->user_timezone)->toDayDateTimeString()}}</span>
                </li>
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Type')}}: {{ucwords(str_replace('_', ' ', $val->type))}}</span>
                </li>
                @if($val->coupon_id != null)
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Promo Code')}}: {{$val?->couponCode?->coupon_code}} - {{$val->discount}}% {{__('discount')}}</span>
                </li>
                @endif
                @if($val->type == 'deposit')
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Method')}}: {{$val?->gateway?->name}}</span>
                </li>
                @elseif($val->type == 'bank_transfer')
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Transfer Reference')}}: {{$val->transfer_reference}}</span>
                </li>
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Bank Reference')}}: {{$val->bank_reference}}</span>
                </li>
                @elseif($val->type == 'giftcard_purchase' || $val->type == 'revenue_share')
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Gift Card')}}: {{$val?->buyCardRate?->rateCountry?->buyGiftcard?->title.' '.$val?->buyCardRate?->rateCountry?->country?->currency_symbol.currencyFormat(number_format($val->buyCardRate?->amount, 2))}}</span>
                </li>
                @elseif($val->type == 'giftcard_sale')
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Gift Card')}}: {{$val?->sellCategory?->name}}</span>
                </li>
                @if($val->code != null)
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Code')}}: {{$val->code}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->code}}" title="{{__('Copy')}}"></i></span>
                </li>
                @endif
                @elseif($val->type == 'payout')
                @if($val->acct_id != null)
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Bank')}}: {{$val?->acct?->bank?->title}}</span>
                </li>
                @if($val->acct->acct_no != null)
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Account Number')}}: {{$val->acct->acct_no}}</span>
                </li>
                @endif
                @if($val->acct->iban != null)
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('IBAN')}}: {{$val->acct->iban}}</span>
                </li>
                @endif
                @if($val->acct->bic != null)
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('BIC')}}: {{$val->acct->bic}}</span>
                </li>
                @endif
                @if($val->acct->sort_code != null)
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Sort Code')}}: {{$val->acct->sort_code}}</span>
                </li>
                @endif
                @if($val->acct->routing_no != null)
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Routing No')}}: {{$val->acct->routing_no}}</span>
                </li>
                @endif
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Account Name')}}: {{$val?->acct?->acct_name}}</span>
                </li>
                @else
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Payout Method')}}: {{$val?->withdrawMethod?->name}}</span>
                </li>
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Details')}}: {{$val->details}}</span>
                </li>
                @endif
                @elseif($val->type == 'debit_transfer')
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Recipient')}}: {{$val?->beneficiary?->recipient?->business?->name}}</span>
                </li>
                @elseif($val->type == 'credit_transfer')
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Sender')}}: {{$val?->sender?->business?->name}}</span>
                </li>
                @endif
                @if($val->status == "declined")
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Decline Reason')}}: {{$val->decline_reason}}</span>
                </li>
                @endif
                <li class="d-flex align-items-center py-2">
                    <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Status')}}:
                        @include('partials.transactions.status', ['val' => $val])
                    </span>
                </li>
                @if($val->rfi_count > 0)
                <livewire:user.rfi.index :val=$val :user=$user :settings=$set :wire:key="$val->id"></livewire:user.rfi.index>
                @endif
            </div>
        </div>
    </div>
</div>