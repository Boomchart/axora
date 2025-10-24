<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-2">
                    {{__('Order Details')}}
                </h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-5">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-info">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.orders')}}" class="text-muted text-hover-info">{{__('Orders')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Order Details')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <a href="{{route('admin.view.transactions', ['transaction' => $val->transaction->ref_id])}}" target="_blank">
                <div class="d-flex align-items-center mb-3 p-3 bg-white rounded-4">
                    <div class="symbol symbol-45px symbol-circle me-2">
                        <div class="symbol-label fs-3 fw-bolder bg-dark text-white">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                    </div>
                    <div class="ps-2">
                        <p class="text-dark fw-bold fs-7 mb-0">
                            {{__('Transactions Details')}}
                        </p>
                    </div>
                </div>
            </a>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-5">
                        <div class="fs-7 d-flex justify-content-between my-4">
                            <div class="">{{__('Order ID')}}</div>
                            <div class="d-flex fw-bold">
                                {{substr($val?->id, 0, 15)}}...
                                <i class="bi bi-clipboard-check text-dark castro-copy fs-5" data-clipboard-text="{{$val->id}}" title="{{__('Copy')}}"></i>
                            </div>
                        </div>
                        <div class="separator separator-dashed"></div>
                        <div class="fs-7 d-flex justify-content-between my-4">
                            <div class="">{{__('Order Status')}}</div>
                            @include('partials.transactions.status', ['val' => $val])
                        </div>
                        <div class="separator separator-dashed"></div>
                        {!!trxDetails(__('Amount'), number_format($val->amount, 2).' '.$val->currency)!!}

                        {!!trxDetails(__('Gift Card Name'), ucwords($val->card_name).' - '.$val->transaction->card_country)!!}
                        {!!trxDetails(__('Customer Name'), $val->name)!!}
                        {!!trxDetails(__('Customer Email'), $val->email)!!}
                        {!!trxDetails(__('Customer Phone'), $val->phone)!!}
                        {!!trxDetails(__('Exchange Rate'), $val->rate.' '.$val->transaction->currency)!!}


                        {!!trxDetails(__('Date'), $val->created_at->setTimezone($admin->timezone)->toDayDateTimeString())!!}
                    </div>

                    @if($val->webhooks->count())
                    <div class="bg-white rounded-4 border border-secondary p-5">
                        <p class="fs-5 fw-bold mb-5">{{__('Webhook Logs')}} ({{number_format_short($val->webhooks->count())}})</p>
                        @foreach($val->webhooks as $webhook)
                        <div class="row mb-1">
                            <div class="col-6">
                                <h4 class="mb-0 fs-7">{{__('UUID')}}</h4>
                                <p class="text-break">{{$webhook->uuid}}</p>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-0 fs-7">{{__('Created')}}</h4>
                                <p class="text-break">{{$webhook->created_at->setTimezone($admin->timezone)->toDayDateTimeString()}}</p>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-0 fs-7">{{__('Response')}}</h4>
                                <p class="text-break">{{$webhook->response_status_code}}</p>
                            </div>
                            <div class="col-6">
                                <h4 class="mb-0 fs-7">{{__('Attempts')}}</h4>
                                <p class="text-break">{{$webhook->attempts}}</p>
                            </div>
                        </div>
                        <button id="kt_webhook{{$webhook->id}}_button" class="btn btn-dark btn-sm rounded-pill btn-block my-4"><i class="bi bi-code-square"></i> {{__('Webhook Details')}}</button>
                        <div wire:ignore.self id="kt_webhook{{$webhook->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_webhook{{$webhook->id}}_button" data-kt-drawer-close="#kt_webhook{{$webhook->id}}_close" data-kt-drawer-width="{default:'100%', 'md': '500px'}">
                            <div class="card w-100">
                                <div class="card-header pe-5 border-0">
                                    <div class="card-title">
                                        <div class="d-flex justify-content-center flex-column me-3">
                                            <div class="fs-5 text-gray-900 text-hover-info me-1 lh-1">{{__('Webhook Details')}}</div>
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                        <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-info" data-kt-drawer-dismiss="true" id="kt_webhook{{$webhook->id}}_close">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-x-lg fs-2"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body text-wrap">
                                    <div class="text-center mb-3">
                                        <div class="symbol symbol-100px symbol-circle okay mb-5">
                                            <span class="symbol-label bg-secondary text-dark fw-bold fs-1">
                                                <i class="bi bi-code-square text-dark" style="font-size:56px;"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="pb-5 mt-10 position-relative zindex-1">
                                        <div class="row mb-5">
                                            <div class="col-12" wire:ignore>
                                                <p class="mb-1 fs-7">{{__('Payload')}}</p>
                                                <pre class="rounded-4">
                                                        <code class="language-json" style="font-size: 0.85rem !important;" data-lang="json">   
                                                        {!! json_encode(json_decode($webhook->payload, true), JSON_PRETTY_PRINT) !!}
                                                        </code>
                                                    </pre>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-12" wire:ignore>
                                                <p class="mb-1 fs-7">{{__('Headers')}}</p>
                                                <pre class="rounded-4">
                                                        <code class="language-json" style="font-size: 0.85rem !important;" data-lang="json">   
                                                        {!! json_encode(json_decode($webhook->headers, true), JSON_PRETTY_PRINT) !!}
                                                        </code>
                                                    </pre>
                                            </div>
                                        </div>
                                        <a wire:click="resendWebhook('{{$webhook->id}}')" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="resendWebhook('{{$webhook->id}}')" class="btn btn-block btn-info">
                                            <span wire:loading.remove wire:target="resendWebhook('{{$webhook->id}}')">{{__('Resend Webhook')}}</span>
                                            <span wire:loading wire:target="resendWebhook('{{$webhook->id}}')">{{__('Processing Request...')}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                        <hr class="bg-light-border">
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>