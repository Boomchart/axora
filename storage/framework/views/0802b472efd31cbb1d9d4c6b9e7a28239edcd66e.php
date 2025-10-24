<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">
                    <?php echo e(__('Transaction Details')); ?>

                </h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-muted text-hover-info"><?php echo e(__('Dashboard')); ?></a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="<?php echo e(route('admin.transactions')); ?>" class="text-muted text-hover-info"><?php echo e(__('Transactions')); ?></a>
                    </li>
                    <li class="breadcrumb-item text-dark"><?php echo e(__('Transaction Details')); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="d-flex align-items-center mb-5 p-3 bg-white rounded-4">
                <div class="symbol symbol-45px symbol-circle me-2">
                    <div class="symbol-label fs-3 fw-bolder bg-dark text-white">
                        <?php if($val->trx_type == 'debit'): ?>
                        <i class="bi bi-dash-lg"></i>
                        <?php else: ?>
                        <i class="bi bi-plus-lg"></i>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="ps-2">
                    <p class="text-dark fw-bold fs-7 mb-0">
                        <?php echo e(ucwords(str_replace('_', ' ', $val->type))); ?>

                    </p>
                </div>
            </div>
            <?php if($val->business->watchlist == 1): ?>
            <div class="card bg-danger mb-5">
                <div class="d-flex align-items-center p-3">
                    <div class="symbol symbol-45px me-4">
                        <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                            <i class="bi bi-bell-slash-fill text-dark"></i>
                        </div>
                    </div>
                    <div class="ps-1">
                        <p class="fs-7 text-white fw-bold mb-0"><?php echo e($val->business->name); ?> <?php echo e(__('is on watchlist')); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if($val->image != null): ?>
            <div class="card bg-secondary mb-5">
                <a href="<?php echo e(getPublicImage($val?->image)); ?>" target="_blank">
                    <div class="d-flex align-items-center p-3">
                        <div class="symbol symbol-45px me-4">
                            <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                                <i class="bi bi-receipt text-dark"></i>
                            </div>
                        </div>
                        <div class="ps-1">
                            <p class="fs-7 text-dark fw-bold mb-0"><?php echo e(__('View receipt')); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <div class="fs-7 d-flex justify-content-between my-4">
                            <div class=""><?php echo e(__('Transaction Reference')); ?></div>
                            <div class="d-flex fw-bold">
                                <?php echo e(substr($val?->ref_id, 0, 15)); ?>...
                                <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="<?php echo e($val->ref_id); ?>" title="<?php echo e(__('Copy')); ?>"></i>
                            </div>
                        </div>
                        <div class="separator separator-dashed"></div>
                        <div class="fs-7 d-flex justify-content-between my-4">
                            <div class=""><?php echo e(__('Transaction Status')); ?></div>
                            <?php echo $__env->make('partials.transactions.status', ['val' => $val], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <div class="separator separator-dashed"></div>
                        <?php echo trxDetails(__('Amount'), number_format($val->amount, 2).' '.$val->currency); ?>

                        <?php echo trxDetails(__('Charge'), number_format($val->charge, 2).' '.$val->currency); ?>

                        <?php echo trxDetails(__('Total'), number_format($val->amount + $val->charge, 2).' '.$val->currency); ?>


                        <?php if($val->type == 'giftcard_purchase'): ?>
                        <?php echo trxDetails(__('Gift Card Name'), ucwords($val->card_name).' - '.$val->card_country); ?>

                        <?php echo trxDetails(__('Gift Card Quantity'), $val->quantity); ?>

                        <?php echo trxDetails(__('Gift Card Amount'), $val->card_amount.' '.$val->card_currency); ?>

                        <?php echo trxDetails(__('Customer Name'), $val->name); ?>

                        <?php echo trxDetails(__('Customer Email'), $val->email); ?>

                        <?php echo trxDetails(__('Customer Phone'), \Propaganistas\LaravelPhone\PhoneNumber::make($val->phone, strtoupper($val->phone_code))); ?>

                        <?php echo trxDetails(__('Exchange Rate'), $val->rate.' '.$val->currency); ?>

                        <?php endif; ?>

                        <?php if($val->type == 'agent_payment'): ?>
                        <?php $agentTrx = $val->agentTransaction; ?>
                        <?php echo trxDetails(__('Merchant Name'), $agentTrx->business->name); ?>

                        <?php echo trxDetails(__('Gift Card Name'), ucwords($agentTrx->card_name).' - '.$agentTrx->card_country); ?>

                        <?php echo trxDetails(__('Gift Card Amount'), $agentTrx->card_amount.' '.$agentTrx->card_currency); ?>

                        <?php endif; ?>

                        <?php if($val->type == 'deposit'): ?>
                        <?php echo trxDetails(__('Payment Method'), $val->gateway->name); ?>

                        <?php endif; ?>

                        <?php if($val->type == 'payout'): ?>
                        <?php echo trxDetails(__('Payment Method'), $val->withdrawMethod->name); ?>

                        <?php echo trxDetails(__('Details'), $val->details); ?>

                        <?php endif; ?>

                        <?php if($val->type == 'bank_transfer'): ?>
                        <?php echo trxDetails(__('Bank Reference'), $val->bank_reference); ?>

                        <?php endif; ?>

                        <?php if($val->status == "declined"): ?>
                        <?php echo trxDetails(__('Decline Reason'), $val->decline_reason); ?>

                        <?php endif; ?>

                        <?php if($val->staff_id): ?>
                        <?php echo trxDetails(__('Edited by'), $val->staff->first_name.' '.$val->staff->last_name); ?>

                        <?php endif; ?>

                        <?php echo trxDetails(__('Date'), $val->created_at->setTimezone($admin->timezone)->toDayDateTimeString()); ?>


                        <a href="<?php echo e(route('user.manage', ['client' => $val->user_id, 'type' => 'details'])); ?>" class="btn btn-whitelabel btn-block mt-5" target="_blank"><?php echo e(__('Manage Account')); ?></a>

                        <?php if($val->type == 'deposit'): ?>
                        <div>
                            <?php if($val->status == "pending"): ?>
                            <button class="btn btn-success btn-block mt-5" wire:click="approveDeposit"><i class="bi bi-check2-circle"></i>
                                <span wire:loading.remove wire:target="approveDeposit"><?php echo e(__('Approve Deposit')); ?></span>
                                <span wire:loading wire:target="approveDeposit"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                            <button class="btn btn-secondary btn-block mt-5" id="kt_decline_<?php echo e($val->id); ?>_button"><i class="bi bi-ban"></i> <?php echo e(__('Decline Deposit')); ?></button>
                            <?php endif; ?>
                            <div wire:ignore.self id="kt_decline_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_decline_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_decline_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{'md': '500px'}">
                                <div class="card w-100">
                                    <div class="card-header pe-5 border-0">
                                        <div class="card-title">
                                            <div class="d-flex justify-content-center flex-column me-3">
                                                <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Deposit')); ?></div>
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_decline_close">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="bi bi-x-lg fs-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-wrap">
                                        <div class="btn-wrapper text-center mb-3">
                                            <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                                                <div class="symbol-label fs-1 text-dark">
                                                    <i class="bi bi-ban fa-2x"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark fs-7 fw-bold"><?php echo e(__('Decline Deposit Request')); ?></p>
                                        </div>
                                        <div class="pb-5 mt-10 position-relative zindex-1">
                                            <form class="form w-100 mb-10" wire:submit.prevent="declineDeposit">
                                                <div class="fv-row mb-6">
                                                    <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="reason" required placeholder="<?php echo e(__('Give a reason for Deposit decline')); ?>"></textarea>
                                                    <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="form-text"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="text-center mt-10">
                                                    <button type="submit" class="btn btn-danger btn-block my-2" wire:loading.attr="disabled" wire:click.prevent="declineDeposit">
                                                        <span wire:loading.remove wire:target="declineDeposit"><?php echo e(__('Decline Transaction')); ?></span>
                                                        <span wire:loading wire:target="declineDeposit"><?php echo e(__('Processing Request...')); ?></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($val->type == 'payout'): ?>
                        <div>
                            <?php if($val->status == "pending"): ?>
                            <button class="btn btn-success btn-block mt-5" wire:click="approvePayout"><i class="bi bi-check2-circle"></i>
                                <span wire:loading.remove wire:target="approvePayout"><?php echo e(__('Approve Payout')); ?></span>
                                <span wire:loading wire:target="approvePayout"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                            <button class="btn btn-secondary btn-block mt-5" id="kt_decline_<?php echo e($val->id); ?>_button"><i class="bi bi-ban"></i> <?php echo e(__('Decline Payout')); ?></button>
                            <?php endif; ?>
                            <div wire:ignore.self id="kt_decline_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_decline_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_decline_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{'md': '500px'}">
                                <div class="card w-100">
                                    <div class="card-header pe-5 border-0">
                                        <div class="card-title">
                                            <div class="d-flex justify-content-center flex-column me-3">
                                                <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Payout')); ?></div>
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_decline_close">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="bi bi-x-lg fs-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-wrap">
                                        <div class="btn-wrapper text-center mb-3">
                                            <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                                                <div class="symbol-label fs-1 text-dark">
                                                    <i class="bi bi-ban fa-2x"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark fs-7 fw-bold"><?php echo e(__('Decline Payout Request')); ?></p>
                                        </div>
                                        <div class="pb-5 mt-10 position-relative zindex-1">
                                            <form class="form w-100 mb-10" wire:submit.prevent="declinePayout">
                                                <div class="fv-row mb-6">
                                                    <textarea class="form-control form-control-solid" rows="8" type="text" wire:model.defer="reason" required placeholder="<?php echo e(__('Give a reason for Payout decline')); ?>"></textarea>
                                                    <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="form-text"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="text-center mt-10">
                                                    <button type="submit" class="btn btn-danger btn-block my-2" wire:loading.attr="disabled" wire:click.prevent="declinePayout">
                                                        <span wire:loading.remove wire:target="declinePayout"><?php echo e(__('Decline Transaction')); ?></span>
                                                        <span wire:loading wire:target="declinePayout"><?php echo e(__('Processing Request...')); ?></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/transactions/details.blade.php ENDPATH**/ ?>