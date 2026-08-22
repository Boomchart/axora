@extends('developer.reference.menu')

@section('content')
    <h1>{{$title}}</h1>
    <p class="lead-text">{{__('Retrieves all gift cards for a specific country')}}</p>

    <div class="endpoint-box">
        <span class="endpoint-method get">GET</span>
        <span class="endpoint-url">{{url('/')}}/api/v1/cards_by_country/{iso2}</span>
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
            <td>The country ISO2</td>
        </tr>

        </tbody>
    </table>

    <h2 id="request-parameters">Query Parameters</h2>

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
            <td><span class="param-name">page</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Sets the page number; use "all" to retrieve all items. The default is 1</td>
        </tr>
        <tr>
            <td><span class="param-name">limit</span></td>
            <td><span class="param-type">string</span></td>
            <td>optional</td>
            <td>Specifies the default number of items per page, with a default setting of 20</td>
        </tr>
        </tbody>
    </table>

    <h2 id="example-request">Example Request</h2>

    <h3 id="list-all-countries">Get all Cards for a specific country</h3>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">cURL</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-bash">curl {{url('/')}}/api/v1/cards_by_country/{iso2} \
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

$response = $client->get('cards_by_country/{iso2}');
$cards = json_decode($response->getBody(), true);</code></pre>
    </div>

    <div class="code-block-wrapper">
        <div class="code-block-header">
            <span class="code-block-title">JavaScript</span>
            <button class="code-copy-button">Copy</button>
        </div>
        <pre><code class="language-javascript">const response = await fetch('{{url('/api/v1/cards_by_country/{iso2}')}}', {
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
        <pre><code class="language-json">{
    "message": "Cards",
    "status": "success",
    "data": [
        {
            "id": "f9677544-04d7-47ea-8c52-f5f00fb41cc3",
            "name": "Airbnb",
            "country": "US",
            "currency": "USD",
            "min": 25,
            "max": 100,
            "denomination_type": "RANGE",
            "denominations": [],
            "exchange_rate": 1,
            "card_art": "https://res.cloudinary.com/dariaqwmj/image/upload/v1778174678/qdnjupubrc5qc3vskptb.png",
            "description": "Airbnb US",
            "redemption_instructions": "To redeem, visit https://www.airbnb.com/gift",
            "terms": null,
            "status": "Active",
            "categories": [
                "Gaming"
            ],
            "discount": 0,
            "issuing_fee": {
                "type": "single",
                "charge_phase": "after_conversion",
                "fee": {
                    "currency": "USD",
                    "flat": 1,
                    "percent": 1,
                    "description": "Charged after card currency is converted to USD"
                }
            }
        },
        {
            "id": "cf562d2a-826c-42f1-a19f-3de7fe6911c0",
            "name": "App Store & iTunes US",
            "country": "US",
            "currency": "USD",
            "min": 2,
            "max": 100,
            "denomination_type": "RANGE",
            "denominations": [],
            "exchange_rate": 1,
            "card_art": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777147415/ynbzlhnaxuc5tdhu1p48.webp",
            "description": "App Store & iTunes US",
            "redemption_instructions": "How to Use Your Apple Gift Card\n\nWhere You Can Use It\n\nThe Apple Gift Card can be used for purchases at:\n • Apple Stores (in-person or online at apple.com).\n • Apple Store app.\n • Apple services, including the App Store, iTunes, Apple Music, Apple TV, Apple News, Apple Books, Apple Arcade, iCloud, and other Apple properties.\n • Apple products like iPhone, iPad, AirPods, MacBook, accessories, and more.\n\nHow to Redeem Your Gift Card\n\n 1. Online Purchases:\n • Go to apple.com/redeem and add the gift card to your Apple Account balance.\n 2. In-Store Purchases:\n • Bring this email with the gift card details to any Apple Store location.\n\nImportant Information\n\n • No Returns or Refunds: Apple Gift Cards are non-refundable and cannot be exchanged.\n • Scam Warning: Never share your gift card code.\n • Restrictions:\n • Valid only for U.S. transactions on Apple properties.\n • Not redeemable at Apple resellers or for cash, except as required by law.\n • Cannot be resold, refunded, or exchanged.\n • Apple is not responsible for unauthorized use of the card.\n\nTerms and Support\n\n • Full terms and conditions apply.\n • For assistance, visit support.apple.com/giftcard or call 1-800-275-2273.\n\nEnjoy your Apple products and services!",
            "terms": null,
            "status": "Active",
            "categories": [
                "Lifestyle"
            ],
            "discount": 1,
            "issuing_fee": {
                "type": "single",
                "charge_phase": "after_conversion",
                "fee": {
                    "currency": "USD",
                    "flat": 1,
                    "percent": 0,
                    "description": "Charged after card currency is converted to USD"
                }
            }
        },
        {
            "id": "84b70dc9-47fb-45a9-89b9-87399febbc1d",
            "name": "PlayStation US",
            "country": "US",
            "currency": "USD",
            "min": 10,
            "max": 100,
            "denomination_type": "FIXED",
            "denominations": [
                {
                    "amount": 10
                },
                {
                    "amount": 25
                },
                {
                    "amount": 50
                },
                {
                    "amount": 75
                },
                {
                    "amount": 100
                }
            ],
            "exchange_rate": 1,
            "card_art": "https://res.cloudinary.com/dariaqwmj/image/upload/v1777132615/jj0t8nxewbfmdfsbz5ue.jpg",
            "description": "PlayStation US",
            "redemption_instructions": "This card may be redeemed through PlayStation Store on a PS4, PS3, and PS Vita system, or a personal computer. . Open a Sony Entertainment Network account or use an existing account. . From your PS4, PS3, or PS Vita system, or a personal computer, access PlayStation Store. . Click the Redeem Codes icon. . Enter the code at the bottom of this card. Please note that the code is case sensitive and must be entered exactly as displayed. . For additional redemption instructions, please visit https://www.playstation.com/en-us/explore/playstationnetwork/redemption Your use of this PlayStation Plus code constitutes your acceptance of these terms and any additional terms available at http://us.playstation.com/redemption. PSN SM and PlayStation Plus offerings may change without notice.",
            "terms": null,
            "status": "Active",
            "categories": [
                "Gaming",
                "Lifestyle"
            ],
            "discount": 1.5,
            "issuing_fee": {
                "type": "single",
                "charge_phase": "after_conversion",
                "fee": {
                    "currency": "USD",
                    "flat": 1,
                    "percent": 1,
                    "description": "Charged after card currency is converted to USD"
                }
            }
        }
    ]
}</code></pre>
    </div>
@endsection