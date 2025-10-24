<div id="kt_notify_account" wire:ignore.self class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_notify_button" data-kt-drawer-width="{'md': '500px'}" data-kt-drawer-close="#kt_notify_close">
    <div class="card w-100">
        <div class="card-header pe-5 border-0">
            <div class="card-title">
                <div class="d-flex justify-content-center flex-column me-3">
                    <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Notifications')}} ({{$unread->count()}})</div>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_notify_close">
                    <span class="svg-icon svg-icon-2">
                        <i class="bi bi-x-lg fs-2"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body text-wrap">
            @if(count($unread))
            <div class="text-end mb-5">
                <a x-data x-on:click.prevent="$wire.markAllAsRead" class="cursor-pointer align-self-center text-nowrap btn btn-dark rounded-pill"> <i class="bi bi-hand-thumbs-up"></i> {{__('Mark All as Read')}} </a>
            </div>
            @endif
            @forelse ($unread as $announcement)
            <div class="overflow-auto pb-5">
                <div class="notice bg-light rounded-4 min-w-lg-400px flex-shrink-0 p-6">
                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                        <div class="mb-3 mb-md-0 fw-semibold">
                            <h5 class="text-dark fw-bold fs-7">{{ $announcement['data']['title'] }}</h5>

                            <div class="fs-7 text-dark pe-7">{{ $announcement['data']['body'] }}</div>
                            <div class="fs-8 text-gray-700 pe-7 mb-3">{{ $announcement->created_at->setTimezone($user->user_timezone)->diffForHumans() }}</div>
                            @if($announcement->read_at === null)
                            <a x-data x-on:click.prevent="$wire.markAsRead('{{$announcement->id}}')" class="cursor-pointer align-self-center text-nowrap btn btn-success btn-sm rounded-pill"> <i class="bi bi-hand-thumbs-up"></i> {{__('Read')}} </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center">
                <p tabindex="0" class="fs-7 flex flex-shrink-0 px-3 py-16 text-gray-500">
                    {{__('No notifications')}}
                </p>
            </div>
            @endforelse

        </div>
    </div>
</div>