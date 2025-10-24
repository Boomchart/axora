<?php if($val->rfi_count > 0 && $val->status != 'declined'): ?>
<span class="badge badge-pill badge-danger badge-sm"><?php echo e(ucwords($val->status).' - '.__('Action Required')); ?></span>
<?php else: ?>
<?php if($val->status == 'success'): ?>
<span class="badge badge-pill badge-success badge-sm"><?php echo e(__('Success')); ?></span>
<?php elseif($val->status == 'pending'): ?>
<span class="badge badge-pill badge-warning badge-sm text-dark"><?php echo e(__('Pending')); ?></span>
<?php elseif($val->status == 'failed'): ?>
<span class="badge badge-pill badge-danger badge-sm"><?php echo e(__('Failed')); ?></span>
<?php elseif($val->status == 'cancelled'): ?>
<span class="badge badge-pill badge-danger badge-sm"><?php echo e(__('Cancelled')); ?></span>
<?php elseif($val->status == 'declined'): ?>
<span class="badge badge-pill badge-danger badge-sm"><?php echo e(__('Declined')); ?></span>
<?php endif; ?>
<?php endif; ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/partials/transactions/status.blade.php ENDPATH**/ ?>