<?php $__env->startSection('content'); ?>
<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.settings.api-log', ['user' => $user])->html();
} elseif ($_instance->childHasBeenRendered('yGtqyVg')) {
    $componentId = $_instance->getRenderedChildComponentId('yGtqyVg');
    $componentTag = $_instance->getRenderedChildComponentTagName('yGtqyVg');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('yGtqyVg');
} else {
    $response = \Livewire\Livewire::mount('user.settings.api-log', ['user' => $user]);
    $html = $response->html();
    $_instance->logRenderedChild('yGtqyVg', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/api-log.blade.php ENDPATH**/ ?>