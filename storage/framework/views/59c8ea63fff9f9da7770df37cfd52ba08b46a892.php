<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo e($title); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?php echo e($set->site_desc); ?>" />
    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>" id="csrf_token" data-turbolinks-permanent>
    <link rel="shortcut icon" href="<?php echo e(asset('asset/images/favicon.png')); ?>" />
    <link href="<?php echo e(asset('asset/fonts/fontawesome/css/all.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('dashboard/plugins/custom/leaflet/leaflet.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('dashboard/plugins/global/plugins.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('dashboard/css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(asset('vendor/prism/prism.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dashboard/css/docs.css')); ?>" type="text/css">
    <?php echo \Livewire\Livewire::styles(); ?>

    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->make('partials.font', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<!-- header begin-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
    <div class="page-loading active text-indigo">
        <div class="page-loading-inner">
            <div class="page-spinner"></div><span></span>
        </div>
    </div>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div id="kt_aside" class="aside aside-default bg-white aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
                <div class="aside-logo flex-column-auto pt-9 pb-10" id="kt_aside_logo">
                    <a href="<?php echo e(route('home')); ?>">
                        <img alt="Logo" src="<?php echo e(asset('asset/images/'.getUi()->dashboard_logo.'.png')); ?>" class="logo-default" style="<?php echo \Illuminate\Support\Arr::toCssStyles(getUi()->dashboard_light_css) ?>"/>
                        <img alt="Logo" src="<?php echo e(asset('asset/images/'.getUi()->dashboard_logo.'.png')); ?>" class="h-50px logo-minimize" style="<?php echo \Illuminate\Support\Arr::toCssStyles(getUi()->dashboard_light_css) ?>"/>
                    </a>
                </div>
                <div class="aside-menu flex-column-fluid">
                    <div class="menu menu-column menu-fit menu-rounded menu-title-dark menu-icon-dark menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-bold fs-7 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
                        <div class="menu-fit hover-scroll-y me-lg-n5 pe-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="20px" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer">
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.index')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.index')); ?>">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-house-check fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title"><?php echo e(__('Introduction')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.environments')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.environments')); ?>">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-globe fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title"><?php echo e(__('Environment')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.authentication')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.authentication')); ?>">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-unlock fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title"><?php echo e(__('Authentication')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.errors')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.errors')); ?>">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-bug fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title"><?php echo e(__('Errors')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.webhook')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.webhook')); ?>">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-send-check fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title"><?php echo e(__('Webhook')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link" href="<?php echo e(route('user.profile', ['type' => 'api'])); ?>" target="_blank">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-key fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title"><?php echo e(__('Get API Keys')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <div class="menu-content">
                                    <div class="separator mx-1 my-4"></div>
                                </div>
                            </div>
                            <p class="text-muted"><?php echo e(__('API Reference')); ?></p>
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1 <?php if(in_array(url()->current(), [route('developer.card.all'), route('developer.card.single')])): ?> here show <?php endif; ?>">
                                <span class="menu-link">
                                    <span class="menu-title ms-5"><?php echo e(__('Gift Cards')); ?></span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion menu-active-bg">
                                    <div class="menu-item mb-0">
                                        <a class="menu-link <?php if(route('developer.card.all')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.card.all')); ?>">
                                            <span class="menu-title text-gray-700 ms-5"><?php echo e(__('Cards')); ?></span>
                                        </a>
                                    </div>
                                    <div class="menu-item mb-0">
                                        <a class="menu-link <?php if(route('developer.card.single')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.card.single')); ?>">
                                            <span class="menu-title text-gray-700 ms-5"><?php echo e(__('A Card')); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1 <?php if(in_array(url()->current(), [route('developer.transaction.all'), route('developer.transaction.single')])): ?> here show <?php endif; ?>">
                                <span class="menu-link">
                                    <span class="menu-title ms-5"><?php echo e(__('Transactions')); ?></span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion menu-active-bg">
                                    <div class="menu-item mb-0">
                                        <a class="menu-link <?php if(route('developer.transaction.all')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.transaction.all')); ?>">
                                            <span class="menu-title text-gray-700 ms-5"><?php echo e(__('Transactions')); ?></span>
                                        </a>
                                    </div>
                                    <div class="menu-item mb-0">
                                        <a class="menu-link <?php if(route('developer.transaction.single')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.transaction.single')); ?>">
                                            <span class="menu-title text-gray-700 ms-5"><?php echo e(__('A Transaction')); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-item mb-1"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.countries')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.countries')); ?>">

                                    <span class="menu-title ms-5"><?php echo e(__('Countries')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item mb-1"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.quote')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.quote')); ?>">
                                    <span class="menu-title ms-5"><?php echo e(__('Get Quote')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item mb-1"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.order')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.order')); ?>">
                                    <span class="menu-title ms-5"><?php echo e(__('Order Card')); ?></span>
                                </a>
                            </div>
                            <div class="menu-item mb-1"><!--begin:Menu link-->
                                <a class="menu-link <?php if(route('developer.balance')==url()->current()): ?> active <?php endif; ?>" href="<?php echo e(route('developer.balance')); ?>">
                                    <span class="menu-title ms-5"><?php echo e(__('Account Balance')); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="aside-footer flex-column-auto" id="kt_aside_footer"></div>
            </div>
        </div>
    </div>
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <!--begin::Header-->
        <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
            <!--begin::Container-->
            <div class="container-fluid d-flex align-items-stretch justify-content-between">
                <!--begin::Logo bar-->
                <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                    <!--begin::Logo-->
                    <a href="<?php echo e(route('home')); ?>" class="d-lg-none">
                        <img alt="Logo" src="<?php echo e(asset('asset/images/'.getUi()->dashboard_logo.'.png')); ?>" style="height:auto; max-width:50%;" />
                    </a>
                    <!--end::Logo-->
                </div>
                <!--end::Logo bar-->
                <!--begin::Topbar-->
                <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                    <!--begin::Search-->
                    <div class="d-flex align-items-stretch">

                    </div>
                    <!--end::Search-->
                    <!--begin::Toolbar wrapper-->
                    <div class="d-flex align-items-stretch flex-shrink-0">
                        <!--begin::User-->
                        <div class="d-flex align-items-center ms-2 ms-lg-3" id="kt_header_user_menu_toggle">
                            <a class="text-success me-5 fs-7 fw-bold" href="<?php echo e(route('developer.card.all')); ?>"><?php echo e(__('API Reference')); ?></a>
                            <a class="btn btn-success" href="<?php echo e(route('register')); ?>" target="_blank"><?php echo e(__('Create Account')); ?></a>
                        </div>
                        <!--end::User -->
                        <!--begin::Aside Toggle-->
                        <div class="d-flex align-items-center d-lg-none ms-1 ms-lg-3">
                            <div class="btn btn-icon btn-icon-dark btn-active-light-success w-30px h-30px w-md-40px h-md-40px" id="kt_aside_toggle">
                                <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                                <span class="svg-icon svg-icon-2x">
                                    <i class="fal fa-bars"></i>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                        </div>
                        <!--end::Aside Toggle-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <!--end::Topbar-->
            </div>
            <!--end::Container-->
        </div>
        <div class="content fs-7 d-flex flex-column flex-column-fluid" id="kt_content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
            <!--begin::Container-->
            <div class="container-fluid d-flex flex-column flex-md-row flex-stack">
                <!--begin::Copyright-->
                <div class="col-md-12">
                    <span class="text-muted fw-bold me-2"><?php echo e(date('Y')); ?> ©</span>
                    <a href="<?php echo e(route('home')); ?>" target="_blank" class="text-gray-800 text-hover-success"><?php echo e($set->site_name); ?></a>
                </div>
                <!--end::Copyright-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Footer-->
    </div>

    <script src="<?php echo e(asset('dashboard/plugins/global/plugins.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/js/scripts.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/fonts/fontawesome/js/all.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/js/custom/general.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/prism/prism.js')); ?>"></script>

</body>

</html>
<?php echo \Livewire\Livewire::scripts(); ?>

<?php echo $__env->yieldContent('script'); ?>

<script>
    $(document).ready(function() {
        $("code[class^='language-']").each(function() {
            $(this).html($(this).html().trim());
        });
        Prism.highlightAll();
    });
</script>

<?php echo $__env->make('partials.extra_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/developer/menu.blade.php ENDPATH**/ ?>