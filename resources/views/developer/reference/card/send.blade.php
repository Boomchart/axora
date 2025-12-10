@extends('developer.reference.menu')

@section('content')
    <h1>Send Gift Card</h1>
    <p class="lead-text">
        Send a gift card directly to a recipient via email. This endpoint creates and delivers a gift card in a single API call.
    </p>

    <div class="endpoint-box">
        <span class="endpoint-method post">POST</span>
        <span class="endpoint-url">/v1/gift-cards/send</span>
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
            <td><span class="param-name">recipient_email</span></td>
            <td><span class="param-type">string</span></td>
            <td><span class="param-required">required</span></td>
            <td>The recipient's email address</td>
        </tr>
        <tr>
            <td><span class="param-name">recipient_name</span></td>
            <td><span class="param-type">string</span></td>
            <td><span class="param-required">required</span></td>
            <td>The recipient's full name</td>
        </tr>
        <tr>
            <td><span class="param-name">sender_name</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>The sender's name (displayed in email)</td>
        </tr>
        <tr>
            <td><span class="param-name">message</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Personal message to include in email (max 500 characters)</td>
        </tr>
        <tr>
            <td><span class="param-name">delivery_date</span></td>
            <td><span class="param-type">date</span></td>
            <td>optional</td>
            <td>Schedule delivery for a future date (ISO 8601 format)</td>
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
        <pre><code class="language-bash">curl -X POST https://api.axoracards.com/v1/gift-cards/send \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json" \
  -d '{
    "brand_id": "amazon",
    "amount": 50.00,
    "currency": "USD",
    "recipient_email": "customer@example.com",
    "recipient_name": "John Doe",
    "sender_name": "Your Company",
    "message": "Thank you for being an amazing customer!",
    "reference": "reward_12345",
    "metadata": {
      "campaign": "Q1_2025_loyalty",
      "user_id": "usr_abc123"
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

$response = $client->post('/gift-cards/send', [
    'json' => [
        'brand_id' => 'amazon',
        'amount' => 50.00,
        'currency' => 'USD',
        'recipient_email' => 'customer@example.com',
        'recipient_name' => 'John Doe',
        'sender_name' => 'Your Company',
        'message' => 'Thank you for being an amazing customer!',
        'reference' => 'reward_12345',
        'metadata' => [
            'campaign' => 'Q1_2025_loyalty',
            'user_id' => 'usr_abc123'
        ]
    ]
]);

$result = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('https://api.axoracards.com/v1/gift-cards/send', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    brand_id: 'amazon',
    amount: 50.00,
    currency: 'USD',
    recipient_email: 'customer@example.com',
    recipient_name: 'John Doe',
    sender_name: 'Your Company',
    message: 'Thank you for being an amazing customer!',
    reference: 'reward_12345',
    metadata: {
      campaign: 'Q1_2025_loyalty',
      user_id: 'usr_abc123'
    }
  })
});

const result = await response.json();</code></pre>
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
    'recipient_email': 'customer@example.com',
    'recipient_name': 'John Doe',
    'sender_name': 'Your Company',
    'message': 'Thank you for being an amazing customer!',
    'reference': 'reward_12345',
    'metadata': {
        'campaign': 'Q1_2025_loyalty',
        'user_id': 'usr_abc123'
    }
}

response = requests.post(
    'https://api.axoracards.com/v1/gift-cards/send',
    headers=headers,
    json=data
)

