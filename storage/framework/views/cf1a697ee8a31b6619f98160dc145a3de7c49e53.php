<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.payout.header', ['settings' => $set, 'type' => $type, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('ZBybGB5')) {
    $componentId = $_instance->getRenderedChildComponentId('ZBybGB5');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZBybGB5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZBybGB5');
} else {
    $response = \Livewire\Livewire::mount('admin.payout.header', ['settings' => $set, 'type' => $type, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('ZBybGB5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.payout.index', ['settings' => $set, 'base' => $type, 'admin' => $admin, 'set' => $set])->html();
} elseif ($_instance->childHasBeenRendered('cJc5dJr')) {
    $componentId = $_instance->getRenderedChildComponentId('cJc5dJr');
    $componentTag = $_instance->getRenderedChildComponentTagName('cJc5dJr');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('cJc5dJr');
} else {
    $response = \Livewire\Livewire::mount('admin.payout.index', ['settings' => $set, 'base' => $type, 'admin' => $admin, 'set' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('cJc5dJr', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/payout/index.blade.php ENDPATH**/ ?>