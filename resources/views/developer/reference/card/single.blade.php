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
        "id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
        "name": "AmazonFoods",
        "country": "GB",
        "currency": "GBP",
        "min": 5,
        "max": 200,
        "denominations": [
            5,
            10,
            25
        ],
        "exchange_rate": 1.359077764815,
        "delivery_method": null,
        "logo": "https://res.cloudinary.com/dariaqwmj/image/upload/v1748347991/images/qinepa0t055skszt4p3e.jpg",
        "card_art": "https://res.cloudinary.com/dariaqwmj/image/upload/v1748242371/images/fxkln6yhcutv6xb7qv6o.jpg",
        "description": "AmazonFoods have served Great Britain for over 60 years. From a butcher shop in Aberdeen we have grown to more than 300 stores.",
        "redemption_instructions": null,
        "terms": null,
        "categories": [
            "Supermarket"
        ]
    }
}</code></pre>
    </div>
@endsection