    <div class="mb-10">
        <div class="card-body">
            <form action="<?php echo e(route('admin.settings.update', ['type' => 'policies'])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Privacy policy')); ?></label>
                    <textarea class="form-control form-control-solid tinymce" rows="20" name="privacy"><?php echo e($set->privacy); ?></textarea>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Terms & Conditions')); ?></label>
                    <textarea class="form-control form-control-solid tinymce" rows="20" name="terms"><?php echo e($set->terms); ?></textarea>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2"><?php echo e(__('Update')); ?></a>
                </div>
            </form>
        </div>
    </div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/partials/admin/policy.blade.php ENDPATH**/ ?>