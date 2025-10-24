<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.dashboard', ['admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('t2d9Ebd')) {
    $componentId = $_instance->getRenderedChildComponentId('t2d9Ebd');
    $componentTag = $_instance->getRenderedChildComponentTagName('t2d9Ebd');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('t2d9Ebd');
} else {
    $response = \Livewire\Livewire::mount('admin.dashboard', ['admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('t2d9Ebd', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>