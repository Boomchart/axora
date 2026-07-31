@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">{{ __('Retrieves a customer deposit address by its asset ID and address ID.') }}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/address/{asset}/{address}</span>
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
            <td>The ID of the crypto asset to which the address belongs.</td>
        </tr>
        <tr>
            <td><span class="param-name">address</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The address record ID. This is not the on-chain wallet address.</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl "{{ url('/') }}/api/v1/address/9128fca1-4c7c-4a09-8bc6-dcf0f956baeb/3fdb8858-eade-4620-b95b-a19ed2b49e2b" \
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

$response = $client->get(
    'address/9128fca1-4c7c-4a09-8bc6-dcf0f956baeb/3fdb8858-eade-4620-b95b-a19ed2b49e2b'
);
$address = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch(
  '{{ url('/api/v1/address/9128fca1-4c7c-4a09-8bc6-dcf0f956baeb/3fdb8858-eade-4620-b95b-a19ed2b49e2b') }}',
  {
    headers: {
      'Authorization': 'Bearer sk_live_your_api_key',
      'Accept': 'application/json'
    }
  }
);

const address = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Address details",
  "status": "success",
  "data": {
    "id": "3fdb8858-eade-4620-b95b-a19ed2b49e2b",
    "asset_id": "9128fca1-4c7c-4a09-8bc6-dcf0f956baeb",
    "label": "treasury-eth",
    "token": "ETH",
    "network": "ETH",
    "address": "0xb37Dc7d8c44E354896197A7Ea689dA17F4b51d1f",
    "mode": "live",
    "created_at": "2026-05-19T18:29:48.000000Z"
  }
}</code></pre>
    </div>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Important
        </div>
        <p>Only send the displayed token over the displayed network. Sending an unsupported asset or network may result in permanent loss.</p>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{ url('/api-reference/crypto/addresses') }}">List deposit addresses</a></li>
            <li><a href="{{ url('/api-reference/crypto/create-address') }}">Create a deposit address</a></li>
            <li><a href="{{ url('/api-reference/crypto/asset') }}">Get a crypto asset</a></li>
        </ul>
    </div>
@endsection
