<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post" wire:loading.class.delay="opacity-50" wire:target="approveKYC">
        <div class="container">
            <div class="row g-6 g-xl-9">
                <div class="col-md-12">
                    <div class="card h-100 rounded-5">
                        <div class="card-body p-9">
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Account ID')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->business_id); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Country')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->getCountry()->name); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('KYC Status')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->business->kyc_status); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Email address')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->email); ?> <?php if($client->email_verify == 1): ?> <span class="badge badge-success badge-sm"><?php echo e(__('Verified')); ?></span> <?php else: ?> <span class="badge badge-danger badge-sm"><?php echo e(__('Unverified')); ?></span> <?php endif; ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Mobile')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->phone); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('IP Address')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->ip_address); ?> </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('2FA Security')); ?></div>
                                    <div class="ms-auto text-dark"> <?php if($client->fa_status == 1): ?> <span class="badge badge-success badge-sm"><?php echo e(__('Enabled')); ?></span> <?php else: ?> <span class="badge badge-danger badge-sm"><?php echo e(__('Disabled')); ?></span> <?php endif; ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Account Status')); ?></div>
                                    <div class="ms-auto text-dark"> <?php if($client->status == 0): ?> <span class="badge badge-success badge-sm"><?php echo e(__('Active')); ?></span> <?php else: ?> <span class="badge badge-danger badge-sm"><?php echo e(__('Blocked')); ?></span> <?php endif; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card h-100 rounded-5 bg-success text-warning">
                        <div class="card-body p-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fs-2hx fw-bold"><?php echo e(number_format($client->userFunds(), 2).' '.$currency->currency); ?></div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button id="kt_balance_button" class="btn btn-white me-3"><i class="bi bi-pen"></i> <?php echo e(__('Edit Balance')); ?></button>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div wire:ignore.self id="kt_balance" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_balance_button" data-kt-drawer-close="#kt_balance_close" data-kt-drawer-width="{'md': '500px'}">
                                    <div class="card w-100">
                                        <div class="card-header pe-5 border-0">
                                            <div class="card-title">
                                                <div class="d-flex justify-content-center flex-column me-3">
                                                    <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Edit Balance')); ?></div>
                                                </div>
                                            </div>
                                            <div class="card-toolbar">
                                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_balance_close">
                                                    <span class="svg-icon svg-icon-2">
                                                        <i class="bi bi-x-lg fs-2"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-wrap">
                                            <div class="btn-wrapper text-center mb-3">
                                                <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                                                    <div class="symbol-label fs-1 bg-whitelabel">
                                                        <i class="fat fa-university fa-2x text-dark"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pb-5 mt-10 position-relative zindex-1">
                                                <form class="form w-100 mb-10" wire:submit.prevent="editBalance" method="post">
                                                    <div class="fv-row mb-6 form-floating">
                                                        <select class="form-select form-select-solid" wire:model="trxtype" required>
                                                            <option value="credit"><?php echo e(__('Credit')); ?></option>
                                                            <option value="debit"><?php echo e(__('Debit')); ?></option>
                                                        </select>
                                                        <label class="form-label text-dark fs-7 fw-bold required"><?php echo e(__('Transaction Type')); ?></label>
                                                        <?php $__errorArgs = ['trxtype'];
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
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text border-0"><?php echo e($currency->currency_symbol); ?></span>
                                                            <input class="form-control form-control-solid <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" step="any" wire:model="amount" autocomplete="amount" id="payout-amount" required placeholder="0.00" />
                                                        </div>
                                                        <?php $__errorArgs = ['amount'];
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
                                                        <label class="form-label fs-7 text-dark"><?php echo e(__('Admin Password')); ?></label>
                                                        <input class="form-control form-control-solid" type="password" wire:model.defer="password" required placeholder="<?php echo e(__('Password')); ?>" />
                                                        <?php $__errorArgs = ['password'];
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
                                                    <div class="p-5 rounded-4 bg-secondary mt-5">
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-40px symbol-circle">
                                                                <span
                                                                    class="symbol-label fw-boldest bg-white text-dark"><i
                                                                        class="bi bi-wallet"></i></span>
                                                            </div>
                                                            <div class="ps-2">
                                                                <p class="fs-7 text-dark mb-0">
                                                                    <?php echo e(number_format($result, 2)); ?>

                                                                    <?php echo e($currency->currency); ?>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-10">
                                                        <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                                            <span wire:loading.remove wire:target="editBalance"><?php echo e(__('Submit Request')); ?></span>
                                                            <span wire:loading wire:target="editBalance"><?php echo e(__('Processing Request...')); ?></span>
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
                    <!--end::Budget-->
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-12">
                                    <h4 class="fw-bold fs-5 mb-5"><?php echo e(__('Webhook')); ?></h4>
                                    <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                        <div class="d-flex fs-7 align-items-center mb-3">
                                            <div class="bullet bg-info me-3"></div>
                                            <div class="text-gray-800 fw-bold"><?php echo e(__('Webhook URL')); ?></div>
                                            <div class="ms-auto text-dark"> <?php echo e($client?->business?->webhook_url); ?></div>
                                        </div>
                                        <div class="d-flex fs-7 align-items-center mb-3">
                                            <div class="bullet bg-info me-3"></div>
                                            <div class="text-gray-800 fw-bold"><?php echo e(__('Webhook Secret')); ?></div>
                                            <div class="ms-auto text-dark"> <?php echo e($client?->business?->webhook_secret); ?></div>
                                        </div>
                                        <div class="d-flex fs-7 align-items-center mb-3">
                                            <div class="bullet bg-info me-3"></div>
                                            <div class="text-gray-800 fw-bold"><?php echo e(__('IP V4 Whitelisting')); ?></div>
                                            <div class="ms-auto text-dark"> <?php echo e($client?->business?->ip_whitelisting ? formatTag($client?->business?->ip_whitelisting) : null); ?></div>
                                        </div>
                                        <div class="d-flex fs-7 align-items-center mb-3">
                                            <div class="bullet bg-info me-3"></div>
                                            <div class="text-gray-800 fw-bold"><?php echo e(__('IP V6 Whitelisting')); ?></div>
                                            <div class="ms-auto text-dark"> <?php echo e($client?->business?->ipv6_whitelisting ? formatTag($client?->business?->ipv6_whitelisting) : null); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/users/details.blade.php ENDPATH**/ ?>