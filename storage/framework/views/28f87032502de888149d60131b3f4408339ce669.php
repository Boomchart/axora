<div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Filter Messages')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7"><?php echo e(__('Sort by')); ?></label>
                        <select class="form-select form-select-solid" wire:model="sortBy">
                            <option value="asc"><?php echo e(__('ASC')); ?></option>
                            <option value="desc"><?php echo e(__('DESC')); ?></option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7"><?php echo e(__('Order by')); ?></label>
                        <select class="form-select form-select-solid" wire:model="orderBy">
                            <option value="created_at"><?php echo e(__('Date')); ?></option>
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
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-md-4">
                    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                        <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="search" class="form-control form-control-solid bg-white rounded-4" wire:model="search" placeholder="<?php echo e(__('Search messages')); ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-md-8 text-end">
                    <button wire:click="markAll(0)" disabled id="unreadAll" class="btn btn-white text-dark me-4"><i class="bi bi-hand-thumbs-up"></i> <?php echo e(__('Unread')); ?></button>
                    <button wire:click="markAll(1)" disabled id="readAll" class="btn btn-white text-dark me-4"><i class="bi bi-hand-thumbs-up"></i> <?php echo e(__('Read all')); ?></button>
                    <button data-bs-toggle="modal" data-bs-target="#deleteall" disabled id="deleteAll" class="btn btn-danger me-4"><i class="fal fa-trash"></i> <?php echo e(__('Delete')); ?></button>
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-dark me-4"><i class="bi bi-filter"></i> <?php echo e(__('Filter')); ?></button>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><?php echo e(__('Delete Message')); ?></h3>
                            <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this?</p>
                            <div class="text-center">
                                <a wire:click="deleteAll" class="btn btn-danger btn-block"><?php echo e(__('Delete')); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($message->count() > 0): ?>
            <div class="table-responsive">
                <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                    <thead>
                        <tr class="fw-semibold fs-7">
                            <th>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="all" wire:model="all" wire:click="setAll" />
                                </div>
                            </th>
                            <th class="min-w-20px"><?php echo e(__('S/N')); ?></th>
                            <th class="min-w-100px"><?php echo e(__('Name')); ?></th>
                            <th class="min-w-250px"><?php echo e(__('Subject')); ?></th>
                            <th class="min-w-50px"><?php echo e(__('Read')); ?></th>
                            <th class="min-w-200px"><?php echo e(__('Created')); ?></th>
                            <th class="scope"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="fw-semibold fs-7">
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="check<?php echo e($val->id); ?>" wire:model="archive.<?php echo e($val->id); ?>" wire:click="checked" />
                                </div>
                            </td>
                            <td><?php echo e($loop->iteration); ?>.</td>
                            <td><?php echo e($val->first_name.' '.$val->last_name); ?></td>
                            <td><?php echo e(substr($val->subject, 0, 60)); ?>...</td>
                            <td>
                                <?php if($val->seen==0): ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('Unread')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('Read')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')); ?></td>
                            <td class="text-center">
                                <button id="kt_message_<?php echo e($val->id); ?>_button" class="btn btn-sm btn-whitelabel rounded-pill">Details</button>
                            </td>
                        </tr>
                        <div><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.message.message', ['val' => $val,'type' => $type,'admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('kt_message_'. $val->id)) {
    $componentId = $_instance->getRenderedChildComponentId('kt_message_'. $val->id);
    $componentTag = $_instance->getRenderedChildComponentTagName('kt_message_'. $val->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kt_message_'. $val->id);
} else {
    $response = \Livewire\Livewire::mount('admin.message.message', ['val' => $val,'type' => $type,'admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('kt_message_'. $val->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></livewire:admin.message.message></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if($message->total() > 0 && $message->count() < $message->total()): ?><button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block"><?php echo e(__('See more')); ?></button><?php endif; ?>
            </div>
            <?php else: ?>
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-inbox text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark fw-bold"><?php echo e(__('No Message Found')); ?></h3>
                <p class="text-dark"><?php echo e(__('We couldn\'t find any message in your inbox')); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    window.livewire.on('clearMarkAll', function() {
        $('#add').val(0);
    });
    window.livewire.on('updatemarked', function(data) {
        $('#unreadAll').attr('disabled', (data == 1) ? false : true);
        $('#readAll').attr('disabled', (data == 1) ? false : true);
        $('#deleteAll').attr('disabled', (data == 1) ? false : true);
    });
</script>
<?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script>
    $(document).on('click', '#readMore<?php echo e($val->id); ?>', function(e) {
        e.preventDefault();
        $('#main-data<?php echo e($val->id); ?>').hide();
        $('#main-data-hide<?php echo e($val->id); ?>').show();
    });
    $(document).on('click', '#readLess<?php echo e($val->id); ?>', function(e) {
        e.preventDefault();
        $('#main-data<?php echo e($val->id); ?>').show();
        $('#main-data-hide<?php echo e($val->id); ?>').hide();
    });
</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/message/inbox.blade.php ENDPATH**/ ?>