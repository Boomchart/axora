<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4"><?php echo e(__('Staffs & Roles')); ?></h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-muted text-hover-success"><?php echo e(__('Dashboard')); ?></a>
                    </li>
                    <li class="breadcrumb-item text-dark"><?php echo e(__('Staff')); ?></li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> <?php echo e(__('Filter')); ?></button>
                <button id="kt_staff_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> <?php echo e(__('Add a Staff')); ?></button>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Filter Staff')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7"><?php echo e(__('Sort by')); ?></label>
                        <select class="form-select form-select-solid" wire:model="sortBy">
                            <option value="asc"><?php echo e(__('ASC')); ?></option>
                            <option value="desc"><?php echo e(__('DESC')); ?></option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7"><?php echo e(__('Order by')); ?></label>
                        <select class="form-select form-select-solid" wire:model="orderBy">
                            <option value="created_at"><?php echo e(__('Date')); ?></option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7"><?php echo e(__('Status')); ?></label>
                        <select class="form-select form-select-solid" wire:model="status">
                            <option value=""><?php echo e(__('All')); ?></option>
                            <option value="0"><?php echo e(__('Active')); ?></option>
                            <option value="1"><?php echo e(__('Blocked')); ?></option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7"><?php echo e(__('Per page')); ?></label>
                        <select class="form-select form-select-solid" wire:model="perPage">
                            <option value="10"><?php echo e(__('10')); ?></option>
                            <option value="25"><?php echo e(__('25')); ?></option>
                            <option value="50"><?php echo e(__('50')); ?></option>
                            <option value="100"><?php echo e(__('100')); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_staff" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_staff_button" data-kt-drawer-close="#kt_staff_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Create a Staff')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_staff_close">
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
                            <i class="bi bi-people text-dark" style="font-size:44px;"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addStaff" method="post">
                        <label class="form-label text-dark fs-7"><?php echo e(__('Full name')); ?></label>
                        <div class="row fv-row mb-6">
                            <div class="col-xl-6">
                                <input class="form-control form-control-solid" type="text" wire:model.defer="first_name" autocomplete="off" required placeholder="<?php echo e(__('First Name')); ?>" />
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
                            <div class="col-xl-6">
                                <input class="form-control form-control-solid" type="text" wire:model.defer="last_name" autocomplete="off" required placeholder="<?php echo e(__('Last Name')); ?>" />
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
                            <label class="form-label text-dark fs-7"><?php echo e(__('Username')); ?></label>
                            <input class="form-control form-control-solid" type="text" wire:model.defer="username" required placeholder="<?php echo e(__('Username')); ?>" />
                            <?php $__errorArgs = ['username'];
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
                            <label class="form-label text-dark fs-7"><?php echo e(__('Password')); ?></label>
                            <input class="form-control form-control-solid" type="password" wire:model.defer="password" required placeholder="<?php echo e(__('Password')); ?>" />
                            <?php $__errorArgs = ['password'];
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
                            <label class="form-label text-dark fs-7"><?php echo e(__('Notification Email Address')); ?></label>
                            <input class="form-control form-control-solid" type="email" wire:model.defer="email" required placeholder="<?php echo e(__('Email Address')); ?>" />
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
                        <div class="fv-row mb-6" wire:ignore>
                            <label class="form-label text-dark fs-7"><?php echo e(__('Timezone')); ?></label>
                            <select class="form-select form-select-solid" id="timezone" data-control="select2" data-placeholder="<?php echo e(__('Select Timezone')); ?>" wire:model="timezone">
                                <?php $__currentLoopData = config('timezones'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"><?php echo e($key); ?> - <?php echo e($value); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <label class="form-label text-dark fs-7"><?php echo e(__('Permissions')); ?></label>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="profile" id="customCheckLogin1" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin1">
                                        <span class="text-muted"><?php echo e(__('Customer')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="support" id="customCheckLogin2" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin2">
                                        <span class="text-muted"><?php echo e(__('Ticket')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="promo" id="customCheckLogin3" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin3">
                                        <span class="text-muted"><?php echo e(__('Promotion')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="message" id="customCheckLogin4" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin4">
                                        <span class="text-muted"><?php echo e(__('Message')); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="deposit" id="deposit" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="deposit">
                                        <span class="text-muted"><?php echo e(__('Deposit')); ?></span>
                                    </label>
                                </div>
                            </div>                            
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="payout" id="payout" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="payout">
                                        <span class="text-muted"><?php echo e(__('Payout')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="email_configuration" id="customCheckLogin14" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin14">
                                        <span class="text-muted"><?php echo e(__('Email Template')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="general_settings" id="customCheckLogin15" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="customCheckLogin15">
                                        <span class="text-muted"><?php echo e(__('General Settings')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="giftcard" id="giftcard" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="giftcard">
                                        <span class="text-muted"><?php echo e(__('Giftcard')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="decline_compliance" id="decline_compliance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="decline_compliance">
                                        <span class="text-muted"><?php echo e(__('Decline compliance')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="approve_compliance" id="approve_compliance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="approve_compliance">
                                        <span class="text-muted"><?php echo e(__('Approve compliance')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="unblock_user" id="unblock_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="unblock_user">
                                        <span class="text-muted"><?php echo e(__('Unblock user')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="block_user" id="block_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="block_user">
                                        <span class="text-muted"><?php echo e(__('Block user')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="unban_user" id="unban_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="unban_user">
                                        <span class="text-muted"><?php echo e(__('Unban user')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="ban_user" id="ban_user" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="ban_user">
                                        <span class="text-muted"><?php echo e(__('Ban user')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="rev_share" id="rev_share" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="rev_share">
                                        <span class="text-muted"><?php echo e(__('Rev share')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="edit_password" id="edit_password" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="edit_password">
                                        <span class="text-muted"><?php echo e(__('Edit password')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="edit_balance" id="edit_balance" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="edit_balance">
                                        <span class="text-muted"><?php echo e(__('Edit balance')); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input type="checkbox" wire:model.defer="api_error" id="api_error" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="api_error">
                                        <span class="text-muted"><?php echo e(__('Receive API Error')); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="addStaff"><?php echo e(__('Submit Request')); ?></span>
                                <span wire:loading wire:target="addStaff"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-lg-12 col-md-12">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="col-md-12">
                            <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="<?php echo e(__('Search Staff')); ?>" />
                            </div>
                        </div>
                    </div>
                    <?php if($staffs->count() > 0): ?>
                    <div class="table-responsive">
                        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                            <thead>
                                <tr class="fw-semibold fs-7">
                                    <th class="min-w-20px"><?php echo e(__('S/N')); ?></th>
                                    <th class="min-w-100px"><?php echo e(__('Name')); ?></th>
                                    <th class="min-w-100px"><?php echo e(__('Username')); ?></th>
                                    <th class="min-w-50px"><?php echo e(__('Status')); ?></th>
                                    <th class="min-w-100px"><?php echo e(__('Created')); ?></th>
                                    <th class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?>.</td>
                                    <td class="fw-bold">
                                        <div class="symbol symbol-40px symbol-circle">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol-label fs-7 bg-warning text-dark"><?php echo e(strtoupper(substr($val->first_name, 0, 1).substr($val->last_name, 0, 1))); ?></div>
                                                <div class="ps-2">
                                                    <p class="fs-7 text-dark text-hover-success fw-bold mb-0"><?php echo e($val->first_name.' '.$val->last_name); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($val->username); ?></td>
                                    <td>
                                        <?php if($val->status==0): ?>
                                        <span class="badge badge-pill badge-success"><?php echo e(__('Active')); ?></span>
                                        <?php elseif($val->status==1): ?>
                                        <span class="badge badge-pill badge-danger"><?php echo e(__('Blocked')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')); ?></td>
                                    <td class="">
                                        <button id="kt_staff_<?php echo e($val->id); ?>_button" class="btn btn-sm btn-whitelabel rounded-pill"><i class="bi bi-pen"></i> <?php echo e(__('Edit')); ?></button>
                                        <button data-bs-toggle="modal" data-bs-target="#delete<?php echo e($val->id); ?>" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-trash"></i> <?php echo e(__('Delete')); ?></button>
                                        <button class="btn btn-secondary dropdown-toggle btn-sm rounded-pill" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php echo e(__('More')); ?>

                                        </button>
                                        <div wire:ignore.self class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#password<?php echo e($val->id); ?>"><?php echo e(__('Change Password')); ?></a>
                                            <a class="dropdown-item" href="#" id="kt_devices_<?php echo e($val->id); ?>_button"><?php echo e(__('Devices')); ?></a>
                                            <?php if($val->status==0): ?>
                                            <a class="dropdown-item" href="#" wire:click="block('<?php echo e($val->id); ?>')"><?php echo e(__('Block')); ?></a>
                                            <?php else: ?>
                                            <a class="dropdown-item" href="#" wire:click="unblock('<?php echo e($val->id); ?>')"><?php echo e(__('Unblock')); ?></a>
                                            <?php endif; ?>
                                        </div>

                                    </td>
                                </tr>
                                <div>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.staff.edit', ['val' => $val])->html();
} elseif ($_instance->childHasBeenRendered('kt_staff_'. $val->id)) {
    $componentId = $_instance->getRenderedChildComponentId('kt_staff_'. $val->id);
    $componentTag = $_instance->getRenderedChildComponentTagName('kt_staff_'. $val->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kt_staff_'. $val->id);
} else {
    $response = \Livewire\Livewire::mount('admin.staff.edit', ['val' => $val]);
    $html = $response->html();
    $_instance->logRenderedChild('kt_staff_'. $val->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></livewire:admin.staff.edit>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-archive text-dark" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark"><?php echo e(__('No Staff Found')); ?></h3>
                        <p class="text-dark"><?php echo e(__('We couldn\'t find any staff, create your first staff')); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div wire:ignore.self id="kt_devices_<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_devices_<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_devices_<?php echo e($val->id); ?>_close" data-kt-drawer-width="{'md': '400px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Devices & Sessions')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_devices_<?php echo e($val->id); ?>_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <?php $__currentLoopData = $val->devices(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex flex-stack mb-6">
                        <div class="d-flex align-items-center me-2">
                            <div class="symbol symbol-45px me-5">
                                <span class="symbol-label bg-light-primary text-dark">
                                    <i class="fal fa-<?php echo e(strtolower($device->deviceType)); ?>"></i>
                                </span>
                            </div>
                            <div>
                                <p class="fs-5 text-gray-800 fw-bold mb-0"><?php echo e($device->userAgent); ?></p>
                                <div class="fs-7 text-gray-800 fw-semibold"><?php echo e(__('Last login:')); ?> <?php echo e(\Carbon\Carbon::create($device->last_login)->format('d M, Y h:i:A')); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="password<?php echo e($val->id); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Change Password')); ?></h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="resetPassword('<?php echo e($val->id); ?>')" method="post" class="mb-10">
                        <?php echo csrf_field(); ?>
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
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-block">
                                <span wire:loading.remove wire:target="resetPassword('<?php echo e($val->id); ?>')"><?php echo e(__('Change Password')); ?></span>
                                <span wire:loading wire:target="resetPassword('<?php echo e($val->id); ?>')"><?php echo e(__('Processing Request...')); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:load', function() {
        $('#timezone').on('change', function(e) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('timezone', $(this).val());
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/staff/index.blade.php ENDPATH**/ ?>