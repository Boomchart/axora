@if($val->rfi_count > 0 && $val->status != 'declined')
<span class="badge badge-pill badge-danger badge-sm">{{ucwords($val->status).' - '.__('Action Required')}}</span>
@else
@if($val->status == 'success')
<span class="badge badge-pill badge-success badge-sm">{{__('Success')}}</span>
@elseif($val->status == 'pending')
<span class="badge badge-pill badge-warning badge-sm text-dark">{{__('Pending')}}</span>
@elseif($val->status == 'failed')
<span class="badge badge-pill badge-danger badge-sm">{{__('Failed')}}</span>
@elseif($val->status == 'cancelled')
<span class="badge badge-pill badge-danger badge-sm">{{__('Cancelled')}}</span>
@elseif($val->status == 'declined')
<span class="badge badge-pill badge-danger badge-sm">{{__('Declined')}}</span>
@endif
@endif