<div>
    <div wire:ignore.self class="modal fade" id="resetpassword" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h3 class="modal-title"><?php echo e(__('Reset Password')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="resetPassword" method="post" class="mb-10">
                        <?php echo csrf_field(); ?>
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="password"><?php echo e(__('Current password')); ?></label>
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
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="new_password" id="new_password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="new_password"><?php echo e(__('New password')); ?></label>
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
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="confirm_password" id="confirm_password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="confirm_password"><?php echo e(__('Confirm password')); ?></label>
                            <?php $__errorArgs = ['confirm_password'];
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
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="resetPassword"><?php echo e(__('Change Password')); ?></span>
                                <span wire:loading wire:target="resetPassword"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                    <div class="bg-light px-6 py-5 mb-10 rounded">
                        <h4 class="mb-0 text-dark"><?php echo e(__('Password requirements')); ?></h4>
                        <p class="mb-2 text-gray-800 fs-7"><?php echo e(__('Ensure that these requirements are met')); ?></p>
                        <ul class="text-gray-800 fs-7">
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span><?php echo e(__('Minimum 8 characters long - the more, the better')); ?></li>
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span><?php echo e(__('At least one lowercase character')); ?></li>
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span><?php echo e(__('At least one uppercase character')); ?></li>
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span><?php echo e(__('At least one number')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_fasecurity" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_fasecurity_button" data-kt-drawer-close="#kt_fasecurity_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Two Factor Authentication')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_fasecurity_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form wire:submit.prevent="secondSecurity" method="post" class="mb-10">
                        <?php echo csrf_field(); ?>
                        <?php if($user->fa_status==0): ?>
                        <div class="text-center mb-10">
                            <img src="<?php echo e($image); ?>" class="user-profile mb-10">
                            <h5 class="m-0 text-dark fw-bold fs-3"><?php echo e($secret); ?> <i class="bi bi-copy text-dark castro-copy fs-5" data-clipboard-text="<?php echo e($secret); ?>" title="<?php echo e(__('Copy')); ?>"></i></h5>
                        </div>
                        <?php endif; ?>
                        <div class="fv-row mb-6 form-floating">
                            <input wire:model="fa_pin" type="tel" minlength="6" maxlength="6" pattern="[0-9]+" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="pin"><?php echo e(__('Code')); ?></label>
                            <?php $__errorArgs = ['fa_pin'];
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
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="secondSecurity">
                                    <?php if($user->fa_status==0): ?>
                                    <?php echo e(__('Activate')); ?>

                                    <?php elseif($user->fa_status==1): ?>
                                    <?php echo e(__('Disable')); ?>

                                    <?php endif; ?>
                                </span>
                                <span wire:loading wire:target="secondSecurity"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                    <div class="bg-light px-6 py-5 mb-10 rounded">
                        <h5 class="mb-1 text-dark fw-bold"><?php echo e(__('Two Factor Authentication')); ?></h5>
                        <p class="mb-2 text-gray-800 fs-7"><?php echo e(__('Two-factor authentication is a security measure used to safeguard your online accounts. When enabled, it requires you to enter not just your password but also a unique code. This code can be obtained through a mobile app. Even if someone manages to obtain your password, they cannot gain access without the accompanying code.')); ?></p>

                            <?php if($user->fa_status==0): ?>
                            <span class="badge badge-pill badge-danger mb-3"><?php echo e(__('Disabled')); ?> </span>
                            <?php else: ?>
                            <span class="badge badge-pill badge-success mb-3"><?php echo e(__('Active')); ?> </span>
                            <?php endif; ?>
                       
                        <ul class="text-gray-800 fs-7">
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span><?php echo e(__('Install an authentication app on your device. Any app that supports the Time-based One-Time Password (TOTP) protocol should work.')); ?></li>
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span><?php echo e(__('Use the authenticator app to scan the barcode below.')); ?></li>
                            <li class="d-flex align-items-center"><span class="bullet me-5 bg-success bullet-vertical"></span><?php echo e(__('Enter the code generated by the authenticator app.')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="resetpin" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h3 class="modal-title"><?php echo e(__('Reset Transfer Pin')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="resetPin" method="post" class="mb-10">
                        <?php echo csrf_field(); ?>
                        <div class="fv-row mb-6 form-floating">
                            <input wire:model="pin" type="tel" minlength="4" maxlength="6" pattern="[0-9]+" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="pin"><?php echo e(__('New Pin')); ?></label>
                            <?php $__errorArgs = ['pin'];
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
                        <?php if($user->social == 0): ?>
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7 mb-0" for="password"><?php echo e(__('Password')); ?></label>
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
                        <?php endif; ?>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="resetPin"><?php echo e(__('Change Pin')); ?></span>
                                <span wire:loading wire:target="resetPin"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="delaccount" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Deactivate Account')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p><?php echo e(__('Deactivate this account means you will no longer be able to access this account on')); ?> <?php echo e($set->site_name); ?></p>
                    <form wire:submit.prevent="deactivateAccount" method="post">
                        <?php echo csrf_field(); ?>

                        <div class="fv-row mb-6">
                            <textarea type="text" wire:model="reason" class="form-control form-control-solid" rows="5" placeholder="<?php echo e(__('Sorry to see you leave, Please tell us why you are leaving')); ?>" required></textarea>
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
                        <?php if($user->social == 0): ?>
                        <div class="fv-row mb-6 form-floating">
                            <input type="password" wire:model="password" class="form-control form-control-solid" required>
                            <label class="form-label text-dark fs-7" for="password"><?php echo e(__('Password')); ?></label>
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
                        <?php endif; ?>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="deactivateAccount"><?php echo e(__('Deactivate account')); ?></span>
                                <span wire:loading wire:target="deactivateAccount"><?php echo e(__('Deactivating account...')); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/settings/options.blade.php ENDPATH**/ ?>