@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">Retrieves details about a network operator</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">POST</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/airtime-number-lookup</span>
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
            <td><span class="param-name">operator_id</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The ID of the airtime operator.</td>
        </tr>

        <tr>
            <td><span class="param-name">phone</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The phone number of the recipient.</td>
        </tr>
        <tr>
            <td><span class="param-name">phone_code</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>
                Recipient phone country code using the country ISO2 format, for example: US, NG, ZW.
            </td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="create-gift-card-orders">Retrieves details about a network operator</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST {{ url('/') }}/api/v1/airtime-number-lookup \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json" \
  -d '{
    "operator_id": "1430b926-3faf-49dc-b0d3-1f801ea7fd12",
    "phone": "09057550480",
    "phone_code": "ng",
}'</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => '{{ url('/') }}/api/v1',
    'headers' => [
        'Authorization' => 'Bearer sk_live_your_api_key',
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ],
]);

$response = $client->post('/airtime-number-lookup', [
    'json' => [
        'data' => [
            'operator_id' => '3e0e1d43-809c-4f36-b069-b7fe6ee2b6d4',
            'phone' => '09057550480',
            'phone_code' => 'ng',
        ],
    ],
]);

$orders = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{ url('/') }}/api/v1/airtime-number-lookup', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    data:{
        operator_id: 'cf562d2a-826c-42f1-a19f-3de7fe6911c0',
        phone: '09057550480',
        phone_code: 'ng',
      }
  })
});

const response = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Network Operator details",
    "status": "success",
    "data": {
        "id": "3e0e1d43-809c-4f36-b069-b7fe6ee2b6d4",
        "name": "Airtel Nigeria",
        "country": "NG",
        "currency": "NGN",
        "min": 50,
        "max": 199999,
        "denomination_type": "RANGE",
        "denominations": [],
        "exchange_rate": 0.00082918739635158,
        "logo": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777478210/efceolff4elirom6ccug.png",
        "status": "Active",
        "discount": 2,
        "issuing_fee": {
            "type": "single",
            "charge_phase": "after_conversion",
            "fee": {
                "currency": "USD",
                "flat": 0,
                "percent": 0,
                "description": "Charged after card currency is converted to USD"
            }
        }
    }
}</code></pre>
    </div>
@endsection