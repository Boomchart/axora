@if($val->type == 'giftcard_purchase' || $val->type == 'revenue_share')
<div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val?->buyCardRate?->rateCountry?->buyGiftcard?->logo}})"></div>

@elseif($val->type == 'giftcard_sale')
<div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val?->sellCategory?->sellGiftcard?->image}})"></div>

@elseif($val->type == 'payout')
@if($val->acct_id != null)
<div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val?->acct?->bank?->image}})"></div>
@else
<div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val?->withdrawMethod?->image}})"></div>
@endif

@elseif($val->type == 'deposit')
<div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val?->gateway?->image}})"></div>

@elseif($val->type == 'bank_transfer')
<div class="symbol-label fs-3 fw-bolder bg-warning">
    <i class="fal fa-bank"></i>
</div>

@elseif($val->type == 'debit_transfer')
@if($val?->beneficiary?->recipient?->avatar == null)
<span class="symbol-label bg-warning text-dark fw-boldest">{{substr(ucwords($val?->beneficiary?->recipient?->name), 0, 1)}}</span>
@else
<div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val?->beneficiary?->recipient?->avatar}})"></div>
@endif

@elseif($val->type == 'credit_transfer')
@if($val?->sender?->business?->avatar == null)
<span class="symbol-label bg-warning text-dark fw-boldest">{{substr(ucwords($val?->sender?->business?->name), 0, 1)}}</span>
@else
<div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val?->sender?->business?->avatar}})"></div>
@endif

@elseif($val->type == 'referral')
@if($val?->referral?->avatar == null)
<span class="symbol-label bg-warning text-dark fw-boldest">{{substr(ucwords($val?->referral?->business?->name), 0, 1)}}</span>
@else
<div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val?->referral?->avatar}})"></div>
@endif

@else
<div class="symbol-label fs-3 fw-bolder bg-warning">
    @if($val->trx_type == 'debit')
    <i class="bi bi-dash-lg"></i>
    @else
    <i class="bi bi-plus-lg"></i>
    @endif
</div>
@endif