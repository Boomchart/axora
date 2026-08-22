@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Retrieve an airtime transaction by it\'s transaction ID')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/airtime-transactions/{id}</span>
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
            <td><span class="param-name">id</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The airtime transaction ID</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get an airtime transaction</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/airtime-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12 \
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

$response = $client->get('airtime-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/airtime-transactions/1430b926-3faf-49dc-b0d3-1f801ea7fd12')}}', {
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
  "message": "Transaction details",
  "status": "success",
  "data": {
    "id": "cb74cee0-113c-4330-bf82-3cf0fb3efd76",
    "currency": "USD",
    "amount": 1.49,
    "charge": 0,
    "total": 1.49,
    "status": "success",
    "mode": "test",
    "balance": {
      "old_balance": 998,
      "new_balance": 998
    },
    "orders": [
      {
        "external_reference": "824a3b3b-6388-4e41-8a92-14f056910ce7",
        "operator": {
          "id": "145a1cf2-e08d-4b00-9ff5-e613984498d9",
          "name": "Airtel Nigeria",
          "amount": 800,
          "currency": "NGN"
        },
        "payment": {
          "currency": "USD",
          "rate": 0.00082918739635158,
          "amount": 0.66,
          "charge": 0,
          "sub_total": 0.66,
          "total": 0.66
        },
        "customer": {
          "phone": "+2349057550480",
          "phone_code": "ng"
        }
      },
      {
        "external_reference": "11d2c1aa-791a-4441-b28b-04f1cf682e91",
        "operator": {
          "id": "145a1cf2-e08d-4b00-9ff5-e613984498d9",
          "name": "Airtel Nigeria",
          "amount": 1000,
          "currency": "NGN"
        },
        "payment": {
          "currency": "USD",
          "rate": 0.00082918739635158,
          "amount": 0.83,
          "charge": 0,
          "sub_total": 0.83,
          "total": 0.83
        },
        "customer": {
          "phone": "+2349072963268",
          "phone_code": "ng"
        }
      }
    ],
    "created_at": "2026-08-20T15:52:07.000000Z"
  }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{url('/api-reference/airtime/transactions')}}">List airtime transactions</a> </li>
            <li><a href="{{url('/api-reference/airtime/quote')}}">Create an airtime transaction quote </a> </li>
        </ul>
    </div>
@endsection