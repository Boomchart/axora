<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.transactions.details', ['settings' => $set, 'val' => $val, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('ZnIo7LQ')) {
    $componentId = $_instance->getRenderedChildComponentId('ZnIo7LQ');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZnIo7LQ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZnIo7LQ');
} else {
    $response = \Livewire\Livewire::mount('admin.transactions.details', ['settings' => $set, 'val' => $val, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('ZnIo7LQ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/transactions/details.blade.php ENDPATH**/ ?>