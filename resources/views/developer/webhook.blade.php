@extends('developer.menu')

@section('content')
    <h1>Webhooks</h1>
    <p class="lead-text">
        Webhooks notify your application when a transaction changes in your {{ $set->site_name }} account. Configure one endpoint and we will send signed HTTP POST requests for gift card, airtime, data, and crypto events.
    </p>

    <h2 id="overview">Overview</h2>
    <p>
        Webhooks remove the need to continuously poll transaction endpoints. When a supported event occurs, {{ $set->site_name }} queues a JSON request to the webhook URL configured for your business.
    </p>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Configure your endpoint
        </div>
        <p>
            Sign in to your <a href="{{ route('user.dashboard') }}" target="_blank" rel="noopener noreferrer">Dashboard</a>, open your API settings, and provide a webhook URL and webhook secret. Use a public HTTPS URL and keep the secret private.
        </p>
    </div>

    <h3 id="delivery-summary">Delivery summary</h3>
    <table class="params-table">
        <thead>
        <tr>
            <th>Property</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>HTTP method</td>
            <td><code>POST</code></td>
        </tr>
        <tr>
            <td>Content type</td>
            <td><code>application/json</code></td>
        </tr>
        <tr>
            <td>Signature header</td>
            <td><code>webhook-secret</code></td>
        </tr>
        <tr>
            <td>Signature algorithm</td>
            <td>HMAC-SHA256 of the exact raw request body</td>
        </tr>
        <tr>
            <td>Request timeout</td>
            <td>3 seconds</td>
        </tr>
        <tr>
            <td>Successful acknowledgement</td>
            <td>Any <code>2xx</code> response</td>
        </tr>
        <tr>
            <td>Delivery attempts</td>
            <td>Up to 3 attempts</td>
        </tr>
        </tbody>
    </table>

    <h2 id="webhook-events">Webhook events</h2>
    <p>The top-level <code>event</code> field identifies the payload type.</p>

    <table class="params-table">
        <thead>
        <tr>
            <th>Event</th>
            <th>When it is sent</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><code>giftcard</code></td>
            <td>A gift card order is fulfilled or its supported status is updated.</td>
        </tr>
        <tr>
            <td><code>redemption</code></td>
            <td>A redeemable gift card balance is processed or updated.</td>
        </tr>
        <tr>
            <td><code>airtime</code></td>
            <td>An airtime purchase is fulfilled or its supported status is updated.</td>
        </tr>
        <tr>
            <td><code>data</code></td>
            <td>A mobile data purchase is fulfilled or its supported status is updated.</td>
        </tr>
        <tr>
            <td><code>crypto_deposit</code></td>
            <td>A supported crypto deposit is confirmed and credited.</td>
        </tr>
        <tr>
            <td><code>crypto_payout</code></td>
            <td>A crypto payout reaches a supported final status.</td>
        </tr>
        </tbody>
    </table>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Handle event values as strings
        </div>
        <p>
            New events and statuses may be added over time. Ignore event types you do not recognise, log them for review, and do not fail your endpoint solely because an unknown event was received.
        </p>
    </div>

    <h2 id="payload-envelope">Payload envelope</h2>
    <p>Every webhook has the same top-level structure:</p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Webhook envelope</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "airtime",
  "data": {
    "id": "01933e49-872a-72b1-a7e2-3a97de3d98b0",
    "status": "success",
    "mode": "live"
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
        <tr>
            <td><code>event</code></td>
            <td>string</td>
            <td>The event name used to route the webhook to the correct handler.</td>
        </tr>
        <tr>
            <td><code>data</code></td>
            <td>object</td>
            <td>The event-specific transaction or redemption data.</td>
        </tr>
        <tr>
            <td><code>data.id</code></td>
            <td>string</td>
            <td>The related {{ $set->site_name }} order, transaction, or redemption record ID.</td>
        </tr>
        <tr>
            <td><code>data.mode</code></td>
            <td>string</td>
            <td>The environment that generated the event: <code>test</code> or <code>live</code>.</td>
        </tr>
        </tbody>
    </table>

    <h2 id="giftcard-event">Gift card event</h2>
    <p>
        The <code>giftcard</code> event contains the ordered card, payment calculation, recipient, current status, and redemption credentials when they are available.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">giftcard</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "giftcard",
  "data": {
    "id": "01933e49-872a-72b1-a7e2-3a97de3d98b0",
    "external_reference": "customer-order-1001",
    "card": {
      "id": "0192fdae-5180-7334-baf7-bbd338d62223",
      "name": "Amazon UK",
      "amount": 25
    },
    "payment": {
      "currency": "NGN",
      "rate": 1950.25,
      "amount": 48756.25,
      "charge": 500,
      "total": 49256.25
    },
    "customer": {
      "name": "Jane Doe",
      "email": "jane@example.com",
      "phone": "8012345678",
      "phone_code": "NG"
    },
    "status": "success",
    "redeem_code": {
      "url": null,
      "card_code": "RJNI-0PLB-VQL3-1ZW6",
      "pin": null
    },
    "mode": "live"
  }
}</code></pre>
    </div>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-shield-lock"></i>
            Protect redemption credentials
        </div>
        <p>
            Values in <code>redeem_code</code> may be sensitive. Store them securely, restrict access, avoid writing complete codes to ordinary logs, and only expose them to the intended recipient.
        </p>
    </div>

    <h2 id="redemption-event">Redemption event</h2>
    <p>
        The <code>redemption</code> event reports a gift card redemption or balance update. Unlike order events, this payload does not include a <code>status</code> field.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">redemption</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "redemption",
  "data": {
    "id": "redemption_01JAB7EFD8A4QTFMRA2MVRF2AH",
    "card_id": "0192fdae-5180-7334-baf7-bbd338d62223",
    "name": "Amazon UK",
    "processed_amount": 10,
    "balance": 15,
    "card_code": "RJNI-0PLB-VQL3-1ZW6",
    "card_url": null,
    "expires": "2027-08-03T23:59:59Z",
    "mode": "live"
  }
}</code></pre>
    </div>

    <h2 id="airtime-event">Airtime event</h2>
    <p>The <code>airtime</code> event contains the operator, payment calculation, recipient telephone number, and current transaction status.</p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">airtime</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "airtime",
  "data": {
    "id": "01933f01-5b78-75a4-a826-54bb09ecb326",
    "external_reference": "airtime-1002",
    "operator": {
      "id": "MTN-NG",
      "name": "MTN Nigeria",
      "amount": 1000
    },
    "payment": {
      "currency": "NGN",
      "rate": 1,
      "amount": 1000,
      "charge": 25,
      "total": 1025
    },
    "status": "success",
    "customer": {
      "phone": "8012345678",
      "phone_code": "NG"
    },
    "mode": "live"
  }
}</code></pre>
    </div>

    <h2 id="data-event">Data event</h2>
    <p>The <code>data</code> event uses the same structure as an airtime event, but represents a mobile data purchase.</p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">data</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "data",
  "data": {
    "id": "01933f21-3a44-7c73-b0ef-b9d0811f5824",
    "external_reference": "data-1003",
    "operator": {
      "id": "MTN-NG-5GB",
      "name": "MTN Nigeria 5 GB",
      "amount": 5000
    },
    "payment": {
      "currency": "NGN",
      "rate": 1,
      "amount": 5000,
      "charge": 75,
      "total": 5075
    },
    "status": "success",
    "customer": {
      "phone": "8012345678",
      "phone_code": "NG"
    },
    "mode": "live"
  }
}</code></pre>
    </div>

    <h2 id="crypto-deposit-event">Crypto deposit event</h2>
    <p>
        The <code>crypto_deposit</code> event is sent after a supported deposit is confirmed and recorded. <code>amount</code> is the credited amount, <code>charge</code> is the applied fee, and <code>total</code> is their sum.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">crypto_deposit</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "crypto_deposit",
  "data": {
    "id": "01934010-c9f2-7de2-a170-7168c707857a",
    "currency": "USDT",
    "amount": 98.5,
    "charge": 1.5,
    "total": 100,
    "status": "success",
    "mode": "live",
    "wallet_address": "0x742d35Cc6634C0532925a3b844Bc454e4438f44e",
    "asset_id": "01931b72-1dcb-70c5-a325-ff177ab2de31",
    "address_id": "01931b9c-13e8-7cef-a14d-3a81cb68a8b7",
    "balance": {
      "old_balance": 250,
      "new_balance": 348.5
    },
    "created_at": "2026-08-03T10:24:51.000000Z"
  }
}</code></pre>
    </div>

    <h2 id="crypto-payout-event">Crypto payout event</h2>
    <p>
        The <code>crypto_payout</code> event reports a supported final payout update. Its payload is similar to a crypto deposit and includes your <code>external_reference</code> when one was supplied.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">crypto_payout</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "event": "crypto_payout",
  "data": {
    "id": "01934045-fc1d-7cde-933f-3e6a856989ac",
    "currency": "USDT",
    "amount": 50,
    "charge": 1.25,
    "total": 51.25,
    "status": "success",
    "mode": "live",
    "wallet_address": "0x8ba1f109551bD432803012645Ac136ddd64DBA72",
    "asset_id": "01931b72-1dcb-70c5-a325-ff177ab2de31",
    "address_id": null,
    "external_reference": "merchant-payout-1004",
    "balance": {
      "old_balance": 348.5,
      "new_balance": 297.25
    },
    "created_at": "2026-08-03T10:31:20.000000Z"
  }
}</code></pre>
    </div>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Network safety
        </div>
        <p>
            Always reconcile the asset, network, destination, amount, and status against your own transaction record. Blockchain transfers may be irreversible once broadcast or confirmed.
        </p>
    </div>

    <h2 id="webhook-signatures">Verify webhook signatures</h2>
    <p>
        Every request is signed using your webhook secret. The signature is a lowercase hexadecimal HMAC-SHA256 digest of the exact raw JSON request body.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Request headers</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-http">Content-Type: application/json
