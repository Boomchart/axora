@extends('developer.menu')

@section('content')
    <h1>Authentication</h1>
    <p class="lead-text">
        The {{$set->site_name}} API uses API keys to authenticate requests. Your API keys carry many privileges, so be sure to keep them secure and never share them publicly.
    </p>

    <h2 id="api-keys">API Keys</h2>
    <p>
        Authentication to the API is performed via HTTP Bearer Token authentication. All API requests must include your API key in the <code>Authorization</code> header.
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Authentication Header</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">Authorization: Bearer YOUR_API_KEY</code></pre>
    </div>

    <h2 id="obtaining-api-keys">Obtaining API Keys</h2>
    <p>
        You can obtain your API keys from the <a href="{{route('user.dashboard')}}" target="_blank">{{$set->site_name}} Dashboard</a>. Each account is provided with two sets of keys:
    </p>

    <ul>
        <li><strong>Sandbox Keys:</strong> For testing and development (prefix: <code>sk_test_</code>)</li>
        <li><strong>Production Keys:</strong> For live transactions (prefix: <code>sk_live_</code>)</li>
    </ul>

    <div class="info-box warning">
        <div class="info-box-title">
            <i class="bi bi-exclamation-triangle"></i>
            Keep Your Keys Secure
        </div>
        <p>
            Your secret API keys can perform any API request without restriction. Keep them secure and never commit them to version control or share them in publicly accessible areas.
        </p>
    </div>

    <h2 id="making-authenticated-requests">Making Authenticated Requests</h2>

    <h3 id="curl-example">cURL Example</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{config('app.url').'/api/v1'}}/gift-cards \
  -H "Authorization: Bearer sk_live_your_api_key" \
  -H "Content-Type: application/json"</code></pre>
    </div>

    <h3 id="php-example">PHP Example</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$apiKey = 'sk_live_your_api_key';
$baseUrl = '{{config('app.url').'/api/v1'}}';

$ch = curl_init($baseUrl . '/gift-cards');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);</code></pre>
    </div>

    <h3 id="javascript-example">JavaScript Example</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript (Node.js)</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const apiKey = 'sk_live_your_api_key';
const baseUrl = '{{config('app.url').'/api/v1'}}';

fetch(`${baseUrl}/gift-cards`, {
  method: 'GET',
  headers: {
    'Authorization': `Bearer ${apiKey}`,
    'Content-Type': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));</code></pre>
    </div>

    <h3 id="python-example">Python Example</h3>
    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Python</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-python">import requests

api_key = 'sk_live_your_api_key'
base_url = '{{config('app.url').'/api/v1'}}'

headers = {
    'Authorization': f'Bearer {api_key}',
    'Content-Type': 'application/json'
}

response = requests.get(f'{base_url}/gift-cards', headers=headers)
data = response.json()
print(data)</code></pre>
    </div>

    <h2 id="authentication-errors">Authentication Errors</h2>
    <p>
        If your API key is missing, invalid, or expired, you'll receive a <code>401 Unauthorized</code> error:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Error Response</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "error": {
    "code": "unauthorized",
    "message": "Invalid API key provided",
    "type": "authentication_error"
  }
}</code></pre>
    </div>

    <h2 id="api-key-types">API Key Types</h2>

    <table class="params-table">
        <thead>
        <tr>
            <th>Key Type</th>
            <th>Prefix</th>
            <th>Use Case</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Secret Key (Test)</td>
            <td><code>sk_test_</code></td>
            <td>Server-side testing and development</td>
        </tr>
        <tr>
            <td>Secret Key (Live)</td>
            <td><code>sk_live_</code></td>
            <td>Server-side production requests</td>
        </tr>
        <tr>
            <td>Publishable Key (Test)</td>
            <td><code>pk_test_</code></td>
            <td>Client-side testing (limited permissions)</td>
        </tr>
        <tr>
            <td>Publishable Key (Live)</td>
            <td><code>pk_live_</code></td>
            <td>Client-side production (limited permissions)</td>
        </tr>
        </tbody>
    </table>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Secret vs Publishable Keys
        </div>
        <p>
            <strong>Secret keys</strong> should only be used on your server and have full API access. <strong>Publishable keys</strong> can be safely used in client-side code (like JavaScript in a browser) and have limited permissions.
        </p>
    </div>

    <h2 id="rotating-api-keys">Rotating API Keys</h2>
    <p>
        If your API key is compromised, you can generate a new one from the Dashboard. Follow these steps:
    </p>

    <ol>
        <li>Log in to your <a href="{{route('user.dashboard')}}" target="_blank">{{$set->site_name}} Dashboard</a></li>
        <li>Navigate to <strong>Settings → API Keys</strong></li>
        <li>Click <strong>Generate New Key</strong></li>
        <li>Update your application with the new key</li>
        <li>Revoke the old key once the new one is deployed</li>
    </ol>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Best Practices
        </div>
        <ul>
            <li>Store API keys in environment variables</li>
            <li>Never commit keys to version control</li>
            <li>Use different keys for development and production</li>
            <li>Rotate keys periodically (every 90 days recommended)</li>
            <li>Monitor API key usage in the Dashboard</li>
            <li>Revoke compromised keys immediately</li>
        </ul>
    </div>
@endsection