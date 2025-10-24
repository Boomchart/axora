<div>
    <div wire:ignore.self id="kt_edit_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_edit_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_edit_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{'md': '900px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Edit Template')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_edit_<?php echo e($val->id); ?>_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="update(Object.fromEntries(new FormData($event.target)))" method="post">
                        <p href="#" class="fs-7 text-dark mb-5"><?php echo e(__('Allowed Tags')); ?>: <?php $__currentLoopData = explode(',', $val->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tags): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <span class="badge badge-warning badge-sm text-dark"><?php echo e($tags); ?></span> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></p>
                        <div class="fv-row mb-6">
                            <input class="form-control form-control-solid" type="text" name="subject" required placeholder="<?php echo e(__('Subject')); ?>" value="<?php echo e($val->subject); ?>"/>
                            <?php $__errorArgs = ['val.subject'];
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
                        <div class="fv-row mb-6" wire:ignore>
                            <textarea class="form-control form-control-solid tinymce<?php echo e($val->id); ?>" rows="10" type="text" name="body" placeholder="<?php echo e(__('Details')); ?>"><?php echo e($val->body); ?></textarea>
                            <?php $__errorArgs = ['val.body'];
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
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="update"><?php echo e(__('Update')); ?></span>
                                <span wire:loading wire:target="update"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('asset/tinymce/tinymce.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/tinymce/init-tinymce.js')); ?>"></script>
<script>
    document.addEventListener('livewire:load', function() {
        initializeTinymce('textarea.tinymce<?php echo e($val->id); ?>');
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/template/edit.blade.php ENDPATH**/ ?>