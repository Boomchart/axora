@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Retrieves all gift cards')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/cards/{card}</span>
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
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/cards/1430b926-3faf-49dc-b0d3-1f801ea7fd12 \
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

$response = $client->get('cards/1430b926-3faf-49dc-b0d3-1f801ea7fd12');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/cards/1430b926-3faf-49dc-b0d3-1f801ea7fd12')}}', {
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
    "id": "f9677544-04d7-47ea-8c52-f5f00fb41cc3",
    "name": "Airbnb",
    "country": "US",
    "currency": "USD",
    "min": 25,
    "max": 100,
    "denomination_type": "RANGE",
    "denominations": [],
    "exchange_rate": 1,
    "card_art": "https://res.cloudinary.com/dariaqwmj/image/upload/v1778174678/qdnjupubrc5qc3vskptb.png",
    "description": "Airbnb US",
    "redemption_instructions": "To redeem, visit https://www.airbnb.com/gift",
    "terms": null,
    "status": "Active",
    "categories": [
      "Gaming"
    ],
    "discount": 0,
    "issuing_fee": {
      "type": "single",
      "charge_phase": "after_conversion",
      "fee": {
        "currency": "USD",
        "flat": 1,
        "percent": 1,
        "description": "Charged after card currency is converted to USD"
      }
    }
  }
}</code></pre>
    </div>
@endsection