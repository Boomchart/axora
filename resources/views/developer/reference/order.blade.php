@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">Creates a gift card order</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">POST</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/order</span>
    </div>

    <h2 id="request-parameters">Body Parameters</h2>

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
            <td><span class="param-name">card_id</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The ID of the card</td>
        </tr>
        <tr>
            <td><span class="param-name">quantity</span></td>
            <td><span class="param-type">integer</span></td>
            <td>required</td>
            <td>Card Quantity, maximum allowed quantity is 10</td>
        </tr>
        <tr>
            <td><span class="param-name">amount</span></td>
            <td><span class="param-type">numeric</span></td>
            <td>required</td>
            <td>The card amount</td>
        </tr>

        <tr>
            <td><span class="param-name">name</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The name of the recipient</td>
        </tr>
        <tr>
            <td><span class="param-name">email</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The email of the recipient</td>
        </tr>
        <tr>
            <td><span class="param-name">phone</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The phone number of the recipient</td>
        </tr>
        <tr>
            <td><span class="param-name">phone_code</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>Recipient Phone code, country iso2 (eg, US, NG, ZW)</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Create an order</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/order \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json" \
  -d '{
        "card_id": "1430b926-3faf-49dc-b0d3-1f801ea7fd12",
        "quantity": 2,
        "amount": 254.50,
        "name": "John Doe",
        "email": "john@somebody.live",
        "phone": "+12025550125",
        "phone_code": "US",
   }'
    </code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => '{{url('/')}}/api/v1',
    'headers' => [
        'Authorization' => 'Bearer sk_live_your_api_key'
    ],
]);

$response = $client->post('/order', [
    'json' => [
        'card_id' => '1430b926-3faf-49dc-b0d3-1f801ea7fd12',
        'amount' => 254.50,
        'quantity' => 2,
        'name' => 'John Doe',
        'email' => 'john@somebody.live',
        'phone' => '+12025550125',
        'phone_code' => 'US',
    ]
]);
$order = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/').'/api/v1/order'}}', {
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json'
  },
 body: JSON.stringify({
    card_id: '1430b926-3faf-49dc-b0d3-1f801ea7fd12',
    amount: 254.50,
    quantity: 2,
    name: 'John Doe',
    email: 'john@somebody.live',
    phone: '+12025550125',
    phone_code: 'US',
  })
});

const orders = await response.json();</code></pre>
    </div>


    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
    "message": "Payment successful",
    "status": "success",
    "data": {
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
    }
}</code></pre>
    </div>

@endsection