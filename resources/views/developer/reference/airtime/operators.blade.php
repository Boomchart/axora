@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Get airtime operators by country')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/airtime_by_country/{iso2}</span>
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
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get airtime operators by country</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/airtime_by_country/ng \
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

$response = $client->get('airtime_by_country/ng');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/airtime_by_country/ng')}}', {
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
    },
    {
        "id": "386f023c-2491-4d25-80cd-c17b4d6a3966",
        "name": "MTN Nigeria",
        "country": "NG",
        "currency": "NGN",
        "min": 50,
        "max": 200000,
        "denomination_type": "RANGE",
        "denominations": [],
        "exchange_rate": 0.00080385852090032,
        "logo": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777477620/oxhc7sbwqxwnifvyyuyd.jpg",
        "status": "Active",
        "discount": 1.5,
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
]</code></pre>
    </div>
@endsection