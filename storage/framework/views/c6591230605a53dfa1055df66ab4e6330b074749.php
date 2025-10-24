<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo e($title); ?> | <?php echo e($set->site_name); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?php echo e($set->site_desc); ?>" />
    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>" id="csrf_token" data-turbolinks-permanent>
    <link rel="shortcut icon" href="<?php echo e(asset('asset/images/favicon.png')); ?>" />
    <link href="<?php echo e(asset('dashboard/plugins/custom/leaflet/leaflet.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('dashboard/plugins/global/plugins.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('dashboard/plugins/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('dashboard/css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('vendor/megaphone/css/megaphone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/filepond/css/filepond.css')); ?>">
    <?php echo \Livewire\Livewire::styles(); ?>

    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->make('partials.font', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-fixed aside-default-enabled">
    <div class="page-loading active text-indigo">
        <div class="page-loading-inner">
            <div class="page-spinner"></div><span></span>
        </div>
    </div>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.menu', ['admin' => $admin, 'settings' => $set])->html();
} elseif ($_instance->childHasBeenRendered('I2m4pe0')) {
    $componentId = $_instance->getRenderedChildComponentId('I2m4pe0');
    $componentTag = $_instance->getRenderedChildComponentTagName('I2m4pe0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('I2m4pe0');
} else {
    $response = \Livewire\Livewire::mount('admin.menu', ['admin' => $admin, 'settings' => $set]);
    $html = $response->html();
    $_instance->logRenderedChild('I2m4pe0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
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
                            <!--begin::Menu wrapper-->
                            <a href="<?php echo e(route('home')); ?>" target="_blank" class="me-5 btn btn-secondary">
                                <?php echo e(__('Visit Homepage')); ?>

                            </a>
                            <div class="cursor-pointer symbol symbol-50px symbol-circle" data-kt-menu-trigger="{default: 'click'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <div class="symbol-label fs-2 fw-bolder text-dark bg-warning"><i class="bi bi-person text-dark fs-2"></i></div>
                            </div>
                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-7 w-275px" data-kt-menu="true" style="">
                                <!--begin::Menu item-->
                                <div class="menu-item px-5 mb-0">
                                    <a href="<?php echo e(route('admin.settings', ['type' => 'system'])); ?>" class="menu-link px-5 py-3">
                                        <i class="bi bi-gear-wide-connected me-3 text-dark"></i> <?php echo e(__('System settings')); ?>

                                    </a>
                                </div>

                                <div class="separator"></div>

                                <div class="menu-item px-5 mb-0">
                                    <a href="<?php echo e(route('admin.logout')); ?>" class="menu-link px-5 py-3">
                                        <i class="fal fa-sign-out me-3"></i> <?php echo e(__('Sign Out')); ?>

                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::User account menu-->
                            <!--end::Menu wrapper-->
                        </div>
                        <!--end::User -->
                        <!--begin::Aside Toggle-->
                        <div class="d-flex align-items-center d-lg-none ms-1 ms-lg-3">
                            <div class="btn btn-icon btn-icon-dark btn-active-light-success w-30px h-30px w-md-40px h-md-40px" id="kt_aside_toggle">
                                <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                                <span class="svg-icon svg-icon-2x">
                                    <i class="fa-thin fa-bars"></i>
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
                <div class="text-dark order-2 order-md-1">
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
    <script src="<?php echo e(asset('asset/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/js/custom/general.js')); ?>"></script>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.laralert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('laralert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</body>

</html>
<?php echo \Livewire\Livewire::scripts(); ?>

<?php echo $__env->yieldPushContent('scripts'); ?>
<script src="<?php echo e(asset('dashboard/js/alpine.js')); ?>"></script>
<?php echo $__env->yieldContent('script'); ?>

<?php echo $__env->make('partials.extra_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<script>
    document.addEventListener('livewire:load', function() {
        Livewire.hook('message.failed', (message, component) => {
            showSpinner('disabled');
        });

        const originalFetch = window.fetch;
        window.fetch = async function(...args) {
            try {
                const response = await originalFetch.apply(this, args);

                // Handle any failed request, not just Livewire
                if (!response.ok) {
                    // Check if it's a Laravel error by looking at response headers
                    const contentType = response.headers.get('content-type');
                    const isJsonResponse = contentType && contentType.includes('application/json');
                    const isHtmlResponse = contentType && contentType.includes('text/html');

                    // Try to read the response to check for Laravel error signatures
                    let responseText = '';
                    try {
                        const clonedResponse = response.clone();
                        responseText = await clonedResponse.text();
                    } catch (e) {}

                    // Check if it's a Laravel error page
                    const isLaravelError = responseText.includes('Laravel') ||
                        responseText.includes('Whoops!') ||
                        responseText.includes('symfony') ||
                        responseText.includes('Illuminate\\');

                    if (response.status === 500) {
                        if (isLaravelError) {
                            showSpinner('disabled');
                            createToast("warning", "<?php echo e(__('An error occurred. Try again later')); ?>");
                        } else {
                            showSpinner('disabled');
                            createToast("warning", "<?php echo e(__('An error occurred. Try again later')); ?>");
                        }
                    }

                    // For Livewire requests, return fake success response
                    if (args[0].includes('livewire') || args[0].includes('/livewire/')) {
                        return new Response(JSON.stringify({
                            effects: {
                                html: '',
                                dirty: []
                            },
                            serverMemo: {}
                        }), {
                            status: 200,
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        });
                    }
                }

                return response;
            } catch (error) {

            }
        };
    });
</script><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/admin/menu.blade.php ENDPATH**/ ?>