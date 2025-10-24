<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.users.header', ['type' => $type, 'admin' => $admin, 'settings' => $set, 'client' => $client])->html();
} elseif ($_instance->childHasBeenRendered('fQ8tFk6')) {
    $componentId = $_instance->getRenderedChildComponentId('fQ8tFk6');
    $componentTag = $_instance->getRenderedChildComponentTagName('fQ8tFk6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('fQ8tFk6');
} else {
    $response = \Livewire\Livewire::mount('admin.users.header', ['type' => $type, 'admin' => $admin, 'settings' => $set, 'client' => $client]);
    $html = $response->html();
    $_instance->logRenderedChild('fQ8tFk6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.users.'.$type, ['type' => $type, 'admin' => $admin, 'settings' => $set, 'client' => $client])->html();
} elseif ($_instance->childHasBeenRendered('TihAfaa')) {
    $componentId = $_instance->getRenderedChildComponentId('TihAfaa');
    $componentTag = $_instance->getRenderedChildComponentTagName('TihAfaa');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('TihAfaa');
} else {
    $response = \Livewire\Livewire::mount('admin.users.'.$type, ['type' => $type, 'admin' => $admin, 'settings' => $set, 'client' => $client]);
    $html = $response->html();
    $_instance->logRenderedChild('TihAfaa', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/user/manage.blade.php ENDPATH**/ ?>