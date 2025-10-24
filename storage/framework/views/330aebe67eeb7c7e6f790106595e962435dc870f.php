<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4"><?php echo e(__('Dashboard')); ?></h1>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1 mb-6">
                <a href="<?php echo e(route('run.migration')); ?>" class="btn btn-white text-dark me-4"><i class="bi bi-database"></i> <?php echo e(__('Run migrations')); ?></a>
                <a href="<?php echo e(route('optimize.system')); ?>" class="btn btn-warning text-dark me-4"><i class="bi bi-lightning"></i> <?php echo e(__('Clear Data Cache')); ?></a>
            </div>
        </div>
        <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
            <div class="container">
                <?php if($set->maintenance == 1): ?>
                <div class="alert alert-danger mb-6">
                    <div class="d-flex flex-column">
                        <span><?php echo e(__('Maintenance mode is turned on, users won\'t be able to create an account & login')); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row mb-5">
                    <div class="col-md-3 mb-5">
                        <div class="card p-5 bg-secondary">
                            <div class="d-flex justify-content-between">
                                <p class="fs-7 text-dark"><?php echo e(__('Pending KYC')); ?></p>
                                <a href="<?php echo e(route('admin.users', ['type' => 'kyc'])); ?>" target="_blank"><i class="bi bi-arrow-right-circle text-dark fs-2"></i></a>
                            </div>
                            <h3 class="text-dark"><?php echo e(number_format_short($admin->pendingKYC())); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <div class="card p-5 bg-secondary">
                            <div class="d-flex justify-content-between">
                                <p class="fs-7 text-dark"><?php echo e(__('Open Support Ticket')); ?></p>
                                <a href="<?php echo e(route('admin.ticket', ['type' => 'open'])); ?>" target="_blank"><i class="bi bi-arrow-right-circle text-dark fs-2"></i></a>
                            </div>
                            <h3 class="text-dark"><?php echo e(number_format_short($admin->openTickets())); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <div class="card p-5 bg-secondary">
                            <div class="d-flex justify-content-between">
                                <p class="fs-7 text-dark"><?php echo e(__('Unread Messages')); ?></p>
                                <a href="<?php echo e(route('admin.message', ['type' => 'inbox'])); ?>" target="_blank"><i class="bi bi-arrow-right-circle text-dark fs-2"></i></a>
                            </div>
                            <h3 class="text-dark"><?php echo e(number_format_short($admin->unreadMessages())); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <div class="card p-5 bg-secondary">
                            <div class="d-flex justify-content-between">
                                <p class="fs-7 text-dark"><?php echo e(__('Watchlist')); ?></p>
                                <a href="<?php echo e(route('admin.watchlist')); ?>" target="_blank"><i class="bi bi-arrow-right-circle text-dark fs-2"></i></a>
                            </div>
                            <h3 class="text-dark"><?php echo e(number_format_short($admin->watchList())); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <div class="card p-5 bg-secondary">
                            <div class="d-flex justify-content-between">
                                <p class="fs-7 text-dark"><?php echo e(__('Pending Orders')); ?></p>
                                <a href="<?php echo e(route('admin.orders')); ?>" target="_blank"><i class="bi bi-arrow-right-circle text-dark fs-2"></i></a>
                            </div>
                            <h3 class="text-dark"><?php echo e(number_format_short($admin->pendingOrders())); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <div class="card p-5 bg-secondary">
                            <div class="d-flex justify-content-between">
                                <p class="fs-7 text-dark"><?php echo e(__('Completed Orders')); ?></p>
                                <a href="<?php echo e(route('admin.orders')); ?>" target="_blank"><i class="bi bi-arrow-right-circle text-dark fs-2"></i></a>
                            </div>
                            <h3 class="text-dark"><?php echo e(number_format_short($admin->completedOrders())); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <div class="card p-5 bg-secondary">
                            <div class="d-flex justify-content-between">
                                <p class="fs-7 text-dark"><?php echo e(__('Pending Transactions')); ?></p>
                                <a href="<?php echo e(route('admin.transactions')); ?>" target="_blank"><i class="bi bi-arrow-right-circle text-dark fs-2"></i></a>
                            </div>
                            <h3 class="text-dark"><?php echo e(number_format_short($admin->pendingTransactions())); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <div class="card p-5 bg-secondary">
                            <div class="d-flex justify-content-between">
                                <p class="fs-7 text-dark"><?php echo e(__('Completed Transactions')); ?></p>
                                <a href="<?php echo e(route('admin.transactions')); ?>" target="_blank"><i class="bi bi-arrow-right-circle text-dark fs-2"></i></a>
                            </div>
                            <h3 class="text-dark"><?php echo e(number_format_short($admin->completedTransactions())); ?></h3>
                        </div>
                    </div>
                </div>
                <form>
                    <div class="fv-row mb-6 form-floating">
                        <div class="input-group">
                            <span class="input-group-text bg-white" id="range"><i class="bi bi-calendar me-2"></i> <?php echo e(__('Period')); ?>:</span>
                            <input class="form-control form-control-solid form-control-lg bg-white" placeholder="<?php echo e(__('Pick date range')); ?>" wire:model="date" autofocus="false">
                        </div>
                    </div>
                </form>
                <div class="d-flex justify-content-between mb-5">
                    <h5 class="fw-bold mb-3"><?php echo e(__('API Response Codes')); ?></h5>
                    <a class="btn btn-dark btn-sm rounded-pill" href="<?php echo e(route('admin.api.logs')); ?>" target="_blank"><i class="bi bi-code-square"></i> <?php echo e(__('API Logs')); ?></a>
                </div>
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
<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:load', function() {
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
        Livewire.emit('launchChart');
    });
