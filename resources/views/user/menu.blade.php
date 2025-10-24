<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{$title}} | {{$set->site_name}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{{$set->site_desc}}" />
    <meta name="csrf_token" content="{{ csrf_token() }}" id="csrf_token" data-turbolinks-permanent>
    <link rel="shortcut icon" href="{{asset('asset/images/favicon.png')}}" />
    <link href="{{asset('dashboard/plugins/custom/leaflet/leaflet.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dashboard/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('dashboard/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('vendor/megaphone/css/megaphone.css') }}">
    <link rel="stylesheet" href="{{asset('asset/filepond/css/filepond.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    @livewireStyles
    @yield('css')
    @include('partials.font')
</head>

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
                    <a href="{{route('user.dashboard')}}">
                        <img alt="Logo" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" class="logo-default" @style(getUi()->dashboard_light_css)/>
                        <img alt="Logo" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" class="h-50px logo-minimize" @style(getUi()->dashboard_light_css)/>
                    </a>
                </div>
                <div class="aside-menu flex-column-fluid">
                    <div class="menu menu-column menu-fit menu-rounded menu-title-dark menu-icon-dark menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fs-7 my-5 mt-lg-2 mb-lg-0" id="kt_aside_menu" data-kt-menu="true">
                        <div class="menu-fit hover-scroll-y me-lg-n5 pe-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="20px" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer">
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link @if(route('user.dashboard')==url()->current()) active @endif" href="{{route('user.dashboard')}}">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-house-check fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title">{{__('Dashboard')}}</span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link @if(strpos(url()->current(), 'user/orders') !== false) active @endif" href="{{route('user.orders')}}">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-cart fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title">{{__('Orders History')}}</span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link @if(strpos(url()->current(), 'user/transactions') !== false) active @endif" href="{{route('user.transactions')}}">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-clipboard-data fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title">{{__('Transactions')}}</span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link @if(strpos(url()->current(), 'user/profile') !== false) active @endif" href="{{route('user.profile', ['type' => 'profile'])}}">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-gear-wide-connected fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title">{{__('Settings')}}</span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link @if(route('api.logs')==url()->current()) active @endif" href="{{route('api.logs')}}">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-code-square fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title">{{__('API Request Log')}}</span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link @if(route('webhook.logs')==url()->current()) active @endif" href="{{route('webhook.logs')}}">
                                    <span class="menu-icon"><!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <i class="bi bi-code-square fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title">{{__('Webhook Log')}}</span>
                                </a>
                            </div>
                            <div class="menu-item"><!--begin:Menu link-->
                                <a class="menu-link @if(route('user.ticket')==url()->current()) active @endif" href="{{route('user.ticket')}}">
                                    <span class="menu-icon">
                                        <i class="bi bi-chat-square-text fs-3 text-whitelabel-menu"></i>
                                    </span>
                                    <span class="menu-title">{{__('Support')}}</span>
                                </a>
                            </div>
                        </div>
                        <div class="fixed-bottom mb-5">
                            <div class="d-flex align-items-center rounded-4 bg-white p-3 cursor-pointer shadow-lg mb-3">
                                <div class="symbol symbol-40px symbol-circle me-2">
                                    <div class="symbol-label fs-5 text-dark fw-bold bg-secondary">{{strtoupper(substr($user->business->name, 0, 2))}}</div>
                                </div>
                                <div class="ps-1">
                                    <p class="fs-8 text-dark fw-bold mb-0" id="kt_user_menu_button">
                                        {{__('Account ID')}}: {{$user?->business->reference}}
                                    </p>
                                    <a href="{{route('developer.index')}}" target="_blank" class="fs-9">{{__('API Documentation')}} <i class="bi bi-box-arrow-up-right"></i></a>
                                </div>
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
                    <a href="{{route('user.dashboard')}}" class="d-lg-none">
                        <img alt="Logo" src="{{asset('asset/images/'.getUi()->dashboard_logo.'.png')}}" style="height:auto; max-width:50%;" />
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
                        <livewire:megaphone></livewire:megaphone>
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
            <livewire:megaphone.popout></livewire:megaphone.popout>
            @yield('content')
        </div>
        <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
            <!--begin::Container-->
            <div class="container-fluid d-flex flex-column flex-md-row flex-stack">
                <!--begin::Copyright-->
                <div class="text-dark order-2 order-md-1">
                    <span class="text-muted fw-bold me-2">{{date('Y')}} ©</span>
                    <a href="{{route('home')}}" target="_blank" class="text-gray-800 text-hover-success">{{$set->site_name}}</a>
                </div>
                <!--end::Copyright-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Footer-->
    </div>
    {!!$set->livechat!!}
    {!!$set->analytic_snippet!!}
    <script src="{{asset('dashboard/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('dashboard/js/scripts.bundle.js')}}"></script>
    <script src="{{asset('dashboard/js/custom/general.js')}}"></script>
    <script src="{{asset('asset/filepond/js/preview.js')}}"></script>
    <script src="{{asset('asset/filepond/js/crop.js')}}"></script>
    <script src="{{asset('asset/filepond/js/transform.js')}}"></script>
    <script src="{{asset('asset/filepond/js/validate-type.js')}}"></script>
    <script src="{{asset('asset/filepond/js/validate-size.js')}}"></script>
    <script src="{{asset('asset/filepond/js/filepond.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>
    <x-laralert />
</body>

</html>
@livewireScripts
@stack('scripts')
<script src="{{asset('dashboard/js/alpine.js')}}"></script>
@yield('script')
@include('partials.extra_scripts')

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
                            createToast("warning", "{{__('An error occurred. Try again later')}}");
                        } else {
                            showSpinner('disabled');
                            createToast("warning", "{{__('An error occurred. Try again later')}}");
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
</script>