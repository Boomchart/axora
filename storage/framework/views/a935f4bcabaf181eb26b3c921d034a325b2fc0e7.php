<div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.filetypes', ['settings' => $set, 'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('uwRv9vH')) {
    $componentId = $_instance->getRenderedChildComponentId('uwRv9vH');
    $componentTag = $_instance->getRenderedChildComponentTagName('uwRv9vH');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('uwRv9vH');
} else {
    $response = \Livewire\Livewire::mount('admin.filetypes', ['settings' => $set, 'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('uwRv9vH', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <h4 class="text-dark"><?php echo e(__('File Types')); ?></h4>
    <div class="table-responsive">
        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
            <thead>
                <tr class="fw-semibold fs-7">
                    <th class="min-w-20px"><?php echo e(__('S/N')); ?></th>
                    <th class="min-w-250px"><?php echo e(__('Mimes Name')); ?></th>
                    <th class="min-w-250px"><?php echo e(__('Type Type')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = config('mimes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?>.</td>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($val); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/partials/admin/file_types.blade.php ENDPATH**/ ?>