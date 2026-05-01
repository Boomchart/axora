@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Retrieves all gift cards')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/cards/{iso2}</span>
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
            <td><span class="param-name">iso2</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The country ISO2</td>
        </tr>

        </tbody>
    </table>

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

    <h3 id="list-all-countries">Get all Cards</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/cards/{iso2} \
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

$response = $client->get('cards/{iso2}');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/cards/{iso2}')}}', {
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
        <pre><code class="language-json">[
    {
        "id": "50f9cbb1-0624-43e7-84b8-e8fe12450845",
        "name": "Google Play Canada",
        "country": "CA",
        "currency": "CAD",
        "min": 10,
        "max": 142.94,
        "denomination_type": "RANGE", //FIXED or RANGE
        "denominations": [],
        "exchange_rate": 0.765523,
        "card_art": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777147533/hyi01mefmu4pp3zetmhg.webp",
        "description": "Google Play Canada",
        "redemption_instructions": "Use this gift card code on Google Play. Any other request for the code may bea scam. To redeem, enter code in the Play Store app or https://play.google.com/store See play.google.com/us-card-terms for full terms. Usable for purchases of eligible items on Google Play only. Not usable for hardware and certain subscriptions. Other limits may apply. No fees or expiration dates. Except as required by law, card is not redeemable for cash or other cards not reloadable or refundable cannot be combined with other non-Google Play balances in your Google Payments account, resold, exchanged or transferred for value.",
        "terms": null,
        "categories": [
            "Lifestyle"
        ],
        "status": true,
        "issuing_fee": {
            "type": "single",
            "charge_phase": "after_conversion",
            "fee": {
                "currency": "CAD",
                "flat": 1,
                "percent": 10,
                "description": "Charged after card currency is converted to USD"
            }
        }
    }
]</code></pre>
    </div>
@endsection