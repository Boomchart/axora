@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Retrieves a transaction by its reference')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">POST</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/transactions/{reference}</span>
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
            <td>The transaction reference</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get a single transaction</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/transactions/1430b92612 \
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

$response = $client->get('transactions/1430b92612');
$transactions = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/transactions/1430b92612')}}', {
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key'
  }
});

const transactions = await response.json();</code></pre>
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
                "charge": 2,
                "currency": "USD",
                "rate": 1,
                "value": 10,
                "status": "pending",
                "redeem_code": {
                    "url": null,
                    "card_code": null,
                    "pin": null
                }
            }
        ],
        "created_at": "2026-04-26T20:26:33.000000Z"
    }
}</code></pre>
    </div>
@endsection