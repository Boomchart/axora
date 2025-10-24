<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2"><?php echo e(__('Support')); ?></h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="<?php echo e(route('user.dashboard')); ?>" class="text-muted text-hover-success"><?php echo e(__('Dashboard')); ?></a>
                    </li>
                    <li class="breadcrumb-item text-dark"><?php echo e(__('Tickets')); ?></li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> <?php echo e(__('Filter')); ?></button>
                <button id="kt_ticket_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> <?php echo e(__('Open Ticket')); ?></button>
                <div wire:ignore.self id="kt_ticket" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_ticket_button" data-kt-drawer-close="#kt_ticket_close" data-kt-drawer-width="{'md': '500px'}">
                    <div class="card w-100">
                        <div class="card-header pe-5 border-0">
                            <div class="card-title">
                                <div class="d-flex justify-content-center flex-column me-3">
                                    <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Open Ticket')); ?></div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_ticket_close">
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-x-lg fs-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-wrap">
                            <div class="btn-wrapper text-center mb-3">
                                <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                                    <div class="symbol-label fs-1 bg-danger">
                                        <i class="bi bi-chat-square-text text-white" style="font-size:54px;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="pb-5 position-relative zindex-1">
                                <form class="form w-100 mb-10" wire:submit.prevent="addTicket" method="post">
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7"><?php echo e(__('Title')); ?></label>
                                        <input class="form-control form-control-solid" type="text" wire:model="subject" required placeholder="<?php echo e(__('Title of complaint')); ?>" />
                                        <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="form-text text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7"><?php echo e(__('Priority')); ?></label>
                                        <select class="form-select form-select-solid" wire:model="selectPriority" required>
                                            <option value="low"><?php echo e(__('Low')); ?></option>
                                            <option value="medium"><?php echo e(__('Medium')); ?></option>
                                            <option value="high"><?php echo e(__('High')); ?></option>
                                        </select>
                                        <?php $__errorArgs = ['selectPriority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="form-text text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7"><?php echo e(__('Description')); ?></label>
                                        <textarea class="form-control form-control-solid preserveLines" rows="6" type="text" wire:model="details" required placeholder="Whats your complaint?"></textarea>
                                        <?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="form-text text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="form-label text-dark fs-7"><?php echo e(__('Attachment - Optional')); ?></label>
                                        <input class="form-control form-control-solid" type="file" wire:model="files" id="files" multiple />
                                        <div wire:loading wire:target="files"><?php echo e(__('Uploading')); ?>...</div>
                                        <?php $__errorArgs = ['files.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="form-text text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="text-center mt-10">
                                        <button type="submit" class="btn btn-dark btn-block me-3 my-2" wire:loading.attr="disabled" wire:target="files">
                                            <span wire:loading.remove wire:target="addTicket"><?php echo e(__('Submit Ticket')); ?></span>
                                            <span wire:loading wire:target="addTicket"><?php echo e(__('Processing Request...')); ?></span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
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
                <div class="col-lg-12 col-md-12">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="col-md-12">
                            <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control form-control-solid bg-white rounded-4" wire:model="search" placeholder="<?php echo e(__('Search')); ?>" />
                            </div>
                        </div>
                    </div>
                    <?php if($ticket->count() > 0): ?>
                    <div class="card-body" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage">
                        <?php $__currentLoopData = $ticket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex flex-stack cursor-pointer" id="kt_message_<?php echo e($tt->id); ?>_button">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px symbol-circle me-4">
                                    <div class="symbol-label fs-2 bg-danger">
                                        <i class="bi bi-chat-square-text text-white"></i>
                                    </div>
                                </div>
                                <div class="ps-1">
                                    <p class="fs-7 text-dark fw-bold mb-0"><?php echo e($tt->ticket_id); ?></p>
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
                            <div class="symbol symbol-50px symbol-circle me-3 cursor-pointer" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Settings')); ?>">
                                <span class="symbol-label bg-white fw-bold fs-4">
                                    <i class="bi bi-caret-down-square text-dark fs-2"></i>
                                </span>
                            </div>
                        </div>
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.ticket.reply', ['val' => $tt,'user' => $user,'settings' => $set])->html();
} elseif ($_instance->childHasBeenRendered('kt_message_'. $tt->id)) {
    $componentId = $_instance->getRenderedChildComponentId('kt_message_'. $tt->id);
    $componentTag = $_instance->getRenderedChildComponentTagName('kt_message_'. $tt->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kt_message_'. $tt->id);
} else {
    $response = \Livewire\Livewire::mount('user.ticket.reply', ['val' => $tt,'user' => $user,'settings' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('kt_message_'. $tt->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></livewire:user.ticket.reply>
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
                                <i class="bi bi-chat-square-text" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark fw-bold"><?php echo e(__('No Ticket')); ?></h3>
                            <p class="text-dark"><?php echo e(($search) ? __('We couldn\'t find').' "'.$search.'" '.__('Try again?') : __('Create a Support Ticket')); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    var element = $('#scrollToBottom');
    element.scrollTop(element[0].scrollHeight);

    window.livewire.on('newChat', function() {
        document.getElementById('files').value = null;
        var element = $('#scrollToBottom');
        element.scrollTop(element[0].scrollHeight);
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/ticket/index.blade.php ENDPATH**/ ?>