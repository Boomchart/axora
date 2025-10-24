<div>
    <div wire:ignore.self class="modal fade" id="gateway_deposit<?php echo e($gateway->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e($gateway->name); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <form wire:submit.prevent="gateway">
                    <div class="modal-body">
                        <div class="fv-row mb-6">
                            <label class="form-label fs-7 text-dark"><?php echo e(__('Amount')); ?> (<?php echo e($currency->currency); ?>)</label>
                            <input class="form-control form-control-solid" type="text" step="any" wire:model.debounce.500ms="amount" autocomplete="transaction-amount" id="amount" min="1" required placeholder="<?php echo e(__('0.00')); ?>" autofocus />
                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php if($gateway->type==1): ?>
                        <?php if($gateway->val1): ?>
                        <div class="fv-row mb-6">
                            <label class="form-label fs-7 text-dark"><?php echo e($gateway->val1); ?></label>
                            <input class="form-control form-control-solid  <?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" wire:model.defer="details" required id="details" />
                            <?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php endif; ?>
                        <div class="fv-row mb-6">
                            <label class="form-label fs-7 text-dark"><?php echo e(__('Receipt')); ?></label>
                            <input class="form-control form-control-solid" type="file" wire:model="image" required />
                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div wire:loading wire:target="image"><?php echo e(__('Uploading')); ?>...</div>
                        </div>
                        <?php if($gateway->instructions || $gateway->crypto=1): ?>

                        <div class="bg-light-warning p-5 mb-7 rounded-4 text-wrap" wire:ignore style="overflow-wrap: break-word;">
                            <?php if($gateway->crypto): ?>
                            <p class="fw-bold fs-7 mb-0"><?php echo e(__('Wallet address')); ?></p>
                            <p class="fs-7"><?php echo e($gateway->val2); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="<?php echo e($gateway->val2); ?>" title="<?php echo e(__('Copy')); ?>"></i></p>
                            <?php endif; ?>
                            <?php if($gateway->instructions): ?>
                            <p class="fw-bold fs-7 mb-0"><?php echo e(__('Instructions')); ?></p>
                            <p class="fs-7"><?php echo e($gateway->instructions); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>

                        <div class="bg-light-primary px-6 py-5 rounded-4">
                            <p class="text-dark fs-7 mb-0"><b><?php echo e(__('You will receive')); ?></b>: <?php echo e($receive); ?></p>
                            <p class="text-dark fs-7 mb-0"><b><?php echo e(__('Fee')); ?></b>: <?php echo e($fee); ?></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-block btn-success" type="submit">
                            <span wire:loading.remove wire:target="gateway"><?php echo e(__('Fund account')); ?></span>
                            <span wire:loading wire:target="gateway"><?php echo e(__('Submitting request...')); ?></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/gateway.blade.php ENDPATH**/ ?>