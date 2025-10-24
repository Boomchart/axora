<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-md-8">
                    <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control form-control-solid rounded-4 bg-white" wire:model="search" placeholder="<?php echo e(__('Search ticket')); ?>" />
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> <?php echo e(__('Filter')); ?></button>
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><?php echo e(__('Filter Ticket')); ?></h3>
                            <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi-x-lg fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Type')); ?></label>
                                <select class="form-select form-select-solid" wire:model="status">
                                    <option value=""><?php echo e(__('All')); ?></option>
                                    <option value="0"><?php echo e(__('Open')); ?></option>
                                    <option value="1"><?php echo e(__('Closed')); ?></option>
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Priority')); ?></label>
                                <select class="form-select form-select-solid" wire:model="priority">
                                    <option value=""><?php echo e(__('All')); ?></option>
                                    <option value="low"><?php echo e(__('Low')); ?></option>
                                    <option value="medium"><?php echo e(__('Medium')); ?></option>
                                    <option value="high"><?php echo e(__('High')); ?></option>
                                </select>
                            </div>
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
            <?php if($ticket->count() > 0): ?>
            <div class="card-body" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage">
                <?php $__currentLoopData = $ticket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex flex-stack cursor-pointer" id="kt_message_<?php echo e($tt->id); ?>_button">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px symbol-circle me-4">
                            <div class="symbol-label fs-2 fw-bolder text-dark bg-warning">
                                <i class="bi bi-clipboard-data"></i>
                            </div>
                        </div>
                        <div class="ps-1">
                            <p href="#" class="fs-7 text-dark text-hover-success fw-bold mb-0"><?php echo e($tt->ticket_id); ?> @ <?php echo e($tt->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')); ?></p>
                            <p href="#" class="fs-7 text-dark mb-1"><?php echo e($tt->subject); ?></p>
                            <?php if($tt->status == 0): ?>
                            <span class="badge badge-sm badge-success"><?php echo e(__('Open')); ?> </span>
                            <?php else: ?>
                            <span class="badge badge-sm badge-danger"><?php echo e(__('Closed')); ?> </span>
                            <?php endif; ?>
                            <span class="badge badge-sm badge-secondary"><?php echo e(__('Priority: ').ucwords($tt->priority)); ?></span>
                            <?php if($tt->files != null): ?>
                            <span class="badge badge-sm badge-secondary"><i class="fal fa-paperclip"></i> Attachment</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button class="btn btn-whitelabel text-dark rounded-pill btn-sm px-5"><?php echo e(__('Details')); ?></button>
                </div>
                <div><?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.ticket.admin-reply', ['val' => $tt,'admin' => $admin,'settings' => $set])->html();
} elseif ($_instance->childHasBeenRendered($tt->id)) {
    $componentId = $_instance->getRenderedChildComponentId($tt->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($tt->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($tt->id);
} else {
    $response = \Livewire\Livewire::mount('admin.ticket.admin-reply', ['val' => $tt,'admin' => $admin,'settings' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild($tt->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></livewire:admin.ticket.admin-reply></div>
                <?php if(!$loop->last): ?>
                <hr class="bg-light-border">
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($ticket->total() > 0 && $ticket->count() < $ticket->total()): ?><button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block"><?php echo e(__('See more')); ?></button><?php endif; ?>
            </div>
            <?php else: ?>
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-check2-circle text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark fw-bold"><?php echo e(__('No Ticket')); ?></h3>
                <p class="text-dark"><?php echo e(__('We couldn\'t find any ticket to this account')); ?></p>
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
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/users/ticket.blade.php ENDPATH**/ ?>