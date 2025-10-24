<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.orders.all', ['admin' => $admin, 'settings' => $set])->html();
} elseif ($_instance->childHasBeenRendered('FiQfg23')) {
    $componentId = $_instance->getRenderedChildComponentId('FiQfg23');
    $componentTag = $_instance->getRenderedChildComponentTagName('FiQfg23');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('FiQfg23');
} else {
    $response = \Livewire\Livewire::mount('admin.orders.all', ['admin' => $admin, 'settings' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('FiQfg23', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>