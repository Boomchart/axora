@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">{{ __('Creates a crypto payout to an external wallet address.') }}</p>

    <div class="endpoint-box">
        <span class="endpoint-method post">POST</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/payout</span>
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
            <td><span class="param-name">amount</span></td>
            <td><span class="param-type">number</span></td>
            <td>required</td>
            <td>The amount to send, denominated in the selected asset's token. Must be zero or greater.</td>
        </tr>
        <tr>
            <td><span class="param-name">asset_id</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The asset ID from which the payout amount and fees will be deducted.</td>
        </tr>
        <tr>
            <td><span class="param-name">to_address</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The destination wallet address. It must be valid for the selected asset and network.</td>
        </tr>
        <tr>
            <td><span class="param-name">external_reference</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>
                A unique reference from your system, up to 255 characters. Reusing it for the same business
                returns a validation error.
            </td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST "{{ url('/') }}/api/v1/payout" \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "amount": 25,
    "asset_id": "5145e120-afa5-40e5-85f8-925f88001859",
    "to_address": "0x742d35Cc6634C0532925a3b844Bc454e4438f44e",
    "external_reference": "withdrawal-2026-000184"
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

$response = $client->post('payout', [
    'json' => [
        'amount' => 25,
        'asset_id' => '5145e120-afa5-40e5-85f8-925f88001859',
        'to_address' => '0x742d35Cc6634C0532925a3b844Bc454e4438f44e',
        'external_reference' => 'withdrawal-2026-000184',
    ],
]);

$payout = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{ url('/api/v1/payout') }}', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    amount: 25,
    asset_id: '5145e120-afa5-40e5-85f8-925f88001859',
    to_address: '0x742d35Cc6634C0532925a3b844Bc454e4438f44e',
    external_reference: 'withdrawal-2026-000184'
  })
});

const payout = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Processing withdrawal",
  "status": "success",
  "data": {
    "id": "8eb727c6-e4cc-4bb5-9bc5-eab3f90a5da4",
    "external_reference": "withdrawal-2026-000184",
    "type": "crypto_payout",
    "currency": "USDC",
    "amount": 25,
    "charge": 0.38,
    "total": 25.38,
    "status": "pending",
    "mode": "live",
    "wallet_address": "0x742d35Cc6634C0532925a3b844Bc454e4438f44e",
    "balance": {
      "old_balance": 2000,
      "new_balance": 1974.62
    },
    "created_at": "2026-07-31T10:42:18.000000Z"
  }
}</code></pre>
    </div>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Payout processing
        </div>
        <p>
            A successful API response means the payout was accepted for processing. Check the transaction
            endpoint for its final status. Crypto payouts cannot normally be reversed after broadcast.
        </p>
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
        <tr><td>402</td><td>The live asset balance cannot cover the payout amount plus fees.</td></tr>
        <tr><td>403</td><td>The live payout amount is not greater than the calculated fees.</td></tr>
        <tr><td>404</td><td>The specified asset cannot be found for your business.</td></tr>
        <tr><td>422</td><td>A field is invalid, the destination is invalid, the reference was reused, or fees cannot be estimated.</td></tr>
        <tr><td>429</td><td>Another write request for the business is already being processed.</td></tr>
        </tbody>
    </table>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{ url('/api-reference/crypto/payout-quote') }}">Create a payout quote</a></li>
            <li><a href="{{ url('/api-reference/crypto/transaction') }}">Get a crypto transaction</a></li>
            <li><a href="{{ url('/api-reference/crypto/assets') }}">List crypto assets</a></li>
        </ul>
    </div>
@endsection
