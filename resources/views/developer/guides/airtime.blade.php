@extends('developer.menu')

@section('content')
    <h1>Airtime Guide</h1>
    <p class="lead-text">
        Learn how to identify the correct mobile operator, validate a recipient, calculate a quote, and send airtime.
    </p>

    <p><a href="{{ route('developer.guides') }}">&larr; Back to all guides</a></p>

    <h2 id="how-the-flow-works">How the Flow Works</h2>
    <ol>
        <li>Choose a supported country and operator.</li>
        <li>Validate the recipient number and operator.</li>
        <li>Request a quote for the airtime amount.</li>
        <li>Create the top-up with a unique external reference.</li>
        <li>Process the airtime webhook and reconcile the final status.</li>
    </ol>

    <h2 id="step-1-select-an-operator">1. Select an Operator</h2>
    <p>
        Use <a href="{{ route('developer.countries') }}">List Countries</a>, then <a href="{{ route('developer.airtime.operators') }}">List Airtime Operators</a> for the selected country. If you already have an operator ID, use <a href="{{ route('developer.airtime.operator') }}">Get Airtime Operator</a> to refresh its limits and currency.
    </p>

    <h2 id="step-2-validate-the-recipient">2. Validate the Recipient</h2>
    <p>
        Call <a href="{{ route('developer.airtime.lookup') }}">Airtime Number Lookup</a> with the operator ID, phone number, and ISO2 country code. Use the result to catch a mismatched operator before taking payment.
    </p>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Phone Country Code
        </div>
        <p>
            <code>phone_code</code> is a two-letter ISO2 country code such as <code>NG</code> or <code>US</code>. It is not an international dialling prefix such as <code>+234</code> or <code>+1</code>.
        </p>
    </div>

    <h2 id="step-3-request-a-quote">3. Request a Quote</h2>
    <p>
        Call <a href="{{ route('developer.airtime.quote') }}">Create Airtime Quote</a> with the operator ID and amount. Confirm that the amount is within the operator's limits and show the returned total before ordering.
    </p>

    <h2 id="step-4-create-the-order">4. Create the Order</h2>
    <p>
        Submit one or more top-ups through <a href="{{ route('developer.airtime.order') }}">Create Airtime Order</a>. Each item needs its own unique <code>external_reference</code>.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Order Request</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST "{{ url('/') }}/api/v1/airtime-order" \
  -H "Authorization: Bearer sk_test_your_api_key" \
  -H "Idempotency-Key: airtime-order-1002" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "data": [
      {
        "external_reference": "airtime-1002",
        "operator_id": "3e0e1d43-809c-4f36-b069-b7fe6ee2b6d4",
        "amount": 1000,
        "phone": "09057550480",
        "phone_code": "NG"
      }
    ]
  }'</code></pre>
    </div>

    <h2 id="step-5-track-the-result">5. Track the Result</h2>
    <p>
        Process the <code>airtime</code> webhook to update your local order. The request response may indicate that processing has started, so do not treat it as proof of delivery. Use <a href="{{ route('developer.airtime.transaction') }}">Get Airtime Transaction</a> or <a href="{{ route('developer.airtime.transactions') }}">List Airtime Transactions</a> to reconcile delayed or missing events.
    </p>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Confirm Before Sending
        </div>
        <p>
            Ask the customer to confirm the phone number, country, operator, and amount. A successful airtime top-up generally cannot be reversed.
        </p>
    </div>

    <h2 id="production-checklist">Production Checklist</h2>
    <ul>
        <li>Refresh operator data and limits instead of hard-coding them.</li>
        <li>Normalize and validate the phone number before lookup.</li>
        <li>Use a unique external reference for every top-up.</li>
        <li>Handle each item separately when submitting a batch.</li>
        <li>Verify webhook signatures and process retries safely.</li>
        <li>Reconcile transactions that remain pending longer than expected.</li>
    </ul>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Related Documentation
        </div>
        <p>
            See <a href="{{ route('developer.airtime.operators') }}">Airtime API Reference</a> and <a href="{{ route('developer.webhook') }}">Webhooks</a> for complete request, response, and event details.
        </p>
    </div>
@endsection
