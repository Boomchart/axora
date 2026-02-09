@extends('developer.reference.menu')

@section('content')
    <h1>Countries</h1>
    <p class="lead-text">
        Retrieve a list of all countries supported by Axora Cards, along with available gift card brands, currencies, and denominations for each country.
    </p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">/v1/countries</span>
    </div>

    <h2 id="overview">Overview</h2>
    <p>
        The Countries endpoint returns comprehensive information about gift card availability across different countries. Use this endpoint to:
    </p>

    <ul>
        <li>Display available countries to your users</li>
        <li>Show which brands are available in each country</li>
        <li>Get supported currencies and denominations</li>
        <li>Build dynamic country/brand selectors in your application</li>
    </ul>

    <h2 id="request-parameters">Request Parameters</h2>

    <table class="params-table">
        <thead>
        <tr>
            <th>Parameter</th>
            <th>Type</th>
            <th>Required</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><span class="param-name">country_code</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Two-letter ISO country code to filter results (e.g., "US", "GB")</td>
        </tr>
        <tr>
            <td><span class="param-name">currency</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Three-letter ISO currency code to filter by currency (e.g., "USD")</td>
        </tr>
        <tr>
            <td><span class="param-name">brand_id</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Filter countries where this brand is available</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">List All Countries</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl https://api.axoracards.com/v1/countries \
  -H "Authorization: Bearer sk_live_your_api_key"</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => 'https://api.axoracards.com/v1',
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
        <pre><code class="language-javascript">const response = await fetch('https://api.axoracards.com/v1/countries', {
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key'
  }
});

