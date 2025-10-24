<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.balance', ['user' => $user, 'settings' => $set, 'currency' => $currency])->html();
} elseif ($_instance->childHasBeenRendered('YpX0TJ2')) {
    $componentId = $_instance->getRenderedChildComponentId('YpX0TJ2');
    $componentTag = $_instance->getRenderedChildComponentTagName('YpX0TJ2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YpX0TJ2');
} else {
    $response = \Livewire\Livewire::mount('user.balance', ['user' => $user, 'settings' => $set, 'currency' => $currency]);
    $html = $response->html();
    $_instance->logRenderedChild('YpX0TJ2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/dashboard/index.blade.php ENDPATH**/ ?>