</script>

<script>
    $(function() {
        var start = '<?php echo e($first); ?>';
        var end = '<?php echo e($last); ?>';

        function cb(start, end) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('date', start.format('M/D/YYYY') + ' - ' + end.format('M/D/YYYY'));
        }

        $('#range').daterangepicker({
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
<script>
    "use strict";
    var KTProjectList = {
        init: function() {
            !(function() {
                var t = document.getElementById("kt_user_list_chart");
                if (t) {
                    var e = t.getContext("2d");
                    new Chart(e, {
                        type: "doughnut",
                        data: {
                            datasets: [{
                                data: ["<?php echo e(number_format_short_nc($admin->customers('active'))); ?>", "<?php echo e(number_format_short_nc($admin->customers('blocked'))); ?>", "<?php echo e(number_format_short_nc($admin->customers('kyc'))); ?>", "<?php echo e(number_format_short_nc($admin->customers('deleted'))); ?>"],
                                backgroundColor: ["#CFFF45", "#50cd89", "#b5b5c3", "#f1416c"]
                            }],
                            labels: ["Active", "Blocked", "KYC Pending", "Deleted"]
                        },
                        options: {
                            chart: {
                                fontFamily: "inherit"
                            },
                            cutout: "75%",
                            cutoutPercentage: 65,
                            responsive: !0,
                            maintainAspectRatio: !1,
                            title: {
                                display: !1
                            },
                            animation: {
                                animateScale: !0,
                                animateRotate: !0
                            },
                            tooltips: {
                                enabled: !0,
                                intersect: !1,
                                mode: "nearest",
                                bodySpacing: 5,
                                yPadding: 10,
                                xPadding: 10,
                                caretPadding: 0,
                                displayColors: !1,
                                backgroundColor: "#20D489",
                                titleFontColor: "#ffffff",
                                cornerRadius: 4,
                                footerSpacing: 0,
                                titleSpacing: 0,
                            },
                            plugins: {
                                legend: {
                                    display: !1
                                }
                            },
                        },
                    });
                }
            })();
        },
    };
    KTUtil.onDOMContentLoaded(function() {
        KTProjectList.init();
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/dashboard.blade.php ENDPATH**/ ?>