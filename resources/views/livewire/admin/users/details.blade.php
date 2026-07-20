<div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post" wire:loading.class.delay="opacity-50" wire:target="approveKYC">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <div class="card h-100 rounded-5">
                        <div class="card-body p-9">
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('Account ID')}}</div>
                                    <div class="ms-auto text-dark">{{$client->business_id}}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('Country')}}</div>
                                    <div class="ms-auto text-dark">{{$client->getCountry()->name}}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('KYC Status')}}</div>
                                    <div class="ms-auto text-dark">{{$client->business->kyc_status}}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('Email address')}}</div>
                                    <div class="ms-auto text-dark">{{$client->email}} @if($client->email_verify == 1) <span class="badge badge-success badge-sm">{{__('Verified')}}</span> @else <span class="badge badge-danger badge-sm">{{__('Unverified')}}</span> @endif</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('Mobile')}}</div>
                                    <div class="ms-auto text-dark">{{$client->phone}}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('IP Address')}}</div>
                                    <div class="ms-auto text-dark">{{$client->ip_address}} </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('2FA Security')}}</div>
                                    <div class="ms-auto text-dark"> @if($client->fa_status == 1) <span class="badge badge-success badge-sm">{{__('Enabled')}}</span> @else <span class="badge badge-danger badge-sm">{{__('Disabled')}}</span> @endif</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                <div class="d-flex fs-7 align-items-center mb-3">
                                    <div class="bullet bg-success me-3"></div>
                                    <div class="text-gray-800 fw-bold">{{__('Account Status')}}</div>
                                    <div class="ms-auto text-dark"> @if($client->status == 0) <span class="badge badge-success badge-sm">{{__('Active')}}</span> @else <span class="badge badge-danger badge-sm">{{__('Blocked')}}</span> @endif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-12">
                                    <h4 class="fw-bold fs-5 mb-5">{{__('Webhook')}}</h4>
                                    <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11">
                                        <div class="d-flex fs-7 align-items-center mb-3">
                                            <div class="bullet bg-info me-3"></div>
                                            <div class="text-gray-800 fw-bold">{{__('Webhook URL')}}</div>
                                            <div class="ms-auto text-dark"> {{$client?->business?->webhook_url}}</div>
                                        </div>
                                        <div class="d-flex fs-7 align-items-center mb-3">
                                            <div class="bullet bg-info me-3"></div>
                                            <div class="text-gray-800 fw-bold">{{__('Webhook Secret')}}</div>
                                            <div class="ms-auto text-dark"> {{$client?->business?->webhook_secret}}</div>
                                        </div>
                                        <div class="d-flex fs-7 align-items-center mb-3">
                                            <div class="bullet bg-info me-3"></div>
                                            <div class="text-gray-800 fw-bold">{{__('IP V4 Whitelisting')}}</div>
                                            <div class="ms-auto text-dark"> {{$client?->business?->ip_whitelisting ? formatTag($client?->business?->ip_whitelisting) : null}}</div>
                                        </div>
                                        <div class="d-flex fs-7 align-items-center mb-3">
                                            <div class="bullet bg-info me-3"></div>
                                            <div class="text-gray-800 fw-bold">{{__('IP V6 Whitelisting')}}</div>
                                            <div class="ms-auto text-dark"> {{$client?->business?->ipv6_whitelisting ? formatTag($client?->business?->ipv6_whitelisting) : null}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>