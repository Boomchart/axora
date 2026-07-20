<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post" wire:loading.class.delay="opacity-50" wire:target="approveKYC">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <div class="card h-100 rounded-5 bg-success text-white">
                        <div class="card-body p-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fs-2hx fw-bold text-white">{{number_format($client->userFunds(), 2).' '.$currency->currency}}</div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button id="kt_balance_button" class="btn btn-white me-3"><i class="bi bi-pen"></i> {{__('Edit Balance')}}</button>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div wire:ignore.self id="kt_balance" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_balance_button" data-kt-drawer-close="#kt_balance_close" data-kt-drawer-width="{'md': '500px'}">
                                    <div class="card w-100">
                                        <div class="card-header pe-5 border-0">
                                            <div class="card-title">
                                                <div class="d-flex justify-content-center flex-column mb-5">
                                                    <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Edit Balance')}}</div>
                                                </div>
                                            </div>
                                            <div class="card-toolbar">
                                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_balance_close">
                                                    <span class="svg-icon svg-icon-2">
                                                        <i class="bi bi-x-lg fs-2"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-wrap">
                                            <div class="btn-wrapper text-center mb-3">
                                                <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                                                    <div class="symbol-label fs-1 bg-whitelabel">
                                                        <i class="fat fa-university fa-2x text-dark"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pb-5 mt-10 position-relative zindex-1">
                                                <form class="form w-100 mb-10" wire:submit.prevent="editBalance" method="post">
                                                    <div class="fv-row mb-6">
                                                        <label class="form-label text-dark fs-7 fw-bold required">{{ __('Transaction Type') }}</label>
                                                        <select class="form-select form-select-solid" wire:model="trxtype" required>
                                                            <option value="credit">{{ __('Credit') }}</option>
                                                            <option value="debit">{{ __('Debit') }}</option>
                                                        </select>
                                                        @error('trxtype')
                                                        <span class="form-text text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="fv-row mb-6">
                                                        <label class="form-label text-dark fs-7 fw-bold required">{{ __('Amount') }}</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text border-0">{{$currency->currency_symbol}}</span>
                                                            <input class="form-control form-control-solid @error('amount') is-invalid @enderror" type="text" step="any" wire:model="amount" autocomplete="amount" id="payout-amount" required placeholder="0.00" />
                                                        </div>
                                                        @error('amount')
                                                        <span class="form-text text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="fv-row mb-6">
                                                        <label class="form-label fs-7 text-dark required">{{__('Admin Password')}}</label>
                                                        <input class="form-control form-control-solid" type="password" wire:model.defer="password" required placeholder="{{__('Password')}}" />
                                                        @error('password')
                                                        <span class="form-text text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="p-5 rounded-4 bg-secondary mt-5">
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-40px symbol-circle">
                                                                <span
                                                                    class="symbol-label fw-boldest bg-white text-dark"><i
                                                                        class="bi bi-wallet"></i></span>
                                                            </div>
                                                            <div class="ps-2">
                                                                <p class="fs-7 text-dark mb-0">
                                                                    {{ number_format($result, 2) }}
                                                                    {{ $currency->currency}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-10">
                                                        <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                                            <span wire:loading.remove wire:target="editBalance">{{__('Submit Request')}}</span>
                                                            <span wire:loading wire:target="editBalance">{{__('Processing Request...')}}</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Budget-->
                </div>
            </div>
            <div class="fs-5 mb-3 fw-bold">{{__('Crypto Balances')}}</div>
            <div class="row">
                @foreach($client->business->cryptoBalances as $balance)
                <div class="col-md-12 mb-5">
                    <div class="card rounded-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap flex-sm-nowrap mb-1">
                                <div class="symbol symbol-55px me-7 mb-4 symbol-circle">
                                    <span class="symbol-label" style="background-image:url({{getPublicImage($balance->getCurrency->image)}});"></span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                                        <div class="d-flex flex-column">
                                            <p class="text-dark fs-4 fw-bold me-3 mb-0">{{$balance->getCurrency->name}} ({{$balance->token}}) <span class="dot"></span> {{$balance->network}}</p>
                                            <p class="text-gray-800 fs-6 me-3 mb-3">{{$balance->amount}} {{$balance->token}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="separator"></div>
                            <livewire:admin.users.edit-balance :val=$balance :admin=$admin :wire:key="$balance->id"></livewire:admin.users.edit-balance>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>