@extends('developer.menu')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-6">{{__('Errors')}}</h1>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <p class="mb-10">{{$set->site_name}} {{__('uses conventional HTTP response codes to indicate the success or failure of an API request. In general: Codes in the 2xx range indicate success. Codes in the 4xx range indicate an error that failed given the information provided (e.g., a required parameter was omitted etc.). Codes in the 5xx range indicate an error with our servers (these are rare)')}}.</p>
            <p class="mb-3 text-dark">{{__('Errors are returned when one or more validation rules fail or unauthorized access to API. Examples include insufficient fund during a call will result in a validation error. Here\'s a sample below')}}:</p>
            <pre class="rounded">
<code class="language-json" data-lang="json">
{
    "status": "{{__('failed')}}",
    "message": "{{__('Insufficient funds, please add funds to your account')}}",
    "data": "null"
}
</code>
            </pre>
            <div class="table-responsive">
                <table class="table table-row-bordered table-flush align-middle gy-6">
                    <thead class="border-bottom border-gray-200 fs-7 fw-bold bg-lighten">
                        <tr>
                            <th class="text-left">{{__('Error 🚦')}}</th>
                            <th class="text-left">{{__('What')}}</th>
                        </tr>
                    </thead>
                    <tbody class="fs-7 fw-bold text-gray-700">
                        <tr>
                            <td class="text-left">{{__('400 - Bad Request')}}</td>
                            <td class="text-left">{{__('The request was unacceptable, often due to missing a required parameter')}}.</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{__('401 - Unauthorized')}}</td>
                            <td class="text-left">{{__('No valid API key provided')}}.</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{__('402 - Request Failed')}}</td>
                            <td class="text-left">{{__('The parameters were valid but the request failed')}}.</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{__('403 - Forbidden')}}</td>
                            <td class="text-left">{{__('The API key doesn\'t have permissions to perform the request')}}.</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{__('404 - Not Found')}}</td>
                            <td class="text-left">{{__('The requested resource doesn\'t exist')}}.</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{__('409 - Conflict')}}</td>
                            <td class="text-left">{{__('The request conflicts with another request (perhaps due to using the same idempotent key)')}}.</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{__('429 - Too Many Requests')}}</td>
                            <td class="text-left">{{__('Too many requests hit the API too quickly. We recommend an exponential backoff of your requests')}}.</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{__('500, 502, 503, 504 - Server Errors')}}</td>
                            <td class="text-left">{{__('Something went wrong on')}} {{$set->site_name}}'s end. {{__('These are rare.')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{__('200 - OK')}}</td>
                            <td class="text-left">{{__('Everything worked as expected')}} 😊</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop