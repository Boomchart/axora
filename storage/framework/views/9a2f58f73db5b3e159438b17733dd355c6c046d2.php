<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('vendor/prism/prism.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('dashboard/css/docs.css')); ?>" type="text/css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.orders.details', ['settings' => $set, 'val' => $val, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('cQqwNhW')) {
    $componentId = $_instance->getRenderedChildComponentId('cQqwNhW');
    $componentTag = $_instance->getRenderedChildComponentTagName('cQqwNhW');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('cQqwNhW');
} else {
    $response = \Livewire\Livewire::mount('admin.orders.details', ['settings' => $set, 'val' => $val, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('cQqwNhW', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('vendor/prism/prism.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/orders/details.blade.php ENDPATH**/ ?>