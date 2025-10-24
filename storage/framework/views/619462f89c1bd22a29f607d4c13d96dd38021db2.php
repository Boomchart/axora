<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap mb-5">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2"><?php echo e(__('Webhook')); ?> (<?php echo e(number_format_short($total)); ?>)</h1>
            </div>
        </div>
        <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
            <div class="container">
                <div wire:ignore.self id="kt_filter" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_filter_button" data-kt-drawer-close="#kt_filter_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
                    <div class="card w-100">
                        <div class="card-header pe-5 border-0">
                            <div class="card-title">
                                <div class="d-flex justify-content-center flex-column me-3">
                                    <div class="fs-4 text-gray-900 text-hover-danger me-1 lh-1"><?php echo e(__('Filter')); ?></div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_filter_close">
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-x-lg fs-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-wrap">
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Date Range')); ?></label>
                                <input class="form-control form-control-solid" placeholder="<?php echo e(__('Pick date rage')); ?>" value="<?php echo e($first.' - '.$last); ?>" id="range" wire:model="date">
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Environment')); ?></label>
                                <select class="form-select form-select-solid" wire:model="mode">
                                    <option value=""><?php echo e(__('All')); ?></option>
                                    <option value="live"><?php echo e(__('Live Environment')); ?></option>
                                    <option value="test"><?php echo e(__('Test Environment')); ?></option>
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Sort by')); ?></label>
                                <select class="form-select form-select-solid" wire:model="sortBy">
                                    <option value="created_at"><?php echo e(__('Date')); ?></option>
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Order by')); ?></label>
                                <select class="form-select form-select-solid" wire:model="orderBy">
                                    <option value="asc"><?php echo e(__('ASC')); ?></option>
                                    <option value="desc"><?php echo e(__('DESC')); ?></option>
                                </select>
                            </div>
                            <div class="fv-row mb-6">
                                <label class="form-label text-dark fs-7"><?php echo e(__('Per page')); ?></label>
                                <select class="form-select form-select-solid" wire:model="perPage">
                                    <option value="10"><?php echo e(__('10')); ?></option>
                                    <option value="25"><?php echo e(__('25')); ?></option>
                                    <option value="50"><?php echo e(__('50')); ?></option>
                                    <option value="100"><?php echo e(__('100')); ?></option>
                                    <option value="500"><?php echo e(__('500')); ?></option>
                                    <option value="1000"><?php echo e(__('1000')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-xl-8">
                    <div class="col-lg-12 col-md-12">
                        <div class="d-flex justify-content-center flex-column me-3">
                            <div class="col-md-12">
                                <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                    <input type="search" class="form-control form-control-solid bg-white rounded-4" wire:model.debounce.1000ms="search" placeholder="<?php echo e(__('Search')); ?>" />
                                    <span class="input-group-text cursor-pointer" id="kt_filter_button"><i class="bi bi-filter"></i></span>
                                </div>
                            </div>
                        </div>
                        <?php if($transactions->count() > 0): ?>
                        <div class="" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage, date, loadMore">
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-bordered table-row-gray-300 gy-3 gs-7" id="kt_datatable_example_5">
                                        <thead>
                                            <tr class="fw-semibold fs-7">
                                                <th></th>
                                                <th class="min-w-50px"><?php echo e(__('Response')); ?></th>
                                                <th class="min-w-50px"><?php echo e(__('Attempts')); ?></th>
                                                <th class="min-w-50px"><?php echo e(__('Environment')); ?></th>
                                                <th class="min-w-200px"><?php echo e(__('UUID')); ?></th>
                                                <th class="min-w-300px"><?php echo e(__('Created')); ?></th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <tbody class="fw-semibold fs-7">
                                            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="cursor-pointer" id="kt_webhook<?php echo e($val->id); ?>_button">
                                                <td>
                                                    <div class="symbol symbol-40px symbol-circle me-5 okay">
                                                        <div class="symbol-label fs-3 fw-bolder bg-white">
                                                            <i class="bi bi-code-square"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo e($val->response_status_code); ?></td>
                                                <td><?php echo e($val->attempts); ?></td>
                                                <td><?php echo e($val->mode); ?></td>
                                                <td><?php echo e($val->uuid); ?></td>
                                                <td><?php echo e($val->created_at->setTimezone($user->user_timezone)->toDayDateTimeString()); ?></td>
                                            </tr>
                                            <div wire:ignore.self id="kt_webhook<?php echo e($val->id); ?>" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_webhook<?php echo e($val->id); ?>_button" data-kt-drawer-close="#kt_webhook<?php echo e($val->id); ?>_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
                                                <div class="card w-100">
                                                    <div class="card-header pe-5 border-0">
                                                        <div class="card-title">
                                                            <div class="d-flex justify-content-center flex-column me-3">
                                                                <div class="fs-5 text-gray-900 text-hover-danger me-1 lh-1"><?php echo e(__('Webhook Details')); ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="card-toolbar">
                                                            <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_webhook<?php echo e($val->id); ?>_close">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <i class="bi bi-x-lg fs-2"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-body text-wrap">
                                                        <div class="text-center mb-3">
                                                            <div class="symbol symbol-100px symbol-circle okay mb-5">
                                                                <span class="symbol-label bg-secondary text-dark fw-bold fs-1">
                                                                    <i class="bi bi-code-square text-dark" style="font-size:56px;"></i>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="pb-5 mt-10 position-relative zindex-1">
                                                            <div class="row mb-5">
                                                                <div class="col-12" wire:ignore>
                                                                    <p class="mb-1 fs-7"><?php echo e(__('Payload')); ?></p>
                                                                    <pre class="rounded-4">
                                                                        <code class="language-json" style="font-size: 0.65rem !important;" data-lang="json">   
                                                                        <?php echo json_encode(json_decode($val->payload, true), JSON_PRETTY_PRINT); ?>

                                                                        </code>
                                                                    </pre>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-5">
                                                                <div class="col-12" wire:ignore>
                                                                    <p class="mb-1 fs-7"><?php echo e(__('Headers')); ?></p>
                                                                    <pre class="rounded-4">
                                                                        <code class="language-json" style="font-size: 0.65rem !important;" data-lang="json">   
                                                                        <?php echo json_encode(json_decode($val->headers, true), JSON_PRETTY_PRINT); ?>

                                                                        </code>
                                                                    </pre>
                                                                </div>
                                                            </div>
                                                            <a wire:click="resendWebhook('<?php echo e($val->id); ?>')" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="resendWebhook('<?php echo e($val->id); ?>')" class="btn btn-block btn-dark">
                                                                <span wire:loading.remove wire:target="resendWebhook('<?php echo e($val->id); ?>')"><?php echo e(__('Resend Webhook')); ?></span>
                                                                <span wire:loading wire:target="resendWebhook('<?php echo e($val->id); ?>')"><?php echo e(__('Processing Request...')); ?></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <?php if($transactions->count() > 100): ?><button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block"><?php echo e(__('See more')); ?></button><?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="text-center mt-20">
                            <div class="symbol symbol-150px symbol-circle mb-10 border border-secondary">
                                <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                    <i class="bi bi-code-square" style="font-size:66px;"></i>
                                </div>
                            </div>
                            <h3 class="text-dark fw-bold text-uppercase fs-5"><?php echo e(($search) ? __('We couldn\'t find').' "'.$search.'" '.__('Try again?') : __('No Webhook Log Found')); ?></h3>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    $(function() {
        var start = '<?php echo e($first); ?>';
        var end = '<?php echo e($last); ?>';

        function cb(start, end) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('date', start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('input[id="range"]').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
    });

    window.livewire.on('drawer', function() {
        $('tr[data-href]').on("click", function() {
            window.location.href = $(this).data('href');
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/settings/webhook.blade.php ENDPATH**/ ?>