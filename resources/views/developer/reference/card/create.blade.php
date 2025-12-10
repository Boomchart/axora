@extends('developer.reference.menu')

@section('content')
    <h1>Create Gift Card</h1>
    <p class="lead-text">
        Create a new gift card order. This endpoint allows you to purchase and generate gift cards programmatically.
    </p>

    <div class="endpoint-box">
        <span class="endpoint-method post">POST</span>
        <span class="endpoint-url">/v1/gift-cards</span>
    </div>

    <h2 id="request-parameters">Request Parameters</h2>

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
            <td><span class="param-name">brand_id</span></td>
            <td><span class="param-type">string</span></td>
            <td><span class="param-required">required</span></td>
            <td>The ID of the gift card brand (e.g., "amazon", "spotify")</td>
        </tr>
        <tr>
            <td><span class="param-name">amount</span></td>
            <td><span class="param-type">number</span></td>
            <td><span class="param-required">required</span></td>
            <td>The gift card amount (minimum: 5, maximum: 500)</td>
        </tr>
        <tr>
            <td><span class="param-name">currency</span></td>
            <td><span class="param-type">string</span></td>
            <td><span class="param-required">required</span></td>
            <td>Three-letter ISO currency code (e.g., "USD", "EUR", "GBP")</td>
        </tr>
        <tr>
            <td><span class="param-name">quantity</span></td>
            <td><span class="param-type">integer</span></td>
            <td>optional</td>
            <td>Number of gift cards to create (default: 1, max: 100)</td>
        </tr>
        <tr>
            <td><span class="param-name">reference</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Your internal reference ID for this order</td>
        </tr>
        <tr>
            <td><span class="param-name">metadata</span></td>
            <td><span class="param-type">object</span></td>
            <td>optional</td>
            <td>Set of key-value pairs for storing additional information</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST https://api.axoracards.com/v1/gift-cards \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json" \
  -d '{
    "brand_id": "amazon",
    "amount": 50.00,
    "currency": "USD",
    "quantity": 1,
    "reference": "order_12345",
    "metadata": {
      "customer_id": "cus_abc123",
      "order_type": "reward"
    }
  }'</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => 'https://api.axoracards.com/v1',
    'headers' => [
        'Authorization' => 'Bearer sk_live_your_api_key',
        'Content-Type' => 'application/json'
    ]
]);

$response = $client->post('/gift-cards', [
    'json' => [
        'brand_id' => 'amazon',
        'amount' => 50.00,
        'currency' => 'USD',
        'quantity' => 1,
        'reference' => 'order_12345',
        'metadata' => [
            'customer_id' => 'cus_abc123',
            'order_type' => 'reward'
        ]
    ]
]);

$giftCard = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('https://api.axoracards.com/v1/gift-cards', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    brand_id: 'amazon',
    amount: 50.00,
    currency: 'USD',
    quantity: 1,
    reference: 'order_12345',
    metadata: {
      customer_id: 'cus_abc123',
      order_type: 'reward'
    }
  })
});

const giftCard = await response.json();</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Python</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-python">import requests

headers = {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json'
}

data = {
    'brand_id': 'amazon',
    'amount': 50.00,
    'currency': 'USD',
    'quantity': 1,
    'reference': 'order_12345',
    'metadata': {
        'customer_id': 'cus_abc123',
        'order_type': 'reward'
    }
}

response = requests.post(
    'https://api.axoracards.com/v1/gift-cards',
    headers=headers,
    json=data
)

