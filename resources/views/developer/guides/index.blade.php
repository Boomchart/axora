@extends('developer.menu')

@section('content')
    <h1>Guides</h1>
    <p class="lead-text">
        Follow these practical guides to build complete Gift Card, Airtime, Data, and Crypto integrations. Each guide explains the recommended request sequence and links to the detailed API reference.
    </p>

    <h2 id="choose-a-guide">Choose a Guide</h2>
    <table class="params-table">
        <thead>
        <tr>
            <th>Resource</th>
            <th>What You Will Build</th>
            <th>Guide</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong>Gift Cards</strong></td>
            <td>Discover cards, calculate a quote, place an order, and deliver redemption details safely.</td>
            <td><a href="{{ route('developer.guides.gift-cards') }}">Read the Gift Card guide</a></td>
        </tr>
        <tr>
            <td><strong>Airtime</strong></td>
            <td>Identify an operator, validate a mobile number, quote a top-up, and track delivery.</td>
            <td><a href="{{ route('developer.guides.airtime') }}">Read the Airtime guide</a></td>
        </tr>
        <tr>
            <td><strong>Data</strong></td>
            <td>Select a data operator, validate the recipient, purchase data, and reconcile the result.</td>
            <td><a href="{{ route('developer.guides.data') }}">Read the Data guide</a></td>
        </tr>
        <tr>
            <td><strong>Crypto</strong></td>
            <td>Create deposit addresses, receive deposit events, quote payouts, and send crypto safely.</td>
            <td><a href="{{ route('developer.guides.crypto') }}">Read the Crypto guide</a></td>
        </tr>
        </tbody>
    </table>

    <h2 id="shared-integration-pattern">Shared Integration Pattern</h2>
    <ol>
        <li>Develop with a sandbox API key and switch to a live key only after completing your tests.</li>
        <li>Authenticate every request and provide a new, unique <code>Idempotency-Key</code>.</li>
        <li>Store your own <code>external_reference</code> and the transaction ID returned by {{$set->site_name}}.</li>
        <li>Configure webhooks before creating orders or accepting crypto deposits.</li>
        <li>Make webhook processing idempotent because deliveries may be retried.</li>
        <li>Reconcile missing or delayed events with the appropriate transaction endpoint.</li>
    </ol>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Start Here
        </div>
        <p>
            If this is your first integration, read <a href="{{ route('developer.authentication') }}">Authentication</a> and <a href="{{ route('developer.webhook') }}">Webhooks</a> before opening a resource guide.
        </p>
    </div>
@endsection
