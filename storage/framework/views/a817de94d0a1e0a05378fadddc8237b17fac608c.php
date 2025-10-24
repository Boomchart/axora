<div>
    <div class="mb-10">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-row-bordered align-middle gy-6">
                    <tbody class="fs-7 fw-semibold">
                        <!--begin::Table row-->
                        <tr>
                            <td class="min-w-250px fs-7 fw-bold"><?php echo e(__('Login Alert')); ?></td>
                            <td class="w-125px">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" wire:click="save" wire:model="login_alert">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="min-w-250px fs-7 fw-bold"><?php echo e(__('Transaction Notifications')); ?></td>
                            <td class="w-125px">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" wire:click="save" wire:model="transaction_notification">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="min-w-250px fs-7 fw-bold"><?php echo e(__('Promotional Emails')); ?></td>
                            <td class="w-125px">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" wire:click="save" wire:model="promotional_emails">
                                </div>
                            </td>
                        </tr>
                        <!--begin::Table row-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/user/settings/notifications.blade.php ENDPATH**/ ?>