<div>
    <div wire:ignore.self class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Delete Country')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p>{{__('Are you sure you want to delete this Country')}}?</p>
                    <div class="text-center">
                    <button wire:click="delete" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete">{{__('Delete')}}</span>
                            <span wire:loading wire:target="delete">{{__('Processing Request...')}}</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>