<div>
    <div wire:ignore.self id="kt_withdraw_money" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_withdraw_money_button" data-kt-drawer-close="#kt_withdraw_money_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Withdraw')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_withdraw_money_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 bg-secondary">
                            <i class="bi bi-bank fa-2x text-dark" style="font-size:46px;"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="payout(Object.fromEntries(new FormData($event.target)))" method="post">
                        <?php $__errorArgs = ['added'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="alert alert-danger">
                            <div class="d-flex flex-column">
                                <span><?php echo e($message); ?></span>
                            </div>
                        </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="d-flex justify-content-between">
                            <label class="form-label text-dark fs-7 required"><?php echo e(__('Amount')); ?> (<?php echo e($currency->currency); ?>)</label>
                            <a wire:click="max" class="cursor-pointer text-success"><u><?php echo e(__('Max Amount')); ?></u></a>
                        </div>
                        <div class="fv-row mb-6">
                            <input class="form-control form-control-solid" type="text" step="any" wire:model.denounce.500ms="amount" autocomplete="one-time-code" required placeholder="<?php echo e(__('0.00')); ?>" />
                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div id="other">
                            <div class="fv-row mb-6 form-floating">
                                <label class="form-label text-dark fs-7 required"><?php echo e(__('Withdrawal options')); ?></label>
                                <select class="form-select form-select-solid" wire:model="other" id="changeMethod">
                                    <option value=""><?php echo e(__('Select options')); ?></option>
                                    <?php $__currentLoopData = getOtherPayout(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($other->id); ?>"><?php echo e($other->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <textarea class="form-control form-control-solid" type="text" wire:model.defer="requirements" placeholder="<?php echo e($placeholder); ?>" rows="3"></textarea>
                            </div>
                        </div>
                        <?php $__errorArgs = ['requirements'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="fv-row mb-6 text-start">
                            <label class="form-label text-dark fs-7 required"><?php echo e(__('2FA Code')); ?></label>
                            <input class="form-control form-control-solid" type="tel" minlength="4" maxlength="6" pattern="[0-9]+" wire:model.defer="otp" placeholder="<?php echo e(__('Enter OTP')); ?>" required />
                            <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="bg-light-primary px-6 py-5 mb-10 rounded-4">
                            <p class="text-dark fs-7 mb-0"><b><?php echo e(__('Balance after transaction')); ?></b>: <?php echo e($balanceAfter); ?></p>
                            <p class="text-dark fs-7 mb-0"><b><?php echo e(__('Fee')); ?></b>: <?php echo e($fee); ?></p>
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="payout"><?php echo e(__('Submit Request')); ?></span>
                                <span wire:loading wire:target="payout"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    window.livewire.on('newTime', data => {
        countDownDate = moment(data).valueOf();
        var x = setInterval(function() {
            var now = moment.utc().valueOf();
            var distance = countDownDate - now + (1 * 60 * 60 * 1000);
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
            var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
            document.getElementById("timer").innerHTML = minutes + ":" + seconds;
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "0:00";
            }
        }, 1);
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/withdraw.blade.php ENDPATH**/ ?>