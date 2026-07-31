@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">{{ __('Calculates the network gas fee and Azora charge for a crypto payout.') }}</p>

    <div class="endpoint-box">
        <span class="endpoint-method post">POST</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/payout-quote</span>
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
            <td>The payout amount, denominated in the address's token. Must be zero or greater.</td>
        </tr>
        <tr>
            <td><span class="param-name">address_id</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>
                The ID of one of your deposit address records. Azora uses its token and network to calculate
                the quote. This is not an on-chain wallet address.
            </td>
        </tr>
        <tr>
            <td><span class="param-name">to_address</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The destination wallet address. It must be valid for the selected token and network.</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST "{{ url('/') }}/api/v1/payout-quote" \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "amount": 0.05,
    "address_id": "3fdb8858-eade-4620-b95b-a19ed2b49e2b",
    "to_address": "0x742d35Cc6634C0532925a3b844Bc454e4438f44e"
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

$response = $client->post('payout-quote', [
    'json' => [
        'amount' => 0.05,
        'address_id' => '3fdb8858-eade-4620-b95b-a19ed2b49e2b',
        'to_address' => '0x742d35Cc6634C0532925a3b844Bc454e4438f44e',
    ],
]);

$quote = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{ url('/api/v1/payout-quote') }}', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    amount: 0.05,
    address_id: '3fdb8858-eade-4620-b95b-a19ed2b49e2b',
    to_address: '0x742d35Cc6634C0532925a3b844Bc454e4438f44e'
  })
});

const quote = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Estimate Calculated",
  "status": "success",
  "data": {
    "gas_fee": 0.00042,
    "azora_charge": 0.00025,
    "total": 0.00067
  }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Quote calculation
        </div>
        <p>
            <code>total</code> is the sum of <code>gas_fee</code> and <code>azora_charge</code>. Fees are
            denominated in the selected token and may change with network conditions. Request a fresh quote
            immediately before creating the payout.
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
        <tr><td>404</td><td>The specified address ID cannot be found for your business and API mode.</td></tr>
        <tr><td>422</td><td>A required field is invalid, the destination is invalid, or a fee estimate cannot be obtained.</td></tr>
        <tr><td>429</td><td>Another write request for the business is already being processed.</td></tr>
        </tbody>
    </table>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{ url('/api-reference/crypto/addresses') }}">List deposit addresses</a></li>
            <li><a href="{{ url('/api-reference/crypto/payout') }}">Create a payout</a></li>
            <li><a href="{{ url('/api-reference/crypto/asset') }}">Get a crypto asset</a></li>
        </ul>
    </div>
@endsection
