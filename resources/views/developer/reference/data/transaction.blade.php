@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Retrieve a data transaction by it\'s transaction ID')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/data-transactions/{id}</span>
    </div>

    <h2 id="request-parameters">Path Parameters</h2>

    <table class="params-table">
        <thead>
        <tr>
            <th>Parameter</th>
            <th>Type</th>
            <th>Required</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><span class="param-name">id</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The data transaction ID</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get a data transaction</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/data-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12 \
  -H "Authorization: Bearer sk_live_your_api_key"</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => '{{url('/')}}/api/v1/',
    'headers' => [
        'Authorization' => 'Bearer sk_live_your_api_key'
    ],
]);

$response = $client->get('data-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/data-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12')}}', {
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key'
  }
});

const cards = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
    "message": "Transaction details",
    "status": "success",
    "data": {
        "id": "d121133e-472d-4552-8af6-cad168a0af9e",
        "currency": "USD",
        "amount": 1.49,
        "charge": 0,
        "total": 1.49,
        "status": "success",
        "mode": "test",
        "balance": {
            "old_balance": 998,
            "new_balance": 998
        },
        "orders": [
            {
                "external_reference": "5430eae0-1c75-4de0-acad-fd5787403969",
                "operator": {
                    "id": "e17b23fa-5b3a-41eb-9228-3d078a4d7be8",
                    "name": "Airtel Nigeria Data - 1.5GB\t2GB Youtube Night + 200MB (YT, IG & Tiktok)  - 7days",
                    "amount": 1000,
                    "currency": "NGN"
                },
                "payment": {
                    "currency": "USD",
                    "rate": 0.00082918739635158,
                    "amount": 0.83,
                    "charge": 0,
                    "sub_total": 0.83,
                    "total": 0.83
                },
                "customer": {
                    "phone": "+2349072963268",
                    "phone_code": "ng"
                }
            },
            {
                "external_reference": "23ba13a0-7a2f-4a95-af45-ec38d3fb1c1d",
                "operator": {
                    "id": "e17b23fa-5b3a-41eb-9228-3d078a4d7be8",
                    "name": "Airtel Nigeria Data - This Data plan gives 1GB - 7days  ",
                    "amount": 800,
                    "currency": "NGN"
                },
                "payment": {
                    "currency": "USD",
                    "rate": 0.00082918739635158,
                    "amount": 0.66,
                    "charge": 0,
                    "sub_total": 0.66,
                    "total": 0.66
                },
                "customer": {
                    "phone": "+2349057550480",
                    "phone_code": "ng"
                }
            }
        ],
        "created_at": "2026-08-20T15:42:04.000000Z"
    }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{url('/api-reference/data/transactions')}}">List data transactions</a> </li>
            <li><a href="{{url('/api-reference/data/quote')}}">Create a data transaction quote </a> </li>
        </ul>
    </div>
@endsection