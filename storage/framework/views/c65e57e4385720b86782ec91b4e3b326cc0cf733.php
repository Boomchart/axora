<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.orders.all', ['user' => $user])->html();
} elseif ($_instance->childHasBeenRendered('fMQiapE')) {
    $componentId = $_instance->getRenderedChildComponentId('fMQiapE');
    $componentTag = $_instance->getRenderedChildComponentTagName('fMQiapE');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('fMQiapE');
} else {
    $response = \Livewire\Livewire::mount('user.orders.all', ['user' => $user]);
    $html = $response->html();
    $_instance->logRenderedChild('fMQiapE', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/orders/index.blade.php ENDPATH**/ ?>