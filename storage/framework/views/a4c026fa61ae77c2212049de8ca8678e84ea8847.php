<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('vendor/prism/prism.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('dashboard/css/docs.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.orders.details', ['user'=> $user, 'settings' => $set, 'val' => $val])->html();
} elseif ($_instance->childHasBeenRendered('DERRQUv')) {
    $componentId = $_instance->getRenderedChildComponentId('DERRQUv');
    $componentTag = $_instance->getRenderedChildComponentTagName('DERRQUv');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DERRQUv');
} else {
    $response = \Livewire\Livewire::mount('user.orders.details', ['user'=> $user, 'settings' => $set, 'val' => $val]);
    $html = $response->html();
    $_instance->logRenderedChild('DERRQUv', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('vendor/prism/prism.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/orders/details.blade.php ENDPATH**/ ?>