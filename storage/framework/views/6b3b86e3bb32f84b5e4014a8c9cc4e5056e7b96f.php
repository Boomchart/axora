<?php if($val->type == 'giftcard_purchase' || $val->type == 'revenue_share'): ?>
<div class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val?->buyCardRate?->rateCountry?->buyGiftcard?->logo); ?>)"></div>

<?php elseif($val->type == 'giftcard_sale'): ?>
<div class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val?->sellCategory?->sellGiftcard?->image); ?>)"></div>

<?php elseif($val->type == 'payout'): ?>
<?php if($val->acct_id != null): ?>
<div class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val?->acct?->bank?->image); ?>)"></div>
<?php else: ?>
<div class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val?->withdrawMethod?->image); ?>)"></div>
<?php endif; ?>

<?php elseif($val->type == 'deposit'): ?>
<div class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val?->gateway?->image); ?>)"></div>

<?php elseif($val->type == 'bank_transfer'): ?>
<div class="symbol-label fs-3 fw-bolder bg-warning">
    <i class="fal fa-bank"></i>
</div>

<?php elseif($val->type == 'debit_transfer'): ?>
<?php if($val?->beneficiary?->recipient?->avatar == null): ?>
<span class="symbol-label bg-warning text-dark fw-boldest"><?php echo e(substr(ucwords($val?->beneficiary?->recipient?->name), 0, 1)); ?></span>
<?php else: ?>
<div class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val?->beneficiary?->recipient?->avatar); ?>)"></div>
<?php endif; ?>

<?php elseif($val->type == 'credit_transfer'): ?>
<?php if($val?->sender?->business?->avatar == null): ?>
<span class="symbol-label bg-warning text-dark fw-boldest"><?php echo e(substr(ucwords($val?->sender?->business?->name), 0, 1)); ?></span>
<?php else: ?>
<div class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val?->sender?->business?->avatar); ?>)"></div>
<?php endif; ?>

<?php elseif($val->type == 'referral'): ?>
<?php if($val?->referral?->avatar == null): ?>
<span class="symbol-label bg-warning text-dark fw-boldest"><?php echo e(substr(ucwords($val?->referral?->business?->name), 0, 1)); ?></span>
<?php else: ?>
<div class="symbol-label" style="background-image:url(<?php echo e(url('/').'/storage/app/'.$val?->referral?->avatar); ?>)"></div>
<?php endif; ?>

<?php else: ?>
<div class="symbol-label fs-3 fw-bolder bg-warning">
    <?php if($val->trx_type == 'debit'): ?>
    <i class="bi bi-dash-lg"></i>
    <?php else: ?>
    <i class="bi bi-plus-lg"></i>
    <?php endif; ?>
</div>
<?php endif; ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/partials/transactions/image.blade.php ENDPATH**/ ?>