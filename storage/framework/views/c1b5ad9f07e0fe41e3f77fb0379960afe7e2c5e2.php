<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.message.header', ['settings' => $set, 'type' => $type, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('A2naaXj')) {
    $componentId = $_instance->getRenderedChildComponentId('A2naaXj');
    $componentTag = $_instance->getRenderedChildComponentTagName('A2naaXj');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('A2naaXj');
} else {
    $response = \Livewire\Livewire::mount('admin.message.header', ['settings' => $set, 'type' => $type, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('A2naaXj', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.message.'.$type, ['settings' => $set, 'type' => $type, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('Htn0sjZ')) {
    $componentId = $_instance->getRenderedChildComponentId('Htn0sjZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('Htn0sjZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Htn0sjZ');
} else {
    $response = \Livewire\Livewire::mount('admin.message.'.$type, ['settings' => $set, 'type' => $type, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('Htn0sjZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/message/index.blade.php ENDPATH**/ ?>