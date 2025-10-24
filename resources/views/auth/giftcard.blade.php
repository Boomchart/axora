@extends('auth.menu')

@section('content')
<div class="col-md-6">
    <div class="pt-10">
        <div class="p-10 p-lg-15 mx-auto">
            <div class="text-center">
                <div class="symbol symbol-100px symbol-circle me-5">
                    <div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$card->rate->rateCountry->buyGiftcard->logo}})"></div>
                </div>
            </div>
            @if($card->mode == 'test')
            <div class="text-center">
                <span class="badge badge-danger mt-5">{{__('Test generated cards, can\'t be used in a real transaction')}}</span>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-10">

    <div class="card mb-10">
        <div class="card-body m-5">
            <div class="text-center">
                <img class="mb-6" src="{{url('/').'/storage/app/'.$card->rate->rateCountry->buyGiftcard->image}}" alt="{{$set->site_name}}" loading="lazy" style="height:auto; max-width:30% !important;">
                <p class="fw-bold fs-6 mb-0">{{$card->rate->rateCountry->country->currency_symbol.currencyFormat(number_format($card->rate->amount, 2))}}</p>
                <p class="fw-bold fs-3 mb-5">{{$card->rate->rateCountry->buyGiftcard->title}}</p>
                <div class="row mb-6 align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input value="{{$card->code}}" autocomplete="off" readonly class="form-control form-control-solid form-control-lg fw-bold fs-2">
                            <span class="input-group-text border-0">
                                <i class="bi bi-clipboard-check text-dark castro-copy fw-bold fs-2" data-clipboard-text="{{$card->code}}" title="{{__('Copy')}}"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="bg-secondary">
            <p class="text-dark fs-5 fw-bold">{{__('Redemption Instructions')}}</p>
            <p class="text-dark fs-7 mb-10 preserveLines">{{$card?->rate?->rateCountry?->buyGiftcard?->redemption_instructions}}</p>

            <p class="text-dark fs-5 fw-bold">{{__('Description')}}</p>
            <p class="text-dark fs-7 mb-10 preserveLines">{{$card?->rate?->rateCountry?->buyGiftcard?->description}}</p>

            <p class="text-dark fs-5 fw-bold">{{__('Terms & Conditions')}}</p>
            <p class="text-dark fs-7 mb-5 preserveLines">{{$card?->rate?->rateCountry?->buyGiftcard?->terms}}</p>
        </div>
    </div>
    <div class="text-center mb-10">
        <a href="{{route('home')}}" target="_blank">{{__('Powered by')}} {{$set->site_name}}</a>
    </div>

</div>
@stop