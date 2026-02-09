<div>
    <div wire:ignore.self id="kt_trx_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_trx_{{$val->id}}_button" data-kt-drawer-close="#kt_trx_{{$val->id}}_close">
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
                    <p class="text-dark fs-1 fw-bold">{{$currency->currency_symbol.currencyFormat(number_format($val->amount, 2)).' '.$currency->currency}}</p>
                </div>
                <div class="d-flex flex-column">
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Reference')}}: {{$val->ref_id}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->ref_id}}" title="{{__('Copy')}}"></i></span>
                    </li>
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Charge')}}: {{$currency->currency_symbol.currencyFormat(number_format($val->charge, 2)).' '.$currency->currency}}</span>
                    </li>
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Date')}}: {{$val->created_at->setTimezone($admin->timezone)->toDayDateTimeString()}}</span>
                    </li>
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Type')}}: {{ucwords(str_replace('_', ' ', $val->type))}}</span>
                    </li>
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
                        <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Recipient')}}: {{$val?->beneficiary?->recipient?->name}}</span>
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
                            @if($val->status == 'success')
                            <span class="badge badge-pill badge-success badge-sm">{{__('Success')}}</span>
                            @elseif($val->status == 'pending')
                            <span class="badge badge-pill badge-warning badge-sm text-dark">{{__('Pending')}}</span>
                            @elseif($val->status == 'failed')
                            <span class="badge badge-pill badge-danger badge-sm">{{__('Failed')}}</span>
                            @elseif($val->status == 'cancelled')
                            <span class="badge badge-pill badge-danger badge-sm">{{__('Cancelled')}}</span>
                            @endif
                        </span>
                    </li>
                    @if($val->staff_id != null)
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Edited by')}}: {{$val?->staff?->first_name.' '.$val?->staff?->last_name}}</span>
                    </li>
                    <li class="d-flex align-items-center py-2">
                        <span class="bullet me-5 bg-success bullet-vertical"></span> <span>{{__('Date & Time')}}: {{$val->updated_at->setTimezone($admin->timezone)->toDayDateTimeString()}}</span>
                    </li>
                    @endif
                </div>
                @if($val->status == "pending")
                @if($val->type == 'payout')
                <button class="btn btn-success btn-block mt-5" wire:click="approve"><i class="bi bi-hand-thumbs-up"></i> {{__('Approve Payout')}}</button>
                <button class="btn btn-secondary btn-block mt-5" id="kt_decline_{{$val->id}}_button"><i class="fal fa-ban"></i> {{__('Decline Payout')}}</button>
                @elseif($val->type == 'deposit' || $val->type == 'bank_transfer')
                <button class="btn btn-success btn-block mt-5" wire:click="approve"><i class="bi bi-hand-thumbs-up"></i> {{__('Approve Deposit')}}</button>
                <button class="btn btn-secondary btn-block mt-5" id="kt_decline_{{$val->id}}_button"><i class="fal fa-ban"></i> {{__('Decline Deposit')}}</button>
                @endif
                @endif
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_decline_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_decline_{{$val->id}}_button" data-kt-drawer-close="#kt_decline_{{$val->id}}_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Transaction')}}</div>
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
                            <i class="fal fa-ban fa-2x"></i>
                        </div>
                    </div>
                    <p class="text-dark fs-7 fw-bold">{{__('Decline Transaction')}}</p>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="decline">
                        <div class="fv-row mb-6">
                            <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="reason" required placeholder="{{__('Give a reason for payout decline')}}"></textarea>
                            @error('reason')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" wire:click="decline" class="btn btn-lg btn-success btn-block fw-bolder me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="decline">{{__('Decline Transaction')}}</span>
                                <span wire:loading wire:target="decline">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>