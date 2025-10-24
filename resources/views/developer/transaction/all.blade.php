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
            <p class="mb-5 text-dark"><span class="badge badge-pill badge-secondary me-3">{{__('Get')}} </span> <i class="text-dark">{{url("/")}}/api/v1/transactions</i></p>
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
                                <p class="mb-1"> <span class="fw-bold">{{__('page')}}</span> <span class="badge badge-pill badge-dark">{{__('string')}}</span> </p>
                                <p class="fs-8">{{__('Sets the page number; use "all" to retrieve all items. The default is 1')}}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"> <span class="fw-bold">{{__('limit')}}</span> <span class="badge badge-pill badge-dark">{{__('integer')}}</span> </p>
                                <p class="fs-8">{{__('Specifies the default number of items per page, with a default setting of 20')}}</p>
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
    "data": [
        {
            "id": "5484cb55-2961-4848-b2e5-6395bca69a07",
            "amount": 67.95,
            "charge": 2.72,
            "total": 70.67,
            "status": "success",
            "mode": "test",
            "customer": {
                "name": "John Doe",
                "email": "name@remote.com",
                "phone": "+12345678990",
                "phone_code": "NG"
            },
            "card": {
                "id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
                "name": "Farmfoods"
            },
            "order": [
                {
                    "id": "c5fed9ce-f9dc-4120-ab3e-ea446ebea312",
                    "card_id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
                    "name": "Farmfoods",
                    "amount": 25,
                    "currency": "GBP",
                    "rate": 1.35908,
                    "value": 33.98,
                    "status": "success",
                    "card_url": "R1D4-3LUR-SNB0-XKCN",
                    "card_code": null,
                    "expires": "2026-07-06T17:14:58.000000Z"
                },
                {
                    "id": "e1a88d14-f8a7-4f10-bced-1da043ca890c",
                    "card_id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
                    "name": "Farmfoods",
                    "amount": 25,
                    "currency": "GBP",
                    "rate": 1.35908,
                    "value": 33.98,
                    "status": "success",
                    "card_url": "UDCV-SHXV-XPAV-41FG",
                    "card_code": null,
                    "expires": "2026-07-06T17:14:58.000000Z"
                }
            ],
            "created_at": "2025-07-06T17:14:58.000000Z"
        }
    ]
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