@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">{{ __('Simulates an incoming crypto deposit in test mode and sends the resulting crypto_deposit webhook to your endpoint.') }}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/simulate-deposit</span>
    </div>

    <p>
        Use this endpoint to test your deposit handling end to end without moving real funds. It does not credit a
        balance or create a transaction record. It only queues a <code>crypto_deposit</code> webhook to the webhook
        URL configured for your business, using the asset and deposit address you specify,
    </p>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Test mode only
        </div>
        <p>
            This endpoint is available with test API keys only. Calling it with a live key returns
            <code>403</code> with the message <em>you can only simulate crypto deposit with test api keys</em>.
            A webhook URL must also be configured for your business before the call can succeed.
        </p>
    </div>

    <h2 id="query-parameters">Query Parameters</h2>
    <p>This endpoint uses <code>GET</code>, so parameters are sent in the query string.</p>
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
            <td><span class="param-name">asset_id</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>
                The asset ID returned by the <a href="{{ url('/api-reference/crypto/assets') }}">list assets</a>
                endpoint. It must belong to your business.
            </td>
        </tr>
        <tr>
            <td><span class="param-name">address_id</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>
                The ID of the deposit address to credit, not the wallet address itself. It is the <code>id</code>
                returned by <a href="{{ url('/api-reference/crypto/create-address') }}">create address</a> and must
                belong to your business in test mode.
            </td>
        </tr>
        <tr>
            <td><span class="param-name">amount</span></td>
            <td><span class="param-type">numeric</span></td>
            <td>required</td>
            <td>The amount of the asset to report as deposited.</td>
        </tr>
        <tr>
            <td><span class="param-name">status</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>
                The status the simulated deposit should carry in the webhook. One of <code>success</code> or
                <code>failed</code>.
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
        <pre><code class="language-bash">curl -G "{{ url('/') }}/api/v1/simulate-deposit" \
  -H "Authorization: Bearer sk_test_your_api_key" \
  -H "Accept: application/json" \
  --data-urlencode "asset_id=5145e120-afa5-40e5-85f8-925f88001859" \
  --data-urlencode "address_id=a0fb1188-dc90-4c60-98ec-0cbc59979e33" \
  --data-urlencode "amount=25" \
  --data-urlencode "status=success"</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => '{{ url('/') }}/api/v1/',
    'headers' => [
        'Authorization' => 'Bearer sk_test_your_api_key',
        'Accept' => 'application/json',
    ],
]);

$response = $client->get('simulate-deposit', [
    'query' => [
        'asset_id' => '5145e120-afa5-40e5-85f8-925f88001859',
        'address_id' => 'a0fb1188-dc90-4c60-98ec-0cbc59979e33',
        'amount' => 25,
        'status' => 'success',
    ],
]);

$result = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const params = new URLSearchParams({
  asset_id: '5145e120-afa5-40e5-85f8-925f88001859',
  address_id: 'a0fb1188-dc90-4c60-98ec-0cbc59979e33',
  amount: '25',
  status: 'success'
});

const response = await fetch(
  '{{ url('/api/v1/simulate-deposit') }}?' + params,
  {
    headers: {
      'Authorization': 'Bearer sk_test_your_api_key',
      'Accept': 'application/json'
    }
  }
);

const result = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>
    <p>
        A successful call confirms only that the webhook has been queued. Delivery happens asynchronously, so the
        webhook may reach your endpoint shortly after this response.
    </p>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "message": "Webhook Sent",
  "status": "success",
  "data": null
}</code></pre>
    </div>

    <h2 id="webhook-payload">Webhook Delivered</h2>
    <p>
        Your webhook URL receives a <code>crypto_deposit</code> event signed with your webhook secret, exactly as a
        real deposit would be delivered. Delivery is retried up to three times if your endpoint does not respond
        successfully.
    </p>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">crypto_deposit</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "crypto_deposit",
  "data": {
    "id": "9f1c2a4e-5f8b-4a55-9c1e-2b7d0f3a6c11",
    "currency": "USDC",
    "amount": 25,
    "charge": 0,
    "total": 25,
    "status": "success",
    "mode": "test",
    "wallet_address": "0x783598B3088c1D4CfB12bA54fBE9A0aC192ec772",
    "asset_id": "5145e120-afa5-40e5-85f8-925f88001859",
    "address_id": "a0fb1188-dc90-4c60-98ec-0cbc59979e33",
    "balance": {
      "old_balance": 0,
      "new_balance": 25
    },
    "created_at": "2026-07-31T10:42:18.000000Z"
  }
}</code></pre>
    </div>

    <table class="params-table">
        <thead>
        <tr>
            <th>Field</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr><td><code>id</code></td><td>string</td><td>A generated identifier for the simulated deposit. It does not reference a stored transaction.</td></tr>
        <tr><td><code>currency</code></td><td>string</td><td>The token of the asset being simulated, for example <code>USDC</code>.</td></tr>
        <tr><td><code>amount</code></td><td>number</td><td>The amount you supplied in the request.</td></tr>
        <tr><td><code>charge</code></td><td>number</td><td>Always <code>0</code> for simulated deposits.</td></tr>
        <tr><td><code>total</code></td><td>number</td><td>Equal to <code>amount</code> for simulated deposits.</td></tr>
        <tr><td><code>status</code></td><td>string</td><td>The status you requested, <code>success</code> or <code>failed</code>.</td></tr>
        <tr><td><code>mode</code></td><td>string</td><td>Always <code>test</code>.</td></tr>
        <tr><td><code>wallet_address</code></td><td>string</td><td>The wallet address belonging to the <code>address_id</code> you supplied.</td></tr>
        <tr><td><code>balance</code></td><td>object</td><td>Simulated balance movement. <code>old_balance</code> is always <code>0</code> and <code>new_balance</code> is the simulated amount. Your real test balance is not changed.</td></tr>
        <tr><td><code>created_at</code></td><td>string</td><td>The time the webhook payload was generated.</td></tr>
        </tbody>
    </table>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Verify the signature
        </div>
        <p>
            Simulated webhooks are signed the same way as live ones. See
            <a href="{{ url('/docs/webhook') }}">Webhooks</a> for the signature header and verification examples.
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
        <tr><td>401</td><td>The API key is missing or invalid.</td></tr>
        <tr><td>403</td><td>A live API key was used, no webhook URL is configured for your business, the request came from an unapproved IP address, or crypto is not enabled on your account.</td></tr>
        <tr><td>404</td><td>The <code>asset_id</code> or <code>address_id</code> does not belong to your business in test mode.</td></tr>
        <tr><td>422</td><td>A required parameter is missing or invalid, for example a <code>status</code> other than <code>success</code> or <code>failed</code>.</td></tr>
        <tr><td>429</td><td>Another request for the business is already being processed. Wait a moment and retry.</td></tr>
        <tr><td>500</td><td>The simulation could not be queued.</td></tr>
        </tbody>
    </table>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{ url('/api-reference/crypto/assets') }}">List crypto assets</a></li>
            <li><a href="{{ url('/api-reference/crypto/create-address') }}">Create a deposit address</a></li>
            <li><a href="{{ url('/api-reference/crypto/transactions') }}">List crypto transactions</a></li>
            <li><a href="{{ url('/docs/webhook') }}">Webhooks</a></li>
        </ul>
    </div>
@endsection
