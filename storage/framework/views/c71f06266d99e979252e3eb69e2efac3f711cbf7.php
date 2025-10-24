<?php $__env->startSection('content'); ?>
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-6"><?php echo e($title); ?></h1>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <p class="mb-5 text-dark"><span class="badge badge-pill badge-secondary me-3"><?php echo e(__('Post')); ?> </span> <i class="text-dark"><?php echo e(url("/")); ?>/api/v1/quote</i></p>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="fw-bold fs-6 mb-3"><?php echo e(__('Headers')); ?></h4>
                        <div class="p-10 bg-secondary mb-3 rounded-5">
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold"><?php echo e(__('Authorization')); ?></span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark"><?php echo e(__('string')); ?></span> </p>
                                <p class="fs-8"><?php echo e(__('Pass your')); ?> {secret_key} <?php echo e(__('as a bearer token in the request header to authorize this call')); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4 class="fw-bold fs-6 mb-3"><?php echo e(__('Body parameters')); ?></h4>
                        <div class="p-10 bg-secondary mb-3 rounded-5">
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold"><?php echo e(__('card_id')); ?></span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark"><?php echo e(__('string')); ?></span> </p>
                                <p class="fs-8"><?php echo e(__('ID of card')); ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold"><?php echo e(__('amount')); ?></span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark"><?php echo e(__('numeric')); ?></span> </p>
                                <p class="fs-8"><?php echo e(__('Card Amount')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="fw-bold fs-6 mb-3"><?php echo e(__('Response')); ?></h4>
                        <pre class="rounded-3" style="min-height: 50vh;">
<code class="language-json" style="font-size: 0.65rem !important;" data-lang="json">
{
    "message": "Quote calculated",
    "status": "success",
    "data": {
        "id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
        "amount": 200,
        "exchange_rate": 1.359077764815,
        "converted_to_usd": 271.815552963,
        "charge": 5.44,
        "total": 277.255552963
    }
}
</code>
</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('developer.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/developer/quote.blade.php ENDPATH**/ ?>