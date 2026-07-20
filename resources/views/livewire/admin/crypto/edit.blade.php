<div>
    <a href="{{route('crypto.edit', ['currency' => $val->id, 'type' => $type])}}" class="me-3">
        <div class="symbol symbol-50px symbol-circle">
            <span class="symbol-label bg-secondary text-dark fw-bold fs-4">
                <i class="bi bi-gear-wide-connected text-dark"></i>
            </span>
        </div>
    </a>
    @if($val->status==1)
    <a wire:click="block" href="#" class="me-3">
        <div class="symbol symbol-50px symbol-circle">
            <span class="symbol-label bg-danger fw-bold fs-4">
                <i class="bi bi-ban text-white"></i>
            </span>
        </div>
    </a>
    @else
    <a wire:click="unblock" href="#" class="me-3">
        <div class="symbol symbol-50px symbol-circle">
            <span class="symbol-label bg-white fw-bold fs-4">
                <i class="bi bi-check text-dark"></i>
            </span>
        </div>
    </a>
    @endif
    <a href="#" class="me-3" data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}">
        <div class="symbol symbol-50px symbol-circle">
            <span class="symbol-label bg-danger fw-bold fs-4">
                <i class="bi bi-trash text-white"></i>
            </span>
        </div>
    </a>

    <div wire:ignore.self class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Delete Coin')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-info ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p>{{__('Are you sure you want to delete this Coin')}}?</p>
                    <div class="text-center">
                        <button wire:click="delete" class="btn btn-danger btn-block" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                            <span wire:loading.remove wire:target="delete">{{__('Delete')}}</span>
                            <span wire:loading wire:target="delete">{{__('Processing Request...')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>