@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Retrieves all gift cards')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/cards/{iso2}/{card}</span>
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
            <td>The ISO2 of the country</td>
        </tr>
        <tr>
            <td><span class="param-name">card</span></td>
            <td><span class="param-type">uuid</span></td>
            <td>required</td>
            <td>The Card ID</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get a single card</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/cards/US/1430b926-3faf-49dc-b0d3-1f801ea7fd12 \
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

$response = $client->get('cards/US/1430b926-3faf-49dc-b0d3-1f801ea7fd12');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/cards/US/1430b926-3faf-49dc-b0d3-1f801ea7fd12')}}', {
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
    "message": "Card details",
    "status": "success",
    "data": {
        "id": "84b70dc9-47fb-45a9-89b9-87399febbc1d",
        "name": "PlayStation US",
        "country": "US",
        "currency": "USD",
        "min": 10,
        "max": 100,
        "denomination_type": "FIXED", //FIXED or RANGE
        "denominations": [
            10,
            25,
            50,
            75,
            100
        ],
        "exchange_rate": 0,
        "card_art": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777132615/jj0t8nxewbfmdfsbz5ue.jpg",
        "description": "PlayStation US",
        "redemption_instructions": "This card may be redeemed through PlayStation Store on a PS4, PS3, and PS Vita system, or a personal computer. . Open a Sony Entertainment Network account or use an existing account. . From your PS4, PS3, or PS Vita system, or a personal computer, access PlayStation Store. . Click the Redeem Codes icon. . Enter the code at the bottom of this card. Please note that the code is case sensitive and must be entered exactly as displayed. . For additional redemption instructions, please visit https://www.playstation.com/en-us/explore/playstationnetwork/redemption Your use of this PlayStation Plus code constitutes your acceptance of these terms and any additional terms available at http://us.playstation.com/redemption. PSN SM and PlayStation Plus offerings may change without notice.",
        "terms": null,
        "categories": [
            "Gaming",
            "Lifestyle"
        ],
        "status": true,
        "issuing_fee": {
            "type": "single",
            "charge_phase": "after_conversion",
            "fee": {
                "currency": "USD",
                "flat": 1,
                "percent": 10,
                "description": "Charged after card currency is converted to USD"
            }
        }
    }
}</code></pre>
    </div>
@endsection