<div>
    <div wire:ignore.self class="modal fade" id="gateway_deposit{{$gateway->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{$gateway->name}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <form wire:submit.prevent="gateway">
                    <div class="modal-body">
                        <div class="fv-row mb-6">
                            <label class="form-label fs-7 text-dark">{{__('Amount')}} ({{$currency->currency}})</label>
                            <input class="form-control form-control-solid" type="text" step="any" wire:model.debounce.500ms="amount" autocomplete="transaction-amount" id="amount" min="1" required placeholder="{{__('0.00')}}" autofocus />
                            @error('amount')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @if($gateway->type==1)
                        @if($gateway->val1)
                        <div class="fv-row mb-6">
                            <label class="form-label fs-7 text-dark">{{$gateway->val1}}</label>
                            <input class="form-control form-control-solid  @error('details') is-invalid @enderror" type="text" wire:model.defer="details" required id="details" />
                            @error('details')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="fv-row mb-6">
                            <label class="form-label fs-7 text-dark">{{__('Receipt')}}</label>
                            <input class="form-control form-control-solid" type="file" wire:model="image" required />
                            @error('image')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <div wire:loading wire:target="image">{{__('Uploading')}}...</div>
                        </div>
                        @if($gateway->instructions || $gateway->crypto=1)

                        <div class="bg-light-warning p-5 mb-7 rounded-4 text-wrap" wire:ignore style="overflow-wrap: break-word;">
                            @if($gateway->crypto)
                            <p class="fw-bold fs-7 mb-0">{{__('Wallet address')}}</p>
                            <p class="fs-7">{{$gateway->val2}} <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$gateway->val2}}" title="{{__('Copy')}}"></i></p>
                            @endif
                            @if($gateway->instructions)
                            <p class="fw-bold fs-7 mb-0">{{__('Instructions')}}</p>
                            <p class="fs-7">{{$gateway->instructions}}</p>
                            @endif
                        </div>
                        @endif
                        @endif

                        <div class="bg-light-primary px-6 py-5 rounded-4">
                            <p class="text-dark fs-7 mb-0"><b>{{__('You will receive')}}</b>: {{$receive}}</p>
                            <p class="text-dark fs-7 mb-0"><b>{{__('Fee')}}</b>: {{$fee}}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-block btn-success" type="submit">
                            <span wire:loading.remove wire:target="gateway">{{__('Fund account')}}</span>
                            <span wire:loading wire:target="gateway">{{__('Submitting request...')}}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>