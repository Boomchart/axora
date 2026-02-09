<div>
    <div class="card rounded-5">
        <div class="card-body m-5">
            <form class="form w-100" wire:submit.prevent="save" method="post">
                @csrf
                <div class="text-start mb-10">
                    <h1 class="text-dark mb-3">{{__('Two Factor Authentication')}}</h1>
                </div>
                <div class="fv-row mb-10">
                    <label class="form-label text-dark fs-7">{{__('Code')}}</label>
                    <input class="form-control form-control-solid border-light" wire:model="pin" type="tel" minlength="6" maxlength="6" pattern="[0-9]+" autocomplete="one-time-code" value="{{old('code')}}" required placeholder="XXXXXX" autofocus onkeyup="this.value=removeSpacesPin(this.value);" onmouseout="this.value=removeSpacesPin(this.value);" />
                    @error('pin')
                    <span class="form-text">{{ $message}}</span>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">{{__('Unlock Account')}}</span>
                        <span wire:loading wire:target="save">{{__('Processing request...')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>