@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Retrieve a gift card transaction by it\'s transaction reference')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/giftcard-transactions/{reference}</span>
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
            <td><span class="param-name">reference</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The gift card transaction reference</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get a gift card transaction</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/giftcard-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12 \
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

$response = $client->get('giftcard-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/giftcard-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12')}}', {
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
        "id": "3f03fd72-1836-4880-912c-c45b4eb016cc",
        "currency": "USD",
        "amount": 124.56,
        "charge": 10.44,
        "total": 135,
        "status": "success",
        "mode": "test",
        "balance": {
            "old_balance": 0,
            "new_balance": 0
        },
        "orders": [
            {
                "external_reference": "50d1251a-d262-41ba-aed0-8cef37af9d3e",
                "card": {
                    "id": "cf562d2a-826c-42f1-a19f-3de7fe6911c0",
                    "name": "App Store & iTunes US",
                    "quantity": 4,
                    "amount": 11,
                    "currency": "USD"
                },
                "payment": {
                    "currency": "USD",
                    "rate": 1,
                    "amount": 11,
                    "charge": 1,
                    "sub_total": 12,
                    "total": 48
                },
                "customer": {
                    "name": "John Doe",
                    "email": "name@remote.com",
                    "phone": "+12025550136",
                    "phone_code": "US"
                },
                "items": [
                    {
                        "id": "3084a8dd-47d7-443a-a14d-a06b1fb18e6e",
                        "status": "pending",
                        "redeem_code": {
                            "url": null,
                            "card_code": null,
                            "pin": null
                        }
                    },
                    {
                        "id": "5c3cbb21-e43f-4e1c-a61a-81c0c19bab60",
                        "status": "pending",
                        "redeem_code": {
                            "url": null,
                            "card_code": null,
                            "pin": null
                        }
                    },
                    {
                        "id": "8a4b7c36-572b-48b7-9aa3-5adc45e646fc",
                        "status": "pending",
                        "redeem_code": {
                            "url": null,
                            "card_code": null,
                            "pin": null
                        }
                    },
                    {
                        "id": "e748d5a8-0907-40f4-a3ed-4d5eea8b4ce3",
                        "status": "pending",
                        "redeem_code": {
                            "url": null,
                            "card_code": null,
                            "pin": null
                        }
                    }
                ]
            },
            {
                "external_reference": "36a1ac5a-07d5-44ef-90f5-51a3a1d1348b",
                "card": {
                    "id": "d96096ad-1eff-4e38-afd0-7d02973d4b5f",
                    "name": "H Samuel",
                    "quantity": 3,
                    "amount": 20,
                    "currency": "GBP"
                },
                "payment": {
                    "currency": "USD",
                    "rate": 1.3425882416122,
                    "amount": 26.85,
                    "charge": 2.15,
                    "sub_total": 29,
                    "total": 87
                },
                "customer": {
                    "name": "John Doe",
                    "email": "name@remote.com",
                    "phone": "+12025550136",
                    "phone_code": "US"
                },
                "items": [
                    {
                        "id": "6991178f-57b6-417c-a78a-e862fa51568a",
                        "status": "pending",
                        "redeem_code": {
                            "url": null,
                            "card_code": null,
                            "pin": null
                        }
                    },
                    {
                        "id": "ccf88760-2335-4204-a843-32b38f02fe5a",
                        "status": "pending",
                        "redeem_code": {
                            "url": null,
                            "card_code": null,
                            "pin": null
                        }
                    },
                    {
                        "id": "e9248e6f-e4db-4d06-8467-e6234ad254a8",
                        "status": "pending",
                        "redeem_code": {
                            "url": null,
                            "card_code": null,
                            "pin": null
                        }
                    }
                ]
            }
        ],
        "created_at": "2026-05-05T13:19:22.000000Z"
    }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{url('/api-reference/gift-cards/transactions')}}">List gift card transactions</a> </li>
            <li><a href="{{url('/api-reference/gift-cards/quote')}}">Create a gift card quote </a> </li>
        </ul>
    </div>
@endsection