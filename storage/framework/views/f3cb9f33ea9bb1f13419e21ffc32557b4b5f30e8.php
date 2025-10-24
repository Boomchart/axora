<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.api-log', ['admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('82YbVEb')) {
    $componentId = $_instance->getRenderedChildComponentId('82YbVEb');
    $componentTag = $_instance->getRenderedChildComponentTagName('82YbVEb');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('82YbVEb');
} else {
    $response = \Livewire\Livewire::mount('admin.api-log', ['admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('82YbVEb', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/dashboard/api-log.blade.php ENDPATH**/ ?>