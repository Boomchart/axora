<div>
    <div class="toolbar" id="kt_toolbar" wire:init="launchChart">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-success fw-bolder my-1 fs-2x mb-6"><?php echo e(__('Hi').' '.$user->first_name); ?>,</h1>
            </div>
        </div>
        <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
            <div class="container">
                <div class="row g-xl-8 mb-6">
                    <?php if($user->business->kyc_status == 'PROCESSING'): ?>
                    <div class="col-md-12">
                        <div class="alert alert-warning mb-0">
                            <div class="d-flex flex-column">
                                <p class="mb-0 text-dark fs-7"><i class="bi bi-info-circle text-dark"></i> <?php echo e(__('We are currently reviewing your compliance information.')); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($user->business->kyc_status==null || $user->business->kyc_status=="RESUBMIT" || $user->business->kyc_status=="PENDING"): ?>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center bg-white rounded-4 p-4">
                            <div class="symbol symbol-45px me-5 symbol-circle">
                                <span class="symbol-label bg-warning">
                                    <i class="bi bi-globe fs-3"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap w-100">
                                <a href="<?php echo e(route('user.compliance')); ?>">
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <div class="fs-7 text-dark text-hover-success fw-bold"><?php echo e(__('Verify Business')); ?></div>
                                        <div class="text-gray-800 fw-semibold"><?php echo e(__('Kindly update your account information to enable gift card issuance for your customers through our API.')); ?></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="card bg-transparent h-md-100">
                        <div class="card-body p-0">
                            <div class="px-9 pt-6 card-rounded w-100 bg-success">
                                <div class="fw-bold fs-7 text-start pb-5 text-warning">
                                    <div class="mb-5"
                                        x-data="{ 
                                            show: <?php echo \Illuminate\Support\Js::from($user->business->reveal_balance)->toHtml() ?>, 
                                            toggle() {
                                                this.show = !this.show;
                                                $wire.displayBalance(); // Call Livewire method
                                            }
                                        }">
                                        <p class="text-white">
                                            <span class="me-2"><?php echo e(__('Available Balance')); ?></span>
                                            <span class="ml-3 fs-3 cursor-pointer wallet-text" @click="toggle">
                                                <i class="bi bi-eye-slash text-white" x-show="show" x-transition></i>
                                                <i class="bi bi-eye text-white" x-show="!show" x-transition></i>
                                            </span>
                                        </p>
                                        <span class="fw-bold fs-7 text-start text-white">
                                            <span class="fw-bolder fs-2hx" x-cloak x-show="show" x-transition>
                                                <?php echo e($currency->currency_symbol.currencyFormat(number_format($user->getBalance($currency->id)->amount,2)).' '.$currency->currency); ?>

                                            </span>
                                            <span class="fw-bolder fs-2hx" x-cloak x-show="!show" x-transition>************</span>
                                        </span>
                                        <?php if($user->business->kyc_status=="APPROVED"): ?>
                                        <p class="text-white">
                                            <span class="fs-8"><?php echo e(__('Issuing Fee')); ?>: <?php echo e($user->business->issuing_fc + collect(json_decode($user->business->issuing_agents, true) ?? [])->sum('rev_fc')); ?> <?php echo e($currency->currency); ?> + <?php echo e($user->business->issuing_pc + collect(json_decode($user->business->issuing_agents, true) ?? [])->sum('rev_pc')); ?>%</span>
                                        </p>
                                        <?php endif; ?>

                                        <?php if($user->business->kyc_status == 'APPROVED'): ?>
                                        <?php $__currentLoopData = getGateways(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.gateway', ['gateway' => $gateway,'user' => $user,'settings' => $set,'currency' => $currency])->html();
} elseif ($_instance->childHasBeenRendered($gateway->id)) {
    $componentId = $_instance->getRenderedChildComponentId($gateway->id);
    $componentTag = $_instance->getRenderedChildComponentTagName($gateway->id);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild($gateway->id);
} else {
    $response = \Livewire\Livewire::mount('user.gateway', ['gateway' => $gateway,'user' => $user,'settings' => $set,'currency' => $currency]);
    $html = $response->html();
    $_instance->logRenderedChild($gateway->id, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?></livewire:user.gateway>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <button id="kt_deposit_money_button" class="btn btn-dark me-3"><i class="bi bi-plus-lg"></i> <?php echo e(__('Add Funds')); ?></button>
                                        <button id="kt_withdraw_money_button" class="btn btn-dark"><i class="bi bi-bank"></i> <?php echo e(__('Withdraw')); ?></button>
                                        <div wire:ignore.self id="kt_deposit_money" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_deposit_money_button" data-kt-drawer-close="#kt_deposit_money_close" data-kt-drawer-width="{'md': '500px'}">
                                            <div class="card w-100">
                                                <div class="card-header pe-5 border-0">
                                                    <div class="card-title">
                                                        <div class="d-flex justify-content-center flex-column me-3">
                                                            <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Top up')); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_deposit_money_close">
                                                            <span class="svg-icon svg-icon-2">
                                                                <i class="bi bi-x-lg fs-2"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body text-wrap">
                                                    <div class="pb-5 mt-10 position-relative zindex-1">
                                                        <!--begin::Item-->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <?php if($set->bk_status == 1): ?>
                                                                <div class="d-flex flex-stack cursor-pointer bg-secondary rounded-4 p-3 mb-5" id="kt_bank_deposit_button">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="symbol symbol-45px symbol-circle me-4">
                                                                            <div class="symbol-label bg-danger">
                                                                                <i class="bi bi-bank text-white fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="ps-1">
                                                                            <p href="#" class="fs-7 text-dark fw-bold mb-0"><?php echo e(__('ACH (Bank Transfer)')); ?></p>
                                                                            <p class="fs-7 text-gray-600 mb-0"><?php if($set->deposit_percent_pc!=null): ?><?php echo e($set->deposit_percent_pc); ?>% <?php else: ?> 0% <?php endif; ?>+ <?php if($set->deposit_fiat_pc!=null): ?><?php echo e($set->deposit_fiat_pc); ?> <?php else: ?> 0 <?php endif; ?><?php echo e($currency->currency); ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div wire:ignore.self id="kt_bank_deposit" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_bank_deposit_button" data-kt-drawer-close="#kt_bank_deposit_close" data-kt-drawer-width="{'md': '500px'}">
                                                                    <div class="card w-100">
                                                                        <div class="card-header pe-5 border-0">
                                                                            <div class="card-title">
                                                                                <div class="d-flex justify-content-center flex-column me-3">
                                                                                    <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1"><?php echo e(__('Bank Transfer')); ?></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-toolbar">
                                                                                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_bank_deposit_close">
                                                                                    <span class="svg-icon svg-icon-2">
                                                                                        <i class="bi bi-x-lg fs-2"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-body text-wrap">
                                                                            <div class="pb-5 position-relative zindex-1">
                                                                                <form wire:submit.prevent="bankDeposit">
                                                                                    <?php echo csrf_field(); ?>
                                                                                    <div class="fv-row mb-6">
                                                                                        <label class="form-label fs-7 text-dark"><?php echo e(__('Amount')); ?> (<?php echo e($currency->currency); ?>)</label>
                                                                                        <input class="form-control form-control-solid" type="text" step="any" wire:model.debounce.500ms="bank_amount" autocomplete="transaction-amount" id="amount" min="1" required placeholder="<?php echo e(__('0.00')); ?>" autofocus />
                                                                                        <?php $__errorArgs = ['bank_amount'];
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
                                                                                    <div class="fv-row mb-6">
                                                                                        <label class="form-label text-dark fs-7" for="bank_reference"><?php echo e(__('Bank Transaction Reference')); ?></label>
                                                                                        <input class="form-control form-control-solid" type="text" wire:model.defer="bank_reference" required id="bank_reference" placeholder="<?php echo e(__('Transaction Reference')); ?>" />
                                                                                        <?php $__errorArgs = ['bank_reference'];
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
                                                                                    <div class="fv-row mb-6">
                                                                                        <label class="form-label fs-7 text-dark"><?php echo e(__('Transaction Receipt')); ?></label>
                                                                                        <input class="form-control form-control-solid" type="file" wire:model="image" required />
                                                                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                                        <div wire:loading wire:target="image"><?php echo e(__('Uploading')); ?>...</div>
                                                                                    </div>
                                                                                    <div class="bg-light-warning px-6 py-5 mb-10 rounded-4">
                                                                                        <p class="text-dark fs-7 fw-bold"><?php echo e(__('Account Details')); ?></p>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Bank Name')); ?>: <?php echo e($set->dp_bank_name); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="<?php echo e($set->dp_bank_name); ?>" title="<?php echo e(__('Copy')); ?>"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Routing Type')); ?>: <?php echo e($set->bk_routing_type); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="<?php echo e($set->bk_routing_type); ?>" title="<?php echo e(__('Copy')); ?>"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Routing Code')); ?>: <?php echo e($set->bk_routing_code); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="<?php echo e($set->bk_routing_code); ?>" title="<?php echo e(__('Copy')); ?>"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Account Number')); ?>: <?php echo e($set->bk_acct_no); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="<?php echo e($set->bk_acct_no); ?>" title="<?php echo e(__('Copy')); ?>"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1">
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Account Name')); ?>: <?php echo e($set->bk_acct_name); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="<?php echo e($set->bk_acct_name); ?>" title="<?php echo e(__('Copy')); ?>"></i></span>
                                                                                        </li>
                                                                                        <li class="d-flex align-items-center py-1" wire:ignore>
                                                                                            <span class="bullet me-5 bg-success bullet-vertical"></span> <span><?php echo e(__('Transaction Description')); ?>: <?php echo e($trx); ?> <i class="bi bi-clipboard-check text-dark castro-copy fs-7" data-clipboard-text="<?php echo e($trx); ?>" title="<?php echo e(__('Copy')); ?>"></i></span>
                                                                                        </li>
                                                                                    </div>
                                                                                    <div class="bg-light-primary px-6 py-5 mb-10 rounded-4">
                                                                                        <p class="text-dark fs-7 mb-0"><b><?php echo e(__('You will receive')); ?></b>: <?php echo e($receive); ?></span></p>
                                                                                        <p class="text-dark fs-7 mb-0"><b><?php echo e(__('Fee')); ?></b>: <?php echo e($fee); ?></span></p>
                                                                                    </div>
                                                                                    <div class="text-center mt-10">
                                                                                        <button class="btn btn-block btn-success" type="submit">
                                                                                            <span wire:loading.remove wire:target="bankDeposit"><?php echo e(__('I\'hv made payment')); ?></span>
                                                                                            <span wire:loading wire:target="bankDeposit"><?php echo e(__('Submitting request...')); ?></span>
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php $__currentLoopData = getGateways(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-md-12">
                                                                <div class="d-flex flex-stack cursor-pointer bg-secondary rounded-4 p-3 mb-5" data-bs-toggle="modal" data-bs-target="#gateway_deposit<?php echo e($gateway->id); ?>">
                                                                    <div class="d-flex align-items-center me-2">
                                                                        <div class="symbol symbol-45px me-5 symbol-circle">
                                                                            <span class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$gateway->image); ?>);"></span>
                                                                        </div>
                                                                        <div class="me-5">
                                                                            <p class="fs-7 text-dark fw-bold mb-0"><?php echo e($gateway->name); ?></p>
                                                                            <p class="fs-7 text-gray-600 mb-0"><?php if($gateway->percent_charge!=null): ?><?php echo e($gateway->percent_charge); ?>% <?php else: ?> 0% <?php endif; ?>+ <?php if($gateway->fiat_charge!=null): ?><?php echo e($gateway->fiat_charge); ?> <?php else: ?> 0 <?php endif; ?><?php echo e($currency->currency); ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user.withdraw', ['user' => $user, 'settings' => $set, 'currency' => $currency])->html();
} elseif ($_instance->childHasBeenRendered('l694739723-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l694739723-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l694739723-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l694739723-1');
} else {
    $response = \Livewire\Livewire::mount('user.withdraw', ['user' => $user, 'settings' => $set, 'currency' => $currency]);
    $html = $response->html();
    $_instance->logRenderedChild('l694739723-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo e(route('developer.index')); ?>" target="_blank">
                        <div class="d-flex flex-stack cursor-pointer bg-white rounded-4 p-3">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px symbol-circle me-4">
                                    <div class="symbol-label bg-danger">
                                        <i class="bi bi-braces text-white fs-3"></i>
                                    </div>
                                </div>
                                <div class="ps-1">
                                    <p href="#" class="fs-7 text-dark fw-bold mb-0"><?php echo e(__('API Documentation')); ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <hr class="bg-secondary mb-0 mt-5">
                    <h4 class="mb-0 fw-bold mb-5"><?php echo e(__('Sales')); ?> (<?php echo e(__('Last 30 days')); ?>)</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-5 mb-5">
                                <p class="fs-7"><?php echo e(__('All Time Sales')); ?></p>
                                <h3><?php echo e($currency->currency_symbol.number_format($sales, 2)); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-5 mb-5">
                                <p class="fs-7"><?php echo e(__('Total Card Issued')); ?></p>
                                <h3><?php echo e(number_format_short($issued)); ?></h3>
                            </div>
                        </div>
                    </div>
                    <hr class="bg-secondary mb-0 mt-5">
                    <h5 class="fw-bold mb-5"><?php echo e(__('API Response Codes')); ?></h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="p-5 rounded-4 border border-secondary mb-5">
                                <p class="fs-7 mb-0"><span class="dot bg-success"></span><?php echo e(__('Success')); ?> (200)</p>
                                <p class="fs-5 fw-bold"><?php echo e($successLogs); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-5 rounded-4 border border-secondary mb-5">
                                <p class="fs-7 mb-0"><span class="dot bg-warning"></span><?php echo e(__('Client error')); ?> (400)</p>
                                <p class="fs-5 fw-bold"><?php echo e($clientLogs); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-5 rounded-4 border border-secondary mb-5">
                                <p class="fs-7 mb-0"><span class="dot bg-danger"></span><?php echo e(__('Server error')); ?> (500)</p>
                                <p class="fs-5 fw-bold"><?php echo e($serverLogs); ?></p>
                            </div>
                        </div>
                    </div>
                    <div id="logChart" wire:ignore.self class="mb-10"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    let chart;
    window.livewire.on('loadChart', data => {
        const series = data.series;
        const categories = data.categories;
        const colorMap = data.colors;

        var options = {
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: false
                },
            },
            series: series,
            xaxis: {
                categories: categories
            },
            colors: series.map(s => colorMap[s.name] || '#000'), // JS logic here
            stroke: {
                width: 2 // or 1 if you want it thinner
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return Number.isInteger(val) ? val : parseInt(val);
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return Number.isInteger(val) ? val : parseInt(val);
                    }
                }
            },
            legend: {
                show: false,
                position: 'top'
            }
        };

        chart = new ApexCharts(document.querySelector("#logChart"), options);
        chart.render();
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/balance.blade.php ENDPATH**/ ?>