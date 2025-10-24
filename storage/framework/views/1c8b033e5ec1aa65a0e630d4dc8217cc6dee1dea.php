<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-md-8">
                    <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control form-control-solid rounded-4 bg-white" wire:model="search" placeholder="<?php echo e(__('Search audit')); ?>" />
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> <?php echo e(__('Filter')); ?></button>
                    <button data-bs-toggle="modal" data-bs-target="#export" class="btn btn-dark"><i class="bi bi-filetype-csv"></i> <?php echo e(__('Export')); ?></button>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><?php echo e(__('Export Transactions')); ?></h3>
                            <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <form wire:submit.prevent="save">
                            <div class="modal-body">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Email Address')); ?></label>
                                    <input class="form-control form-control-solid" type="email" wire:model="exportEmail" placeholder="name@example.com">
                                    <?php $__errorArgs = ['exportEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-text"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-block btn-info" type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="save"><i class="bi bi-filetype-csv"></i>
                                    <span wire:loading.remove wire:target="save"><?php echo e(__('Export')); ?></span>
                                    <span wire:loading wire:target="save"><?php echo e(__('Exporting file...')); ?></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><?php echo e(__('Filter Audit')); ?></h3>
                            <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Sort by')); ?></label>
                                <select class="form-select form-select-solid" wire:model="orderBy">
                                    <option value="asc"><?php echo e(__('ASC')); ?></option>
                                    <option value="desc"><?php echo e(__('DESC')); ?></option>
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Per page')); ?></label>
                                <select class="form-select form-select-solid" wire:model="perPage">
                                    <option value="10"><?php echo e(__('10')); ?></option>
                                    <option value="25"><?php echo e(__('25')); ?></option>
                                    <option value="50"><?php echo e(__('50')); ?></option>
                                    <option value="100"><?php echo e(__('100')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($audit->count() > 0): ?>
            <div class="card-body" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage">
                <?php $__currentLoopData = $audit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex flex-stack cursor-pointer" id="kt_message_<?php echo e($tt->id); ?>_button">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px symbol-circle me-4">
                            <div class="symbol-label fs-2 fw-bolder text-dark bg-warning">
                                <i class="bi bi-clipboard-data"></i>
                            </div>
                        </div>
                        <div class="ps-1">
                            <p href="#" class="fs-7 text-dark mb-2"><?php echo e(str_replace('_', ' ', ucwords($tt->log))); ?></p>
                            <p href="#" class="fs-7 text-dark mb-2"><?php echo e($tt->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')); ?></p>
                            <?php if($tt->admin_id): ?>
                            <span class="badge badge-danger"><?php echo e($tt?->staff?->first_name.' '.$tt?->staff?->last_name); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if(!$loop->last): ?>
                <hr class="bg-light-border">
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block mt-5"><?php echo e(__('See more')); ?></button>
            </div>
            <?php else: ?>
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-check2-circle text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark fw-bold"><?php echo e(__('No Audit')); ?></h3>
                <p class="text-dark"><?php echo e(__('We couldn\'t find any audit to this account')); ?></p>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    var element = $('#scrollToBottom');
    element.scrollTop(element[0].scrollHeight);

    window.livewire.on('newChat', function() {
        var element = $('#scrollToBottom');
        element.scrollTop(element[0].scrollHeight);
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/users/audit.blade.php ENDPATH**/ ?>