gift_card = response.json()</code></pre>
    </div>

    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "id": "gc_1a2b3c4d5e6f",
  "object": "gift_card",
  "brand": {
    "id": "amazon",
    "name": "Amazon",
    "logo_url": "https://cdn.axoracards.com/brands/amazon.png"
  },
  "amount": 50.00,
  "currency": "USD",
  "code": "XXXX-XXXX-XXXX-XXXX",
  "pin": "1234",
  "status": "active",
  "reference": "order_12345",
  "metadata": {
    "customer_id": "cus_abc123",
    "order_type": "reward"
  },
  "redemption_url": "https://www.amazon.com/gc/redeem?code=XXXX",
  "expires_at": "2026-01-15T23:59:59Z",
  "created_at": "2025-01-15T10:30:00Z"
}</code></pre>
    </div>

    <h2 id="response-attributes">Response Attributes</h2>

    <table class="params-table">
        <thead>
        <tr>
            <th>Attribute</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><span class="param-name">id</span></td>
            <td><span class="param-type">string</span></td>
            <td>Unique identifier for the gift card</td>
        </tr>
        <tr>
            <td><span class="param-name">object</span></td>
            <td><span class="param-type">string</span></td>
            <td>Object type, always "gift_card"</td>
        </tr>
        <tr>
            <td><span class="param-name">brand</span></td>
            <td><span class="param-type">object</span></td>
            <td>Information about the gift card brand</td>
        </tr>
        <tr>
            <td><span class="param-name">amount</span></td>
            <td><span class="param-type">number</span></td>
            <td>Gift card value</td>
        </tr>
        <tr>
            <td><span class="param-name">currency</span></td>
            <td><span class="param-type">string</span></td>
            <td>Three-letter ISO currency code</td>
        </tr>
        <tr>
            <td><span class="param-name">code</span></td>
            <td><span class="param-type">string</span></td>
            <td>Gift card redemption code</td>
        </tr>
        <tr>
            <td><span class="param-name">pin</span></td>
            <td><span class="param-type">string</span></td>
            <td>Gift card PIN (if applicable)</td>
        </tr>
        <tr>
            <td><span class="param-name">status</span></td>
            <td><span class="param-type">string</span></td>
            <td>Status: "active", "redeemed", "expired", or "cancelled"</td>
        </tr>
        <tr>
            <td><span class="param-name">reference</span></td>
            <td><span class="param-type">string</span></td>
            <td>Your internal reference ID</td>
        </tr>
        <tr>
            <td><span class="param-name">metadata</span></td>
            <td><span class="param-type">object</span></td>
            <td>Additional information you provided</td>
        </tr>
        <tr>
            <td><span class="param-name">redemption_url</span></td>
            <td><span class="param-type">string</span></td>
            <td>URL where the gift card can be redeemed</td>
        </tr>
        <tr>
            <td><span class="param-name">expires_at</span></td>
            <td><span class="param-type">timestamp</span></td>
            <td>When the gift card expires (ISO 8601)</td>
        </tr>
        <tr>
            <td><span class="param-name">created_at</span></td>
            <td><span class="param-type">timestamp</span></td>
            <td>When the gift card was created (ISO 8601)</td>
        </tr>
        </tbody>
    </table>

    <h2 id="errors">Errors</h2>

    <h3 id="invalid-brand">Invalid Brand</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">400 Bad Request</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "error": {
    "code": "brand_not_found",
    "message": "The specified brand does not exist",
    "type": "invalid_request_error",
    "param": "brand_id"
  }
}</code></pre>
    </div>

    <h3 id="invalid-amount">Invalid Amount</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">422 Unprocessable Entity</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "error": {
    "code": "invalid_amount",
    "message": "The amount must be between 5 and 500",
    "type": "invalid_request_error",
    "param": "amount"
  }
}</code></pre>
    </div>

    <h3 id="insufficient-balance">Insufficient Balance</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">400 Bad Request</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "error": {
    "code": "insufficient_balance",
    "message": "Your account balance is insufficient for this transaction",
    "type": "invalid_request_error"
  }
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Multiple Gift Cards
        </div>
        <p>
            When creating multiple gift cards (quantity > 1), each gift card is returned as a separate object in the response array. The total cost will be deducted from your account balance.
        </p>
    </div>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Next Steps
        </div>
        <ul>
            <li>Learn how to <a href="{{url('/api/gift-cards/send')}}">Send Gift Cards</a> to recipients</li>
            <li>View <a href="{{url('/docs/webhooks')}}">Webhook Events</a> for gift card status updates</li>
            <li>Check <a href="{{url('/api/countries')}}">Available Countries</a> and brands</li>
        </ul>
    </div>
@endsection