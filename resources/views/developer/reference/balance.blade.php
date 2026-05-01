@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">
        Retrieves Account Balance
    </p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('')}}/api/v1/balance</span>
    </div>

    <h2 id="overview">Overview</h2>
    <p>
       This endpoint returns information about the current account balance held.
    </p>


    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get current account balance</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -GET {{url('/').'/api/v1/balance'}} \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json" \
            </code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => '{{url('/')}}/api/v1',
    'headers' => [
        'Authorization' => 'Bearer sk_live_your_api_key',
        'Content-Type' => 'application/json',
    ]
]);

$response = $client->get('/balance');
$balance = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/')}}/api/v1/balance', {
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json',
  }
});

const balance = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Account Balance",
    "status": "success",
    "data": {
        "amount": "12000.00",
        "currency": "USD"
    }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{route('developer.order')}}">Orders</a> - Create Gift Card Order</li>
            <li><a href="{{route('developer.index')}}">Introduction</a> - Getting started guide</li>
        </ul>
    </div>
@endsection