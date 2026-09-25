@extends('developer.menu')

@section('content')
    <h1>Data Guide</h1>
    <p class="lead-text">
        Learn how to select a mobile data operator, validate a recipient, calculate the price, and purchase data.
    </p>

    <p><a href="{{ route('developer.guides') }}">&larr; Back to all guides</a></p>

    <h2 id="how-the-flow-works">How the Flow Works</h2>
    <ol>
        <li>List data operators for the destination country.</li>
        <li>Inspect the selected product and validate the recipient.</li>
        <li>Request a quote for the selected amount.</li>
        <li>Create the data order with a unique external reference.</li>
        <li>Process the data webhook and reconcile the final result.</li>
    </ol>

    <h2 id="step-1-select-a-data-operator">1. Select a Data Operator</h2>
    <p>
        Use <a href="{{ route('developer.data.operators') }}">List Data Operators</a> for the customer's country. Open <a href="{{ route('developer.data.operator') }}">Get Data Operator</a> to confirm the product, currency, minimum, maximum, and other current details.
    </p>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Keep Resource IDs Separate
        </div>
        <p>
            Airtime and Data are separate resources. Use an operator ID returned by the Data endpoints when creating a data quote or order.
        </p>
    </div>

    <h2 id="step-2-validate-the-recipient">2. Validate the Recipient</h2>
    <p>
        Call <a href="{{ route('developer.data.lookup') }}">Data Number Lookup</a> with the data operator ID, phone number, and ISO2 country code. Confirm the detected network with the customer before continuing.
    </p>

    <h2 id="step-3-request-a-quote">3. Request a Quote</h2>
    <p>
        Call <a href="{{ route('developer.data.quote') }}">Create Data Quote</a> with the operator ID and amount. Display the returned currency, rate, charge, and total before taking payment.
    </p>

    <h2 id="step-4-create-the-order">4. Create the Order</h2>
    <p>
        Use <a href="{{ route('developer.data.order') }}">Create Data Order</a> to submit one or more purchases. Every order item must have a unique <code>external_reference</code>.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Order Request</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl -X POST "{{ url('/') }}/api/v1/data-order" \
  -H "Authorization: Bearer sk_test_your_api_key" \
  -H "Idempotency-Key: data-order-1003" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "data": [
      {
        "external_reference": "data-1003",
        "operator_id": "c2625008-d46c-4a64-991f-d8d176ab59e1",
        "amount": 1000,
        "phone": "09057550480",
        "phone_code": "NG"
      }
    ]
  }'</code></pre>
    </div>

    <h2 id="step-5-track-the-result">5. Track the Result</h2>
    <p>
        Update your local order from the <code>data</code> webhook. Do not mark the purchase delivered from the initial API response alone. Use <a href="{{ route('developer.data.transaction') }}">Get Data Transaction</a> or <a href="{{ route('developer.data.transactions') }}">List Data Transactions</a> when you need to reconcile its status.
    </p>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Validate Before Ordering
        </div>
        <p>
            Confirm the recipient phone number, network, product, and amount. A successfully delivered data purchase generally cannot be reversed.
        </p>
    </div>

    <h2 id="production-checklist">Production Checklist</h2>
    <ul>
        <li>Refresh data operators and product limits regularly.</li>
        <li>Validate the phone number and network before ordering.</li>
        <li>Use a unique external reference for every purchase.</li>
        <li>Handle each batch item and its errors independently.</li>
        <li>Verify webhook signatures and make processing idempotent.</li>
        <li>Reconcile transactions that remain pending longer than expected.</li>
    </ul>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Related Documentation
        </div>
        <p>
            See <a href="{{ route('developer.data.operators') }}">Data API Reference</a> and <a href="{{ route('developer.webhook') }}">Webhooks</a> for full request fields, responses, and event payloads.
        </p>
    </div>
@endsection
