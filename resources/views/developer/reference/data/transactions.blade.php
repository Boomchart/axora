@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Get all Data transactions')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/data-transactions</span>
    </div>

    <h2 id="request-parameters">Query Parameters</h2>

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
            <td><span class="param-name">page</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Sets the page number; use "all" to retrieve all items. The default is 1</td>
        </tr>
        <tr>
            <td><span class="param-name">limit</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Specifies the default number of items per page, with a default setting of 20</td>
        </tr>
        <tr>
            <td><span class="param-name">day</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Specifies the transactions to retrieve for a particular day. Date format must be in y-m-d</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get all data transactions</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/data-transactions \
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

$response = $client->get('data-transactions');
$transactions = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/data-transactions')}}', {
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
    "data": [
        {
            "id": "89bd227f-483f-4728-9b04-72ed6cd6d03c",
            "currency": "USD",
            "amount": 1.49,
            "charge": 0,
            "total": 1.49,
            "status": "success",
            "mode": "test",
            "balance": {
                "old_balance": null,
                "new_balance": null
            },
            "orders": [
                {
                    "external_reference": "f4ec3c9f-0f1c-46ea-9eed-ce2e2c294a16",
                    "operator": {
                        "id": "c2625008-d46c-4a64-991f-d8d176ab59e1",
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
                },
                {
                    "external_reference": "5ea47826-360b-4599-8783-c044b79232cb",
                    "operator": {
                        "id": "c2625008-d46c-4a64-991f-d8d176ab59e1",
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
                }
            ],
            "created_at": "2026-05-05T13:21:07.000000Z"
        }
    ],
    "links": {
        "first": "{{url('/')}}/api/v1/data-transactions?page=1",
        "last": "{{url('/')}}/api/v1/data-transactions?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "{{url('/')}}/api/v1/data-transactions?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "{{url('/')}}/api/v1/data-transactions",
        "per_page": 20,
        "to": 1,
        "total": 1
    }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{url('/api-reference/gift-cards/transaction')}}">Get gift card transaction</a></li>
            <li><a href="{{url('/api-reference/gift-cards/order')}}">Create a gift card order </a> </li>
        </ul>
    </div>
@endsection