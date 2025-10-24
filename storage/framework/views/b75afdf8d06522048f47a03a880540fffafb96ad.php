<?php $__env->startSection('content'); ?>
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-6"><?php echo e(__('Authentication')); ?></h1>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <p class="mb-3 text-dark"><?php echo e(__('All API calls on')); ?> <?php echo e($set->site_name); ?> <?php echo e(__('are authenticated. API requests made without authorization will fail with the status code 401: Unauthorized')); ?>.</p>
            <div class="card-body text-left bg-light-primary rounded mb-10">
                <p class="mb-2 text-dark"><?php echo e(__('Your')); ?> <b><?php echo e(__('API Key')); ?></b> <?php echo e(__('can perform any actions on your')); ?> <?php echo e($set->site_name); ?> <?php echo e(__('account without restriction. It should be kept confidential and only stored on your servers, preferably as an environment variable. It should not be included in your Git repository or front-end JavaScript code')); ?>.</p>
            </div>
            <p class="mb-2 text-dark"><?php echo e(__('To authorize API calls from your server, pass your API key as a bearer token. This means passing an')); ?> <span class="text-success fw-bold">Authorization</span> <?php echo e(__('header with a value of')); ?> <span class="text-success fw-bold">"Bearer: {api_key}"</span>.</p>
            <h2 class="fw-bold fs-5"><?php echo e(__('API keys')); ?></h2>
            <p class="mb-3 text-dark"><?php echo e(__('It can authorize any action on your account, so it should never be exposed to the public')); ?>.</p>
            <p class="mb-0 text-dark"><?php echo e(__('To get your keys')); ?>:</p>
            <ul style="font-size:14px;">
                <li><?php echo e(__('Log in to your')); ?> <a class="text-success" target="_blank" href="<?php echo e(route('user.dashboard')); ?>"><u><?php echo e($set->site_name); ?> <?php echo e(__('dashboard')); ?></u></a></li>
                <li><?php echo e(__('Navigate to Settings')); ?></li>
                <li><?php echo e(__('Select')); ?> <b><?php echo e(__('API keys')); ?></b> <?php echo e(__('from API & Webhook section to view and copy your keys')); ?></li>
            </ul>
            <div class="card-body text-left bg-light-primary rounded mb-10">
                <h4 class="fw-bold fs-7"><?php echo e(__('Don\'t take any chances')); ?></h4>
                <p class="mb-0 text-dark"><?php echo e(__('If you think your keys may have been compromised (for instance, you accidentally committed them to Git), you should immediately generate new ones using the')); ?> <b><?php echo e(__('Generate new keys')); ?></b> <?php echo e(__('button on the')); ?> <b><?php echo e(__('Settings> API & Webhook')); ?></b> <?php echo e(__('page on your dashboard. This will invalidate all existing keys and give you a new set, and you can then update your app to use the new ones')); ?>.</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('developer.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/developer/authentication.blade.php ENDPATH**/ ?>