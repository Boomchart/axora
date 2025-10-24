<?php $__env->startSection('content'); ?>
<div class="toolbar" id="kt_toolbar">
  <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
      <h1 class="text-dark fw-bold my-1 fs-2 mb-6"><?php echo e(__('Settings')); ?></h1>
      <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
        <li class="nav-item">
          <a class="nav-link text-dark <?php if(route('user.profile', ['type' => 'profile'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-1-tab" href="<?php echo e(route('user.profile', ['type' => 'profile'])); ?>" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><?php echo e(__('Profile')); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark <?php if(route('user.profile', ['type' => 'api'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('user.profile', ['type' => 'api'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('API Keys & Webhook')); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark <?php if(route('user.profile', ['type' => 'security'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('user.profile', ['type' => 'security'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Security')); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark <?php if(route('user.profile', ['type' => 'notifications'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('user.profile', ['type' => 'notifications'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Notifications')); ?></a>
        </li>
      </ul>
    </div>
  </div>
  <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.settings.options', ['user' => $user, 'set' => $set, 'secret' => $secret, 'image' => $image])->html();
} elseif ($_instance->childHasBeenRendered('qsvNX2b')) {
    $componentId = $_instance->getRenderedChildComponentId('qsvNX2b');
    $componentTag = $_instance->getRenderedChildComponentTagName('qsvNX2b');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('qsvNX2b');
} else {
    $response = \Livewire\Livewire::mount('user.settings.options', ['user' => $user, 'set' => $set, 'secret' => $secret, 'image' => $image]);
    $html = $response->html();
    $_instance->logRenderedChild('qsvNX2b', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
  <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
    <div class="container">
      <?php if(route('user.profile', ['type' => 'profile'])==url()->current()): ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.settings.index', ['user' => $user, 'type' => 'profile'])->html();
} elseif ($_instance->childHasBeenRendered('mkK5dBi')) {
    $componentId = $_instance->getRenderedChildComponentId('mkK5dBi');
    $componentTag = $_instance->getRenderedChildComponentTagName('mkK5dBi');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('mkK5dBi');
} else {
    $response = \Livewire\Livewire::mount('user.settings.index', ['user' => $user, 'type' => 'profile']);
    $html = $response->html();
    $_instance->logRenderedChild('mkK5dBi', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php endif; ?>

      <?php if(route('user.profile', ['type' => 'api'])==url()->current() && $set->api_resell): ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.settings.index', ['user' => $user, 'type' => 'api', 'settings' => $set])->html();
} elseif ($_instance->childHasBeenRendered('NdZ2d0q')) {
    $componentId = $_instance->getRenderedChildComponentId('NdZ2d0q');
    $componentTag = $_instance->getRenderedChildComponentTagName('NdZ2d0q');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('NdZ2d0q');
} else {
    $response = \Livewire\Livewire::mount('user.settings.index', ['user' => $user, 'type' => 'api', 'settings' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('NdZ2d0q', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php endif; ?>

      <?php if(route('user.profile', ['type' => 'security'])==url()->current()): ?>
      <div class="d-flex flex-stack cursor-pointer mt-6" data-bs-toggle="modal" data-bs-target="#resetpassword">
        <div class="d-flex align-items-center">
          <div class="symbol symbol-45px symbol-circle me-4">
            <div class="symbol-label bg-warning">
              <i class="bi bi-unlock text-dark fs-3"></i>
            </div>
          </div>
          <div class="ps-1">
            <p href="#" class="fs-7 text-gray-800 text-hover-success fw-bold mb-0"><?php echo e(__('Reset Password')); ?></p>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php if(route('user.profile', ['type' => 'notifications'])==url()->current()): ?>
      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.settings.notifications', ['user' => $user])->html();
} elseif ($_instance->childHasBeenRendered('V70Uk5p')) {
    $componentId = $_instance->getRenderedChildComponentId('V70Uk5p');
    $componentTag = $_instance->getRenderedChildComponentTagName('V70Uk5p');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('V70Uk5p');
} else {
    $response = \Livewire\Livewire::mount('user.settings.notifications', ['user' => $user]);
    $html = $response->html();
    $_instance->logRenderedChild('V70Uk5p', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/user/profile/index.blade.php ENDPATH**/ ?>