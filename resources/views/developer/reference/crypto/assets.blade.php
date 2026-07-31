@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">{{ __('Lists the crypto assets available to your business, including balances and fees.') }}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/assets</span>
    </div>

    <h2 id="example-request">Example Request</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl "{{ url('/') }}/api/v1/assets" \
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

$response = $client->get('assets');
$assets = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{ url('/api/v1/assets') }}', {
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Accept': 'application/json'
  }
});

const assets = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Assets",
  "status": "success",
  "data": [
    {
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
    },
    {
      "id": "5145e120-afa5-40e5-85f8-925f88001859",
      "name": "USD Coin",
      "token": "USDC",
      "network": "ETH",
      "balance": 2000,
      "payout": true,
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
  ]
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{ url('/api-reference/crypto/asset') }}">Get a crypto asset</a></li>
            <li><a href="{{ url('/api-reference/crypto/create-address') }}">Create a deposit address</a></li>
            <li><a href="{{ url('/api-reference/crypto/payout') }}">Create a payout</a></li>
        </ul>
    </div>
@endsection
