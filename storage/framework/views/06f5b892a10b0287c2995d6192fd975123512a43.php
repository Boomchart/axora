<div>
    <?php $__currentLoopData = $template; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="d-flex flex-stack cursor-pointer" id="kt_edit_<?php echo e($val->id); ?>_button">
        <div class="d-flex align-items-center">
            <div class="symbol symbol-45px symbol-circle me-4">
                <div class="symbol-label fs-2 fw-bolder text-dark bg-warning">
                    <i class="bi bi-file-richtext text-dark" style='font-size:20px;'></i>
                </div>
            </div>
            <div class="ps-1">
                <p href="#" class="fs-7 text-dark mb-0"><?php echo e(ucwords(str_replace('_', ' ', $val->type))); ?></p>
                <p href="#" class="fs-7 text-dark mb-0"><?php echo e(__('Allowed Tags')); ?>: <?php $__currentLoopData = explode(',', $val->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tags): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <span class="badge badge-dark badge-sm"><?php echo e($tags); ?></span> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></p>
                <p href="#" class="fs-7 text-dark"><?php echo e(__('Updated at')); ?>: <?php echo e($val->updated_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')); ?></p>
            </div>
        </div>
        <button class="btn btn-whitelabel text-dark rounded-pill btn-sm px-5"><i class="bi bi-pen"></i> <?php echo e(__('Edit')); ?></button>
    </div>
    <?php if(!$loop->last): ?>
    <hr class="bg-light-border">
    <?php endif; ?>
    <div><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.template.edit', ['val' => $val])->html();
} elseif ($_instance->childHasBeenRendered('kt_edit_'. $val->id)) {
    $componentId = $_instance->getRenderedChildComponentId('kt_edit_'. $val->id);
    $componentTag = $_instance->getRenderedChildComponentTagName('kt_edit_'. $val->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kt_edit_'. $val->id);
} else {
    $response = \Livewire\Livewire::mount('admin.template.edit', ['val' => $val]);
    $html = $response->html();
    $_instance->logRenderedChild('kt_edit_'. $val->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></livewire:admin.template.edit></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/template/index.blade.php ENDPATH**/ ?>