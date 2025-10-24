<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.transactions.all', ['admin' => $admin, 'settings' => $set])->html();
} elseif ($_instance->childHasBeenRendered('rSIaMWE')) {
    $componentId = $_instance->getRenderedChildComponentId('rSIaMWE');
    $componentTag = $_instance->getRenderedChildComponentTagName('rSIaMWE');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('rSIaMWE');
} else {
    $response = \Livewire\Livewire::mount('admin.transactions.all', ['admin' => $admin, 'settings' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('rSIaMWE', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/transactions/index.blade.php ENDPATH**/ ?>