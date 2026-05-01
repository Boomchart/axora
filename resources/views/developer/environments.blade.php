@extends('developer.menu')

@section('content')
    <h1>Environment</h1>
    <p class="lead-text">
        {{$set->site_name}} provides two distinct environments for development and production: Sandbox and Production.
    </p>

    <h2 id="sandbox-environment">Sandbox Environment</h2>
    <p>
        The Sandbox environment is a fully-featured testing environment that allows you to test your integration without processing real transactions or spending real money.
    </p>

    <h3 id="sandbox-url">Sandbox Base URL</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Sandbox URL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">{{config('app.url').'/api/v1'}}</code></pre>
    </div>

    <h3 id="sandbox-features">Sandbox Features</h3>
    <ul>
        <li>Test all API endpoints without real transactions</li>
        <li>No actual gift cards are delivered</li>
        <li>No charges to your account</li>
        <li>Webhooks are delivered to your test endpoints</li>
        <li>Full access to all brands and denominations</li>
        <li>Rate limit: 60 requests per minute</li>
    </ul>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Test Credentials
        </div>
        <p>
            When you sign up for an {{$set->site_name}} account, you'll automatically receive both Sandbox and Production API keys. Use your Sandbox keys for testing and development.
        </p>
    </div>

    <h2 id="production-environment">Production Environment</h2>
    <p>
        The Production environment is where real transactions occur. Use your Production API keys to process actual gift card purchases and deliveries.
    </p>

    <h3 id="production-url">Production Base URL</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Production URL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">{{config('app.url').'/api/v1'}}</code></pre>
    </div>

    <h3 id="production-features">Production Features</h3>
    <ul>
        <li>Real gift card transactions</li>
        <li>Actual gift cards delivered to recipients</li>
        <li>Real charges to your account balance</li>
        <li>Live webhooks for transaction events</li>
        <li>Rate limit: 100 requests per minute</li>
        <li>24/7 support and monitoring</li>
    </ul>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Production Warning
        </div>
        <p>
            In Production mode, all transactions are real and will result in actual charges. Make sure to thoroughly test your integration in Sandbox before switching to Production.
        </p>
    </div>

    <h2 id="switching-environments">Switching Between Environments</h2>
    <p>
        To switch between environments, simply change the API key in your application:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">// Sandbox
$baseUrl = '{{config('app.url').'/api/v1'}}';
$apiKey = 'sk_test_your_sandbox_key';

// Production
$baseUrl = '{{config('app.url').'/api/v1'}}';
$apiKey = 'sk_live_your_production_key';</code></pre>
    </div>

    <h2 id="api-key-prefixes">API Key Prefixes</h2>
    <p>
        {{$set->site_name}} API keys use prefixes to indicate the environment:
    </p>

    <table class="params-table">
        <thead>
        <tr>
            <th>Prefix</th>
            <th>Environment</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><code>sk_test_</code></td>
            <td>Sandbox</td>
            <td>Secret key for testing</td>
        </tr>
        <tr>
            <td><code>sk_live_</code></td>
            <td>Production</td>
            <td>Secret key for production</td>
        </tr>
        </tbody>
    </table>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Best Practices
        </div>
        <ul>
            <li>Always use environment variables to store API keys</li>
            <li>Never commit API keys to version control</li>
            <li>Use Sandbox for all development and testing</li>
            <li>Test webhooks thoroughly before going live</li>
            <li>Monitor your Production environment closely</li>
        </ul>
    </div>

    <h2 id="environment-differences">Environment Differences</h2>

    <table class="params-table">
        <thead>
        <tr>
            <th>Feature</th>
            <th>Sandbox</th>
            <th>Production</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Real Transactions</td>
            <td>No</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>Gift Card Delivery</td>
            <td>Test codes only</td>
            <td>Real codes</td>
        </tr>
        <tr>
            <td>Billing</td>
            <td>Free</td>
            <td>Per transaction</td>
        </tr>
        <tr>
            <td>Rate Limit</td>
            <td>60/min</td>
            <td>60/min</td>
        </tr>
        <tr>
            <td>Support</td>
            <td>Email only</td>
            <td>24/7 priority</td>
        </tr>
        </tbody>
    </table>
@endsection