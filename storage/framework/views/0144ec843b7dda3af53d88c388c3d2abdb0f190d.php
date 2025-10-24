<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.ticket.index', ['user' => $user, 'settings' => $set])->html();
} elseif ($_instance->childHasBeenRendered('bRC0biP')) {
    $componentId = $_instance->getRenderedChildComponentId('bRC0biP');
    $componentTag = $_instance->getRenderedChildComponentTagName('bRC0biP');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('bRC0biP');
} else {
    $response = \Livewire\Livewire::mount('user.ticket.index', ['user' => $user, 'settings' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('bRC0biP', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/support/index.blade.php ENDPATH**/ ?>