@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Get data network operators by country')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/data_by_country/{iso2}</span>
    </div>

    <h2 id="request-parameters">Path Parameters</h2>

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
            <td><span class="param-name">iso2</span></td>
            <td><span class="param-type">string</span></td>
            <td>required</td>
            <td>The ISO2 of the country</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get data operators by country</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/data_by_country/ng \
  -H "Authorization: Bearer sk_live_your_api_key"</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">PHP</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-php">$client = new GuzzleHttp\Client([
    'base_uri' => '{{url('/')}}/api/v1/',
    'headers' => [
        'Authorization' => 'Bearer sk_live_your_api_key'
    ],
]);

$response = $client->get('data_by_country/ng');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/data_by_country/ng')}}', {
  headers: {
    'Authorization': 'Bearer sk_live_your_api_key'
  }
});

const cards = await response.json();</code></pre>
    </div>

    <h2 id="response">Response</h2>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">200 OK</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-json">[
    {
        "id": "c2625008-d46c-4a64-991f-d8d176ab59e1",
        "name": "Airtel Nigeria Data",
        "country": "NG",
        "currency": "NGN",
        "min": 50,
        "max": 100000,
        "denomination_type": "FIXED",
        "denominations": [
            {
                "amount": 50,
                "plan": "250MB - 1Day"
            },
            {
                "amount": 100,
                "plan": "This Data plan gives 100MB for N100 valid for 1day"
            },
            {
                "amount": 200,
                "plan": "This Data 200MB for valid for 2 days"
            },
            {
                "amount": 300,
                "plan": "This Data plan gives 300MB for 2 days "
            },
            {
                "amount": 500,
                "plan": "This Data plan gives 1.5GB for 1 Day"
            },
            {
                "amount": 600,
                "plan": "This Data plan gives  2GB for 2 days"
            },
            {
                "amount": 800,
                "plan": "This Data plan gives 1GB - 7days  "
            },
            {
                "amount": 1000,
                "plan": "1.5GB\t2GB Youtube Night + 200MB (YT, IG & Tiktok)  - 7days"
            },
            {
                "amount": 1500,
                "plan": "3.5GB\t5GB Youtube Night + 200MB (YT, IG & Tiktok)  - 7days"
            },
            {
                "amount": 2000,
                "plan": "3GB - 2GB Youtube Night + 200MB (YT, IG & Tiktok) -30days"
            },
            {
                "amount": 2500,
                "plan": "4GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) \t30days"
            },
            {
                "amount": 3000,
                "plan": "8GB -2GB Youtube Night + 200MB (YT, IG & Tiktok) - 30days "
            },
            {
                "amount": 4000,
                "plan": "10GB -2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days "
            },
            {
                "amount": 5000,
                "plan": "13GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 6000,
                "plan": "18GB - 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 8000,
                "plan": "25GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 10000,
                "plan": "35GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30day"
            },
            {
                "amount": 15000,
                "plan": "60GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 20000,
                "plan": "100GB- 2GB Youtube Night + 200MB (YT, IG & Tiktok) 30days"
            },
            {
                "amount": 30000,
                "plan": "This Data plan gives 160GB 30days"
            },
            {
                "amount": 40000,
                "plan": "This Data plan gives  210GB for N30,000 valid for 30days"
            },
            {
                "amount": 50000,
                "plan": "This Data plan gives  300GB for 90days"
            },
            {
                "amount": 60000,
                "plan": "This Data plan gives  350GB for N60,000 valid for 120days"
            },
            {
                "amount": 100000,
                "plan": "This Data plan gives  650GB for N100,000 valid for 365days"
            }
        ],
        "exchange_rate": 0.00082918739635158,
        "logo": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777623590/ayelthr7zqsknyjq1fnb.png",
        "status": "Active",
        "discount": 2,
        "issuing_fee": {
            "type": "single",
            "charge_phase": "after_conversion",
            "fee": {
                "currency": "USD",
                "flat": 0,
                "percent": 0,
                "description": "Charged after card currency is converted to USD"
            }
        }
    },
    {
        "id": "d19ae8c3-7511-49a0-a42c-da5998d732a8",
        "name": "MTN Nigeria Data",
        "country": "NG",
        "currency": "NGN",
        "min": 100,
        "max": 90000,
        "denomination_type": "FIXED",
        "denominations": [
            {
                "amount": 100,
                "plan": "110MB Daily Plan"
            },
            {
                "amount": 200,
                "plan": "230MB Daily Plan"
            },
            {
                "amount": 350,
                "plan": "500MB Daily Plan"
            },
            {
                "amount": 500,
                "plan": "1GB Daily Plan + 1.5mins."
            },
            {
                "amount": 600,
                "plan": "1.5GB 2-Day Plan"
            },
            {
                "amount": 750,
                "plan": "2.5GB Daily Plan"
            },
            {
                "amount": 800,
                "plan": "1GB Weekly Plan"
            },
            {
                "amount": 900,
                "plan": "2.5GB 2-Day Plan"
            },
            {
                "amount": 1000,
                "plan": "3.2gb 2-day plan"
            },
            {
                "amount": 1200,
                "plan": "4GB 2Days Plan"
            },
            {
                "amount": 1500,
                "plan": "5.5GB 2Days Plan"
            },
            {
                "amount": 1800,
                "plan": "7GB 2-Days Plan"
            },
            {
                "amount": 2000,
                "plan": "2.7GB+2mins Monthly Plan"
            },
            {
                "amount": 2500,
                "plan": "6GB Weekly Plan"
            },
            {
                "amount": 3500,
                "plan": "11GB Weekly Bundle"
            },
            {
                "amount": 4500,
                "plan": "10GB+10mins Monthly Plan"
            },
            {
                "amount": 5000,
                "plan": "20GB Weekly Plan"
            },
            {
                "amount": 6500,
                "plan": "16.5GB+10mins Monthly Plan"
            },
            {
                "amount": 7500,
                "plan": "20GB Monthly Plan"
            },
            {
                "amount": 9000,
                "plan": "25GB Monthly Plan"
            },
            {
                "amount": 11000,
                "plan": "36GB Monthly Plan"
            },
            {
                "amount": 16000,
                "plan": "65GB Monthly Plan"
            },
            {
                "amount": 18000,
                "plan": "75GB Monthly Plan"
            },
            {
                "amount": 35000,
                "plan": "165GB Monthly Plan"
            },
            {
                "amount": 40000,
                "plan": "150GB 2-Month Plan"
            },
            {
                "amount": 90000,
                "plan": "480GB 3-Month Plan"
            }
        ],
        "exchange_rate": 0.00080385852090032,
        "logo": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777623617/pth7xib3kq5i01rk2u7n.jpg",
        "status": "Active",
        "discount": 1.5,
        "issuing_fee": {
            "type": "single",
            "charge_phase": "after_conversion",
            "fee": {
                "currency": "USD",
                "flat": 0,
                "percent": 0,
                "description": "Charged after card currency is converted to USD"
            }
        }
    }
]</code></pre>
    </div>
@endsection