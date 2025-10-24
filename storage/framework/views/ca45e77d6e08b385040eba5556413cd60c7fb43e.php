<div>
    <?php if($type == 'profile'): ?>
    <div class="card mb-10">
        <div class="card-body">
            <form wire:submit.prevent="profile">
                <?php echo csrf_field(); ?>
                <div class="row fv-row">
                    <div class="col-xl-6 mb-6">
                        <label class="form-label text-dark fs-7"><?php echo e(__('First Name')); ?></label>
                        <input class="form-control form-control-solid" type="text" name="first_name" autocomplete="off" value="<?php echo e($user->first_name); ?>" required readonly />
                        <?php $__errorArgs = ['first_name'];
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
                    <div class="col-xl-6 mb-6">
                        <label class="form-label text-dark fs-7"><?php echo e(__('Last Name')); ?></label>
                        <input class="form-control form-control-solid" type="text" name="last_name" autocomplete="off" value="<?php echo e($user->last_name); ?>" required readonly />
                        <?php $__errorArgs = ['last_name'];
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
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Email')); ?></label>
                    <input class="form-control form-control-solid" type="email" name="email" autocomplete="email" value="<?php echo e($user->email); ?>" required readonly />
                    <?php $__errorArgs = ['email'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Phone')); ?></label>
                    <input class="form-control form-control-solid" type="tel" name="phone" autocomplete="phone" value="<?php echo e($user->phone); ?>" required placeholder="123456789" readonly />
                    <?php $__errorArgs = ['phone'];
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
                <div class="fv-row mb-6" wire:ignore>
                    <label class="form-label text-dark fs-7"><?php echo e(__('Timezone')); ?></label>
                    <select class="form-select form-select-solid" id="timezone" data-control="select2" data-placeholder="<?php echo e(__('Select Timezone')); ?>" wire:model="timezone">
                        <?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val); ?>"><?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="profile"><?php echo e(__('Update Account')); ?></span>
                        <span wire:loading wire:target="profile"><?php echo e(__('Processing Request...')); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <?php if($type == 'api'): ?>
    <a href="<?php echo e(route('developer.index')); ?>" target="_blank">
        <div class="card bg-secondary mb-5">
            <div class="d-flex align-items-center p-3">
                <div class="symbol symbol-40px me-4">
                    <div class="symbol-label fs-7 text-dark bg-white rounded-5">
                        <i class="bi bi-braces text-dark"></i>
                    </div>
                </div>
                <div class="ps-1">
                    <p class="fs-7 text-dark text-hover-success fw-bold mb-0"><?php echo e(__('API Documentation')); ?></p>
                </div>
            </div>
        </div>
    </a>
    <div class="card mb-10">
        <div class="card-body">
            <form wire:submit.prevent="webhookUpdate" method="post">
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Live Key')); ?> <span class="badge badge-success badge-pill ms-2 cursor-pointer castro-copy" data-clipboard-text="<?php echo e($api_key); ?>" title="<?php echo e(__('Copy')); ?>"><?php echo e(__('Copy')); ?></span></label>
                    <div class="input-group">
                        <input class="form-control form-control-solid border-right-0" type="<?php echo e(($hide_live == 1) ? 'password' : 'text'); ?>" wire:model="api_key" readonly />
                        <span class="input-group-text" wire:click="liveStatus">
                            <?php if($hide_live == 1): ?>
                            <i class="bi bi-eye text-dark castro-copy fw-bold fs-5"></i>
                            <?php else: ?>
                            <i class="bi bi-eye-slash text-dark castro-copy fw-bold fs-5"></i>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php $__errorArgs = ['api_key'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Test Key')); ?> <span class="badge badge-success badge-pill ms-2 cursor-pointer castro-copy" data-clipboard-text="<?php echo e($test_api_key); ?>" title="<?php echo e(__('Copy')); ?>"><?php echo e(__('Copy')); ?></span></label>
                    <div class="input-group">
                        <input class="form-control form-control-solid border-right-0" type="text" wire:model="test_api_key" readonly />
                    </div>
                    <?php $__errorArgs = ['test_api_key'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('IP V4 Whitelisted')); ?></label>
                    <div wire:ignore>
                        <input class="form-control form-control-solid" wire:model.debounce.1000ms="ip_whitelisting" id="ip_whitelisting" placeholder="<?php echo e(__('Allowed IP addresses, seperate each ip address with a comma.')); ?>">
                    </div>
                    <?php $__errorArgs = ['ip_whitelisting'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('IP V6 Whitelisted')); ?></label>
                    <div wire:ignore>
                        <input class="form-control form-control-solid" wire:model.debounce.1000ms="ipv6_whitelisting" id="ipv6_whitelisting" placeholder="<?php echo e(__('Allowed IP addresses, seperate each ip address with a comma.')); ?>">
                    </div>
                    <?php $__errorArgs = ['ipv6_whitelisting'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Webhook URL')); ?></label>
                    <input class="form-control form-control-solid" type="url" wire:model="webhook_url" autocomplete="off" placeholder="<?php echo e(__('https://webhook.site')); ?>" />
                    <?php $__errorArgs = ['webhook_url'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Webhook Secret')); ?> <span wire:click="generateWebhookSecret" class="badge badge-dark cursor-pointer"><?php echo e(__('Generate Webhook Secret')); ?></span></label>
                    <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="webhook_secret" autocomplete="off" placeholder="<?php echo e(__('Secret Hash')); ?>" />
                    <span class="form-text text-dark"><?php echo e(__('Required to verify webhook signature')); ?></span>
                    <?php $__errorArgs = ['webhook_secret'];
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

                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2" wire:loading.attr="disabled" wire:target="webhookUpdate">
                        <span wire:loading.remove wire:target="webhookUpdate"><?php echo e(__('Update')); ?></span>
                        <span wire:loading wire:target="webhookUpdate"><?php echo e(__('Processing Request...')); ?></span>
                    </button>
                    <a wire:click="generate" class="btn rounded-pill btn-light-success me-3 my-2" wire:loading.attr="disabled" wire:target="generate">
                        <span wire:loading.remove wire:target="generate"><?php echo e(__('Generate New API Keys')); ?></span>
                        <span wire:loading wire:target="generate"><?php echo e(__('Processing Request...')); ?></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->startPush('scripts'); ?>
<?php if($type == 'profile'): ?>
<script>
    document.addEventListener('livewire:load', function() {
        $('#timezone').on('change', function(e) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('timezone', $(this).val());
        });
    });
</script>
<?php else: ?>
<script>
    document.addEventListener('livewire:load', function() {
        var ipFilter = document.querySelector("#ip_whitelisting");
        var ipFilterV6 = document.querySelector("#ipv6_whitelisting");
        var tagifyIpFilter = new Tagify(ipFilter);
        var tagifyIpFilterV6 = new Tagify(ipFilterV6);

        ipFilter.addEventListener('change', function(e) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('ip_whitelisting', e.target.value);
        });

        ipFilterV6.addEventListener('change', function(e) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('ipv6_whitelisting', e.target.value);
        });
    });
</script>
<?php endif; ?>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/settings/kin.blade.php ENDPATH**/ ?>