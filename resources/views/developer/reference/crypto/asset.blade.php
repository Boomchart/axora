@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">{{ __('Retrieves a crypto asset and its current balance, capabilities, and fees.') }}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/assets/{asset}</span>
    </div>

    <h2 id="path-parameters">Path Parameters</h2>
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
            <td><span class="param-name">asset</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The asset ID returned by the list assets endpoint.</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl "{{ url('/') }}/api/v1/assets/9128fca1-4c7c-4a09-8bc6-dcf0f956baeb" \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Accept: application/json"</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => '{{ url('/') }}/api/v1/',
    'headers' => [
        'Authorization' => 'Bearer sk_live_your_api_key',
        'Accept' => 'application/json',
    ],
]);

$response = $client->get('assets/9128fca1-4c7c-4a09-8bc6-dcf0f956baeb');
$asset = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch(
  '{{ url('/api/v1/assets/9128fca1-4c7c-4a09-8bc6-dcf0f956baeb') }}',
  {
    headers: {
      'Authorization': 'Bearer sk_live_your_api_key',
      'Accept': 'application/json'
    }
  }
);

const asset = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Asset details",
  "status": "success",
  "data": {
    "id": "9128fca1-4c7c-4a09-8bc6-dcf0f956baeb",
    "name": "Ethereum",
    "token": "ETH",
    "network": "ETH",
    "balance": 110,
    "payout": false,
    "deposit_fee": {
      "flat": 0,
      "percent": 0
    },
    "payout_fee": {
      "gas_fee": "not_fixed",
      "flat": 0,
      "percent": 0
    }
  }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Fee fields
        </div>
        <p>
            <code>flat</code> is charged in the asset's token and <code>percent</code> is a percentage of the
            transaction amount. Payout gas is network-dependent and is returned by the payout quote endpoint.
        </p>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{ url('/api-reference/crypto/assets') }}">List crypto assets</a></li>
            <li><a href="{{ url('/api-reference/crypto/addresses') }}">List deposit addresses</a></li>
            <li><a href="{{ url('/api-reference/crypto/payout-quote') }}">Create a payout quote</a></li>
        </ul>
    </div>
@endsection
