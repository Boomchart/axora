@extends('developer.reference.menu')

@section('content')
    <h1>Countries</h1>
    <p class="lead-text">
        Retrieve a list of all countries supported by Axora.
    </p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">/v1/countries</span>
    </div>

    <h2 id="overview">Overview</h2>
    <p>
        The Countries endpoint returns information about gift card availability across different countries. Use this endpoint to:
    </p>

    <ul>
        <li>Display available countries to your users</li>
        <li>Build dynamic country selectors in your application</li>
    </ul>


    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">List All Countries</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('')}}/api/v1/countries \
  -H "Authorization: Bearer sk_live_your_api_key"</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => '{{url('')}}/api/v1',
    'headers' => [
        'Authorization' => 'Bearer sk_live_your_api_key'
    ]
]);

$response = $client->get('/countries');
$countries = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('')}}/api/v1/countries', {
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key'
  }
});

const countries = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
    "data": [
        {
            "name": "Benin",
            "iso2": "BJ"
        },
        {
            "name": "France",
            "iso2": "FR"
        },
        {
            "name": "Nigeria",
            "iso2": "NG"
        },
        {
            "name": "United Kingdom",
            "iso2": "GB"
        },
        {
            "name": "United States",
            "iso2": "US"
        },
        {
            "name": "Zimbabwe",
            "iso2": "ZW"
        }
    ],
    "links": {
        "first": "{{url('')}}/api/v1/countries?page=1",
        "last": "{{url('')}}/api/v1/countries?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "{{url('')}}/api/v1/countries?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "{{url('')}}/api/v1/countries",
        "per_page": 20,
        "to": 6,
        "total": 6
    }
}</code></pre>
    </div>

    <h2 id="caching">Caching Recommendations</h2>
    <p>
        The countries data doesn't change frequently, so we recommend caching the response:
    </p>

    <ul>
        <li>Cache for 24 hours in production</li>
        <li>Store in Redis, Memcached, or file cache</li>
        <li>Refresh cache daily via cron job</li>
    </ul>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP Caching Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">use Illuminate\Support\Facades\Cache;

// Get countries with caching
$countries = Cache::remember('axora_countries', 86400, function () use ($client) {
    $response = $client->get('/countries');
    return json_decode($response->getBody(), true);
});

// Use cached data
foreach ($countries as $country) {
    echo $country['name'] . "\n";
}</code></pre>
    </div>

    <div class="info-box success">
        <div class="info-box-title">
            <i class="bi bi-check-circle"></i>
            Best Practices
        </div>
        <ul>
            <li>Cache country data to reduce API calls</li>
        </ul>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{url('/api/gift-cards/create')}}">Get gift cards</a> - gift cards</li>
            <li><a href="{{url('/docs/introduction')}}">Introduction</a> - Getting started guide</li>
        </ul>
    </div>
@endsection