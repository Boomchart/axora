<div>
    <div wire:ignore id="kt_message_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_message_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_message_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Message')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_message__<?php echo e($val->id); ?>_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark bg-whitelabel">
                            <i class="bi bi-inbox text-dark" style="font-size:44px;"></i>
                        </div>
                    </div>
                    <p class="text-dark fs-4 fw-bold"><?php echo e($val->subject); ?></p>
                    <div class="text-start text-dark fs-7 ">
                        <?php if(Str::length($val->message)>50): ?>
                        <div id="main-data<?php echo e($val->id); ?>">
                            <p class="preserveLines"><?php echo e(Str::words($val->message, 50)); ?></p>
                            <a id="readMore<?php echo e($val->id); ?>" href="javascript:void;"><?php echo e(__('Read more')); ?></a>
                        </div>
                        <?php else: ?>
                        <p class="preserveLines"><?php echo e($val->message); ?></p>
                        <?php endif; ?>
                        <div style="display:none;" id="main-data-hide<?php echo e($val->id); ?>">
                            <p class="preserveLines"><?php echo e($val->message); ?></p>
                            <a id="readLess<?php echo e($val->id); ?>" href="javascript:void;"><?php echo e(__('Read less')); ?></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <div class="bg-light-primary px-6 py-5 mb-10 rounded">
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Name')); ?>: <?php echo e($val->first_name.' '.$val->last_name); ?> </span>
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Email')); ?>: <?php echo e($val->email); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="<?php echo e($val->email); ?>" title="<?php echo e(__('Copy')); ?>"></i></span>
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Mobile')); ?>: <?php echo e($val->mobile); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="<?php echo e($val->mobile); ?>" title="<?php echo e(__('Copy')); ?>"></i></span>
                        </li>
                        <?php if($val->admin_id != null): ?>
                        <li class="d-flex align-items-center py-2">
                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Marked as Read by')); ?>: <?php echo e($val->user->first_name.' '.$val->user->last_name); ?></span>
                        </li>
                        <?php endif; ?>
                    </div>
                    <?php if($val->deleted_at == null): ?>
                    <button class="btn btn-secondary btn-block mt-5" id="kt_email_<?php echo e($val->id); ?>_button"><i class="bi bi-envelope"></i> <?php echo e(__('Send Email')); ?></button>
                    <?php if($val->seen == 0): ?>
                    <button class="btn btn-success btn-block mt-5" wire:click="seen('<?php echo e($val->id); ?>', 1)"><i class="bi bi-hand-thumbs-up"></i> <?php echo e(__('Mark as Read')); ?></button>
                    <?php endif; ?>
                    <button class="btn btn-danger btn-block mt-5" wire:click="delete('<?php echo e($val->id); ?>')"><i class="fal fa-trash"></i> <?php echo e(__('Delete')); ?></button>
                    <?php else: ?>
                    <button class="btn btn-secondary btn-block mt-5" wire:click="restore('<?php echo e($val->id); ?>')"><i class="fal fa-trash-arrow-up"></i> <?php echo e(__('Restore Message')); ?></button>
                    <button class="btn btn-danger btn-block mt-5" wire:click="forceDelete('<?php echo e($val->id); ?>')"><i class="fal fa-trash"></i> <?php echo e(__('Delete Permanently')); ?></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_email_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_email_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_email_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Send Email')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_send_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark bg-whitelabel">
                            <i class="bi bi-inbox text-dark" style="font-size:44px;"></i>
                        </div>
                    </div>
                    <p class="text-dark fs-7 fw-bold"><?php echo e(__('Send Email to')); ?> <?php echo e($val->contact->first_name.' '.$val->contact->last_name); ?></p>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="sendEmail('<?php echo e($val->contact->id); ?>')" method="post">
                        <div class="fv-row mb-6">
                            <input class="form-control form-control-solid" type="text" wire:model.defer="subject" required placeholder="Subject" />
                            <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="form-text"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="fv-row mb-6">
                            <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="message" required placeholder="Message"></textarea>
                            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="form-text"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" id="filepond-upload" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="sendEmail('<?php echo e($val->contact->id); ?>')"><?php echo e(__('Add to Queue')); ?></span>
                                <span wire:loading wire:target="sendEmail('<?php echo e($val->contact->id); ?>')"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/message/message.blade.php ENDPATH**/ ?>