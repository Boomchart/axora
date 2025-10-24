<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">
                    <?php echo e(__('Transaction Details')); ?>

                </h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="<?php echo e(route('user.dashboard')); ?>" class="text-muted text-hover-info"><?php echo e(__('Dashboard')); ?></a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="<?php echo e(route('user.transactions')); ?>" class="text-muted text-hover-info"><?php echo e(__('Transactions')); ?></a>
                    </li>
                    <li class="breadcrumb-item text-dark"><?php echo e(__('Transaction Details')); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="d-flex align-items-center mb-3 p-3 bg-white rounded-4">
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

                        <?php echo trxDetails(__('Date'), $val->created_at->setTimezone($user->user_timezone)->toDayDateTimeString()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/transactions/details.blade.php ENDPATH**/ ?>