const countries = await response.json();</code></pre>
    </div>

    <h3 id="filter-by-country">Filter by Country</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Get United States Data</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl https://api.axoracards.com/v1/countries?country_code=US \
  -H "Authorization: Bearer sk_live_your_api_key"</code></pre>
    </div>

    <h3 id="filter-by-brand">Filter by Brand</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Countries with Amazon Gift Cards</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl https://api.axoracards.com/v1/countries?brand_id=amazon \
  -H "Authorization: Bearer sk_live_your_api_key"</code></pre>
    </div>

    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "object": "list",
  "data": [
    {
      "code": "US",
      "name": "United States",
      "flag": "🇺🇸",
      "currencies": ["USD"],
      "brands_count": 450,
      "brands": [
        {
          "id": "amazon",
          "name": "Amazon",
          "logo_url": "https://cdn.axoracards.com/brands/amazon.png",
          "category": "Retail",
          "denominations": {
            "type": "range",
            "min": 5,
            "max": 500,
            "currency": "USD"
          },
          "redemption": {
            "type": "online",
            "url": "https://www.amazon.com/gc/redeem"
          }
        },
        {
          "id": "spotify",
          "name": "Spotify",
          "logo_url": "https://cdn.axoracards.com/brands/spotify.png",
          "category": "Entertainment",
          "denominations": {
            "type": "fixed",
            "values": [10, 30, 60],
            "currency": "USD"
          },
          "redemption": {
            "type": "online",
            "url": "https://www.spotify.com/redeem"
          }
        }
      ]
    },
    {
      "code": "GB",
      "name": "United Kingdom",
      "flag": "🇬🇧",
      "currencies": ["GBP"],
      "brands_count": 380,
      "brands": [
        {
          "id": "amazon-uk",
          "name": "Amazon UK",
          "logo_url": "https://cdn.axoracards.com/brands/amazon-uk.png",
          "category": "Retail",
          "denominations": {
            "type": "range",
            "min": 5,
            "max": 500,
            "currency": "GBP"
          },
          "redemption": {
            "type": "online",
            "url": "https://www.amazon.co.uk/gc/redeem"
          }
        }
      ]
    }
  ],
  "has_more": false,
  "total_count": 52
}</code></pre>
    </div>

    <h2 id="response-attributes">Response Attributes</h2>

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
            <td><span class="param-name">object</span></td>
            <td><span class="param-type">string</span></td>
            <td>Always "list"</td>
        </tr>
        <tr>
            <td><span class="param-name">data</span></td>
            <td><span class="param-type">array</span></td>
            <td>Array of country objects</td>
        </tr>
        <tr>
            <td><span class="param-name">data[].code</span></td>
            <td><span class="param-type">string</span></td>
            <td>Two-letter ISO country code</td>
        </tr>
        <tr>
            <td><span class="param-name">data[].name</span></td>
            <td><span class="param-type">string</span></td>
            <td>Country name</td>
        </tr>
        <tr>
            <td><span class="param-name">data[].flag</span></td>
            <td><span class="param-type">string</span></td>
            <td>Country flag emoji</td>
        </tr>
        <tr>
            <td><span class="param-name">data[].currencies</span></td>
            <td><span class="param-type">array</span></td>
            <td>List of supported currencies in this country</td>
        </tr>
        <tr>
            <td><span class="param-name">data[].brands_count</span></td>
            <td><span class="param-type">integer</span></td>
            <td>Number of available brands in this country</td>
        </tr>
        <tr>
            <td><span class="param-name">data[].brands</span></td>
            <td><span class="param-type">array</span></td>
            <td>Array of available gift card brands</td>
        </tr>
        <tr>
            <td><span class="param-name">has_more</span></td>
            <td><span class="param-type">boolean</span></td>
            <td>Whether there are more results available</td>
        </tr>
        <tr>
            <td><span class="param-name">total_count</span></td>
            <td><span class="param-type">integer</span></td>
            <td>Total number of countries</td>
        </tr>
        </tbody>
    </table>

    <h2 id="brand-object">Brand Object</h2>

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
            <td>Unique brand identifier</td>
        </tr>
        <tr>
            <td><span class="param-name">name</span></td>
            <td><span class="param-type">string</span></td>
            <td>Brand name</td>
        </tr>
        <tr>
            <td><span class="param-name">logo_url</span></td>
            <td><span class="param-type">string</span></td>
            <td>URL to brand logo image</td>
        </tr>
        <tr>
            <td><span class="param-name">category</span></td>
            <td><span class="param-type">string</span></td>
            <td>Brand category (e.g., "Retail", "Entertainment", "Dining")</td>
        </tr>
        <tr>
            <td><span class="param-name">denominations</span></td>
            <td><span class="param-type">object</span></td>
            <td>Available denominations for this brand</td>
        </tr>
        <tr>
            <td><span class="param-name">redemption</span></td>
            <td><span class="param-type">object</span></td>
            <td>Redemption information</td>
        </tr>
        </tbody>
    </table>

    <h2 id="denomination-types">Denomination Types</h2>

    <h3 id="range-denominations">Range Denominations</h3>
    <p>
        Brands with range denominations accept any amount within the specified range:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Range Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "denominations": {
    "type": "range",
    "min": 5,
    "max": 500,
    "currency": "USD"
  }
}</code></pre>
    </div>

    <h3 id="fixed-denominations">Fixed Denominations</h3>
    <p>
        Brands with fixed denominations only accept specific preset amounts:
    </p>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Fixed Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">{
  "denominations": {
    "type": "fixed",
    "values": [10, 25, 50, 100],
    "currency": "USD"
  }
}</code></pre>
    </div>

    <h2 id="brand-categories">Brand Categories</h2>
    <p>
        Brands are organized into the following categories:
    </p>

    <ul>
        <li><strong>Retail:</strong> Amazon, Walmart, Target, etc.</li>
        <li><strong>Entertainment:</strong> Netflix, Spotify, Xbox, PlayStation, etc.</li>
        <li><strong>Dining:</strong> Uber Eats, DoorDash, Starbucks, etc.</li>
        <li><strong>Travel:</strong> Airbnb, Hotels.com, etc.</li>
        <li><strong>Fashion:</strong> Nike, Adidas, H&M, etc.</li>
        <li><strong>Beauty:</strong> Sephora, Ulta, etc.</li>
        <li><strong>Home:</strong> IKEA, Home Depot, etc.</li>
        <li><strong>Gaming:</strong> Steam, Roblox, Nintendo, etc.</li>
    </ul>

    <h2 id="example-use-cases">Example Use Cases</h2>

    <h3 id="build-country-selector">Build a Country Selector</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">// Fetch all countries
