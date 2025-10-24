<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('vendor/prism/prism.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('dashboard/css/docs.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.settings.webhook', ['user' => $user])->html();
} elseif ($_instance->childHasBeenRendered('HIEUyVO')) {
    $componentId = $_instance->getRenderedChildComponentId('HIEUyVO');
    $componentTag = $_instance->getRenderedChildComponentTagName('HIEUyVO');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('HIEUyVO');
} else {
    $response = \Livewire\Livewire::mount('user.settings.webhook', ['user' => $user]);
    $html = $response->html();
    $_instance->logRenderedChild('HIEUyVO', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('vendor/prism/prism.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/webhook.blade.php ENDPATH**/ ?>