webhook-secret: 2f55bd728a6a49dbd2c9b694573401433e12a354e19ee74bbde26817a14d838d</code></pre>
    </div>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Use the raw body
        </div>
        <p>
            Verify the signature before parsing the JSON. Parsing and re-encoding the payload can change whitespace, escaping, or key formatting and produce a different signature.
        </p>
    </div>

    <h3 id="verify-with-php">PHP verification example</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP webhook handler</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">&lt;?php

$rawBody = file_get_contents('php://input');
$signature = $_SERVER['HTTP_WEBHOOK_SECRET'] ?? '';
$webhookSecret = getenv('AZORA_WEBHOOK_SECRET');

$expectedSignature = hash_hmac('sha256', $rawBody, $webhookSecret);

if ($signature === '' || !hash_equals($expectedSignature, $signature)) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

try {
    $payload = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);

    switch ($payload['event'] ?? null) {
        case 'giftcard':
            handleGiftCard($payload['data']);
            break;

        case 'redemption':
            handleRedemption($payload['data']);
            break;

        case 'airtime':
            handleAirtime($payload['data']);
            break;

        case 'data':
            handleData($payload['data']);
            break;

        case 'crypto_deposit':
            handleCryptoDeposit($payload['data']);
            break;

        case 'crypto_payout':
            handleCryptoPayout($payload['data']);
            break;

        default:
            error_log('Unknown webhook event');
    }

    http_response_code(200);
    echo json_encode(['received' => true]);
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
}</code></pre>
    </div>

    <h3 id="verify-with-laravel">Laravel verification example</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Laravel controller</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

