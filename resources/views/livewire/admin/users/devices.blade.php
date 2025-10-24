<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            @if($devices->count() > 0)
            <div class="card-body" wire:loading.class.delay="opacity-50" wire:target="orderBy, perPage">
                @foreach($devices as $val)
                <div class="d-flex flex-stack mb-6">
                    <div class="d-flex align-items-center me-2">
                        <div class="ps-1">
                            <p class="fs-7 text-gray-800 fw-bold mb-0">{{$val->userAgent}}</p>
                            <p class="fs-7 text-gray-800 mb-0">{{$val->deviceType}}</p>
                            <div class="fs-7 text-gray-800 fw-semibold">{{__('Last login:')}} {{\Carbon\Carbon::create($val->last_login)->setTimezone($admin->timezone)->format('d M, Y h:i:A')}}</div>
                        </div>
                    </div>
                </div>
                @if(!$loop->last)
                <hr class="bg-light-border">
                @endif
                @endforeach
                @if($devices->total() > 0 && $devices->count() < $devices->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
                    @else
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-display text-dark" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark fw-bold">{{__('No Devices')}}</h3>
                    </div>
                    @endif

            </div>
        </div>
    </div>
</div>