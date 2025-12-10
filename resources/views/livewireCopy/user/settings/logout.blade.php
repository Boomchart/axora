<div>
    <!--begin::Menu wrapper-->
    <div>
        <div class="cursor-pointer symbol symbol-45px symbol-circle" data-kt-menu-trigger="{default: 'click'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            @if($user->avatar == null)
            <div class="symbol-label fs-5 text-dark fw-bold">{{strtoupper(substr($user->business->name, 0, 2))}}</div>
            @else
            <div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$user->avatar}})"></div>
            @endif
        </div>
        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-7 w-275px" data-kt-menu="true" style="">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-45px symbol-circle me-5">
                        @if($user->avatar == null)
                        <div class="symbol-label fs-5 text-dark fw-bold">{{strtoupper(substr($user->business->name, 0, 2))}}</div>
                        @else
                        <div class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$user->avatar}})"></div>
                        @endif
                    </div>
                    <!--end::Avatar-->

                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-7">
                            {{$user->business->name}}
                        </div>

                        <div class="fw-semibold text-hover-success fs-7">
                            {{$user->email}}
                        </div>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <div class="separator"></div>
            <div class="menu-item px-5 mb-0">
                <a href="{{route('user.logout')}}" class="menu-link px-5 py-3">
                    <i class="bi bi-box-arrow-right me-3 text-whitelabel-menu"></i> {{__('Sign Out')}}
                </a>
            </div>
            <!--end::Menu item-->
        </div>
    </div>
</div>