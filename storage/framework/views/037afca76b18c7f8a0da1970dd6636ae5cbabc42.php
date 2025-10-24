<?php $__env->startSection('content'); ?>
<div class="col-md-4">
  <div class="py-10">
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('auth.security', ['set' => $set, 'user' => $user])->html();
} elseif ($_instance->childHasBeenRendered('Locim6P')) {
    $componentId = $_instance->getRenderedChildComponentId('Locim6P');
    $componentTag = $_instance->getRenderedChildComponentTagName('Locim6P');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Locim6P');
} else {
    $response = \Livewire\Livewire::mount('auth.security', ['set' => $set, 'user' => $user]);
    $html = $response->html();
    $_instance->logRenderedChild('Locim6P', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/auth/multi-factor/user.blade.php ENDPATH**/ ?>