<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">
                    <?php echo e(__('Order Details')); ?>

                </h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="<?php echo e(route('user.dashboard')); ?>" class="text-muted text-hover-info"><?php echo e(__('Dashboard')); ?></a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="<?php echo e(route('user.orders')); ?>" class="text-muted text-hover-info"><?php echo e(__('Orders')); ?></a>
                    </li>
                    <li class="breadcrumb-item text-dark"><?php echo e(__('Order Details')); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <a href="<?php echo e(route('view.transactions', ['transaction' => $val->transaction->ref_id])); ?>" target="_blank">
                <div class="d-flex align-items-center mb-3 p-3 bg-white rounded-4">
                    <div class="symbol symbol-45px symbol-circle me-2">
                        <div class="symbol-label fs-3 fw-bolder bg-dark text-white">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                    </div>
                    <div class="ps-2">
                        <p class="text-dark fw-bold fs-7 mb-0">
                            <?php echo e(__('Transactions Details')); ?>

                        </p>
                    </div>
                </div>
            </a>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-5">
                        <div class="fs-7 d-flex justify-content-between my-4">
                            <div class=""><?php echo e(__('Order ID')); ?></div>
                            <div class="d-flex fw-bold">
                                <?php echo e(substr($val?->id, 0, 15)); ?>...
                                <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="<?php echo e($val->id); ?>" title="<?php echo e(__('Copy')); ?>"></i>
                            </div>
                        </div>
                        <div class="separator separator-dashed"></div>
                        <div class="fs-7 d-flex justify-content-between my-4">
                            <div class=""><?php echo e(__('Order Status')); ?></div>
                            <?php echo $__env->make('partials.transactions.status', ['val' => $val], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="separator separator-dashed"></div>
                        <?php echo trxDetails(__('Amount'), number_format($val->amount, 2).' '.$val->currency); ?>


                        <?php echo trxDetails(__('Gift Card Name'), ucwords($val->card_name).' - '.$val->transaction->card_country); ?>

                        <?php echo trxDetails(__('Customer Name'), $val->name); ?>

                        <?php echo trxDetails(__('Customer Email'), $val->email); ?>

                        <?php echo trxDetails(__('Customer Phone'), $val->phone); ?>

                        <?php echo trxDetails(__('Exchange Rate'), $val->rate.' '.$val->transaction->currency); ?>



                        <?php echo trxDetails(__('Date'), $val->created_at->setTimezone($user->user_timezone)->toDayDateTimeString()); ?>

                    </div>

                    <?php if($val->webhooks->count()): ?>
                    <div class="bg-white rounded-4 border border-secondary p-5">
                        <p class="fs-5 fw-bold mb-5"><?php echo e(__('Webhook Logs')); ?> (<?php echo e(number_format_short($val->webhooks->count())); ?>)</p>
                        <?php $__currentLoopData = $val->webhooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $webhook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row mb-1">
                            <div class="col-6">
                                <h4 class="mb-0 fs-7"><?php echo e(__('UUID')); ?></h4>
                                <p class="text-break"><?php echo e($webhook->uuid); ?></p>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-0 fs-7"><?php echo e(__('Created')); ?></h4>
                                <p class="text-break"><?php echo e($webhook->created_at->setTimezone($user->user_timezone)->toDayDateTimeString()); ?></p>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-0 fs-7"><?php echo e(__('Response')); ?></h4>
                                <p class="text-break"><?php echo e($webhook->response_status_code); ?></p>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-0 fs-7"><?php echo e(__('Attempts')); ?></h4>
                                <p class="text-break"><?php echo e($webhook->attempts); ?></p>
                            </div>
                        </div>
                        <button id="kt_webhook<?php echo e($webhook->id); ?>_button" class="btn btn-dark btn-sm rounded-pill btn-block my-4"><i class="bi bi-code-square"></i> <?php echo e(__('Webhook Details')); ?></button>
                        <div wire:ignore.self id="kt_webhook<?php echo e($webhook->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_webhook<?php echo e($webhook->id); ?>_button" data-kt-drawer-close="#kt_webhook<?php echo e($webhook->id); ?>_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
                            <div class="card w-100">
                                <div class="card-header pe-5 border-0">
                                    <div class="card-title">
                                        <div class="d-flex justify-content-center flex-column me-3">
                                            <div class="fs-5 text-gray-900 text-hover-info me-1 lh-1"><?php echo e(__('Webhook Details')); ?></div>
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                        <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_webhook<?php echo e($webhook->id); ?>_close">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-x-lg fs-2"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body text-wrap">
                                    <div class="text-center mb-3">
                                        <div class="symbol symbol-100px symbol-circle okay mb-5">
                                            <span class="symbol-label bg-secondary text-dark fw-bold fs-1">
                                                <i class="bi bi-code-square text-dark" style="font-size:56px;"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="pb-5 mt-10 position-relative zindex-1">
                                        <div class="row mb-5">
                                            <div class="col-12" wire:ignore>
                                                <p class="mb-1 fs-7"><?php echo e(__('Payload')); ?></p>
                                                <pre class="rounded-4">
                                                        <code class="language-json" style="font-size: 0.85rem !important;" data-lang="json">   
                                                        <?php echo json_encode(json_decode($webhook->payload, true), JSON_PRETTY_PRINT); ?>

                                                        </code>
                                                    </pre>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-12" wire:ignore>
                                                <p class="mb-1 fs-7"><?php echo e(__('Headers')); ?></p>
                                                <pre class="rounded-4">
                                                        <code class="language-json" style="font-size: 0.85rem !important;" data-lang="json">   
                                                        <?php echo json_encode(json_decode($webhook->headers, true), JSON_PRETTY_PRINT); ?>

                                                        </code>
                                                    </pre>
                                            </div>
                                        </div>
                                        <a wire:click="resendWebhook('<?php echo e($webhook->id); ?>')" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="resendWebhook('<?php echo e($webhook->id); ?>')" class="btn btn-block btn-info">
                                            <span wire:loading.remove wire:target="resendWebhook('<?php echo e($webhook->id); ?>')"><?php echo e(__('Resend Webhook')); ?></span>
                                            <span wire:loading wire:target="resendWebhook('<?php echo e($webhook->id); ?>')"><?php echo e(__('Processing Request...')); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(!$loop->last): ?>
                        <hr class="bg-light-border">
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/orders/details.blade.php ENDPATH**/ ?>