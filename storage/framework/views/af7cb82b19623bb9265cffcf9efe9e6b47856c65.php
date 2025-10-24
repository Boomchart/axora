<div>
    <div wire:ignore.self id="kt_message_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_message_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_message_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-danger me-1 lh-1"><?php echo e(__('Manage Ticket')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_message_<?php echo e($val->id); ?>_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <?php if($val?->business?->watchlist == 1): ?>
                    <div class="card bg-danger mb-6">
                        <div class="d-flex align-items-center p-3">
                            <div class="symbol symbol-40px me-4">
                                <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                                    <i class="bi bi-bell-slash-fill text-dark"></i>
                                </div>
                            </div>
                            <div class="ps-1">
                                <p class="fs-7 text-white text-hover-danger fw-bold mb-0"><?php echo e($val?->business?->name); ?> <?php echo e(__('is on watchlist')); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="bg-light-primary px-6 py-5 mb-10 rounded" wire:ignore>
                        <p class="text-dark fs-7 mb-0"><?php echo e(__('Ticket ID')); ?>: <?php echo e($val->ticket_id); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="<?php echo e($val->ticket_id); ?>" title="<?php echo e(__('Copy')); ?>"></i></p>
                        <p class="text-dark fs-7 mb-0"><?php echo e(__('Subject')); ?>: <?php echo e($val->subject); ?></p>
                        <p class="text-dark fs-7 mb-2"><?php echo e(__('Created')); ?>: <?php echo e($val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')); ?></p>
                        <?php if($val->files != null): ?>
                        <div class="symbol-group symbol-hover mt-3 mb-3">
                            <?php $__currentLoopData = explode(',', $val->files); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(url('/').'/storage/app/'.$files); ?>" target="_blank">
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip">
                                    <span class="symbol-label bg-warning text-dark fw-bold">
                                        <i class="bi bi-file-text fs-2 text-dark"></i>
                                    </span>
                                </div>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>
                        <?php if($val->status == 0): ?>
                        <a href="#" class="btn btn-danger btn-block btn-sm rounded-pill" wire:click="close"><i class="bi bi-check2-circle"></i> <?php echo e(__('Close Ticket')); ?></a>
                        <?php else: ?>
                        <a href="#" class="btn btn-success btn-block btn-sm rounded-pill" wire:click="open"><i class="bi bi-check2-circle"></i> <?php echo e(__('Re-Open Ticket')); ?></a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('user.manage', ['client' => $val->user_id, 'type' => 'details'])); ?>" class="btn btn-dark btn-block mt-5"><?php echo e(__('Manage Account')); ?></a>
                    </div>
                    <div class="card-body" id="kt_chat_messenger_body" wire:poll.visible>
                        <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" id="scrollToBottom" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px" style="max-height: 266px;">
                            <div class="d-flex justify-content-start mb-10">
                                <div class="d-flex flex-column align-items-start">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-3">
                                            <span class="text-muted fs-8 mb-1"><?php echo e($val->created_at->setTimezone($admin->timezone)->diffForHumans()); ?></span>
                                            <a href="#" class="fs-7 fw-bold text-gray-900 text-hover-danger me-1"><?php echo e($val?->business?->name); ?></a>
                                        </div>
                                        <div class="symbol symbol-50px symbol-circle">
                                            <div class="symbol-label fs-7 fw-bold text-dark bg-light-warning"><?php echo e(strtoupper(substr($val?->business?->name, 0, 2))); ?></div>
                                        </div>
                                    </div>
                                    <div class="p-3 rounded text-dark mw-lg-400px text-start preserveLines bg-light-warning" data-kt-element="message-text"><?php echo e($val->message); ?></div>
                                </div>
                            </div>
                            <?php if($val->reply->count()>0): ?>
                            <?php $__currentLoopData = $val->reply; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex <?php echo e(($reply->status == 1) ? 'justify-content-end' : 'justify-content-start'); ?> mb-10">
                                <div class="d-flex flex-column <?php echo e(($reply->status == 1) ? 'align-items-end' : 'align-items-start'); ?>">
                                    <div class="d-flex align-items-center mb-2">
                                        <?php if($reply->status == 0): ?>
                                        <div class="me-3">
                                            <span class="text-muted fs-8 mb-1"><?php echo e($val->created_at->setTimezone($admin->timezone)->diffForHumans()); ?></span>
                                            <a href="#" class="fs-7 fw-bold text-gray-900 text-hover-danger me-1"><?php echo e($val?->business?->name); ?></a>
                                        </div>
                                        <div class="symbol symbol-50px symbol-circle">
                                            <div class="symbol-label fs-7 fw-bold text-dark bg-light-warning"><?php echo e(strtoupper(substr($val?->business?->name, 0, 2))); ?></div>
                                        </div>
                                        <?php else: ?>
                                        <div class="me-3">
                                            <a href="#" class="fs-7 fw-bold text-gray-900 text-hover-danger ms-1"><?php echo e($reply?->staff?->first_name.' '.$reply?->staff?->last_name); ?></a>
                                            <span class="text-muted fs-7 mb-1"><?php echo e($val->created_at->setTimezone($admin->timezone)->diffForHumans()); ?></span>
                                        </div>
                                        <div class="symbol symbol-50px symbol-circle">
                                            <div class="symbol-label fs-7 fw-bold text-dark bg-light-primary"><i class="bi bi-bank"></i></div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-3 rounded text-dark mw-lg-400px preserveLines text-start <?php echo e(($reply->status == 0) ? 'bg-light-warning' : 'bg-light-primary'); ?>" data-kt-element="message-text"><?php echo e($reply->reply); ?></div>
                                    <?php if($reply->status == 0): ?>
                                    <?php if($reply->files != null): ?>
                                    <div class="symbol-group symbol-hover mt-n2">
                                        <?php $__currentLoopData = explode(',', $reply->files); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(url('/').'/storage/app/'.$files); ?>" target="_blank">
                                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip">
                                                <span class="symbol-label bg-warning text-dark fw-bold">
                                                    <i class="bi bi-file-text fs-2 text-dark"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($val->status == 0): ?>
                    <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                        <form class="form w-100 mb-10" wire:submit.prevent="reply" method="post">
                            <textarea class="form-control form-control-flush mb-3 preserveLines" rows="8" wire:model.defer="message" placeholder="Type a message" required></textarea>
                            <button class="btn btn-success btn-block" type="submit">
                                <span wire:loading.remove wire:target="reply"><?php echo e(__('Send')); ?></span>
                                <span wire:loading wire:target="reply"><?php echo e(__('Replying ticket...')); ?></span>
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/ticket/admin-reply.blade.php ENDPATH**/ ?>