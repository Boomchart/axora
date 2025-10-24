<?php $__env->startSection('content'); ?>
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <h1 class="text-success fw-bolder my-1 fs-2x mb-3"><?php echo e(__('Gift Card Order API')); ?></h1>
      <p class="text-dark fs-5 fw-bold"><?php echo e(__('Welcome')); ?></p>
    </div>
  </div>
  <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
    <div class="container">
      <p class="mb-10"><?php echo e($set->site_name); ?> <?php echo e(__('offers a unified API to integrate giftcard service to your application')); ?>.</p>
      <h2 class="text-dark fs-5 fw-bold"><?php echo e(__('Can we assist you?')); ?></h2>
      <p class="mb-0 text-dark"><?php echo e(__('Thank you for taking the time to use')); ?> <?php echo e($set->site_name); ?> <?php echo e(__('APIs')); ?>.</p>
      <p class="mb-10 text-dark"><?php echo e(__('Please contact us at')); ?> <a href="mailto:<?php echo e($set->support_email); ?>"><?php echo e($set->support_email); ?></a> <?php echo e(__('if you have any queries, feature suggestions, or discover any problems')); ?>. </p>
      <h2 class="text-dark fs-5 fw-bold"><?php echo e(__('HTTP Request Sample')); ?></h2>
      <p class="mb-10 text-dark"><?php echo e(__('We would provide cURL request sample, just so you can quickly test each endpoint on your terminal or command line. Need a quick how-to for making cURL requests? just use an HTTP client such as Postman, like the rest of us!')); ?></p>
      <h2 class="text-dark fs-5 fw-bold"><?php echo e(__('Requests and Responses')); ?></h2>
      <p class="mb-0 text-dark"><?php echo e(__('Both request body data and response data are formatted as JSON. Content type for responses is always of the type application/json. You can use your test API key, which does not affect your live data. The API key you use to authenticate the request determines whether the request is a live mode or test mode. Amount is always returned in lowest currency denomination, eg cent, kobo, always divided by 100.')); ?></p>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('developer.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/developer/index.blade.php ENDPATH**/ ?>