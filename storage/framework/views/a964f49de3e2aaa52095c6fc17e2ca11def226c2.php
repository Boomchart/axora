<div>
    <div wire:ignore.self id="kt_filter" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_filter_button" data-kt-drawer-close="#kt_filter_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Filter')); ?></div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_filter_close">
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
                    <label class="form-label text-dark fs-7"><?php echo e(__('Sort by')); ?></label>
                    <select class="form-select form-select-solid" wire:model="sortBy">
                        <option value="created_at"><?php echo e(__('Date')); ?></option>
                        <option value="amount"><?php echo e(__('Amount')); ?></option>
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
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-md-6">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="col-md-12">
                            <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control form-control-solid rounded-4 bg-white" wire:model="search" placeholder="<?php echo e(__('Transaction reference')); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <button id="kt_filter_button" class="btn btn-white text-dark me-4"><i class="fal fa-filter-list"></i> <?php echo e(__('Filter')); ?></button>
                    <button wire:click="save" class="btn btn-dark">
                        <span wire:loading.remove wire:target="save"><i class="bi bi-filetype-xlsx"></i> <?php echo e(__('Export')); ?></span>
                        <span wire:loading wire:target="save"><?php echo e(__('Exporting...')); ?></span>
                    </button>
                </div>
            </div>

            <?php if($transactions->count() > 0): ?>
            <div class="" wire:loading.class.delay="opacity-50" wire:target="search, status, orderBy, perPage, date, loadMore">
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" id="kt_datatable_example_5">
                            <thead>
                                <tr class="fw-semibold fs-7">
                                    <th></th>
                                    <th class="min-w-150px"><?php echo e(__('Name')); ?></th>
                                    <th class="min-w-150px"><?php echo e(__('Amount')); ?></th>
                                    <th class="min-w-150px"><?php echo e(__('Fee')); ?></th>
                                    <th class="min-w-50px"><?php echo e(__('Reference ID')); ?></th>
                                    <th class="min-w-200px"><?php echo e(__('Created')); ?></th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <tbody class="fw-semibold text-dark fs-7">
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="cursor-pointer">
                                    <td>
                                        <a href="<?php echo e(route('admin.view.transactions', ['transaction' => $val->ref_id])); ?>" class="btn btn-info btn-sm rounded-pill" target="_blank"><?php echo e(__('Manage')); ?></a>
                                    </td>
                                    <td>
                                        <p class="mb-0"><?php echo e($val->business->name); ?></p>
                                    </td>
                                    <td><?php echo e($currency->currency_symbol.currencyFormat(number_format($val->amount, 2)).' '.$currency->currency); ?></td>
                                    <td><?php echo e($currency->currency_symbol.currencyFormat(number_format($val->charge, 2)).' '.$currency->currency); ?></td>
                                    <td><?php echo e($val->ref_id); ?></td>
                                    <td><?php echo e($val->created_at->setTimezone($admin->timezone)->toDayDateTimeString()); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if($transactions->total() > 0 && $transactions->count() < $transactions->total()): ?><button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block"><?php echo e(__('See more')); ?></button><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-clipboard-data text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark"><?php echo e(__('No Transactions Found')); ?></h3>
                <p class="text-dark"><?php echo e(__('We couldn\'t find any transactions to this account')); ?></p>
            </div>
            <?php endif; ?>
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
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/payout/index.blade.php ENDPATH**/ ?>