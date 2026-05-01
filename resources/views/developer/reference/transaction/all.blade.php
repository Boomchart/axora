@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Gets all transactions')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">POST</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/transactions</span>
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
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get all transactions</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/transactions \
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

$response = $client->get('transactions');
$transactions = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/transactions')}}', {
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
            "id": "7666daeb-b3f3-496a-96e5-7d65fe288ddf",
            "amount": 22.97,
            "charge": 5.3,
            "quantity": 3,
            "currency": "USD",
            "status": "success",
            "mode": "test",
            "customer": {
                "name": "John Doe",
                "email": "name@remote.com",
                "phone": "+12025550136",
                "phone_code": "US"
            },
            "card": {
                "id": "50f9cbb1-0624-43e7-84b8-e8fe12450845",
                "name": "Google Play Canada"
            },
            "order": [
                {
                    "id": "053155b2-8e14-40ed-9a88-71e49f51e03d",
                    "card_id": "50f9cbb1-0624-43e7-84b8-e8fe12450845",
                    "name": "John Doe",
                    "amount": 10,
                    "currency": "CAD",
                    "rate": 0.76552,
                    "value": 7.66,
                    "status": "pending",
                    "payment": {
                        "currency": "USD",
                        "charge": 1.9,
                        "amount": 10,
                        "total": 11.9
                    },
                    "redeem_code": {
                        "url": null,
                        "card_code": null,
                        "pin": null
                    }
                },
                {
                    "id": "6fb3ee0a-44f3-4558-8ad3-e16280b98d33",
                    "card_id": "50f9cbb1-0624-43e7-84b8-e8fe12450845",
                    "name": "John Doe",
                    "amount": 10,
                    "currency": "CAD",
                    "rate": 0.76552,
                    "value": 7.66,
                    "status": "pending",
                    "payment": {
                        "currency": "USD",
                        "charge": 1.9,
                        "amount": 10,
                        "total": 11.9
                    },
                    "redeem_code": {
                        "url": null,
                        "card_code": null,
                        "pin": null
                    }
                },
                {
                    "id": "7ac0b19a-4e5a-4c8b-bcf4-c009a5dcaee2",
                    "card_id": "50f9cbb1-0624-43e7-84b8-e8fe12450845",
                    "name": "John Doe",
                    "amount": 10,
                    "currency": "CAD",
                    "rate": 0.76552,
                    "value": 7.66,
                    "status": "pending",
                    "payment": {
                        "currency": "USD",
                        "charge": 1.9,
                        "amount": 7.65,
                        "total": 9.55
                    },
                    "redeem_code": {
                        "url": null,
                        "card_code": null,
                        "pin": null
                    }
                }
            ],
            "created_at": "2026-04-26T20:29:17.000000Z"
        },
        {
            "id": "1f60b4a3-3259-4a0b-843a-0bcca882200a",
            "amount": 20,
            "charge": 4,
            "quantity": 2,
            "currency": "USD",
            "status": "success",
            "mode": "test",
            "customer": {
                "name": "John Doe",
                "email": "name@remote.com",
                "phone": "+12025550136",
                "phone_code": "US"
            },
            "card": {
                "id": "84b70dc9-47fb-45a9-89b9-87399febbc1d",
                "name": "PlayStation US"
            },
            "order": [
                {
                    "id": "97d82e6a-6bb7-4dca-8ab5-5c6c1525e99e",
                    "card_id": "84b70dc9-47fb-45a9-89b9-87399febbc1d",
                    "name": "John Doe",
                    "amount": 10,
                    "currency": "USD",
                    "rate": 1,
                    "value": 10,
                    "status": "pending",
                     "payment": {
                        "currency": "USD",
                        "charge": 1.9,
                        "amount": 10,
                        "total": 11.9
                    },
                    "redeem_code": {
                        "url": null,
                        "card_code": null,
                        "pin": null
                    }
                },
                {
                    "id": "e5f2419c-7077-4d2a-aa05-ec6a2b390643",
                    "card_id": "84b70dc9-47fb-45a9-89b9-87399febbc1d",
                    "name": "John Doe",
                    "amount": 10,
                    "currency": "USD",
                    "rate": 1,
                    "value": 10,
                    "status": "pending",
                    "payment": {
                        "currency": "USD",
                        "charge": 1.9,
                        "amount": 10,
                        "total": 11.9
                    },
                    "redeem_code": {
                        "url": null,
                        "card_code": null,
                        "pin": null
                    }
                }
            ],
            "created_at": "2026-04-26T20:26:33.000000Z"
        }
    ],
    "links": {
        "first": "{{url('/')}}/api/v1/transactions?page=1",
        "last": "{{url('/')}}/api/v1/transactions?page=1",
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
                "url": "{{url('/')}}/api/v1/transactions?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "{{url('/')}}/api/v1/transactions",
        "per_page": 20,
        "to": 2,
        "total": 2
    }
}</code></pre>
    </div>
@endsection