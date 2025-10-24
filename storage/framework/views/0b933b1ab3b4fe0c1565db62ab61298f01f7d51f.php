<div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo e(__('Filter')); ?></h3>
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
    <div class="row g-xl-8">
        <div class="col-md-8">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="<?php echo e(__('Search Methods')); ?>" />
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="fal fa-filter-list"></i> <?php echo e(__('Filter')); ?></button>
            <button id="kt_addmethod_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> <?php echo e(__('Add Method')); ?></button>
        </div>
    </div>
    <div wire:ignore.self id="kt_addmethod" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_addmethod_button" data-kt-drawer-close="#kt_addmethod_close" data-kt-drawer-width="{'md': '900px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Add a Payout Method')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_article_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addMethod" method="post">
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
                                                <input type="file" wire:model="image" id="image" accept=".png, .jpg, .jpeg, .svg" required>
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
                                        <?php $__errorArgs = ['image'];
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
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Name')); ?></label>
                                    <input class="form-control form-control-solid" type="text" wire:model.defer="name" required placeholder="<?php echo e(__('Name of Method')); ?>" />
                                    <?php $__errorArgs = ['name'];
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
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Requirements')); ?></label>
                                    <textarea class="form-control form-control-solid" type="text" wire:model.defer="requirements" rows="5" required placeholder="<?php echo e(__('Payout requirements')); ?>"></textarea>
                                    <span class="form-text"><?php echo e(__('This will be showed to clients as placeholder to tell them, what they must provide for a successful withdrawal')); ?></span>
                                    <?php $__errorArgs = ['requirements'];
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label text-dark fs-7"><?php echo e(__('Minimum')); ?></label>
                                            <div class="input-group">
                                                <span class="input-group-text border-0"><?php echo e($currency->currency_symbol); ?></span>
                                                <input type="number" wire:model.defer="min" step="any" class="form-control form-control-solid" required placeholder="0.00">
                                            </div>
                                            <?php $__errorArgs = ['min'];
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
                                            <label class="form-label text-dark fs-7"><?php echo e(__('Maximum')); ?></label>
                                            <div class="input-group">
                                                <span class="input-group-text border-0"><?php echo e($currency->currency_symbol); ?></span>
                                                <input type="number" wire:model.defer="max" step="any" class="form-control form-control-solid" required placeholder="0.00">
                                            </div>
                                            <?php $__errorArgs = ['max'];
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
                
                                <div class="form-group mb-6">
                                    <label class="form-label text-dark fs-7"><?php echo e(__('Charge type')); ?></label>
                                    <select class="form-select form-select-solid" wire:model="pct" required>
                                        <option value="both"><?php echo e(__('Percentage & Fiat')); ?></option>
                                        <option value="percent"><?php echo e(__('Percentage')); ?></option>
                                        <option value="fiat"><?php echo e(__('Fiat')); ?></option>
                                        <option value="none"><?php echo e(__('No fees')); ?></option>
                                        <option value="min"><?php echo e(__('Below')); ?></option>
                                        <option value="max"><?php echo e(__('Above')); ?></option>
                                    </select>
                                </div>
                                <div class="fv-row mb-6 row">
                                    <div class="col-md-6">
                                        <label class="form-label text-dark fs-7"><?php echo e(__('Percent charge')); ?></label>
                                        <div class="input-group">
                                            <input type="number" step="any" wire:model.defer="pc" placeholder="<?php echo e(__('Percent charge')); ?>" autocomplete="off" class="form-control form-control-solid" <?php if($pc_required==1): ?> required <?php endif; ?>>
                                            <span class="input-group-text border-0">%</span>
                                        </div>
                                        <?php $__errorArgs = ['pc'];
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
                                        <label class="form-label text-dark fs-7"><?php echo e(__('Fiat charge')); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text border-0"><?php echo e($currency->currency_symbol); ?></span>
                                            <input type="number" step="any" wire:model.defer="fc" placeholder="<?php echo e(__('Fiat charge')); ?>" autocomplete="off" class="form-control form-control-solid" <?php if($fc_required==1): ?> required <?php endif; ?>>
                                        </div>
                                        <?php $__errorArgs = ['fc'];
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
                                    <select class="form-select form-select-solid" wire:model.defer="status" required>
                                        <option value="1"><?php echo e(__('Published')); ?></option>
                                        <option value="0"><?php echo e(__('Disabled')); ?></option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
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
                                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="addMethod"><?php echo e(__('Submit Method')); ?></span>
                                        <span wire:loading wire:target="addMethod"><?php echo e(__('Processing Request...')); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if($methods->count() > 0): ?>
    <div class="table-responsive">
        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
            <thead>
                <tr class="fw-semibold fs-7">
                    <th class="min-w-20px"><?php echo e(__('S/N')); ?></th>
                    <th class="min-w-150px"><?php echo e(__('Title')); ?></th>
                    <th class="min-w-100px"><?php echo e(__('Limit')); ?></th>
                    <th class="min-w-50px"><?php echo e(__('Charge')); ?></th>
                    <th class="min-w-50px"><?php echo e(__('Status')); ?></th>
                    <th class="min-w-200px"><?php echo e(__('Created')); ?></th>
                    <th class="scope"></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?>.</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px">
                                <span class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val->image); ?>);"></span>
                            </div>
                            <div class="ms-5">
                                <?php echo e($val->name); ?>

                            </div>
                        </div>
                    </td>
                    <td><?php echo e($currency->currency_symbol.$val->min.' - '.$currency->currency_symbol.$val->max); ?></td>
                    <td><?php echo e($currency->currency_symbol.$val->fc.' + '.$val->pc); ?>%</td>
                    <td>
                        <?php if($val->status==1): ?>
                        <span class="badge badge-pill badge-success"><?php echo e(__('Active')); ?></span>
                        <?php elseif($val->status==0): ?>
                        <span class="badge badge-pill badge-danger"><?php echo e(__('Disabled')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')); ?></td>
                    <td class="text-center">
                        <button id="kt_edit_<?php echo e($val->id); ?>_button" class="btn btn-sm btn-whitelabel rounded-pill"><?php echo e(__('Edit')); ?></button>
                        <?php if($val->status==1): ?>
                        <a wire:click="disable('<?php echo e($val->id); ?>')" class="btn btn-sm btn-danger rounded-pill"><?php echo e(__('Disable')); ?></a>
                        <?php else: ?>
                        <a wire:click="enable('<?php echo e($val->id); ?>')" class="btn btn-sm btn-secondary rounded-pill"><?php echo e(__('Enable')); ?></a>
                        <?php endif; ?>
                        <a data-bs-toggle="modal" data-bs-target="#delete<?php echo e($val->id); ?>" href="" class="btn btn-sm btn-danger rounded-pill"><?php echo e(__('Delete')); ?></a>
                    </td>
                </tr>
                <div>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.withdraw.edit', ['val' => $val])->html();
} elseif ($_instance->childHasBeenRendered($val->id)) {
    $componentId = $_instance->getRenderedChildComponentId($val->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($val->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($val->id);
} else {
    $response = \Livewire\Livewire::mount('admin.withdraw.edit', ['val' => $val]);
    $html = $response->html();
    $_instance->logRenderedChild($val->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></livewire:admin.withdraw.edit>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php if($methods->total() > 0 && $methods->count() < $methods->total()): ?><button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block"><?php echo e(__('See more')); ?></button><?php endif; ?>
    </div>
    <?php else: ?>
    <div class="text-center mt-20">
        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                <i class="bi bi-bank text-dark" style="font-size:66px;"></i>
            </div>
        </div>
        <h3 class="text-dark"><?php echo e(__('No Payout Method Found')); ?></h3>
    </div>
    <?php endif; ?>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/withdraw/index.blade.php ENDPATH**/ ?>