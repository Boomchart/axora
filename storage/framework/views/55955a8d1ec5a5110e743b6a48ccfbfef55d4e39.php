<!doctype html>
<html class="no-js" lang="en">

<head>
  <title><?php echo e($title); ?> - <?php echo e($set->site_name); ?></title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="robots" content="index, follow">
  <meta name="apple-mobile-web-app-title" content="<?php echo e($set->site_name); ?>" />
  <meta name="application-name" content="<?php echo e($set->site_name); ?>" />
  <meta name="description" content="<?php echo e($set->site_desc); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="<?php echo e(asset('asset/images/favicon.png')); ?>" />
  <link href="<?php echo e(asset('dashboard/plugins/global/plugins.bundle.css')); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo e(asset('dashboard/css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
  <link rel="stylesheet" href="<?php echo e(asset('asset/filepond/css/filepond.css')); ?>" />
  <?php echo \Livewire\Livewire::styles(); ?>

  <?php echo $__env->yieldContent('css'); ?>
  <?php echo $__env->make('partials.font', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body id="kt_body" class="bg-secondary header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
  <div class="page-loading active text-indigo">
    <div class="page-loading-inner">
      <div class="page-spinner"></div><span></span>
    </div>
  </div>
  <!--begin::Main-->
  <div class="row justify-content-center">
      <?php echo $__env->yieldContent('content'); ?>
  </div>
  <?php echo $set->livechat; ?>

  <?php echo $set->analytic_snippet; ?>

  <script src="<?php echo e(asset('dashboard/plugins/global/plugins.bundle.js')); ?>"></script>
  <script src="<?php echo e(asset('dashboard/js/scripts.bundle.js')); ?>"></script>
  <script src="<?php echo e(asset('dashboard/js/custom/general.js')); ?>"></script>
  <script src="<?php echo e(asset('asset/filepond/js/preview.js')); ?>"></script>
  <script src="<?php echo e(asset('asset/filepond/js/crop.js')); ?>"></script>
  <script src="<?php echo e(asset('asset/filepond/js/transform.js')); ?>"></script>
  <script src="<?php echo e(asset('asset/filepond/js/validate-type.js')); ?>"></script>
  <script src="<?php echo e(asset('asset/filepond/js/validate-size.js')); ?>"></script>
  <script src="<?php echo e(asset('asset/filepond/js/filepond.js')); ?>"></script>
</body>

</html>
<?php echo \Livewire\Livewire::scripts(); ?>

<?php echo $__env->yieldPushContent('scripts'); ?>
<script src="<?php echo e(asset('dashboard/js/alpine.js')); ?>"></script>
<?php echo $__env->yieldContent('script'); ?>

<?php if($set->recaptcha==1): ?>
<?php echo RecaptchaV3::initJs(); ?>

<?php endif; ?>

<?php echo $__env->make('partials.extra_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/auth/menu.blade.php ENDPATH**/ ?>