@extends('user.menu')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-4">{{__('Purchase Giftcard')}}</h1>
            <ul class="breadcrumb fw-dase fs-7 my-1 mb-6">
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('user.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}} </a>
                </li>
                <li class="breadcrumb-item text-dark">{{__('Giftcard')}}</li>
            </ul>
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('user.giftcard.buy', ['type' => 'all'])==url()->current()) active @endif" id="tabs-icons-text-3-tab" href="{{route('user.giftcard.buy', ['type' => 'all'])}}" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">{{__('All')}}</a>
                </li>
                @foreach(getCardCategory() as $card)
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('user.giftcard.buy', ['type' => $card->id])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('user.giftcard.buy', ['type' => $card->id])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{$card->name}}</a>
                </li>
                @endforeach

            </ul>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            @foreach(getCardCategory() as $circle)
            @if(route('user.giftcard.buy', ['type' => $circle->id])==url()->current())
            @livewire('user.giftcard.buy', ['type' => $circle->id, 'user' => $user, 'settings' => $set])
            @endif
            @endforeach
            
            @if(route('user.giftcard.buy', ['type' => 'all'])==url()->current())
            @livewire('user.giftcard.buy', ['type' => 'all', 'user' => $user, 'settings' => $set])
            @endif
        </div>
    </div>
</div>
@stop