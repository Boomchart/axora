@foreach($transactions as $k=>$val)
<tr class="cursor-pointer" id="kt_trx_{{$val->id}}_button">
    <td>
        <div class="symbol symbol-40px symbol-circle me-5">
            @include('partials.transactions.image')
        </div>
    </td>
    <td class="fw-bold">{{$currency->currency_symbol.currencyFormat(number_format($val->amount, 2)).' '.$currency->currency}}</td>
    <td>{{ucwords(str_replace('_', ' ', $val->type))}}</td>
    <td>
        @include('partials.transactions.status', ['val' => $val])
    </td>
    @if($all == 1)<td>{{$val->ref_id}}</td> @endif
    <td>{{$val->created_at->setTimezone($user->user_timezone)->toDayDateTimeString()}}</td>
</tr>
@include('partials.transactions.details', ['admincheck' => 0])
@endforeach