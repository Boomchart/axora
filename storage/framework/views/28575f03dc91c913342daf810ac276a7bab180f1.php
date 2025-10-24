<?php $__env->startSection('content'); ?>
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-6"><?php echo e(__('Email/SMS Template')); ?></h1>
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('template.settings', ['type' => 'settings'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-1-tab" href="<?php echo e(route('template.settings', ['type' => 'settings'])); ?>" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><?php echo e(__('Template')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('template.settings', ['type' => 'code'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-1-tab" href="<?php echo e(route('template.settings', ['type' => 'code'])); ?>" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><?php echo e(__('Tags')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php if(route('template.settings', ['type' => 'email-template'])==url()->current()): ?> active <?php endif; ?>" id="tabs-icons-text-2-tab" href="<?php echo e(route('template.settings', ['type' => 'email-template'])); ?>" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><?php echo e(__('Email Messages')); ?></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?php if(route('template.settings', ['type' => 'settings'])==url()->current()): ?>show active <?php endif; ?>" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <div class="card mb-10">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.settings.update', ['type' => 'email_template'])); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <h5><?php echo e(__('Template Configuration')); ?></h5>
                                <div class="fv-row mb-6 mb-6">
                                    <div class="col-lg-12">
                                        <textarea type="text" name="email_template" rows="4" class="form-control tinymce"><?php echo e($set->email_template); ?></textarea>
                                    </div>
                                </div>
                                <div class="text-start">
                                    <button type="submit" class="btn btn-success"><?php echo e(__('Save')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php if(route('template.settings', ['type' => 'code'])==url()->current()): ?>show active <?php endif; ?>" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <div class=" mb-10">
                        <div class="card-body">
                            <p class="fs-7 mb-7"><?php echo e(__('Tags are replaced by software with real data when email or sms is sent to users')); ?></p>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" id="kt_datatable_example_5">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('Tag')); ?></th>
                                            <th><?php echo e(__('DESCRIPTION')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> 1. </td>
                                            <td> &#123;&#123;site_name&#125;&#125; </td>
                                            <td> <?php echo e(__('Website Name')); ?></td>
                                        </tr>
                                        <tr>
                                            <td> 2. </td>
                                            <td> &#123;&#123;unsubscribe&#125;&#125; </td>
                                            <td> <?php echo e(__('Unsubscribe link for promotional emails')); ?></td>
                                        </tr>
                                        <tr>
                                            <td> 3. </td>
                                            <td> &#123;&#123;token&#125;&#125; </td>
                                            <td> <?php echo e(__('Authentication Token')); ?></td>
                                        </tr>
                                        <tr>
                                            <td> 4. </td>
                                            <td> &#123;&#123;reason&#125;&#125; </td>
                                            <td> <?php echo e(__('Transaction or KYC Decline Response')); ?></td>
                                        </tr>
                                        <tr>
                                            <td> 5. </td>
                                            <td> &#123;&#123;first_name&#125;&#125; </td>
                                            <td> <?php echo e(__('User First name')); ?></td>
                                        </tr>
                                        <tr>
                                            <td> 6. </td>
                                            <td> &#123;&#123;last_name&#125;&#125; </td>
                                            <td> <?php echo e(__('User Last name')); ?></td>
                                        </tr>
                                        <tr>
                                            <td> 7. </td>
                                            <td> &#123;&#123;amount&#125;&#125; </td>
                                            <td> <?php echo e(__('Transaction Amount')); ?></td>
                                        </tr>
                                        <tr>
                                            <td> 8. </td>
                                            <td> &#123;&#123;charge&#125;&#125; </td>
                                            <td> <?php echo e(__('Transaction Charge')); ?></td>
                                        </tr>
                                        <tr>
                                            <td> 9. </td>
                                            <td> &#123;&#123;reference&#125;&#125; </td>
                                            <td> <?php echo e(__('Transaction Reference')); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php if(route('template.settings', ['type' => 'email-template'])==url()->current()): ?>show active <?php endif; ?>" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                    <div class="card-body">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.template.index', ['type' => 0, 'settings' => $set, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('hl4wA81')) {
    $componentId = $_instance->getRenderedChildComponentId('hl4wA81');
    $componentTag = $_instance->getRenderedChildComponentTagName('hl4wA81');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('hl4wA81');
} else {
    $response = \Livewire\Livewire::mount('admin.template.index', ['type' => 0, 'settings' => $set, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('hl4wA81', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php if(route('template.settings', ['type' => 'settings'])==url()->current()): ?>
<script src="<?php echo e(asset('asset/tinymce/tinymce.min.js')); ?>"></script>
<script src="<?php echo e(asset('asset/tinymce/init-tinymce.js')); ?>"></script>
<script>
    initializeTinymce('textarea.tinymce');
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/settings/template.blade.php ENDPATH**/ ?>