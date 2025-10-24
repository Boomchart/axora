<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.staff.index', ['settings' => $set])->html();
} elseif ($_instance->childHasBeenRendered('KCeThWX')) {
    $componentId = $_instance->getRenderedChildComponentId('KCeThWX');
    $componentTag = $_instance->getRenderedChildComponentTagName('KCeThWX');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('KCeThWX');
} else {
    $response = \Livewire\Livewire::mount('admin.staff.index', ['settings' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('KCeThWX', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/staff/index.blade.php ENDPATH**/ ?>