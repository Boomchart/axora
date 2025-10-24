    <div class="card mb-10">
        <div class="card-body">
            <h4 class="fw-bold fs-5 mb-6"><?php echo e(__('Bank Deposit')); ?></h4>
            <form action="<?php echo e(route('admin.settings.update', ['type' => 'bank_deposit'])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Bank name')); ?></label>
                    <input class="form-control form-control-solid" type="text" name="dp_bank_name" value="<?php echo e($set->dp_bank_name); ?>" required />
                    <?php $__errorArgs = ['dp_bank_name'];
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
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Routing Code')); ?></label>
                    <input class="form-control form-control-solid" type="text" name="bk_routing_code" value="<?php echo e($set->bk_routing_code); ?>" required />
                    <?php $__errorArgs = ['bk_routing_code'];
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
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Routing Type')); ?></label>
                    <input class="form-control form-control-solid" type="text" name="bk_routing_type" value="<?php echo e($set->bk_routing_type); ?>" required />
                    <?php $__errorArgs = ['bk_routing_type'];
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
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Account Number')); ?></label>
                    <input class="form-control form-control-solid" type="text" name="bk_acct_no" value="<?php echo e($set->bk_acct_no); ?>" required />
                    <?php $__errorArgs = ['bk_acct_no'];
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
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Account Name')); ?></label>
                    <input class="form-control form-control-solid" type="text" name="bk_acct_name" value="<?php echo e($set->bk_acct_name); ?>" required />
                    <?php $__errorArgs = ['bk_acct_name'];
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
                <div class="form-group mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Payout charge type')); ?></label>
                    <select class="form-select form-select-solid" name="deposit_pct" id="pct" required>
                        <option value="both" <?php if($set->deposit_pct=="both"): ?> selected <?php endif; ?>><?php echo e(__('Percentage & Fiat')); ?></option>
                        <option value="percent" <?php if($set->deposit_pct=="percent"): ?> selected <?php endif; ?>><?php echo e(__('Percentage')); ?></option>
                        <option value="fiat" <?php if($set->deposit_pct=="fiat"): ?> selected <?php endif; ?>><?php echo e(__('Fiat')); ?></option>
                        <option value="none" <?php if($set->deposit_pct=="none"): ?> selected <?php endif; ?>><?php echo e(__('No fees')); ?></option>
                        <option value="min" <?php if($set->deposit_pct=="min"): ?> selected <?php endif; ?>><?php echo e(__('Below')); ?></option>
                        <option value="max" <?php if($set->deposit_pct=="max"): ?> selected <?php endif; ?>><?php echo e(__('Above')); ?></option>
                    </select>
                    <?php $__errorArgs = ['deposit_pct'];
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
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-6">
                            <div class="input-group">
                                <input type="number" step="any" name="deposit_percent_pc" id="percent_pc" readonly placeholder="<?php echo e(__('percent charge')); ?>" value="<?php echo e($set->deposit_percent_pc); ?>" autocomplete="off" class="form-control form-control-solid">
                                <span class="input-group-text border-0">%</span>
                            </div>
                            <?php $__errorArgs = ['deposit_percent_pc'];
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
                    <div class="col-lg-6">
                        <div class="form-group mb-6">
                            <div class="input-group">
                                <span class="input-group-text border-0"><?php echo e($currency->currency_symbol); ?></span>
                                <input type="number" step="any" name="deposit_fiat_pc" id="fiat_pc" placeholder="<?php echo e(__('fiat charge')); ?>" value="<?php echo e($set->deposit_fiat_pc); ?>" autocomplete="off" class="form-control form-control-solid">
                                <span class="input-group-text border-0"><?php echo e($currency->currency); ?></span>
                            </div>
                            <?php $__errorArgs = ['deposit_fiat_pc'];
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
                </div>
                <div class="form-check form-check-custom form-check-solid mb-6">
                    <input class="form-check-input" type="checkbox" id="bk_status" name="bk_status" value="1" <?php if($set->bk_status==1): ?>checked <?php endif; ?> />
                    <label class="form-check-label" for="bk_status"><?php echo e(__('Bank Deposit')); ?></label>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2"><?php echo e(__('Update')); ?></a>
                </div>
            </form>
        </div>
    </div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.gateway.index', ['admin' => $admin, 'currency' => $currency])->html();
} elseif ($_instance->childHasBeenRendered('6abEE69')) {
    $componentId = $_instance->getRenderedChildComponentId('6abEE69');
    $componentTag = $_instance->getRenderedChildComponentTagName('6abEE69');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('6abEE69');
} else {
    $response = \Livewire\Livewire::mount('admin.gateway.index', ['admin' => $admin, 'currency' => $currency]);
    $html = $response->html();
    $_instance->logRenderedChild('6abEE69', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/partials/admin/deposit.blade.php ENDPATH**/ ?>