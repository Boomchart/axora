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
}</code></pre>
    </div>
@endsection