result = response.json()</code></pre>
    </div>

    <h2 id="scheduled-delivery">Scheduled Delivery</h2>
    <p>
        You can schedule gift card delivery for a future date by including the <code>delivery_date</code> parameter:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Scheduled Delivery Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "brand_id": "spotify",
  "amount": 25.00,
  "currency": "USD",
  "recipient_email": "birthday@example.com",
  "recipient_name": "Sarah Johnson",
  "sender_name": "Your Team",
  "message": "Happy Birthday! Enjoy some music on us!",
  "delivery_date": "2025-12-25T09:00:00Z"
}</code></pre>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Delivery Scheduling
        </div>
        <p>
            Scheduled deliveries must be at least 1 hour in the future and no more than 1 year ahead. The gift card will be sent at the specified time in UTC.
        </p>
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
  "status": "delivered",
  "recipient": {
    "email": "customer@example.com",
    "name": "John Doe"
  },
  "sender_name": "Your Company",
  "message": "Thank you for being an amazing customer!",
  "reference": "reward_12345",
  "metadata": {
    "campaign": "Q1_2025_loyalty",
    "user_id": "usr_abc123"
  },
  "redemption_url": "https://www.amazon.com/gc/redeem?code=XXXX",
  "delivered_at": "2025-01-15T10:30:15Z",
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
            <td>Status: "pending", "delivered", "failed", or "scheduled"</td>
        </tr>
        <tr>
            <td><span class="param-name">recipient</span></td>
            <td><span class="param-type">object</span></td>
            <td>Recipient information (email and name)</td>
        </tr>
        <tr>
            <td><span class="param-name">sender_name</span></td>
            <td><span class="param-type">string</span></td>
            <td>The sender's name displayed in email</td>
        </tr>
        <tr>
            <td><span class="param-name">message</span></td>
            <td><span class="param-type">string</span></td>
            <td>Personal message included in email</td>
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
            <td><span class="param-name">delivered_at</span></td>
            <td><span class="param-type">timestamp</span></td>
            <td>When the email was delivered (ISO 8601)</td>
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

    <h2 id="email-customization">Email Customization</h2>
    <p>
        The email sent to recipients includes:
    </p>

    <ul>
        <li>Your company name (sender_name)</li>
        <li>Recipient's name</li>
        <li>Gift card brand logo</li>
        <li>Gift card amount</li>
        <li>Personal message (if provided)</li>
        <li>Redemption code and PIN</li>
        <li>Redemption instructions</li>
        <li>Expiration date</li>
    </ul>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Email Branding
        </div>
        <p>
            You can customize the email template with your company branding in the <a href="">Dashboard</a> under Settings → Email Templates. This is available on Pro and Enterprise plans.
        </p>
    </div>

    <h2 id="webhooks">Webhook Events</h2>
    <p>
        When sending a gift card, you'll receive webhook notifications for:
    </p>

    <ul>
        <li><code>gift_card.created</code> - Gift card order created</li>
        <li><code>gift_card.delivered</code> - Email successfully delivered</li>
        <li><code>gift_card.failed</code> - Delivery failed</li>
    </ul>

    <p>
        Learn more about <a href="{{url('/docs/webhooks')}}">Webhooks</a>.
    </p>

    <h2 id="errors">Errors</h2>

    <h3 id="invalid-email">Invalid Email</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">422 Unprocessable Entity</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "error": {
    "code": "validation_error",
    "message": "The recipient email field must be a valid email address",
    "type": "invalid_request_error",
    "param": "recipient_email"
  }
}</code></pre>
    </div>

    <h3 id="delivery-failed">Delivery Failed</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">400 Bad Request</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "error": {
    "code": "delivery_failed",
    "message": "Failed to deliver gift card email. Please check the recipient email address",
    "type": "api_error"
  }
}</code></pre>
    </div>

    <h3 id="invalid-delivery-date">Invalid Delivery Date</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">422 Unprocessable Entity</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "error": {
    "code": "invalid_delivery_date",
    "message": "Delivery date must be at least 1 hour in the future",
    "type": "invalid_request_error",
    "param": "delivery_date"
  }
}</code></pre>
    </div>

    <h2 id="bulk-sending">Bulk Sending</h2>
    <p>
        To send gift cards to multiple recipients, make separate API calls for each recipient. For high-volume sending (100+ recipients), consider using our <a href="">Bulk API</a> or contact our sales team for enterprise solutions.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Bulk Sending Example (PHP)</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$recipients = [
    ['email' => 'user1@example.com', 'name' => 'User One'],
    ['email' => 'user2@example.com', 'name' => 'User Two'],
    ['email' => 'user3@example.com', 'name' => 'User Three']
];

foreach ($recipients as $recipient) {
    try {
        $response = $client->post('/gift-cards/send', [
            'json' => [
                'brand_id' => 'amazon',
                'amount' => 25.00,
                'currency' => 'USD',
                'recipient_email' => $recipient['email'],
                'recipient_name' => $recipient['name'],
                'sender_name' => 'Your Company',
                'message' => 'Thanks for your hard work!'
            ]
        ]);

        echo "Gift card sent to {$recipient['email']}\n";

    } catch (Exception $e) {
        echo "Failed to send to {$recipient['email']}: {$e->getMessage()}\n";
    }

    // Rate limiting: pause between requests
    usleep(100000); // 100ms delay
}</code></pre>
    </div>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Best Practices
        </div>
        <ul>
            <li>Validate email addresses before sending</li>
            <li>Keep personal messages under 500 characters</li>
            <li>Use scheduled delivery for special occasions</li>
            <li>Implement retry logic for failed deliveries</li>
            <li>Monitor delivery status via webhooks</li>
            <li>Test with sandbox environment first</li>
            <li>Add meaningful metadata for tracking</li>
            <li>Respect rate limits when bulk sending</li>
        </ul>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Next Steps
        </div>
        <ul>
            <li>Learn about <a href="{{url('/api/gift-cards/create')}}">Creating Gift Cards</a> without sending</li>
            <li>Set up <a href="{{url('/docs/webhooks')}}">Webhooks</a> for delivery notifications</li>
            <li>Browse <a href="{{url('/api/countries')}}">Available Brands</a> by country</li>
        </ul>
    </div>
@endsection