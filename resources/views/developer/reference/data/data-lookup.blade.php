@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">Retrieves details about a data network operator</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">POST</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/data-number-lookup</span>
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
            <td>The ID of the data operator.</td>
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

    <h3 id="create-gift-card-orders">Retrieves details about a data network operator</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST {{ url('/') }}/api/v1/data-number-lookup \
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

$response = $client->post('/data-number-lookup', [
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
        <pre><code class="language-javascript">const response = await fetch('{{ url('/') }}/api/v1/data-number-lookup', {
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
        "id": "c2625008-d46c-4a64-991f-d8d176ab59e1",
        "name": "Airtel Nigeria Data",
        "country": "NG",
        "currency": "NGN",
        "min": 50,
        "max": 100000,
        "denomination_type": "FIXED",
        "denominations": [
            {
                "amount": 50,
                "plan": "250MB - 1Day"
            },
            {
                "amount": 100,
                "plan": "This Data plan gives 100MB for N100 valid for 1day"
            },
            {
                "amount": 200,
                "plan": "This Data 200MB for valid for 2 days"
            },
            {
                "amount": 300,
                "plan": "This Data plan gives 300MB for 2 days "
            },
            {
                "amount": 500,
                "plan": "This Data plan gives 1.5GB for 1 Day"
            },
            {
                "amount": 600,
                "plan": "This Data plan gives  2GB for 2 days"
            },
            {
                "amount": 800,
                "plan": "This Data plan gives 1GB - 7days  "
            },
            {
                "amount": 1000,
                "plan": "1.5GB\t2GB Youtube Night + 200MB (YT, IG & Tiktok)  - 7days"
            },
            {
                "amount": 1500,
                "plan": "3.5GB\t5GB Youtube Night + 200MB (YT, IG & Tiktok)  - 7days"
            },
            {
                "amount": 2000,
                "plan": "3GB - 2GB Youtube Night + 200MB (YT, IG & Tiktok) -30days"
            },
            {
                "amount": 2500,
                "plan": "4GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) \t30days"
            },
            {
                "amount": 3000,
                "plan": "8GB -2GB Youtube Night + 200MB (YT, IG & Tiktok) - 30days "
            },
            {
                "amount": 4000,
                "plan": "10GB -2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days "
            },
            {
                "amount": 5000,
                "plan": "13GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 6000,
                "plan": "18GB - 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 8000,
                "plan": "25GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 10000,
                "plan": "35GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30day"
            },
            {
                "amount": 15000,
                "plan": "60GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 20000,
                "plan": "100GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 30000,
                "plan": "This Data plan gives 160GB 30days"
            },
            {
                "amount": 40000,
                "plan": "This Data plan gives  210GB for N30,000 valid for 30days"
            },
            {
                "amount": 50000,
                "plan": "This Data plan gives  300GB for 90days"
            },
            {
                "amount": 60000,
                "plan": "This Data plan gives  350GB for N60,000 valid for 120days"
            },
            {
                "amount": 100000,
                "plan": "This Data plan gives  650GB for N100,000 valid for 365days"
            }
        ],
        "exchange_rate": 0.00082918739635158,
        "logo": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777623590/ayelthr7zqsknyjq1fnb.png",
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