$response = $client->get('/countries');
$data = json_decode($response->getBody(), true);

// Display in dropdown
echo '<select name="country">';
foreach ($data['data'] as $country) {
    echo sprintf(
        '<option value="%s">%s %s</option>',
        $country['code'],
        $country['flag'],
        $country['name']
    );
}
echo '</select>';</code></pre>
    </div>

    <h3 id="filter-brands-by-category">Filter Brands by Category</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">// Fetch US brands
const response = await fetch('https://api.axoracards.com/v1/countries?country_code=US', {
  headers: { 'Authorization': 'Bearer sk_live_your_api_key' }
});

const data = await response.json();
const country = data.data[0];

// Group brands by category
const brandsByCategory = country.brands.reduce((acc, brand) => {
  if (!acc[brand.category]) {
    acc[brand.category] = [];
  }
  acc[brand.category].push(brand);
  return acc;
}, {});

// Display by category
Object.keys(brandsByCategory).forEach(category => {
  console.log(`${category}:`);
  brandsByCategory[category].forEach(brand => {
    console.log(`  - ${brand.name}`);
  });
});</code></pre>
    </div>

    <h3 id="check-brand-availability">Check Brand Availability</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">Python Example</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-python">import requests

# Check if Spotify is available in Canada
response = requests.get(
    'https://api.axoracards.com/v1/countries',
    params={'country_code': 'CA', 'brand_id': 'spotify'},
    headers={'Authorization': 'Bearer sk_live_your_api_key'}
)

data = response.json()

if data['total_count'] > 0:
    country = data['data'][0]
    brand = next((b for b in country['brands'] if b['id'] == 'spotify'), None)
    if brand:
        print(f"Spotify is available in {country['name']}")
        print(f"Denominations: {brand['denominations']}")
else:
    print("Spotify is not available in Canada")</code></pre>
    </div>

    <h2 id="supported-countries">Supported Countries</h2>
    <p>
        Axora Cards currently supports gift cards in 52+ countries across 6 continents:
    </p>

    <ul>
        <li><strong>North America:</strong> United States, Canada, Mexico</li>
        <li><strong>Europe:</strong> United Kingdom, Germany, France, Spain, Italy, Netherlands, and 20+ more</li>
        <li><strong>Asia Pacific:</strong> Australia, Japan, Singapore, India, South Korea, and more</li>
        <li><strong>Latin America:</strong> Brazil, Argentina, Chile, Colombia, Peru</li>
        <li><strong>Middle East:</strong> UAE, Saudi Arabia, Kuwait, Qatar</li>
        <li><strong>Africa:</strong> South Africa, Nigeria, Kenya, Egypt</li>
    </ul>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Country Expansion
        </div>
        <p>
            We're constantly adding new countries and brands. Subscribe to our <a href="">Product Updates</a> to get notified when new countries become available.
        </p>
    </div>

    <h2 id="caching">Caching Recommendations</h2>
    <p>
        The countries data doesn't change frequently, so we recommend caching the response:
    </p>

    <ul>
        <li>Cache for 24 hours in production</li>
        <li>Store in Redis, Memcached, or file cache</li>
        <li>Refresh cache daily via cron job</li>
        <li>Include ETag headers for conditional requests</li>
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
foreach ($countries['data'] as $country) {
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
            <li>Filter by country_code for better performance</li>
            <li>Use brand categories for organized display</li>
            <li>Check denomination types before accepting user input</li>
            <li>Store brand logos locally for faster page loads</li>
            <li>Handle missing brands gracefully</li>
        </ul>
    </div>

    <div class="info-box note">
        <div class="info-box-title">
            <i class="bi bi-info-circle"></i>
            Related Endpoints
        </div>
        <ul>
            <li><a href="{{url('/api/gift-cards/create')}}">Create Gift Card</a> - Purchase gift cards</li>
            <li><a href="{{url('/api/gift-cards/send')}}">Send Gift Card</a> - Send to recipients</li>
            <li><a href="{{url('/docs/introduction')}}">Introduction</a> - Getting started guide</li>
        </ul>
    </div>
@endsection