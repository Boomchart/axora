@extends('developer.menu')

@section('content')
    <h1>Webhooks</h1>
    <p class="lead-text">
        Webhooks allow you to receive real-time notifications about events that happen in your {{$set->site_name}} account. Instead of polling our API, you can configure webhook endpoints to receive automatic notifications when events occur.
    </p>

    <h2 id="overview">Overview</h2>
    <p>
        When an event occurs (such as a gift card being successfully delivered or a transaction failing), {{$set->site_name}} sends an HTTP POST request to the webhook URL you've configured. Your application can then perform actions based on these events.
    </p>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Setting Up Webhooks
        </div>
        <p>
            You can configure webhook endpoint in your <a href="{{route('user.dashboard')}}" target="_blank">Dashboard</a> under Settings → Webhooks.
        </p>
    </div>

    <h2 id="webhook-events">Webhook Events</h2>
    <p>
        {{$set->site_name}} sends webhooks for the following events:
    </p>

    <table class="params-table">
        <thead>
        <tr>
            <th>Event</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><code>gift_card.created</code></td>
            <td>A gift card order was created</td>
        </tr>
        <tr>
            <td><code>gift_card.delivered</code></td>
            <td>A gift card was successfully delivered</td>
        </tr>
        <tr>
            <td><code>gift_card.failed</code></td>
            <td>A gift card delivery failed</td>
        </tr>
        <tr>
            <td><code>gift_card.refunded</code></td>
            <td>A gift card order was refunded</td>
        </tr>
        <tr>
            <td><code>transaction.completed</code></td>
            <td>A transaction was completed successfully</td>
        </tr>
        <tr>
            <td><code>transaction.failed</code></td>
            <td>A transaction failed</td>
        </tr>
        <tr>
            <td><code>balance.updated</code></td>
            <td>Your account balance was updated</td>
        </tr>
        </tbody>
    </table>

    <h2 id="webhook-payload">Webhook Payload</h2>
    <p>
        All webhook requests include a JSON payload with information about the event:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Webhook Payload Structure</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "issued",
  "data": {
    "id": "e1a88d14-f8a7-4f10-bced-1da043ca890c",
    "card_id": "e6d64c61-7459-4f1b-8d8d-4d06346c429f",
    "name": "Farmfoods",
    "amount": 25,
    "currency": "GBP",
    "status": "success",
    "card_code": "RJNI-0PLB-VQL3-1ZW6",
    "card_url": null,
    "expires": "2026-07-06T17:14:58.000000Z"
  }
}</code></pre>
    </div>

    <h2 id="payload-attributes">Payload Attributes</h2>

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
            <td>Unique identifier for the event</td>
        </tr>
        <tr>
            <td><span class="param-name">type</span></td>
            <td><span class="param-type">string</span></td>
            <td>The event type (e.g., gift_card.delivered)</td>
        </tr>
        <tr>
            <td><span class="param-name">created_at</span></td>
            <td><span class="param-type">timestamp</span></td>
            <td>When the event occurred (ISO 8601)</td>
        </tr>
        <tr>
            <td><span class="param-name">data</span></td>
            <td><span class="param-type">object</span></td>
            <td>Contains the event data</td>
        </tr>
        <tr>
            <td><span class="param-name">data.object</span></td>
            <td><span class="param-type">object</span></td>
            <td>The resource affected by the event</td>
        </tr>
        </tbody>
    </table>

    <h2 id="webhook-signatures">Webhook Signatures</h2>
    <p>
        {{$set->site_name}} signs all webhook requests with a signature that you can verify to ensure the request came from us and wasn't tampered with.
    </p>

    <h3 id="signature-header">Signature Header</h3>
    <p>
        The signature is included in the <code>signature</code> header of each webhook request:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Signature Header</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">signature: cebeda32affa62cdca3fa51cad7e77a0e56ff536d0ce8e108d8bd</code></pre>
    </div>

    <h3 id="verifying-signatures">Verifying Signature</h3>
    <p>
        To verify the webhook signature, simply ensure that the value of the signature header matches with the webhook secret hash you set when enabling webhooks. If it doesn't match, then the request is not from {{$set->site_name}}.
    </p>

    <h2 id="handling-webhooks">Handling Webhooks</h2>
    <p>
        Your webhook endpoint should:
    </p>

    <ul>
        <li>Respond quickly (within 5 seconds)</li>
        <li>Return a 2xx status code to acknowledge receipt</li>
        <li>Verify the webhook signature</li>
        <li>Process the webhook asynchronously if needed</li>
        <li>Be idempotent (handle duplicate events gracefully)</li>
    </ul>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Webhook Handler Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">// webhook-handler.php
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_AXORA_SIGNATURE'] ?? '';
$webhookSecret = getenv('AXORA_WEBHOOK_SECRET');

try {
    // Verify signature
    verifyWebhookSignature($payload, $signature, $webhookSecret);

    // Parse event
    $event = json_decode($payload, true);

    // Handle event based on type
    switch ($event['type']) {
        case 'gift_card.delivered':
            handleGiftCardDelivered($event['data']['object']);
            break;

        case 'gift_card.failed':
            handleGiftCardFailed($event['data']['object']);
            break;

        case 'transaction.completed':
            handleTransactionCompleted($event['data']['object']);
            break;

        default:
            // Log unknown event type
            error_log('Unknown webhook event: ' . $event['type']);
    }

    // Respond with 200 OK
    http_response_code(200);
    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    // Log error and return 400
    error_log('Webhook error: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}

function handleGiftCardDelivered($giftCard) {
    // Update database
    // Send confirmation email
    // Log the event
}

function handleGiftCardFailed($giftCard) {
    // Update database
    // Notify administrators
    // Attempt retry logic
}

function handleTransactionCompleted($transaction) {
    // Update accounting records
    // Generate invoice
}</code></pre>
    </div>

    <h2 id="retries">Webhook Retries</h2>
    <p>
        If your endpoint doesn't respond with a 2xx status code, {{$set->site_name}} will automatically retry the webhook:
    </p>

    <ul>
        <li>Attempt 1: Immediately</li>
        <li>Attempt 2: After 1 minute</li>
        <li>Attempt 3: After 5 minutes</li>
        <li>Attempt 4: After 30 minutes</li>
        <li>Attempt 5: After 2 hours</li>
    </ul>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Idempotency
        </div>
        <p>
            Because webhooks may be retried, your endpoint should be idempotent. Use the event <code>id</code> to track which events you've already processed and avoid processing the same event multiple times.
        </p>
    </div>


    <h3 id="local-testing">Local Testing</h3>
    <p>
        For local development, use tools like <a href="https://ngrok.com" target="_blank">ngrok</a> to expose your local server:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Local Testing with ngrok</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash"># Start ngrok
ngrok http 8000

# Use the ngrok URL in your webhook settings
# Example: https://abc123.ngrok.io/webhooks/{{$set->site_name}}</code></pre>
    </div>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Best Practices
        </div>
        <ul>
            <li>Always verify webhook signatures</li>
            <li>Respond quickly with a 2xx status code</li>
            <li>Process webhooks asynchronously using queues</li>
            <li>Implement idempotency using event IDs</li>
            <li>Log all webhook events for debugging</li>
            <li>Monitor webhook failures in your Dashboard</li>
            <li>Use HTTPS endpoints only</li>
            <li>Handle all event types gracefully</li>
        </ul>
    </div>
@endsection