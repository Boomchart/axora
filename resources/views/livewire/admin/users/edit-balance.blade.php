<div>
    <form class="form w-100" wire:submit.prevent="update">
        <p class="fs-7 fw-bold mt-5">{{ __('Vendor Deposit Fee') }}</p>
        <div class="mb-6">
            <div class="row mb-6">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="number" step="any" wire:model.debounce.1000ms="crypto_wallet_pc" placeholder="{{__('Percent charge')}}" autocomplete="off" class="form-control form-control-solid">
                        <span class="input-group-text border-0">%</span>
                    </div>
                    @error('crypto_wallet_pc')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="number" step="any" wire:model.debounce.1000ms="crypto_wallet_fc" placeholder="{{__('Fiat charge')}}" autocomplete="off" class="form-control form-control-solid">
                        <span class="input-group-text border-0">{{$val->token}}</span>
                    </div>
                    @error('crypto_wallet_fc')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="p-5 border rounded-4 mb-10">
            <p class="fs-9 fw-bold mb-5 text-uppercase text-gray-700">{{__('Rev Share')}}</p>
            @foreach($crypto_wallet_agents as $index => $item)
            <div class="row align-items-center">
                <div class="col-6">
                    <p class="fs-7 fw-bold">{{__('Agent')}} {{$loop->iteration}}</p>
                </div>
                <div class="col-6 text-end">
                    <a class="text-danger mb-0 cursor-pointer" wire:click.prevent="removeCryptoWalletAgent({{ $index }})"><i class="bi bi-trash text-danger"></i> <u>{{__('Remove')}}</u></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7 fw-bold">{{__('Account ID')}}</label>
                        <input type="text" class="form-control form-control-solid" autocomplete="off" placeholder="{{__('Enter Agent Account Id')}}" wire:model.debounce.1000ms="crypto_wallet_agents.{{$index}}.account_id">
                        @error('crypto_wallet_agents.'.$index.'.account_id')<p class="form-text text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7 fw-bold">{{__('Rev Fc')}} ({{$val->token}})</label>
                        <input type="text" steps="any" class="form-control form-control-solid" min="0" autocomplete="off" required wire:model.debounce.1000ms="crypto_wallet_agents.{{$index}}.rev_fc">
                        @error('crypto_wallet_agents.'.$index.'.rev_fc')<p class="form-text text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7 fw-bold">{{__('Rev Pc')}} (%)</label>
                        <input type="text" steps="any" class="form-control form-control-solid" autocomplete="off" required wire:model.debounce.1000ms="crypto_wallet_agents.{{$index}}.rev_pc">
                        @error('crypto_wallet_agents.'.$index.'.rev_pc')<p class="form-text text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
            </div>
            @endforeach
            <div class="text-center">
                <a class="text-primary fw-bold cursor-pointer" wire:click.prevent="addCryptoWalletAgent"><i class="bi bi-plus-lg"></i> <u>{{__('Add Rev Share')}}</u></a>
            </div>
        </div>

        <hr class="bg-light-border my-4">
        <p class="fs-7 fw-bold">{{ __('Vendor Payout Fee') }}</p>
        <div class="mb-6">
            <div class="row mb-6">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="number" step="any" wire:model.debounce.1000ms="crypto_wallet_payout_pc" placeholder="{{__('Percent charge')}}" autocomplete="off" class="form-control form-control-solid">
                        <span class="input-group-text border-0">%</span>
                    </div>
                    @error('crypto_wallet_payout_pc')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="number" step="any" wire:model.debounce.1000ms="crypto_wallet_payout_fc" placeholder="{{__('Fiat charge')}}" autocomplete="off" class="form-control form-control-solid">
                        <span class="input-group-text border-0">{{$val->token}}</span>
                    </div>
                    @error('crypto_wallet_payout_fc')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="p-5 border rounded-4 mb-10">
            <p class="fs-9 fw-bold mb-5 text-uppercase text-gray-700">{{__('Rev Share')}}</p>
            @foreach($crypto_wallet_payout_agents as $index => $item)
            <div class="row align-items-center">
                <div class="col-6">
                    <p class="fs-7 fw-bold">{{__('Agent')}} {{$loop->iteration}}</p>
                </div>
                <div class="col-6 text-end">
                    @if($index > 0)
                    <a class="text-danger mb-0 cursor-pointer" wire:click.prevent="removeCryptoWalletPayoutAgent({{ $index }})"><i class="bi bi-trash text-danger"></i> <u>{{__('Remove')}}</u></a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7 fw-bold">{{__('Account ID')}}</label>
                        <input type="text" class="form-control form-control-solid" autocomplete="off" placeholder="{{__('Enter Agent Account Id')}}" wire:model.debounce.1000ms="crypto_wallet_payout_agents.{{$index}}.account_id">
                        @error('crypto_wallet_payout_agents.'.$index.'.account_id')<p class="form-text text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7 fw-bold">{{__('Rev Fc')}} ({{$val->token}})</label>
                        <input type="text" steps="any" class="form-control form-control-solid" min="0" autocomplete="off" required wire:model.debounce.1000ms="crypto_wallet_payout_agents.{{$index}}.rev_fc">
                        @error('crypto_wallet_payout_agents.'.$index.'.rev_fc')<p class="form-text text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7 fw-bold">{{__('Rev Pc')}} (%)</label>
                        <input type="text" steps="any" class="form-control form-control-solid" autocomplete="off" required wire:model.debounce.1000ms="crypto_wallet_payout_agents.{{$index}}.rev_pc">
                        @error('crypto_wallet_payout_agents.'.$index.'.rev_pc')<p class="form-text text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
            </div>
            @endforeach
            <div class="text-center">
                <a class="text-primary fw-bold cursor-pointer" wire:click.prevent="addCryptoWalletPayoutAgent"><i class="bi bi-plus-lg"></i> <u>{{__('Add Rev Share')}}</u></a>
            </div>
        </div>
        <div class="text-center mt-10">
            <button type="submit" class="btn btn-primary btn-block my-2" wire:loading.attr="disabled"
                wire:loading.class="opacity-50">
                <span wire:loading.remove wire:target="update">{{ __('Save Settings') }}</span>
                <span wire:loading wire:target="update">{{ __('Processing Request...') }}</span>
            </button>
        </div>
    </form>
</div>