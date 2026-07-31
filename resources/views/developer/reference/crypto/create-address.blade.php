@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">{{ __('Creates a customer deposit address for a crypto asset.') }}</p>

    <div class="endpoint-box">
        <span class="endpoint-method post">POST</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/create-address</span>
    </div>

    <h2 id="body-parameters">Body Parameters</h2>
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
            <td><span class="param-name">label</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>
                A unique label for the address, up to 255 characters. A label cannot be reused by the same
                business in the current API mode.
            </td>
        </tr>
        <tr>
            <td><span class="param-name">asset_id</span></td>
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
        <pre><code class="language-bash">curl -X POST "{{ url('/') }}/api/v1/create-address" \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "label": "customer-1048",
    "asset_id": "5145e120-afa5-40e5-85f8-925f88001859"
  }'</code></pre>
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

$response = $client->post('create-address', [
    'json' => [
        'label' => 'customer-1048',
        'asset_id' => '5145e120-afa5-40e5-85f8-925f88001859',
    ],
]);

$address = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{ url('/api/v1/create-address') }}', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    label: 'customer-1048',
    asset_id: '5145e120-afa5-40e5-85f8-925f88001859'
  })
});

const address = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Address generated",
  "status": "success",
  "data": {
    "id": "a0fb1188-dc90-4c60-98ec-0cbc59979e33",
    "asset_id": "5145e120-afa5-40e5-85f8-925f88001859",
    "label": "customer-1048",
    "token": "USDC",
    "network": "ETH",
    "address": "0x783598B3088c1D4CfB12bA54fBE9A0aC192ec772",
    "mode": "live",
    "created_at": "2026-05-19T18:45:43.000000Z"
  }
}</code></pre>
    </div>

    <h2 id="errors">Possible Errors</h2>
    <table class="params-table">
        <thead>
        <tr>
            <th>HTTP status</th>
            <th>When it occurs</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>404</td><td>The specified asset does not belong to your business.</td></tr>
        <tr><td>422</td><td>A required field is invalid, the label has already been used, or address generation fails.</td></tr>
        <tr><td>429</td><td>Another write request for the business is already being processed.</td></tr>
        </tbody>
    </table>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Network safety
        </div>
        <p>Show the returned token and network to the sender. Funds sent using an unsupported network may be permanently lost.</p>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{ url('/api-reference/crypto/assets') }}">List crypto assets</a></li>
            <li><a href="{{ url('/api-reference/crypto/address') }}">Get a deposit address</a></li>
            <li><a href="{{ url('/api-reference/crypto/transactions') }}">List crypto transactions</a></li>
        </ul>
    </div>
@endsection
