@extends('developer.menu')

@section('content')
<h1>{{__('Get API Keys')}}</h1>
<p class="lead-text">
    {{__('Learn how to obtain and manage your')}} {{$set->site_name}} {{__('API keys to start integrating our gift card API into your application.')}}
</p>

<h2 id="creating-account">{{__('Creating an Account')}}</h2>
<p>
    {{__('Before you can obtain API keys, you need to create an')}} {{$set->site_name}} {{__('account:')}}
</p>

<ul>
    <li>{{__('Visit')}} <a target="_blank" href="{{route('register')}}">{{route('register')}}</a> {{__('to register for a free account')}}</li>
</ul>

<div class="info-box warning">
    <div class="info-box-title">
        <i class="bi bi-exclamation-triangle"></i>
        {{__('Keep Secret Keys Secure')}}
    </div>
    <p>
        {{__('Secret keys can perform any API operation. Always keep them secure and never commit them to version control or share them publicly.')}}
    </p>
</div>


<h2 id="using-keys">{{__('Using Your API Keys')}}</h2>
<p>
    {{__('Once you have your API keys, include them in the Authorization header of your requests:')}}
</p>

<div class="code-block-wrapper">
    <div class="code-block-header">
        <span class="code-block-title">{{__('Using API Keys')}}</span>
        <button class="code-copy-button">{{__('Copy')}}</button>
    </div>
    <pre><code class="language-bash">curl {{config('app.url').'/api/v1'}}/gift-cards \
  -H "Authorization: Bearer sk_live_your_api_key_here" \
  -H "Content-Type: application/json"</code></pre>
</div>

<h3 id="environment-variables">{{__('Environment Variables')}}</h3>
<p>
    {{__('Store your API keys in environment variables for security:')}}
</p>

<div class="code-block-wrapper">
    <div class="code-block-header">
        <span class="code-block-title">.env File</span>
        <button class="code-copy-button">{{__('Copy')}}</button>
    </div>
    <pre><code class="language-bash"># Sandbox Keys
            {{strtoupper($set->site_name)}}_TEST_SECRET_KEY=sk_test_your_test_key_here

            # Production Keys
            {{strtoupper($set->site_name)}}_LIVE_SECRET_KEY=sk_live_your_live_key_here
            </code></pre>
</div>

<div class="code-block-wrapper">
    <div class="code-block-header">
        <span class="code-block-title">PHP Usage</span>
        <button class="code-copy-button">Copy</button>
    </div>
    <pre><code class="language-php">// Load API key from environment
$apiKey = getenv('{{strtoupper($set->site_name)}}_LIVE_SECRET_KEY');

// Use in your application
$client = new GuzzleHttp\Client([
    'base_uri' => '{{config('app.url')}}/api/v1',
    'headers' => [
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json'
    ]
]);
</code></pre>
</div>

<h2 id="monitoring-usage">{{__('Monitoring API Key Usage')}}</h2>
<p>
    {{__('You can monitor the usage of your API keys in the Dashboard:')}}
</p>

<ul>
    <li>View request counts per key</li>
    <li>See last used timestamp</li>
    <li>Monitor error rates</li>
    <li>Track which endpoints are being used</li>
</ul>

<div class="info-box success">
    <div class="info-box-title">
        <i class="bi bi-check-circle"></i>
        Best Practices
    </div>
    <ul>
        <li>Store API keys in environment variables, never in code</li>
        <li>Use different keys for development, staging, and production</li>
        <li>Rotate keys regularly (every 90 days for production)</li>
        <li>Revoke compromised keys immediately</li>
        <li>Monitor key usage in the Dashboard</li>
        <li>Use secret keys only on your server</li>
        <li>Add descriptive names to keys for easy identification</li>
        <li>Set up alerts for unusual API key activity</li>
    </ul>
</div>

<h2 id="troubleshooting">Troubleshooting</h2>

<h3 id="invalid-key">Invalid API Key Error</h3>
<p>
    If you receive a 401 error with "Invalid API key":
</p>

<ul>
    <li>Verify you're using the correct key for the environment</li>
    <li>Ensure the key hasn't been revoked</li>
    <li>Check that you're including "Bearer " before the key</li>
    <li>Confirm there are no extra spaces or characters</li>
</ul>

<h3 id="wrong-environment">Wrong Environment</h3>
<p>
    Make sure you're using the correct key for your environment:
</p>

<ul>
    <li>Test keys (<code>sk_test_</code>) only work with <code>sandbox</code></li>
    <li>Live keys (<code>sk_live_</code>) only work with <code>production</code></li>
</ul>
@endsection