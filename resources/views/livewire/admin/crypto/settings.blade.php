<div>
    @include('admin.crypto.header', ['currency' => $val, 'type' => $type])
    <div class="card mb-10">
        <div class="card-body">
            <form class="form w-100" wire:submit.prevent="update">
                <p class="fs-7 fw-bold">{{ __('Features') }}</p>
                <div class="form-check form-check-custom form-check-solid mb-6">
                    <input class="form-check-input" type="checkbox" id="payout" wire:model="payout" />
                    <label class="form-check-label fs-7" for="payout">{{ __('Payout (Remittance)') }} - {{ __('For recipients') }}</label>
                </div>
                @error('payout')
                <span class="form-text text-danger">{{ $message }}</span>
                @enderror

                <div class="text-center mt-10">
                    <button type="submit" class="btn btn-primary btn-block my-2" wire:loading.attr="disabled"
                        wire:loading.class="opacity-50">
                        <span wire:loading.remove wire:target="update">{{ __('Save Settings') }}</span>
                        <span wire:loading wire:target="update">{{ __('Processing Request...') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>