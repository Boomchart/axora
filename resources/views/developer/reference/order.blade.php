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
}</code></pre>
    </div>

@endsection