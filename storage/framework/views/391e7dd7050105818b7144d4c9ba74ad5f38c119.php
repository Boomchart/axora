<div class="tab-pane fade <?php if(route('admin.settings', ['type' => 'system'])==url()->current()): ?>show active <?php endif; ?>" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
    <div class="card mb-10">
        <div class="card-body">
            <form action="<?php echo e(route('admin.settings.update', ['type' => 'system'])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Website name')); ?></label>
                    <input class="form-control form-control-solid" type="text" name="site_name" value="<?php echo e($set->site_name); ?>" required />
                    <?php $__errorArgs = ['site_name'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Website email')); ?></label>
                    <input class="form-control form-control-solid" type="email" name="email" value="<?php echo e($set->email); ?>" required />
                    <span class="form-text text-muted"><?php echo e(__('Displayed on homepage')); ?></span>
                    <?php $__errorArgs = ['email'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Support email')); ?></label>
                    <input class="form-control form-control-solid" type="email" name="support_email" value="<?php echo e($set->support_email); ?>" required />
                    <span class="form-text text-muted"><?php echo e(__('For support ticket')); ?></span>
                    <?php $__errorArgs = ['support_email'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Mobile')); ?></label>
                    <input class="form-control form-control-solid" type="text" name="mobile" value="<?php echo e($set->mobile); ?>" required />
                    <?php $__errorArgs = ['mobile'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Website title')); ?></label>
                    <input class="form-control form-control-solid" type="text" name="title" value="<?php echo e($set->title); ?>" required />
                    <?php $__errorArgs = ['title'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Short description')); ?></label>
                    <textarea class="form-control form-control-solid" type="text" name="site_desc" required rows="3"><?php echo e($set->site_desc); ?></textarea>
                    <?php $__errorArgs = ['site_desc'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Livechat snippet code')); ?></label>
                    <textarea class="form-control form-control-solid" type="text" name="livechat" rows="3"><?php echo e($set->livechat); ?></textarea>
                    <?php $__errorArgs = ['livechat'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Analytics snippet code')); ?></label>
                    <textarea class="form-control form-control-solid" type="text" name="analytic_snippet" rows="3"><?php echo e($set->analytic_snippet); ?></textarea>
                    <?php $__errorArgs = ['analytic_snippet'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Career URL')); ?></label>
                    <input class="form-control form-control-solid" type="url" name="career_url" value="<?php echo e($set->career_url); ?>" />
                    <span class="form-text text-muted"><?php echo e(__('Available job positions link')); ?></span>
                    <?php $__errorArgs = ['career_url'];
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
                <hr class="bg-light">
                <p><?php echo e(__('Platform Currency')); ?></p>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Format')); ?></label>
                    <select class="form-select form-select-solid" name="currency_format" required>
                        <option value="normal" <?php if($set->currency_format=="normal"): ?> selected <?php endif; ?></option><?php echo e(__('Normal - 1,000.00')); ?></option>
                        <option value="reversed" <?php if($set->currency_format=="reversed"): ?> selected <?php endif; ?></option><?php echo e(__('Reversed - 1.000,00')); ?></option>
                    </select>
                    <?php $__errorArgs = ['currency_format'];
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Default Country & Currency')); ?></label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="<?php echo e(__('Select Currency')); ?>" name="currency">
                        <option></option>
                        <?php $__currentLoopData = getAllCountry(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->id); ?>" <?php if($admin->currency()->real->iso2 == $val->iso2): ?>selected <?php endif; ?>><?php echo e($val->name.' - '.$val->currency); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <hr class="bg-light">
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Super Admin Dashboard Timezone')); ?></label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="<?php echo e(__('Select Timezone')); ?>" name="admin_timezone">
                        <option></option>
                        <?php $__currentLoopData = config('timezones'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php if($admin->timezone == $key): ?>selected <?php endif; ?>><?php echo e($key); ?> - <?php echo e($val); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2"><?php echo e(__('Update')); ?></a>
                </div>
            </form>
        </div>
    </div> 
    <div class="card mb-10">
        <div class="card-body">
            <h4 class="fw-bold fs-5 mb-6"><?php echo e(__('Language')); ?></h4>
            <form action="<?php echo e(route('admin.settings.update', ['type' => 'language'])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="form-check form-check-custom form-check-solid mb-6">
                    <input class="form-check-input" type="checkbox" id="language" name="language" value="1" <?php if($set->language==1): ?>checked <?php endif; ?> />
                    <label class="form-check-label" for="language"><?php echo e(__('Language translation - Enables changing language on user dashboard & homepage')); ?></label>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Admin Dashboard Default')); ?></label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="<?php echo e(__('Select Language')); ?>" name="admin_language">
                        <option></option>
                        <?php $__currentLoopData = getLang(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->code); ?>" <?php if($set->admin_language == $val->code): ?>selected <?php endif; ?>><?php echo e(ucwords($val->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('User Dashboard Default')); ?></label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="<?php echo e(__('Select Language')); ?>" name="user_language">
                        <option></option>
                        <?php $__currentLoopData = getLang(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->code); ?>" <?php if($set->user_language == $val->code): ?>selected <?php endif; ?>><?php echo e(ucwords($val->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2"><?php echo e(__('Update')); ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-10">
        <div class="card-body">
            <h4 class="fw-bold fs-5 mb-6"><?php echo e(__('Preloader')); ?></h4>
            <form action="<?php echo e(route('admin.settings.update', ['type' => 'preloader'])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="form-check form-check-custom form-check-solid mb-6">
                    <input class="form-check-input" type="checkbox" id="preloader" name="preloader" value="1" <?php if($set->preloader==1): ?>checked <?php endif; ?> />
                    <label class="form-check-label" for="preloader"><?php echo e(__('Enable Preloader on Dashboard')); ?></label>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7"><?php echo e(__('Preloader Color')); ?></label>
                    <input type="color" name="preloader_color" required class="form-control form-control-md form-control-solid" placeholder="<?php echo e(__('#0000000')); ?>" value="<?php echo e($set->preloader_color); ?>" required>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2"><?php echo e(__('Update')); ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-10">
        <div class="card-body">
            <h4 class="fw-bold fs-5 mb-6"><?php echo e(__('Business Addresses')); ?></h4>
            <form action="<?php echo e(route('homepage.update')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <p><?php echo e(__('Addresses')); ?></p>
                <div class="fv-row mb-6">
                    <input type="text" name="address1_t" class="form-control form-control-md form-control-solid" placeholder="Address 1 title" value="<?php echo e($ui->address1_t); ?>">
                </div>
                <div class="fv-row mb-6">
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Address 1 Country" name="address1_c">
                        <option></option>
                        <?php $__currentLoopData = getAllCountry(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->iso2); ?>" <?php if($ui->address1_c == $val->iso2): ?>selected <?php endif; ?>><?php echo e($val->name.' '.$val->emoji); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="fv-row mb-6">
                    <input type="text" name="address2_t" class="form-control form-control-md form-control-solid" placeholder="Address 2 title" value="<?php echo e($ui->address2_t); ?>">
                </div>
                <div class="fv-row mb-6">
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Address 2  Country" name="address2_c">
                        <option></option>
                        <?php $__currentLoopData = getAllCountry(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->iso2); ?>" <?php if($ui->address2_c == $val->iso2): ?>selected <?php endif; ?>><?php echo e($val->name.' '.$val->emoji); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="fv-row mb-6">
                    <input type="text" name="address3_t" class="form-control form-control-md form-control-solid" placeholder="Address 3 title" value="<?php echo e($ui->address3_t); ?>">
                </div>
                <div class="fv-row mb-6">
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Address 3 Country" name="address3_c">
                        <option></option>
                        <?php $__currentLoopData = getAllCountry(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->iso2); ?>" <?php if($ui->address3_c == $val->iso2): ?>selected <?php endif; ?>><?php echo e($val->name.' '.$val->emoji); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2"><?php echo e(__('Update')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/partials/admin/general.blade.php ENDPATH**/ ?>