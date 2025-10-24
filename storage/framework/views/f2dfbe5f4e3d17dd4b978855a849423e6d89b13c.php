<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.transactions.all', ['user' => $user])->html();
} elseif ($_instance->childHasBeenRendered('X8PnQEC')) {
    $componentId = $_instance->getRenderedChildComponentId('X8PnQEC');
    $componentTag = $_instance->getRenderedChildComponentTagName('X8PnQEC');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('X8PnQEC');
} else {
    $response = \Livewire\Livewire::mount('user.transactions.all', ['user' => $user]);
    $html = $response->html();
    $_instance->logRenderedChild('X8PnQEC', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/transactions/index.blade.php ENDPATH**/ ?>