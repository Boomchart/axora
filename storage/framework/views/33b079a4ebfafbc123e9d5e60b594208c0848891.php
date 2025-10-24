<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post" wire:loading.class.delay="opacity-50" wire:target="approveKYC">
        <div class="container">
            <div class="row g-6 g-xl-9">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="fs-5 mb-6 fw-bold"><?php echo e(__('Flag Features on this Account')); ?></div>
                            <div class="table-responsive">
                                <table class="table table-row-dashed border-gray-300 align-middle gy-4">
                                    <tbody class="fs-7 fw-semibold">
                                        <tr>
                                            <td class="min-w-250px fs-7"><?php echo e(__('Watchlist (Easily keep track of this user, if user seems suspicious)')); ?></td>
                                            <td class="w-125px">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" wire:click="save" wire:model="watchlist">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-250px fs-7"><?php echo e(__('Agent')); ?></td>
                                            <td class="w-125px">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" wire:click="save" wire:model="agent">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form w-100" wire:submit.prevent="updateIssuing">
                                <p class="fs-6 fw-bold mb-5"><?php echo e(__('Gift Card Issuing Fee & Rev Share')); ?></p>
                                <div class="fv-row mb-6 form-floating">
                                    <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="issuing_fc" />
                                    <label class="form-label fs-7 text-dark fw-bold required"><?php echo e(__('Flat Fee')); ?> (<?php echo e($currency->currency); ?>)</label>
                                    <?php $__errorArgs = ['issuing_fc'];
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
                                <div class="fv-row mb-6 form-floating">
                                    <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="issuing_pc" />
                                    <label class="form-label fs-7 text-dark fw-bold required"><?php echo e(__('Percent Fee')); ?> (%)</label>
                                    <?php $__errorArgs = ['issuing_pc'];
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

                                <div class="p-5 border rounded-4 mb-10">
                                    <p class="fs-9 fw-bold mb-5 text-uppercase text-gray-700"><?php echo e(__('Agent Rev Share')); ?></p>
                                    <?php $__currentLoopData = $issuing_agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <p class="fs-7 fw-bold"><?php echo e(__('Item')); ?> <?php echo e($loop->iteration); ?></p>
                                        </div>
                                        <div class="col-6 text-end">
                                            <?php if($index > 0): ?>
                                            <a class="text-danger mb-0 cursor-pointer" wire:click.prevent="removeIssuingAgent(<?php echo e($index); ?>)"><i class="bi bi-trash text-danger"></i> <u><?php echo e(__('Remove')); ?></u></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="fv-row mb-6 form-floating">
                                                <input type="text" class="form-control form-control-solid" autocomplete="off" placeholder="<?php echo e(__('Enter Agent Account Id')); ?>" wire:model.debounce.1000ms="issuing_agents.<?php echo e($index); ?>.account_id">
                                                <label class="form-label text-dark fs-7 fw-bold"><?php echo e(__('Account ID')); ?></label>
                                                <?php $__errorArgs = ['issuing_agents.'.$index.'.account_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-text text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-6 form-floating">
                                                <input type="text" steps="any" class="form-control form-control-solid" min="0" autocomplete="off" required wire:model.debounce.1000ms="issuing_agents.<?php echo e($index); ?>.rev_fc">
                                                <label class="form-label text-dark fs-7 fw-bold"><?php echo e(__('Rev Fc')); ?> (<?php echo e($currency->currency); ?>)</label>
                                                <?php $__errorArgs = ['issuing_agents.'.$index.'.rev_fc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-text text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-6 form-floating">
                                                <input type="text" steps="any" class="form-control form-control-solid" autocomplete="off" required wire:model.debounce.1000ms="issuing_agents.<?php echo e($index); ?>.rev_pc">
                                                <label class="form-label text-dark fs-7 fw-bold"><?php echo e(__('Rev Pc')); ?> (%)</label>
                                                <?php $__errorArgs = ['issuing_agents.'.$index.'.rev_pc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-text text-danger"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <div class="text-center">
                                        <a class="text-info fw-bold cursor-pointer" wire:click.prevent="addIssuingAgent"><i class="bi bi-plus-lg"></i> <u><?php echo e(__('Add Rev Share')); ?></u></a>
                                    </div>
                                </div>
                                <div class="text-start mt-10">
                                    <button type="submit" class="btn btn-info" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                                        <span wire:loading.remove wire:target="updateIssuing"><?php echo e(__('Save Settings')); ?></span>
                                        <span wire:loading wire:target="updateIssuing"><?php echo e(__('Processing Request...')); ?></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-body p-9">
                            <div class="fs-5 mb-6 fw-bold"><?php echo e(__('Company Data')); ?></div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('KYC Status')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->business->kyc_status); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Legal Name')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->first_name.' '.$client->last_name); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Business Name')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->business->name); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Staff Size')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->business->staff_size); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Business Monthly Limits')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client?->business->business_monthly_limits); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('MCC')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client->business->getMcc?->name); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Registration Type')); ?></div>
                                    <div class="ms-auto text-dark"><?php echo e($client?->business->getRegType?->name); ?></div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Incorporation Date')); ?></div>
                                    <div class="ms-auto text-dark">
                                        <?php echo e(ucwords($client->business->incorporation_date)); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Registration Location')); ?></div>
                                    <div class="ms-auto text-dark">
                                        <?php echo e(ucwords($client->business->registration_location)); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e(__('Business Address')); ?></div>
                                    <div class="ms-auto text-dark">
                                        <?php echo e($client->business->business_street . ', ' . $client->business->business_state . ', ' . $client->business->business_city . ', ' . $client->business->business_postal_code . ', ' . $client->business->business_country); ?>

                                    </div>
                                </div>
                            </div>
                            <?php if($client?->business->directors->count()): ?>
                            <div class="fs-5 mb-6 fw-bold mt-6"><?php echo e(__('Directors')); ?></div>
                            <?php $__currentLoopData = $client->business->directors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-secondary rounded-4 p-4 mb-3">
                                <p class="fs-7 fw-bold mb-0 text-dark"><?php echo e(__('Name')); ?>:
                                    <?php echo e($val->first_name . ' ' . $val->last_name); ?>

                                </p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('Position')); ?>: <?php echo e($val->position); ?></p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('Email')); ?>: <?php echo e($val->email); ?></p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('Phone')); ?>: <?php echo e($val->phone); ?></p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('Ownership')); ?>: <?php echo e($val->ownership); ?>%
                                </p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('Gender')); ?>: <?php echo e($val->gender); ?></p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('Birthday')); ?>: <?php echo e($val->birthday); ?></p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('Address')); ?>:
                                    <?php echo e($val->street . ', ' . $val->state . ', ' . $val->city . ', ' . $val->postal_code . ', ' . $val->country); ?>

                                </p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('ID Type')); ?>: <?php echo e($val->doc_type); ?></p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('ID Number')); ?>: <?php echo e($val->doc_number); ?>

                                </p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('Passport')); ?>: <a
                                        href="<?php echo e($val->passport); ?>" target="_blank"><?php echo e($val->passport); ?></a>
                                </p>
                                <p class="fs-8 mb-0 text-dark"><?php echo e(__('ID URL')); ?>: <a
                                        href="<?php echo e($val->doc_front); ?>"
                                        target="_blank"><?php echo e($val->doc_front); ?></a></p>
                            </div>
                            <hr class="bg-secondary">
                            <?php if(!$loop->last): ?>
                            <hr class="bg-light-border">
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <div class="fs-5 mb-6 fw-bold mt-6"><?php echo e(__('KYC Doc Data')); ?></div>
                            <?php $__currentLoopData = $client->kycs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kyc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-danger me-3"></div>
                                    <div class="text-gray-800 fw-bold"><?php echo e($kyc?->doc?->title); ?> <?php if($kyc->doc->deleted_at != null): ?>
                                        <span
                                            class="badge badge-danger badge-sm"><?php echo e(__('Deleted Doc Type')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($kyc?->doc?->doc): ?>
                                    <div class="ms-auto text-dark"> <a href="<?php echo e($kyc->value); ?>"
                                            target="_blank"><?php echo e($kyc->value); ?></a></div>
                                    <?php else: ?>
                                    <div class="ms-auto text-dark"> <?php echo e($kyc->value); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($client->business->kyc_status == 'PROCESSING'): ?>
                            <div class="mt-10">
                                <button class="btn btn-sm btn-success rounded-pill mb-3 me-5" wire:click="approveKYC" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="approveUpgrade"> <span wire:loading.remove wire:target="approveUpgrade"><i class="bi bi-check"></i> <?php echo e(__('Approve Business Account')); ?></span> <span wire:loading wire:target="approveUpgrade"><?php echo e(__('Processing Request...')); ?></span></button>
                                <button class='btn btn-sm btn-danger rounded-pill mb-3' data-bs-toggle="modal" data-bs-target="#decline-upgrade"> <i class="bi bi-ban"></i> <?php echo e(__('Resubmit Compliance')); ?> </button>
                            </div>
                            <?php elseif($client->business->kyc_status == 'APPROVED'): ?>
                            <button class='btn btn-sm btn-danger rounded-pill mb-3' data-bs-toggle="modal" data-bs-target="#decline-upgrade"> <i class="bi bi-ban"></i> <?php echo e(__('Resubmit Compliance')); ?> </button>
                            <?php endif; ?>
                            <div wire:ignore.self class="modal fade" id="decline-upgrade" tabindex="-1"
                                role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title"><?php echo e(__('Decline')); ?></h3>
                                            <div class="btn btn-icon btn-sm btn-active-light-info ms-2"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                <span class="svg-icon svg-icon-1">
                                                    <i class="bi bi-x-lg fs-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <form wire:submit.prevent="declineKYC">
                                                <div class="form-group mb-6">
                                                    <textarea type="text" wire:model.defer="reason" class="form-control form-control-solid" rows="5"
                                                        placeholder="<?php echo e(__('Provide Reason')); ?>" required></textarea>
                                                    <?php $__errorArgs = ['reason'];
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
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-danger btn-block my-2"
                                                        wire:loading.attr="disabled" wire:loading.class="opacity-50"
                                                        wire:target="declineKYC">
                                                        <span wire:loading.remove
                                                            wire:target="declineKYC"><?php echo e(__('Submit')); ?></span>
                                                        <span wire:loading
                                                            wire:target="declineKYC"><?php echo e(__('Processing Request...')); ?></span>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark fw-bold mb-0 fs-5"><?php echo e(__('Block Account')); ?></p>
                            <p class="text-gray-800 mb-5 fs-7"><?php echo e(__('User won\'t be able to log in or use any platform apis')); ?></p>
                            <?php if($client->status==0): ?>
                            <a wire:click="block" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-ban"></i> <?php echo e(__('Block Account')); ?></a>
                            <?php else: ?>
                            <a wire:click="unblock" class="btn btn-sm btn-info rounded-pill"><i class="bi bi-check2-circle"></i> <?php echo e(__('Unblock Account')); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark fw-bold mb-0 fs-5"><?php echo e(__('Change Password')); ?></p>
                            <p class="text-gray-800 mb-5 fs-7"><?php echo e(__('Reset account password')); ?></p>
                            <button id="kt_password_button" class="btn btn-sm btn-info rounded-pill"><i class="bi bi-lock"></i> <?php echo e(__('Reset')); ?></button>
                            <div wire:ignore.self id="kt_password" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_password_button" data-kt-drawer-close="#kt_password_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
                                <div class="card w-100">
                                    <div class="card-header pe-5 border-0">
                                        <div class="card-title">
                                            <div class="d-flex justify-content-center flex-column me-3">
                                                <div class="fs-4 text-gray-900 text-hover-info me-1 lh-1"><?php echo e(__('Change Password')); ?></div>
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_password_close">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="bi bi-x-lg fs-2"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-wrap">
                                        <div class="text-center mb-3">
                                            <div class="symbol symbol-100px symbol-circle mb-10">
                                                <div class="symbol-label fs-1 bg-info text-white">
                                                    <i class="bi bi-lock fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pb-5 mt-10 position-relative zindex-1">
                                            <form class="form w-100 mb-10" wire:submit.prevent="editPassword">
                                                <div class="fv-row mb-6">
                                                    <label class="form-label fs-7 text-dark"><?php echo e(__('New Password')); ?></label>
                                                    <input class="form-control form-control-solid" type="password" wire:model.defer="new_password" required placeholder="<?php echo e(__('Password')); ?>" />
                                                    <?php $__errorArgs = ['new_password'];
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
                                                    <label class="form-label fs-7 text-dark"><?php echo e(__('Super Admin Password')); ?></label>
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
                                                <div class="text-center mt-10">
                                                    <button type="submit" class="btn btn-info btn-block my-2" wire:loading.attr="disabled" wire:loading.class="opacity-50">
                                                        <span wire:loading.remove wire:target="editPassword"><?php echo e(__('Submit Request')); ?></span>
                                                        <span wire:loading wire:target="editPassword"><?php echo e(__('Processing Request...')); ?></span>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark fw-bold mb-0 fs-5"><?php echo e(__('Ban Account')); ?></p>
                            <p class="text-gray-800 mb-5 fs-7"><?php echo e(__('User won\'t be able to create account or login anymore with their current phone number, ip address or emails')); ?></p>
                            <?php if($client->ban == 0): ?>
                            <a wire:click="ban" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-ban"></i> <?php echo e(__('Ban Account')); ?></a>
                            <?php else: ?>
                            <a wire:click="unban" class="btn btn-sm btn-info rounded-pill"><i class="bi bi-check2-circle"></i> <?php echo e(__('Unban Account')); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/users/compliance.blade.php ENDPATH**/ ?>