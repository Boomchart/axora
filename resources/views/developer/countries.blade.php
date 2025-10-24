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
            <p class="mb-5 text-dark"><span class="badge badge-pill badge-secondary me-3">{{__('Get')}} </span> <i class="text-dark">{{url("/")}}/api/v1/countries</i></p>
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
            "name": "Benin",
            "iso2": "BJ"
        },
        {
            "name": "France",
            "iso2": "FR"
        },
        {
            "name": "Nigeria",
            "iso2": "NG"
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