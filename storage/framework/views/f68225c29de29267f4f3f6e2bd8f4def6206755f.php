<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.ticket.header', ['type' => $type, 'settings' => $set, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('9ncjJgF')) {
    $componentId = $_instance->getRenderedChildComponentId('9ncjJgF');
    $componentTag = $_instance->getRenderedChildComponentTagName('9ncjJgF');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('9ncjJgF');
} else {
    $response = \Livewire\Livewire::mount('admin.ticket.header', ['type' => $type, 'settings' => $set, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('9ncjJgF', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.ticket.'.$type, ['type' => $type, 'settings' => $set, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('TwFmA21')) {
    $componentId = $_instance->getRenderedChildComponentId('TwFmA21');
    $componentTag = $_instance->getRenderedChildComponentTagName('TwFmA21');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('TwFmA21');
} else {
    $response = \Livewire\Livewire::mount('admin.ticket.'.$type, ['type' => $type, 'settings' => $set, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('TwFmA21', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/support/index.blade.php ENDPATH**/ ?>