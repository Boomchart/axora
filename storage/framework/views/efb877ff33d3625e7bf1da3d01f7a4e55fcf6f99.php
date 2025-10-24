<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.deposit.header', ['settings' => $set, 'type' => $type, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('rGHxWjG')) {
    $componentId = $_instance->getRenderedChildComponentId('rGHxWjG');
    $componentTag = $_instance->getRenderedChildComponentTagName('rGHxWjG');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('rGHxWjG');
} else {
    $response = \Livewire\Livewire::mount('admin.deposit.header', ['settings' => $set, 'type' => $type, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('rGHxWjG', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.deposit.index', ['settings' => $set, 'base' => $type, 'admin' => $admin, 'set' => $set])->html();
} elseif ($_instance->childHasBeenRendered('qFqep0z')) {
    $componentId = $_instance->getRenderedChildComponentId('qFqep0z');
    $componentTag = $_instance->getRenderedChildComponentTagName('qFqep0z');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('qFqep0z');
} else {
    $response = \Livewire\Livewire::mount('admin.deposit.index', ['settings' => $set, 'base' => $type, 'admin' => $admin, 'set' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('qFqep0z', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/deposit/index.blade.php ENDPATH**/ ?>