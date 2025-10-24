<?php $__env->startSection('content'); ?>
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-6"><?php echo e(__('Environment')); ?></h1>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <p class="mb-10"><?php echo e(__('To make testing and developing with')); ?> <?php echo e($set->site_name); ?> <?php echo e(__('quick and easy, we make use of the same API endpoint for sandbox and production, the only difference is the keys used when calling the APIs')); ?>.</p>
            <div class="table-responsive">
                <table class="table table-row-bordered table-flush align-middle gy-6">
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold bg-lighten">
                        <tr>
                            <th class="text-left"><?php echo e(__('Environment')); ?></th>
                            <th class="text-left"><?php echo e(__('Purpose')); ?></th>
                            <th class="text-left"><?php echo e(__('Base URL')); ?></th>
                        </tr>
                    </thead>
                    <tbody class="fs-7 fw-bold text-gray-700">
                        <tr>
                            <td class="text-left"><?php echo e(__('Sandbox')); ?></td>
                            <td class="text-left"><?php echo e(__('The sandbox environment is dedicated to test and development phases')); ?>.</td>
                            <td class="text-left">
                                <p class="text-success"><?php echo e(url('/')); ?>/api</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><?php echo e(__('Production')); ?></td>
                            <td class="text-left"><?php echo e(__('The production environment is dedicated for live transactions')); ?>.</td>
                            <td class="text-left">
                                <p class="text-success"><?php echo e(url('/')); ?>/api</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('developer.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/developer/environments.blade.php ENDPATH**/ ?>