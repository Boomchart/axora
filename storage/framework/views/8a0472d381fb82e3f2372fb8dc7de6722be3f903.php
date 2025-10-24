<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <?php if($devices->count() > 0): ?>
            <div class="card-body" wire:loading.class.delay="opacity-50" wire:target="orderBy, perPage">
                <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex flex-stack mb-6">
                    <div class="d-flex align-items-center me-2">
                        <div class="ps-1">
                            <p class="fs-7 text-gray-800 fw-bold mb-0"><?php echo e($val->userAgent); ?></p>
                            <p class="fs-7 text-gray-800 mb-0"><?php echo e($val->deviceType); ?></p>
                            <div class="fs-7 text-gray-800 fw-semibold"><?php echo e(__('Last login:')); ?> <?php echo e(\Carbon\Carbon::create($val->last_login)->setTimezone($admin->timezone)->format('d M, Y h:i:A')); ?></div>
                        </div>
                    </div>
                </div>
                <?php if(!$loop->last): ?>
                <hr class="bg-light-border">
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($devices->total() > 0 && $devices->count() < $devices->total()): ?><button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block"><?php echo e(__('See more')); ?></button><?php endif; ?>
                    <?php else: ?>
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-display text-dark" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark fw-bold"><?php echo e(__('No Devices')); ?></h3>
                    </div>
                    <?php endif; ?>

            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/users/devices.blade.php ENDPATH**/ ?>