@extends('developer.menu')

@section('content')
    <h1>Crypto Guide</h1>
    <p class="lead-text">
        Learn how to create customer deposit addresses, process crypto deposits, calculate payout fees, and send crypto safely.
    </p>

    <p><a href="{{ route('developer.guides') }}">&larr; Back to all guides</a></p>

    <h2 id="two-separate-flows">Two Separate Flows</h2>
    <ul>
        <li><strong>Deposits:</strong> Create an address for a customer and credit the customer after a verified <code>crypto_deposit</code> webhook.</li>
        <li><strong>Payouts:</strong> Quote the fees, confirm the destination, create the payout, and track the <code>crypto_payout</code> webhook.</li>
    </ul>

    <h2 id="accept-a-crypto-deposit">Accept a Crypto Deposit</h2>

    <h3 id="deposit-step-1-select-an-asset">1. Select an Asset</h3>
    <p>
        Use <a href="{{ route('developer.crypto.assets') }}">List Crypto Assets</a>. Each asset represents an exact token and network combination. Show both values to the customer and store the returned <code>asset_id</code>.
    </p>

    <h3 id="deposit-step-2-create-an-address">2. Create a Deposit Address</h3>
    <p>
        Call <a href="{{ route('developer.crypto.create-address') }}">Create Crypto Address</a> with the selected <code>asset_id</code> and a unique label that maps the address to your customer.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Create Address Request</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST "{{ url('/') }}/api/v1/create-address" \
  -H "Authorization: Bearer sk_test_your_api_key" \
  -H "Idempotency-Key: create-address-customer-1048" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "label": "customer-1048",
    "asset_id": "5145e120-afa5-40e5-85f8-925f88001859"
  }'</code></pre>
    </div>

    <p>Store these returned values separately:</p>
    <table class="params-table">
        <thead>
        <tr>
            <th>Value</th>
            <th>Purpose</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><code>data.id</code></td>
            <td>The address record ID used in API requests. This is not an on-chain wallet address.</td>
        </tr>
        <tr>
            <td><code>data.asset_id</code></td>
            <td>The selected token and network asset record.</td>
        </tr>
        <tr>
            <td><code>data.address</code></td>
            <td>The on-chain wallet address shown to the sender.</td>
        </tr>
        <tr>
            <td><code>data.token</code> and <code>data.network</code></td>
            <td>The exact transfer route that must be shown with the wallet address.</td>
        </tr>
        </tbody>
    </table>

    <h3 id="deposit-step-3-display-transfer-details">3. Display the Transfer Details</h3>
    <p>
        Display the token, network, and wallet address together. Do not infer the network from the address format, and do not allow the sender to substitute another network.
    </p>

    <h3 id="deposit-step-4-process-the-webhook">4. Process the Deposit Webhook</h3>
    <p>
        Credit the customer only after verifying and processing the <code>crypto_deposit</code> webhook. Compare its asset, wallet address, amount, status, mode, and balance change with the address record in your database.
    </p>
    <p>
        In sandbox, use <a href="{{ route('developer.crypto.simulate-deposit') }}">Simulate Crypto Deposit</a> to test successful and failed events without sending real funds.
    </p>

    <h2 id="send-a-crypto-payout">Send a Crypto Payout</h2>

    <h3 id="payout-step-1-confirm-the-route">1. Confirm the Route and Destination</h3>
    <p>
        Select the exact asset with <a href="{{ route('developer.crypto.assets') }}">List Crypto Assets</a>. Ask the user to confirm the token, network, destination wallet address, and amount before continuing.
    </p>

    <h3 id="payout-step-2-request-a-quote">2. Request a Payout Quote</h3>
    <p>
        Call <a href="{{ route('developer.crypto.payout-quote') }}">Create Crypto Payout Quote</a> with the amount, an <code>address_id</code> belonging to the selected asset, and the destination <code>to_address</code>. The quote returns the network gas fee, {{$set->site_name}} charge, and total fee.
    </p>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Address ID vs Wallet Address
        </div>
        <p>
            <code>address_id</code> is the ID of an address record created in your account. <code>to_address</code> is the external on-chain wallet that will receive the payout.
        </p>
    </div>

    <h3 id="payout-step-3-create-the-payout">3. Create the Payout</h3>
    <p>
        Call <a href="{{ route('developer.crypto.payout') }}">Create Crypto Payout</a> with the asset ID, destination, amount, and a unique <code>external_reference</code>. Crypto payouts are available with live API keys.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Payout Request</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST "{{ url('/') }}/api/v1/payout" \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Idempotency-Key: crypto-payout-1004" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 25,
    "asset_id": "5145e120-afa5-40e5-85f8-925f88001859",
    "to_address": "0x742d35Cc6634C0532925a3b844Bc454e4438f44e",
    "external_reference": "merchant-payout-1004"
  }'</code></pre>
    </div>

    <h3 id="payout-step-4-track-the-result">4. Track the Result</h3>
    <p>
        Store the {{$set->site_name}} transaction ID returned by the API. Process the <code>crypto_payout</code> webhook and use <a href="{{ route('developer.crypto.transaction') }}">Get Crypto Transaction</a> for reconciliation. That endpoint expects the {{$set->site_name}} transaction ID, not your <code>external_reference</code>.
    </p>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Network Safety
        </div>
        <p>
            Funds sent through an incorrect or unsupported network may be permanently lost. Crypto transfers may be irreversible once broadcast, so confirm the asset, network, destination, amount, and fees before creating a payout.
        </p>
    </div>

    <h2 id="production-checklist">Production Checklist</h2>
    <ul>
        <li>Use an exact token and network asset returned by the API.</li>
        <li>Keep address record IDs separate from on-chain wallet addresses.</li>
        <li>Never credit a deposit from an unverified client-side callback.</li>
        <li>Verify webhook signatures and process duplicate deliveries safely.</li>
        <li>Use a unique external reference for every payout.</li>
        <li>Require a final confirmation before submitting an irreversible payout.</li>
        <li>Reconcile transaction IDs, amounts, statuses, and balance changes.</li>
    </ul>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Related Documentation
        </div>
        <p>
            See <a href="{{ route('developer.crypto.assets') }}">Crypto API Reference</a> and <a href="{{ route('developer.webhook') }}">Webhooks</a> for complete request fields, response schemas, and event payloads.
        </p>
    </div>
@endsection
