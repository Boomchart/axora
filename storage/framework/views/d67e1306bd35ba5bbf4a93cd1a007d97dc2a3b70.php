<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.users.index', ['admin' => $admin, 'settings' => $set, 'type' => $type, 'title' => $title])->html();
} elseif ($_instance->childHasBeenRendered('kiJA2dZ')) {
    $componentId = $_instance->getRenderedChildComponentId('kiJA2dZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('kiJA2dZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kiJA2dZ');
} else {
    $response = \Livewire\Livewire::mount('admin.users.index', ['admin' => $admin, 'settings' => $set, 'type' => $type, 'title' => $title]);
    $html = $response->html();
    $_instance->logRenderedChild('kiJA2dZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/user/index.blade.php ENDPATH**/ ?>