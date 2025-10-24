<div>
    <div wire:ignore.self class="modal fade" id="delete<?php echo e($val->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Delete User')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <?php if($val->deleted_at == null): ?>
                    <p><?php echo e(__('Are you sure you want to delete this user, you can\'t undo this action?')); ?></p>
                    <?php else: ?>
                    <p><?php echo e(__('Are you sure you want to delete this user permanently, you can\'t undo this action?')); ?></p>
                    <?php endif; ?>
                    <div class="text-center">
                        <button wire:click="delete" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete"><?php echo e(__('Delete')); ?></span>
                            <span wire:loading wire:target="delete"><?php echo e(__('Processing Request...')); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="restore<?php echo e($val->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Restore User')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p><?php echo e(__('Are you sure you want to restore this user account')); ?>?</p>
                    <div class="text-center">
                        <button wire:click="restore" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="restore"><?php echo e(__('Restore')); ?></span>
                            <span wire:loading wire:target="restore"><?php echo e(__('Processing Request...')); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/users/edit-users.blade.php ENDPATH**/ ?>