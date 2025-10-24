<?php $__env->startSection('content'); ?>
<div class="d-flex flex-row-fluid flex-column flex-column-fluid text-center p-10 py-20">
    <div class="pt-30 mb-12 error-bg"></div>
    <div class="text-center">
        <div class="d-flex flex-column flex-lg-row-fluid">
            <div class="d-flex flex-center flex-column flex-column-fluid">
                <div class="w-lg-700px w-700px">
                    <h1 class="fw-bolder fs-7tx text-white mb-3"><?php echo e(__('404')); ?></h1>
                    <div class="fs-3 fw-bold text-white mb-10"><?php echo e(__('We couldn\'t find the page you are looking for.')); ?></div>
                    <div class="mb-10">
                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline btn-lg btn-outline-secondary btn-active-secondary"><?php echo e(__('Go back')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('errors.menu', ['title' => '404'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/errors/404.blade.php ENDPATH**/ ?>