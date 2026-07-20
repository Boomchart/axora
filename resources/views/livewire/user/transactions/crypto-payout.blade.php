<div>

    @if($sent == 'pending')
    <form class="form w-100" wire:submit.prevent="transfer">
        <div style="margin-bottom: 1.5rem !important">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold text-dark fs-7 required">{{__('You are sending')}}</span>
                <a wire:click="max" class="cursor-pointer badge badge-light-primary fw-bold fs-9 px-3 py-2">{{__('Max')}}</a>
            </div>

            <div class="card rounded-4 bg-light p-4 mb-2 border border-primary border-opacity-10 shadow-none">
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-white shadow-sm rounded-pill btn-sm d-flex align-items-center px-3 py-2" type="button" data-bs-toggle="dropdown">
                            <span class="fi fis rounded-circle me-2 fs-3" style="background-image:url({{getPublicImage($balance->getCurrency->image)}});"></span>
                            <span class="fs-5 fw-bolder text-dark me-2">{{$balance->token}}</span>
                            <i class="bi bi-chevron-down text-muted fs-9"></i>
                        </button>
                        <ul class="dropdown-menu shadow-sm rounded-4 py-2">
                            @foreach($user->business->cryptobalances()->orderBy('amount', 'desc')->orderBy('token', 'asc')->get() as $check)
                            <li>
                                <a class="text-decoration-none dropdown-item fs-7 cursor-pointer d-flex align-items-center py-2" wire:click="changeDefaultWallet('{{$check->id}}')">
                                    <span class="fi fis rounded-circle me-3 fs-4" style="background-image:url({{getPublicImage($check->getCurrency->image)}});"></span>
                                    <span class="fw-semibold text-dark">{{ $check->token}}</span>
                                    <span class="ms-auto text-muted fs-8">{{ $check->amount }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="flex-grow-1 text-end">
                        <input type="text" step="any" wire:model.debounce.2000ms="amount" autocomplete="one-time-code" required placeholder="0.00" class="form-control bg-transparent text-end border-0 p-0 fs-1 fw-bolder">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center text-muted fs-8 px-1">
                <span>{{__('Balance after')}}</span>
                <span class="fw-semibold text-dark">
                    {{$balanceAfter}}
                    <span wire:loading wire:target="amount"><span class="spinner-border spinner-border-sm text-primary"></span></span>
                </span>
            </div>
            @error('validationAmount')
            <p class="form-text text-danger mt-2 mb-0">{{$message}}</p>
            @enderror
        </div>

        <div class="fv-row mb-6">
            <label class="form-label text-dark fs-7 fw-bold required">{{__('Wallet Address')}} <span wire:loading wire:target="wallet_address"><span class="spinner-border spinner-border-sm text-primary"></span></span></label>
            <input wire:model.debounce.1000ms="wallet_address" type="text" class="form-control form-control-solid ps-12" placeholder="{{__('Enter wallet address')}}" required>
            @error('wallet_address')
            <span class="form-text text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="fv-row mb-6">
            <label class="form-label text-dark fs-7 fw-bold required">{{__('Authenticator Code')}}</label>
            <input class="form-control form-control-solid ps-12" wire:model="fa_code" type="tel" minlength="4" maxlength="6" pattern="[0-9]+" autocomplete="one-time-code" required placeholder="XXXXXX" autofocus />
            @error('fa_code')
            <span class="form-text text-danger">{{ $message}}</span>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-between bg-light-warning px-5 py-4 mb-8 rounded-4">
            <span class="d-flex align-items-center text-dark fs-7 fw-semibold"><i class="bi bi-fuel-pump me-2 text-warning"></i>{{__('Network Fee')}}</span>
            <span class="fw-bolder text-dark fs-7">{{$feeBen}} {{$balance->token}}</span>
        </div>

        <div class="d-grid gap-2">
            <a class="btn btn-primary" wire:click="next" wire:loading.remove wire:target="next">
                <span wire:loading.remove wire:target="next">{{__('Continue')}}</span>
                <span wire:loading wire:target="next">{{__('Processing Request...')}}</span>
            </a>
            <a href="{{route('user.dashboard')}}" wire:ignore class="btn btn-light-primary"><i class="bi bi-chevron-left"></i> {{__('Back to dashboard')}}</a>
        </div>
    </form>
    @else
    <div class="text-center py-4">
        <div class="symbol symbol-90px symbol-circle mb-6">
            <div class="symbol-label bg-light-success">
                <i class="bi bi-check2-circle text-success" style="font-size:54px;"></i>
            </div>
        </div>
        <h2 class="text-dark fw-bolder fs-3 mb-1">{{__('Transfer Processing')}}</h2>
        <p class="text-muted fs-7 mb-6">{{__('We are reviewing your request')}}</p>

        <div class="bg-light p-5 rounded-4 mb-6 text-start">
            {!!trxDetails(__('Reference'), substr($debit_trx->ref_id, 0, 10).'...')!!}
            {!!trxDetails(__('Amount'), number_format($debit_trx->amount, 2).' '.$debit_trx->currency)!!}
            {!!trxDetails(__('Wallet Address'), substr($debit_trx->wallet_address, 0, 10).'...')!!}
        </div>

        <div class="d-grid gap-2">
            <a class="btn btn-primary" wire:click="newTrx">{{__('New Transaction')}}</a>
            <a href="{{route('user.dashboard')}}" wire:ignore class="btn btn-light-primary"><i class="bi bi-chevron-left"></i> {{__('Back to dashboard')}}</a>
        </div>
    </div>
    @endif

    <div wire:loading wire:target="next">
        <div class="loading-overlay">
            <div class="loading-content">
                <div class="loading-spinner"></div>
                <span class="text-white">{{__('Processing')}}...</span>
            </div>
        </div>
    </div>
</div>