public function handle(Request $request)
{
    $rawBody = $request->getContent();
    $signature = $request->header('webhook-secret', '');
    $expected = hash_hmac(
        'sha256',
        $rawBody,
        config('services.azora.webhook_secret')
    );

    abort_unless(
        $signature !== '' && hash_equals($expected, $signature),
        401,
        'Invalid signature'
    );

    $payload = $request->json()->all();

    // Store or queue the event before returning.
    ProcessAzoraWebhook::dispatch($payload);

    return response()->json(['received' => true]);
}</code></pre>
    </div>

    <h3 id="verify-with-node">Node.js verification example</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Express webhook handler</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">import crypto from 'node:crypto';
import express from 'express';

const app = express();

app.post(
  '/webhooks/azora',
  express.raw({ type: 'application/json' }),
  (request, response) =&gt; {
    const signature = request.get('webhook-secret') ?? '';
    const rawBody = request.body;
    const expected = crypto
      .createHmac('sha256', process.env.AZORA_WEBHOOK_SECRET)
      .update(rawBody)
      .digest('hex');

    const valid =
      signature.length === expected.length &&
      crypto.timingSafeEqual(
        Buffer.from(signature, 'utf8'),
        Buffer.from(expected, 'utf8')
      );

    if (!valid) {
      return response.status(401).json({ error: 'Invalid signature' });
    }

    const event = JSON.parse(rawBody.toString('utf8'));

    // Store or queue the event before acknowledging it.
    queueWebhook(event);

    return response.status(200).json({ received: true });
  }
);</code></pre>
    </div>

    <h2 id="handling-webhooks">Receive webhooks safely</h2>
    <ol>
        <li>Read the exact raw request body.</li>
        <li>Calculate its HMAC-SHA256 signature using your webhook secret.</li>
        <li>Compare the calculated value with the <code>webhook-secret</code> header using a timing-safe comparison.</li>
        <li>Persist the event or place it on your own queue.</li>
        <li>Return a <code>2xx</code> response within 3 seconds.</li>
        <li>Process the business action asynchronously.</li>
    </ol>

    <h3 id="idempotency">Idempotency and ordering</h3>
    <p>
        Webhooks may be delivered more than once because of automatic retries or manual resends. Deliveries can also arrive out of order. Your handler must therefore be idempotent and must not assume that receiving an event once means no later update will arrive.
    </p>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Recommended deduplication key
        </div>
        <p>
            For transaction updates, store a composite key containing <code>event</code>, <code>data.id</code>, <code>data.status</code>, and <code>data.mode</code>. Do not deduplicate only on <code>data.id</code>, because the same transaction may legitimately produce more than one status update.
        </p>
    </div>

    <h2 id="retries">Retries and failures</h2>
    <p>
        A delivery is considered successful when your endpoint returns any <code>2xx</code> response within 3 seconds. Network errors, TLS errors, timeouts, and non-<code>2xx</code> responses trigger the retry schedule.
    </p>

    <table class="params-table">
        <thead>
        <tr>
            <th>Attempt</th>
            <th>Timing</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>Immediately</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Approximately 10 seconds after the first failed attempt</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Approximately 100 seconds after the second failed attempt</td>
        </tr>
        </tbody>
    </table>

    <p>
        You can review delivery attempts and responses in your webhook logs. Where the Dashboard offers a resend action, treat the resent request as a duplicate and process it idempotently.
    </p>

    <h2 id="testing">Testing webhooks</h2>
    <p>
        Test-mode transactions produce payloads with <code>"mode": "test"</code>. Keep test and live processing logically separated, even if both environments deliver to the same endpoint.
    </p>

    <h3 id="local-testing">Local testing</h3>
    <p>
        A local server is not publicly reachable. During development, use a secure tunnel such as <a href="https://ngrok.com" target="_blank" rel="noopener noreferrer">ngrok</a> and save its HTTPS URL in your webhook settings.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Local endpoint with ngrok</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash"># Expose a Laravel application running on port 8000
ngrok http 8000

# Example webhook URL
https://example-subdomain.ngrok-free.app/webhooks/azora</code></pre>
    </div>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Production checklist
        </div>
        <ul>
            <li>Use a public HTTPS endpoint with a valid TLS certificate.</li>
            <li>Keep the webhook secret outside source control and client-side code.</li>
            <li>Verify the signature using the raw request body.</li>
            <li>Return a <code>2xx</code> response within 3 seconds.</li>
            <li>Queue slow processing after the event is safely stored.</li>
            <li>Make every event handler idempotent.</li>
            <li>Do not assume webhook delivery order.</li>
            <li>Protect gift card codes, PINs, wallet addresses, and customer data.</li>
            <li>Monitor failed deliveries and reconcile transactions through the API.</li>
            <li>Handle unknown events and statuses without crashing.</li>
        </ul>
    </div>
@endsection
