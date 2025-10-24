<div>
    <div wire:ignore.self id="kt_edit_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_edit_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_edit_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{'md': '900px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Edit')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_edit_<?php echo e($val->id); ?>_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="update">
                        <div class="row">
                            <div class="col-md-4">
                                <!--begin::Thumbnail settings-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card body-->
                                    <div class="card-body text-center pt-0">
                                        <!--begin::Image input-->
                                        <!--begin::Image input placeholder-->
                                        
                                        <!--end::Image input placeholder-->

                                        <div wire:ignore class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-150px h-150px"></div>
                                            <!--end::Preview existing avatar-->

                                            <!--begin::Label-->
                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="<?php echo e(__('Change avatar')); ?>" data-bs-original-title="<?php echo e(__('Change avatar')); ?>" data-kt-initialized="1">
                                                <i class="bi bi-pencil-fill fs-7"></i>

                                                <!--begin::Inputs-->
                                                <input type="file" wire:model="image" id="image<?php echo e($val->id); ?>" accept=".png, .jpg, .jpeg, .svg">
                                                <input type="hidden" name="avatar_remove">
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Cancel-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="<?php echo e(__('Cancel avatar')); ?>" data-bs-original-title="<?php echo e(__('Cancel avatar')); ?>" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->

                                            <!--begin::Remove-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="<?php echo e(__('Remove avatar')); ?>" data-bs-original-title="<?php echo e(__('Remove avatar')); ?>" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->

                                        <!--begin::Description-->
                                        <div class="text-muted fs-7"><?php echo e(__('Set the thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted')); ?></div>
                                        <div wire:loading wire:target="image" class="fs-7"><?php echo e(__('Uploading')); ?>...</div>
                                        <?php $__errorArgs = ['val.image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="form-text text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Gateway Name')); ?></label>
                                    <input class="form-control form-control-solid" type="text" wire:model.defer="val.name" required placeholder="Name of Method" />
                                    <?php $__errorArgs = ['val.name'];
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
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Minimum')); ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0"><?php echo e($currency->currency_symbol); ?></span>
                                        <input type="number" wire:model.defer="val.minamo" step="any" class="form-control form-control-solid" required placeholder="0.00">
                                    </div>
                                    <?php $__errorArgs = ['val.minamo'];
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
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Maximum')); ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0"><?php echo e($currency->currency_symbol); ?></span>
                                        <input type="number" wire:model.defer="val.maxamo" step="any" class="form-control form-control-solid" required placeholder="0.00">
                                    </div>
                                    <?php $__errorArgs = ['val.maxamo'];
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
                                <label class="form-label text-dark fs-7"><?php echo e(__('Deposit Fee')); ?></label>
                                <div class="fv-row mb-6 row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="number" step="any" wire:model.defer="val.percent_charge" placeholder="<?php echo e(__('Percent charge')); ?>" autocomplete="off" class="form-control form-control-solid">
                                            <span class="input-group-text border-0">%</span>
                                        </div>
                                        <?php $__errorArgs = ['val.percent_charge'];
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
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text border-0"><?php echo e($currency->currency_symbol); ?></span>
                                            <input type="number" step="any" wire:model.defer="val.fiat_charge" placeholder="<?php echo e(__('Fiat charge')); ?>" autocomplete="off" class="form-control form-control-solid">
                                        </div>
                                        <?php $__errorArgs = ['val.fiat_charge'];
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
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Status')); ?></label>
                                    <select class="form-select form-select-solid" wire:model.defer="val.status" required>
                                        <option value="1"><?php echo e(__('Published')); ?></option>
                                        <option value="0"><?php echo e(__('Disabled')); ?></option>
                                    </select>
                                    <?php $__errorArgs = ['val.status'];
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
                                <?php if($val->type == 1): ?>
                                <div class="fv-row mb-6">
                                    <textarea class="form-control form-control-solid" type="text" wire:model.defer="val.instructions" rows="5" required placeholder="<?php echo e(__('Deposit Instructions')); ?>"></textarea>
                                    <?php $__errorArgs = ['val.instructions'];
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
                                    <textarea class="form-control form-control-solid" type="text" wire:model.defer="val.val1" rows="5" required placeholder="<?php echo e(__('Payment Details')); ?>"></textarea>
                                    <?php $__errorArgs = ['val.val1'];
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
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Require Receipt')); ?></label>
                                    <select class="form-select form-select-solid" wire:model.defer="receipt" required>
                                        <option value="1"><?php echo e(__('Yes')); ?></option>
                                        <option value="0"><?php echo e(__('No')); ?></option>
                                    </select>
                                    <?php $__errorArgs = ['receipt'];
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
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Crypto')); ?></label>
                                    <select class="form-select form-select-solid" wire:model="crypto" required>
                                        <option value="1"><?php echo e(__('Yes')); ?></option>
                                        <option value="0"><?php echo e(__('No')); ?></option>
                                    </select>
                                    <?php $__errorArgs = ['val.crypto'];
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
                                <?php if($showCrypto == 1): ?>
                                <div class="fv-row mb-6">
                                    <input class="form-control form-control-solid" type="text" wire:model.defer="val.val2" placeholder="<?php echo e(__('Wallet Address')); ?>" <?php if($showCrypto==1): ?> required <?php endif; ?> />
                                    <?php $__errorArgs = ['val.val2'];
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

                                <?php endif; ?>
                                <div class="text-center mt-10">
                                    <button type="submit" wire:click.prevent="update" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="update"><?php echo e(__('Update method')); ?></span>
                                        <span wire:loading wire:target="update"><?php echo e(__('Processing Request...')); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="delete<?php echo e($val->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Delete Method')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <p><?php echo e(__('Are you sure you want to delete this Method')); ?>?</p>
                    <div class="text-center">
                        <button wire:click="delete" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete"><?php echo e(__('Delete')); ?></span>
                            <span wire:loading wire:target="delete"><?php echo e(__('Processing Request...')); ?></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/gateway/edit.blade.php ENDPATH**/ ?>