@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">
        Gets a quote of what a gift card will cost.
    </p>

    <div class="endpoint-box">
        <span class="endpoint-method get">POST</span>
        <span class="endpoint-url">{{url("/")}}/api/v1/giftcard-quote</span>
    </div>


    <h2 id="request-parameters">Body parameters</h2>

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
            <td>ID of the card</td>
        </tr>
        <tr>
            <td><span class="param-name">amount</span></td>
            <td><span class="param-type">numeric</span></td>
            <td>required</td>
            <td>The card amount</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get Quote</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST {{url('/')}}/api/v1/giftcard-quote \
-H "Authorization: Bearer sk_live_your_api_key" \
-H "Content-Type: application/json" \
-d '{
    "card_id": "1430b926-3faf-49dc-b0d3-1f801ea7fd12",
    "amount": "3000",
}'</code></pre>
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
    ]
]);

$response = $client->post('giftcard-quote', [
    'json' => [
        'card_id' => '1430b926-3faf-49dc-b0d3-1f801ea7fd12',
        'amount' => '3000'
    ]
]);

$quote = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/')}}/api/v1/giftcard-quote', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    card_id: '1430b926-3faf-49dc-b0d3-1f801ea7fd12',
    amount: '3000'
  })
});

const quote = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
   "message": "Quote calculated",
    "status": "success",
    "data": {
        "id": "d96096ad-1eff-4e38-afd0-7d02973d4b5f",
        "amount": 10,
        "exchange_rate": 1.3425882416122,
        "converted_to_usd": 13.425882416121999,
        "charge": 1.0744,
        "total": 14.500282416122,
        "card": {
            "id": "d96096ad-1eff-4e38-afd0-7d02973d4b5f",
            "name": "H Samuel",
            "country": "GB",
            "currency": "GBP",
            "min": 10,
            "max": 2500,
            "denomination_type": "RANGE",
            "denominations": [],
            "exchange_rate": 1.3425882416122,
            "card_art": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777205042/kbmdtnk3tgvh8dwllii2.png",
            "description": "H Samuel",
            "redemption_instructions": "",
            "terms": null,
            "categories": [
                "Streaming"
            ],
            "status": "Active",
            "discount": 0,
            "issuing_fee": {
                "type": "tier_pricing",
                "charge_phase": "before_conversion",
                "fee": [
                    {
                        "currency": "USD",
                        "min": 0,
                        "max": 10,
                        "flat": 0,
                        "percent": 10,
                        "description": "Charged after card currency is converted to USD, amount must be greater than min amount. if max amount is null, means there is no limit on tier pricing"
                    },
                    {
                        "currency": "USD",
                        "min": 10,
                        "max": null,
                        "flat": 0,
                        "percent": 8,
                        "description": "Charged after card currency is converted to USD, amount must be greater than min amount. if max amount is null, means there is no limit on tier pricing"
                    }
                ]
            }
        }
    }
}</code></pre>
    </div>
@endsection