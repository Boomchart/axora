<div>
    <div class="card mb-10">
        <div class="card-body">
            <form wire:submit.prevent="filetypeUpdate" method="post">
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Documents File Types allowed to be uploaded to server')); ?></label>
                    <div wire:ignore>
                        <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="files_allowed" id="files_allowed" required />
                    </div>
                    <?php $__errorArgs = ['files_allowed'];
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
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Images File Type allowed to be uploaded to server')); ?></label>
                    <div wire:ignore>
                        <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="images_allowed" id="images_allowed" required />
                    </div>
                    <?php $__errorArgs = ['images_allowed'];
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
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('File upload size')); ?></label>
                    <div class="input-group">
                        <input class="form-control form-control-solid" type="number" wire:model.debounce.1000ms="file_upload_size"/>
                        <span class="input-group-text border-0"><?php echo e(__('KB')); ?></span>
                    </div>
                    <span class="form-text text-muted"><?php echo e(__('Maximum file size allowed on admin and user dashboard')); ?></span>
                    <?php $__errorArgs = ['file_upload_size'];
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
                <button type="submit" class="btn btn-success me-3 my-2" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="filetypeUpdate">
                    <span wire:loading.remove wire:target="filetypeUpdate"><?php echo e(__('Update')); ?></span>
                    <span wire:loading wire:target="filetypeUpdate"><?php echo e(__('Processing Request...')); ?></span>
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:load', function() {
        var fileFilter = document.querySelector("#files_allowed");
        var imageFilter = document.querySelector("#images_allowed");
        var tagifyFileFilter = new Tagify(fileFilter);
        var tagifyImageFilter = new Tagify(imageFilter);

        fileFilter.addEventListener('change', function(e) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('files_allowed', e.target.value);
        });        
        imageFilter.addEventListener('change', function(e) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('images_allowed', e.target.value);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/filetypes.blade.php ENDPATH**/ ?>