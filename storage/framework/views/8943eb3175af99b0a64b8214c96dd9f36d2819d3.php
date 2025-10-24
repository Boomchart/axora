<!doctype html>
<html class="no-js" lang="en">

<head>
    <title><?php echo e($title); ?> - <?php echo e($set->site_name); ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta name="apple-mobile-web-app-title" content="<?php echo e($set->site_name); ?>" />
    <meta name="application-name" content="<?php echo e($set->site_name); ?>" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="description" content="<?php echo e($set->site_desc); ?>" />
    <link rel="shortcut icon" href="<?php echo e(asset('asset/images/favicon.png')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('front/css/theme.css')); ?>" type="text/css" media="all">
    <link rel="preload" media="screen" href="<?php echo e(asset('front/vendor/boxicons/css/boxicons.css')); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" media="screen" href="<?php echo e(asset('front/vendor/lightgallery/css/lightgallery-bundle.min.css')); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" media="screen" href="<?php echo e(asset('front/vendor/swiper/swiper-bundle.min.css')); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" href="<?php echo e(asset('front/css/cookie.css')); ?>" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo e(asset('front/css/toast.css')); ?>" type="text/css">
    <link href="<?php echo e(asset('asset/fonts/fontawesome/css/all.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->make('partials.font', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
    <main class="page-wrapper">
        <header class="header navbar navbar-expand-lg bg-light navbar-sticky">
            <div class="container px-3">
                <a href="<?php echo e(route('home')); ?>" class="navbar-brand pe-3">
                    <img src="<?php echo e(asset('asset/images/logo.png')); ?>" alt="<?php echo e($set->site_name); ?>" loading="lazy" style="<?php echo \Illuminate\Support\Arr::toCssStyles(getUi()->home_light_css) ?>">
                </a>
                <div id="navbarNav" class="offcanvas offcanvas-end">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title"><?php echo e(__('Menu')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                       <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
                            <li class="nav-item">
                                <a href="<?php echo e(route('login')); ?>" class="nav-link"><?php echo e(__('Sign in')); ?></a>
                            </li>                            
                            <li class="nav-item">
                                <a href="<?php echo e(route('register')); ?>" class="nav-link"><?php echo e(__('Register')); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a href="<?php echo e(route('login')); ?>" class="d-none d-lg-inline-flex me-4 text-decoration-none text-dark fw-500" rel="noopener">
                    <?php echo e(__('Log In')); ?>

                </a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-success rounded-pill d-none d-lg-inline-flex" rel="noopener">
                    <?php echo e(__('Get Started')); ?> <i class="fal fa-angle-right mx-2"></i>
                </a>
            </div>
        </header>
        <?php echo $__env->yieldContent('content'); ?>
        <footer class="footer light-mode border-top border-light py-5 bg-white" data-jarallax data-img-position="0% 100%" data-speed="0.5">
            <div class="container pt-lg-4">
                <div class="row pb-5">
                    <div class="col-xl-12 col-lg-12 col-md-12 pt-4 pt-md-1 pt-lg-0">
                        <div id="footer-links" class="row">
                            <div class="col-xl-3 col-lg-3 col-6">
                                <h6 class="mb-4 fs-5 fw-500"><?php echo e(__('Available Cards')); ?></h6>
                                <ul class="nav flex-column mb-2 mb-lg-0">
                                    <?php $__currentLoopData = getCardCategory(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item"><a href="<?php echo e(route('card.category', ['slug' => $card->slug])); ?>" class="footer-link d-inline-block px-0 pt-1 pb-2"><?php echo e($card->name); ?> <?php echo e(__('Gift Cards')); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-6 pt-2 pt-lg-0">
                                <h6 class="mb-4 fs-5 fw-500"><?php echo e(__('Resources')); ?></h6>
                                <ul class="nav flex-column mb-2 mb-lg-0 mb-3">
                                    
                                    <li class="nav-item"><a href="<?php echo e(route('developer.index')); ?>" target="_blank" class="footer-link d-inline-block px-0 pt-1 pb-2"><?php echo e(__('Developer API')); ?></a></li>
                                    <?php if($set->career_url != null): ?>
                                    <li class="nav-item"><a href="<?php echo e($set->career_url); ?>" target="_blank" class="footer-link d-inline-block px-0 pt-1 pb-2"><?php echo e(__('Careers')); ?></a></li>
                                    <?php endif; ?>
                                    <?php $__currentLoopData = getPage(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item"><a href="<?php echo e(route('page', ['page' => $val->slug])); ?>" class="footer-link d-inline-block px-0 pt-1 pb-2"><?php echo e($val->title); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-6 pt-2 pt-lg-0">
                                <h6 class="mb-4 fs-5 fw-500"><?php echo e(__('Legal')); ?></h6>
                                <ul class="nav flex-column mb-2 mb-lg-0">
                                    <li class="nav-item"><a href="<?php echo e(route('terms')); ?>" class="footer-link d-inline-block px-0 pt-1 pb-2"><?php echo e(__('Terms & Conditions')); ?></a></li>
                                    <li class="nav-item"><a href="<?php echo e(route('privacy')); ?>" class="footer-link d-inline-block px-0 pt-1 pb-2"><?php echo e(__('Privacy Policy')); ?></a></li>
                                </ul>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-6 pt-2 pt-lg-0">
                                <h6 class="mb-4 fs-5 fw-500"><?php echo e(__('Contact')); ?></h6>
                                <p class="fs-sm pb-lg-3 mb-0 text-dark"><a href="<?php echo e(route('contact')); ?>" class="footer-link"><?php echo e(__('Get in Touch')); ?></a></p>
                                <p class="fs-sm pb-lg-3 mb-0 text-dark"><a class="footer-link" href="mailto:<?php echo e($set->email); ?>"><i class="bi bi-envelope"></i> <?php echo e($set->email); ?></a></p>
                                <p class="fs-sm mb-3 text-dark"><a class="footer-link" href="tel:<?php echo e($set->mobile); ?>"><i class="fal fa-phone-volume"></i> <?php echo e($set->mobile); ?></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <?php if($set->language): ?>
                        <div class="btn-group dropdown my-5">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fi fi-<?php echo e(strtolower(getDefaultLang()->iso2)); ?> me-2 fis fs-sm rounded-4 text-dark"></span> <span><?php echo e(ucwords(getDefaultLang()->name)); ?> (<?php echo e(ucwords(getDefaultLang()->iso2)); ?>)</span>
                            </button>
                            <div class="dropdown-menu my-1">
                                <?php $__currentLoopData = getLang(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item" href="<?php echo e(route('lang', ['locale' => $val->code])); ?>"><span class="fi fi-<?php echo e(strtolower($val->iso2)); ?> me-2 fis fs-sm rounded-4 text-dark"></span> <?php echo e(ucwords($val->name)); ?> (<?php echo e($val->iso2); ?>)</a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(getUi()->address1_t): ?>
                        <p class="fs-sm pb-lg-3 mb-1 text-dark"><span class="fi fi-<?php echo e(strtolower(getUi()->address1_c)); ?> me-2 fis fs-sm rounded-4 text-dark"></span> <?php echo e(getUi()->address1_t); ?></p>
                        <?php endif; ?>
                        <?php if(getUi()->address2_t): ?>
                        <p class="fs-sm pb-lg-3 mb-1 text-dark"><span class="fi fi-<?php echo e(strtolower(getUi()->address2_c)); ?> me-2 fis fs-sm rounded-4 text-dark"></span> <?php echo e(getUi()->address2_t); ?></p>
                        <?php endif; ?>
                        <?php if(getUi()->address3_t): ?>
                        <p class="fs-sm pb-lg-3 mb-1 text-dark"><span class="fi fi-<?php echo e(strtolower(getUi()->address3_c)); ?> me-2 fis fs-sm rounded-4 text-dark"></span> <?php echo e(getUi()->address3_t); ?></p>
                        <?php endif; ?>
                        <div class="d-flex mb-5">
                            <?php $__currentLoopData = getSocial(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($val->value)): ?>
                            <a href="<?php echo e($val->value); ?>" class="mx-2" target="_blank">
                                <i class="bi bi-<?php echo e(($val->type != 'twitter') ? $val->type : 'twitter-x'); ?> fs-3 text-success"></i>
                            </a>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="space-1">
                    <!-- Copyright -->
                    <div class="w-md-75 text-lg-center mx-lg-auto">
                        <p class="small text-dark">© <?php echo e($set->site_name); ?>. <?php echo e(date('Y')); ?>. <?php echo e(__('All rights reserved.')); ?></p>
                        <p class="small text-dark"><?php echo e(__('When you visit or interact with our sites, services or tools, we or our authorised service providers may use cookies for storing information to help provide you with a better, faster and safer experience and for marketing purposes.')); ?></p>
                    </div>
                    <!-- End Copyright -->
                </div>
            </div>
        </footer>


        <!-- Back to top button -->
        <a href="#top" class="btn-scroll-top" data-scroll>
            <span class="btn-scroll-top-tooltip text-muted fs-sm me-2"><?php echo e(__('Top')); ?></span>
            <i class="btn-scroll-top-icon bx bx-chevron-up"></i>
        </a>
    </main>
    <?php echo $set->livechat; ?>

    <?php echo $set->analytic_snippet; ?>

    <script src="<?php echo e(asset('front/vendor/jquery/dist/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/swiper/swiper-bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/jarallax/dist/jarallax.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/cleave.js/dist/cleave.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/imagesloaded/imagesloaded.pkgd.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/parallax-js/dist/parallax.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/rellax/rellax.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/shufflejs/dist/shuffle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/lightgallery/lightgallery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/lightgallery/plugins/video/lg-video.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front/vendor/@lottiefiles/lottie-player/dist/lottie-player.js')); ?>"></script>
    <script src="<?php echo e(asset('front/js/theme.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie_svg.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.8.9/dist/cookieconsent.js"></script>
    <script src="<?php echo e(asset('front/js/cookie.js')); ?>"></script>
    <script src="<?php echo e(asset('front/js/toast.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/fonts/fontawesome/js/all.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>
    <?php echo $__env->yieldContent('script'); ?>

    <?php if(session('success')): ?>
    <script>
        "use strict";
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.closeButton = true;
        toastr.success("<?php echo session('success'); ?>");
    </script>
    <?php endif; ?>

    <?php if(session('alert')): ?>
    <script>
        "use strict";
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.closeButton = true;
        toastr.warning("<?php echo session('alert'); ?>");
    </script>
    <?php endif; ?>

    <?php if($set->recaptcha==1): ?>
    <?php echo RecaptchaV3::initJs(); ?>

    <?php endif; ?>

</body>

</html><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/front/menu.blade.php ENDPATH**/ ?>