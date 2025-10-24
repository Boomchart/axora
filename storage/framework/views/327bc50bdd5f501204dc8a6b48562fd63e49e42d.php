<div>
    <div id="kt_aside" wire:ignore class="aside aside-default bg-white aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
        <div class="aside-logo flex-column-auto pt-9 pb-10" id="kt_aside_logo">
            <a href="<?php echo e(route('home')); ?>">
                <img alt="Logo" src="<?php echo e(asset('asset/images/'.getUi()->dashboard_logo.'.png')); ?>" class="logo-default" style="<?php echo \Illuminate\Support\Arr::toCssStyles(getUi()->dashboard_light_css) ?>" />
                <img alt="Logo" src="<?php echo e(asset('asset/images/'.getUi()->dashboard_logo.'.png')); ?>" class="logo-minimize" style="<?php echo \Illuminate\Support\Arr::toCssStyles(getUi()->dashboard_light_css) ?>" />
            </a>
        </div>
        <div class="aside-menu flex-column-fluid">
            <div class="menu menu-column menu-fit menu-rounded menu-title-dark menu-icon-dark menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fs-7 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
                <div class="menu-fit hover-scroll-y me-lg-n5 pe-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="20px" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer">
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(route('admin.dashboard')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                            <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <i class="bi bi-house-check fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Dashboard')); ?></span>
                        </a>
                    </div>
                    <?php if($admin->giftcard): ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(strpos(url()->current(), 'admin/transactions') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('admin.transactions')); ?>">
                            <span class="menu-icon">
                                <i class="bi bi-clipboard-data fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Transactions')); ?></span>
                        </a>
                    </div>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(strpos(url()->current(), 'admin/orders') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('admin.orders')); ?>">
                            <span class="menu-icon">
                                <i class="bi bi-cart fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Orders')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if((strpos(url()->current(), 'admin/users') !== false) || strpos(url()->current(), 'admin/manage-user') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('admin.users', ['type' => 'all'])); ?>">
                            <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <i class="bi bi-people fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Clients')); ?></span>
                        </a>
                    </div>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(route('admin.watchlist')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('admin.watchlist')); ?>">
                            <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <i class="bi bi-bell-slash fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Watchlist')); ?></span>
                        </a>
                    </div>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(route('admin.kyc')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('admin.kyc')); ?>">
                            <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <i class="bi bi-file-person fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Pending KYC')); ?></span>
                        </a>
                    </div>
                    <?php if($admin->support): ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(strpos(url()->current(), 'admin/ticket') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('admin.ticket', ['type' => 'open'])); ?>">
                            <span class="menu-icon">
                                <i class="bi bi-chat-square-text fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Support Ticket')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if($admin->deposit): ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(strpos(url()->current(), 'admin/deposit') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('admin.deposit', ['type' => 'pending'])); ?>">
                            <span class="menu-icon">
                                <i class="bi bi-arrow-down-circle fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Deposit')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if($admin->payout==1): ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(strpos(url()->current(), 'admin/payout') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('admin.payout', ['type' => 'pending'])); ?>">
                            <span class="menu-icon">
                                <i class="bi bi-arrow-up-circle fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Payout')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if($admin->message): ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(strpos(url()->current(), 'admin/messages') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('admin.message', ['type' => 'inbox'])); ?>">
                            <span class="menu-icon">
                                <i class="bi bi-inbox fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Messages')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if($admin->role=="super"): ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(route('admin.staffs')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('admin.staffs')); ?>">
                            <span class="menu-icon">
                                <i class="bi bi-people fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Staff & Roles')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if($admin->email_configuration): ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(strpos(url()->current(), 'admin/template') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('template.settings', ['type' => 'settings'])); ?>">
                            <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <i class="bi bi-file-richtext fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Email Templates')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if($admin->general_settings): ?>
                    <div class="menu-item"><!--begin:Menu link-->
                        <a wire:ignore.self class="menu-link <?php if(strpos(url()->current(), 'admin/settings') !== false): ?> active <?php endif; ?>" href="<?php echo e(route('admin.settings', ['type' => 'system'])); ?>">
                            <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <i class="bi bi-sliders fs-3 text-whitelabel-menu"></i>
                            </span>
                            <span class="menu-title"><?php echo e(__('Settings')); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="aside-footer flex-column-auto" id="kt_aside_footer"></div>
    </div>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/livewire/admin/menu.blade.php ENDPATH**/ ?>