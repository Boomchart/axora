<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.transactions.details', ['user'=> $user, 'settings' => $set, 'val' => $val])->html();
} elseif ($_instance->childHasBeenRendered('jqsJRXN')) {
    $componentId = $_instance->getRenderedChildComponentId('jqsJRXN');
    $componentTag = $_instance->getRenderedChildComponentTagName('jqsJRXN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('jqsJRXN');
} else {
    $response = \Livewire\Livewire::mount('user.transactions.details', ['user'=> $user, 'settings' => $set, 'val' => $val]);
    $html = $response->html();
    $_instance->logRenderedChild('jqsJRXN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/transactions/details.blade.php ENDPATH**/ ?>