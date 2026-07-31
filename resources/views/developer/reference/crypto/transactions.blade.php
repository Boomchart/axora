@extends('developer.reference.menu')

@section('content')
    <h1>{{ $title }}</h1>
    <p class="lead-text">{{ __('Lists crypto deposit and payout transactions.') }}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{ url('/') }}/api/v1/crypto-transactions</span>
    </div>

    <h2 id="query-parameters">Query Parameters</h2>
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
            <td><span class="param-name">page</span></td>
            <td><span class="param-type">integer|string</span></td>
            <td>optional</td>
            <td>The page number to retrieve. Use <code>all</code> to return every transaction without pagination.</td>
        </tr>
        <tr>
            <td><span class="param-name">limit</span></td>
            <td><span class="param-type">integer</span></td>
            <td>optional</td>
            <td>The number of transactions per page. Defaults to 20.</td>
        </tr>
        <tr>
            <td><span class="param-name">day</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Returns transactions created on a specific date in <code>YYYY-MM-DD</code> format.</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl "{{ url('/') }}/api/v1/crypto-transactions?page=1&amp;limit=20&amp;day=2026-07-31" \
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

$response = $client->get('crypto-transactions', [
    'query' => [
        'page' => 1,
        'limit' => 20,
        'day' => '2026-07-31',
    ],
]);

$transactions = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const query = new URLSearchParams({
  page: '1',
  limit: '20',
  day: '2026-07-31'
});

const response = await fetch(
  `{{ url('/api/v1/crypto-transactions') }}?${query}`,
  {
    headers: {
      'Authorization': 'Bearer sk_live_your_api_key',
      'Accept': 'application/json'
    }
  }
);

const transactions = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "data": [
    {
      "id": "8eb727c6-e4cc-4bb5-9bc5-eab3f90a5da4",
      "external_reference": "withdrawal-2026-000184",
      "type": "crypto_payout",
      "currency": "USDC",
      "amount": 25,
      "charge": 0.38,
      "total": 25.38,
      "status": "success",
      "mode": "live",
      "wallet_address": "0x742d35Cc6634C0532925a3b844Bc454e4438f44e",
      "balance": {
        "old_balance": 2000,
        "new_balance": 1974.62
      },
      "created_at": "2026-07-31T10:42:18.000000Z"
    }
  ],
  "links": {
    "first": "{{ url('/') }}/api/v1/crypto-transactions?page=1",
    "last": "{{ url('/') }}/api/v1/crypto-transactions?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "{{ url('/') }}/api/v1/crypto-transactions",
    "per_page": 20,
    "to": 1,
    "total": 1
  }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Pagination
        </div>
        <p>
            When <code>page=all</code> is used, the response contains the <code>data</code> collection without
            the <code>links</code> and <code>meta</code> pagination objects.
        </p>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{ url('/api-reference/crypto/transaction') }}">Get a crypto transaction</a></li>
            <li><a href="{{ url('/api-reference/crypto/payout') }}">Create a payout</a></li>
            <li><a href="{{ url('/api-reference/crypto/addresses') }}">List deposit addresses</a></li>
        </ul>
    </div>
@endsection
