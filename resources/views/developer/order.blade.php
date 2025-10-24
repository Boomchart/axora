@extends('developer.menu')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-6">{{$title}}</h1>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <p class="mb-5 text-dark"><span class="badge badge-pill badge-secondary me-3">{{__('Post')}} </span> <i class="text-dark">{{url("/")}}/api/v1/order</i></p>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="fw-bold fs-6 mb-3">{{__('Headers')}}</h4>
                        <div class="p-10 bg-secondary mb-3 rounded-5">
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('Authorization')}}</span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark">{{__('string')}}</span> </p>
                                <p class="fs-8">{{__('Pass your')}} {secret_key} {{__('as a bearer token in the request header to authorize this call')}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4 class="fw-bold fs-6 mb-3">{{__('Body parameters')}}</h4>
                        <div class="p-10 bg-secondary mb-3 rounded-5">
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('card_id')}}</span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark">{{__('string')}}</span> </p>
                                <p class="fs-8">{{__('ID of card')}}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('quantity')}}</span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark">{{__('integer')}}</span> </p>
                                <p class="fs-8">{{__('Card Quantity, maximum allowed quantity is 10')}}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('amount')}}</span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark">{{__('numeric')}}</span> </p>
                                <p class="fs-8">{{__('Card Amount')}}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('name')}}</span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark">{{__('string')}}</span> </p>
                                <p class="fs-8">{{__('Recipient Name')}}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('email')}}</span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark">{{__('string')}}</span> </p>
                                <p class="fs-8">{{__('Recipient Email')}}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('phone')}}</span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark">{{__('string')}}</span> </p>
                                <p class="fs-8">{{__('Recipient Phone number')}}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('phone_code')}}</span><span class="text-danger">*</span> <span class="badge badge-pill badge-dark">{{__('string')}}</span> </p>
                                <p class="fs-8">{{__('Recipient Phone code, country iso2 eg, US, NG, ZW')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="fw-bold fs-6 mb-3">{{__('Response')}}</h4>
                        <pre class="rounded-3" style="min-height: 50vh;">
<code class="language-json" style="font-size: 0.65rem !important;" data-lang="json">
{
    "message": "Payment successful",
    "status": "success",
    "data": {
        "id": "11f62fff-30c4-41ad-8e01-aad05752b09a",
        "amount": 12.47,
        "charge": 1.1,
        "quantity": 1,
        "currency": "USD",
        "status": "success",
        "mode": "live",
        "customer": {
            "name": "John Doe",
            "email": "name@remote.com",
            "phone": "+12025550136",
            "phone_code": "US"
        },
        "card": {
            "id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
            "name": "Farmfoods"
        },
        "order": [
            {
                "id": "6168879a-baf1-4846-b422-42e0be8c146d",
                "card_id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
                "name": "Farmfoods",
                "amount": 9,
                "currency": "GBP",
                "rate": 1.35908,
                "value": 12.23,
                "status": "pending",
                "card_url": null,
                "card_code": null,
                "expires": "2026-10-06 11:34:49"
            }
        ],
        "created_at": "2025-10-06T11:34:49.000000Z"
    }
}
</code>
</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop