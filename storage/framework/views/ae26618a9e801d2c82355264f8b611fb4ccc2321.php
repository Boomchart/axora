<div>
    <div wire:ignore.self id="kt_edit_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_edit_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_edit_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-danger me-1 lh-1"><?php echo e(__('Edit')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_edit_<?php echo e($val->id); ?>_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="update">
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7"><?php echo e(__('Registration Type')); ?></label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="val.name" required placeholder="<?php echo e(__('name')); ?>" />
                            <?php $__errorArgs = ['val.name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="form-text text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" wire:click.prevent="update" class="btn btn-dark btn-block my-2" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="update">
                                <span wire:loading.remove wire:target="update"><?php echo e(__('Update')); ?></span>
                                <span wire:loading wire:target="update"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="delete<?php echo e($val->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Delete')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-info ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <button wire:click="delete" class="btn btn-danger btn-block" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                            <span wire:loading.remove wire:target="delete"><?php echo e(__('Delete')); ?></span>
                            <span wire:loading wire:target="delete"><?php echo e(__('Processing Request...')); ?></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/regtype/edit.blade.php ENDPATH**/ ?>