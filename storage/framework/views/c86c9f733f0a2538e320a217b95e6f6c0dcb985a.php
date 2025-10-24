<!doctype html>
<html class="no-js" lang="en">

<head>
  <title><?php echo e($title); ?></title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="robots" content="index, follow">
  <meta name="apple-mobile-web-app-title" content="<?php echo e($set->site_name); ?>" />
  <meta name="application-name" content="<?php echo e($set->site_name); ?>" />
  <meta name="description" content="<?php echo e($set->site_desc); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="<?php echo e(asset('asset/images/favicon.png')); ?>" />
  <link href="<?php echo e(asset('asset/fonts/fontawesome/css/all.css')); ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo e(asset('dashboard/plugins/global/plugins.bundle.css')); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo e(asset('dashboard/css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
  <?php echo $__env->yieldContent('css'); ?>
  <?php echo $__env->make('partials.font', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body id="kt_body" class="bg-dark header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid">
      <!--begin::Aside-->
      <?php echo $__env->yieldContent('content'); ?>
    </div>
    <!--end::Authentication - Sign-in-->
  </div>
  <?php echo $set->livechat; ?>

  <?php echo $set->analytic_snippet; ?>

  <script src="<?php echo e(asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')); ?>"></script>
  <script src="<?php echo e(asset('dashboard/plugins/global/plugins.bundle.js')); ?>"></script>
  <script src="<?php echo e(asset('dashboard/js/scripts.bundle.js')); ?>"></script>
  <script src="<?php echo e(asset('asset/fonts/fontawesome/js/all.js')); ?>"></script>
  <script src="<?php echo e(asset('asset/dashboard/js/pincode.js')); ?>"></script>
</body>

</html>
<?php echo $__env->yieldContent('script'); ?>
<?php if(session('success')): ?>
<script>
  "use strict";
  toastr.success("<?php echo session('success'); ?>");
</script>
<?php endif; ?>
<?php if(session('alert')): ?>
<script>
  "use strict";
  toastr.warning("<?php echo session('alert'); ?>");
</script>
<?php endif; ?>
<?php if($set->recaptcha==1): ?>
<?php echo RecaptchaV3::initJs(); ?>

<?php endif; ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/errors/menu.blade.php ENDPATH**/ ?>