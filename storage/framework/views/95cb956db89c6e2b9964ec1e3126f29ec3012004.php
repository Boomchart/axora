<?php $__env->startSection('content'); ?>
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-10"><?php echo e(__('Settings')); ?></h1>
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'system'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-1-tab" href="<?php echo e(route('admin.settings', ['type' => 'system'])); ?>" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><?php echo e(__('General Settings')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'security'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('admin.settings', ['type' => 'security'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Security')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'deposit'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('admin.settings', ['type' => 'deposit'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Deposit')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'payout'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('admin.settings', ['type' => 'payout'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Withdrawal')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'country'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-1-tab" href="<?php echo e(route('admin.settings', ['type' => 'country'])); ?>" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><?php echo e(__('Country supported')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'policies'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('admin.settings', ['type' => 'policies'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Legal Policies')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'logo'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('admin.settings', ['type' => 'logo'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Logos & favicon')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'regtype'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('admin.settings', ['type' => 'regtype'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Business Registration Types')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'mcc'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('admin.settings', ['type' => 'mcc'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Business MCC')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('admin.settings', ['type' => 'file_types'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('admin.settings', ['type' => 'file_types'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('File Types')); ?></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                <?php if(route('admin.settings', ['type' => 'payout'])==url()->current()): ?>
                <?php echo $__env->make('partials.admin.withdraw', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'system'])==url()->current()): ?>
                <?php echo $__env->make('partials.admin.general', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'country'])==url()->current()): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.country.index', ['settings' => $set, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('jGlQPKg')) {
    $componentId = $_instance->getRenderedChildComponentId('jGlQPKg');
    $componentTag = $_instance->getRenderedChildComponentTagName('jGlQPKg');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('jGlQPKg');
} else {
    $response = \Livewire\Livewire::mount('admin.country.index', ['settings' => $set, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('jGlQPKg', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'security'])==url()->current()): ?>
                <?php echo $__env->make('partials.admin.security', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'policies'])==url()->current()): ?>
                <?php echo $__env->make('partials.admin.policy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'logo'])==url()->current()): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.logo.index', ['settings' => $set, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('voSDRM7')) {
    $componentId = $_instance->getRenderedChildComponentId('voSDRM7');
    $componentTag = $_instance->getRenderedChildComponentTagName('voSDRM7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('voSDRM7');
} else {
    $response = \Livewire\Livewire::mount('admin.logo.index', ['settings' => $set, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('voSDRM7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'regtype'])==url()->current()): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.regtype.index', ['settings' => $set, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('u2jUXui')) {
    $componentId = $_instance->getRenderedChildComponentId('u2jUXui');
    $componentTag = $_instance->getRenderedChildComponentTagName('u2jUXui');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('u2jUXui');
} else {
    $response = \Livewire\Livewire::mount('admin.regtype.index', ['settings' => $set, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('u2jUXui', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'mcc'])==url()->current()): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.mcc.index', ['settings' => $set, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('xd8i5N8')) {
    $componentId = $_instance->getRenderedChildComponentId('xd8i5N8');
    $componentTag = $_instance->getRenderedChildComponentTagName('xd8i5N8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('xd8i5N8');
} else {
    $response = \Livewire\Livewire::mount('admin.mcc.index', ['settings' => $set, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('xd8i5N8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'file_types'])==url()->current()): ?>
                <?php echo $__env->make('partials.admin.file_types', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if(route('admin.settings', ['type' => 'deposit'])==url()->current()): ?>
                <?php echo $__env->make('partials.admin.deposit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php if(route('admin.settings', ['type' => 'policies'])==url()->current()): ?>
<script src="<?php echo e(asset('asset/tinymce/tinymce.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/tinymce/init-tinymce.js')); ?>"></script>
<script>
    initializeTinymce('textarea.tinymce');
</script>
<?php endif; ?>

<?php if(route('admin.settings', ['type' => 'security'])==url()->current() || route('admin.settings', ['type' => 'system'])==url()->current()): ?>
<script>
    var input1 = document.querySelector("#kt_tagify_1");
    new Tagify(input1);
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>