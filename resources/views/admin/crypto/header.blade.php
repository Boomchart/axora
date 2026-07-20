<div class="card mb-9 rounded-5">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap mb-1">
            <div class="symbol symbol-55px me-7 mb-4 symbol-circle">
                <span class="symbol-label" style="background-image:url({{getPublicImage($currency->image)}});"></span>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div class="d-flex flex-column">
                        <p class="text-dark fs-4 fw-bold me-3 mb-0">{{$currency->name}} ({{$currency->token}}) <span class="dot"></span> {{$currency->network}}</p>
                        <p class="text-gray-800 fs-6 me-3 mb-3">{{$currency->balance_amount}} {{$currency->token}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <div class="d-flex overflow-auto">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-8 flex-wrap h-50px">
                <li class="nav-item">
                    <a class="nav-link text-active-success text-dark me-6 @if($type == 'settings') active @endif" href="{{route('crypto.edit', ['currency' => $currency->id, 'type' => 'settings'])}}">{{__('Settings')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-success text-dark me-6 @if($type == 'balances') active @endif" href="{{route('crypto.edit', ['currency' => $currency->id, 'type' => 'balances'])}}">{{__('Account Balances')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-success text-dark me-6 @if($type == 'transactions') active @endif" href="{{route('crypto.edit', ['currency' => $currency->id, 'type' => 'transactions'])}}">{{__('Transactions')}}</a>
                </li>
            </ul>
        </div>
    </div>
</div>