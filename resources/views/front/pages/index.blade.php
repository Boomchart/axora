@extends('front.menu', ['title' => $set->site_desc])

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">{{__('Deliver Global Rewards, Airtime & Crypto Instantly')}}</h1>
                    <p class="hero-subtitle">{{__('Our unified ')}} {{config('app.name')}} {{__('API connects you to 3,000+ global brands, worldwide mobile operators, and Web3 infrastructure. Effortlessly integrated, instantly impactful — just plug and go.')}}</p>
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{route('register')}}" class="btn btn-primary">{{__('Start for free')}}</a>
                        <a href="{{route('developer.index')}}" target="_blank" class="btn btn-outline-primary">{{__('Documentation')}} <i class="fa-solid fa-long-arrow-alt-right"></i></a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="hero-stat-number">20K+</span>
                            <span class="hero-stat-label">{{__('Customers')}}</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number">3000+</span>
                            <span class="hero-stat-label">{{__('Brands & Telcos')}}</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number">200+</span>
                            <span class="hero-stat-label">{{__('Businesses')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-md-block">
                    <img src="{{asset('front/img/dash.webp')}}" alt="API Dashboard" class="img-fluid rounded-5 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section class="code-section">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <h2 class="section-title text-start">{{__('Getting Started with ')}} {{config('app.name')}} {{__(' Unified API')}}</h2>
                    <p class="content-text">{{__('Integrate our API in minutes with your preferred programming language. Our developer-friendly endpoints make it easy to start sending gift cards, topping up airtime, or generating crypto wallets.')}}</p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill"></i><span>{{__('RESTful API with JSON responses')}}</span></li>
                        <li><i class="bi bi-check-circle-fill"></i><span>{{__('Comprehensive documentation & SDKs')}}</span></li>
                        <li><i class="bi bi-check-circle-fill"></i><span>{{__('Sandbox environment for safe testing')}}</span></li>
                    </ul>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{route('developer.index')}}" target="_blank" class="btn btn-primary">{{__('View Full Documentation')}} <i class="fa-solid fa-long-arrow-alt-right"></i></a>
                        <a href="{{route('register')}}" class="btn btn-outline-primary">{{__('Get API Key')}}</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="code-snippet-container">
                        <div class="code-tabs">
                            <button class="code-tab active" data-lang="curl">cURL</button>
                            <button class="code-tab" data-lang="javascript">Node.js</button>
                            <button class="code-tab" data-lang="php">PHP</button>
                            <button class="code-tab" data-lang="python">Python</button>
                            <button class="code-tab" data-lang="ruby">Ruby</button>
                        </div>
                        <div class="code-content">
                            <div class="code-block active" data-lang="curl">
<pre><code class="language-bash">curl --request POST \
    --url {{route('home')}}/v1/transaction \
    --header 'Authorization: Bearer YOUR_API_KEY' \
    --header 'Content-Type: application/json' \
    --data '{
        "service_type": "airtime",
        "product_id": "mtn-ng-airtime",
        "amount": 25.50,
        "recipient": "+2348030000000",
        "email": "user@example.com"
    }'
</code></pre>
                            </div>
                            <div class="code-block" data-lang="javascript">
<pre><code class="language-javascript">const axios = require('axios');

const response = await axios.post(
'{{route('home')}}/v1/transaction',
    {
        "service_type": "gift_card",
        "product_id": "amazon-us-10",
        "quantity": 1,
        "amount": 10.00,
        "email": "user@example.com"
    },
    {
        headers: {
        'Authorization': 'Bearer YOUR_API_KEY',
        'Content-Type': 'application/json'
        }
    }
);

</code></pre>
                            </div>
                            <div class="code-block" data-lang="php">
<pre><code class="language-php">&lt;?php
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "{{route('home')}}/v1/wallet/generate",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer YOUR_API_KEY",
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode([
            'network' => 'TRC20',
            'currency' => 'USDT',
            'user_reference' => 'user_98765'
        ])
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    echo $response;
    ?&gt;
</code></pre>
                            </div>
                            <div class="code-block" data-lang="python">
<pre><code class="language-python">
    import requests
    url = "{{route('home')}}/v1/transaction"

    headers = {
        "Authorization": "Bearer YOUR_API_KEY",
        "Content-Type": "application/json"
    }

    payload = {
        "service_type": "data_bundle",
        "product_id": "vodafone-uk-10gb",
        "recipient": "+447700900000",
        "email": "user@example.com"
    }

    response = requests.post(url, json=payload, headers=headers)
    print(response.json())
</code></pre>
                            </div>
                            <div class="code-block" data-lang="ruby">
                            <pre><code class="language-ruby">
    require 'net/http'
    require 'json'

    uri = URI('{{route('home')}}/v1/transaction')
    http = Net::HTTP.new(uri.host, uri.port)
    http.use_ssl = true

    request = Net::HTTP::Post.new(uri.path)
    request['Authorization'] = 'Bearer YOUR_API_KEY'
    request['Content-Type'] = 'application/json'

    request.body = {
        service_type: 'airtime',
        product_id: 'att-us-topup',
        amount: 50.00,
        recipient: '+12025550125'
    }.to_json

    response = http.request(request)
    puts response.body
                            </code></pre>
                            </div>
                        </div>
                        <button class="code-copy-btn" title="Copy to clipboard">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="platform" class="features-section">
        <div class="container">
            <h2 class="section-title">{{__('A Unified Digital Infrastructure')}}</h2>
            <p class="section-subtitle">{{__('Simplify the complexities of global payouts, mobile top-ups, and Web3 wallets through a single connection.')}}</p>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-phone-fill"></i></div>
                        <h3 class="feature-title">{{__('Airtime & Data')}}</h3>
                        <p class="feature-description">{{__('Instantly top up mobile airtime and data bundles for hundreds of telcos globally.')}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-gift-fill"></i></div>
                        <h3 class="feature-title">{{__('Gift Cards')}}</h3>
                        <p class="feature-description">{{__('Deliver digital gift cards from 3,000+ top retailers across 40 countries and 25 currencies.')}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-wallet2"></i></div>
                        <h3 class="feature-title">{{__('Crypto Wallets')}}</h3>
                        <p class="feature-description">{{__('Generate secure, non-custodial crypto wallets to onboard your users into Web3.')}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                        <h3 class="feature-title">{{__('Secure & Scalable')}}</h3>
                        <p class="feature-description">{{__('99.999% uptime with multi-layered security and fraud prevention to protect your transactions.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="how-it-works-section">
        <div class="container">
            <h2 class="section-title">{{__('How Our Unified API Works')}}</h2>
            <p class="section-subtitle">{{__('Get up and running in three simple steps')}}</p>
            <div class="row g-4 g-md-5">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h3 class="step-title">{{__('Get Sandbox Credentials')}}</h3>
                        <p class="step-description">{{__('Our sandbox is free, fully-featured, and ready for you to test everything from airtime to crypto.')}}</p>
                        <div class="step-connector"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h3 class="step-title">{{__('Develop Your Integration')}}</h3>
                        <p class="step-description">{{__('Follow our comprehensive API documentation. Our developer support team is on standby if you need help.')}}</p>
                        <div class="step-connector"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h3 class="step-title">{{__('Go Live')}}</h3>
                        <p class="step-description">{{__('Obtain a production API key and process your first multi-asset transaction in minutes.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="brand-catalog-section">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <h2 class="section-title text-start">{{__('Endless options: Gift Cards, Airtime & Crypto')}}</h2>
                    <p class="content-text mb-4">
                        {{__("Give your users the power of choice. Access the world's leading retail brands, global mobile network operators for instant top-ups, and seamless crypto infrastructure—all from one centralized platform.")}}
                    </p>
                    <p class="content-text mb-4">
                        {{__('Whether you are rewarding employees, building a cross-border remittance app, or creating a loyalty program, we have the digital assets you need.')}}
                    </p>
                    <a href="{{route('contact')}}" class="btn btn-primary btn-lg">{{__('Contact Sales')}}</a>
                </div>
                <div class="col-lg-6">
                    <div class="gift-cards-stack">
                        <div class="gift-card-item card-1">
                            <div class="gift-card-brand spotify"><i class="bi bi-spotify"></i><span>Spotify</span></div>
                        </div>
                        <div class="gift-card-item card-2">
                            <div class="gift-card-brand xbox" style="background: #FF9900; color: #fff;"><span>MTN</span><small>AIRTIME & DATA</small></div>
                        </div>
                        <div class="gift-card-item card-3">
                            <div class="gift-card-brand roblox" style="background: #2775CA; color: #fff;"><i class="bi bi-currency-bitcoin"></i><span>Crypto</span><small>USDT / BTC</small></div>
                        </div>
                        <div class="gift-card-item card-4">
                            <div class="gift-card-brand nintendo" style="background: #E60000; color: #fff;"><span>Airtel</span><small>TOP UP</small></div>
                        </div>
                        <div class="gift-card-item card-5">
                            <div class="gift-card-brand ikea"><span>IKEA</span></div>
                        </div>
                        <div class="gift-card-item card-6">
                            <div class="gift-card-brand apple"><i class="bi bi-apple"></i><span>App Store & iTunes</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="solutions" class="use-cases-section">
        <div class="container">
            <h2 class="section-title">{{__('Where Could a Unified API Take You?')}}</h2>
            <p class="section-subtitle">{{__('Discover the endless possibilities for fintechs, reward platforms, and global businesses')}}</p>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="use-case-card">
                        <div class="use-case-icon"><i class="bi bi-globe"></i></div>
                        <h3 class="use-case-title">{{__('Cross-Border Remittance')}}</h3>
                        <p class="use-case-description">{{__('Enable users to send value home instantly via mobile airtime, data bundles, or crypto transfers.')}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="use-case-card">
                        <div class="use-case-icon"><i class="bi bi-trophy-fill"></i></div>
                        <h3 class="use-case-title">{{__('Loyalty & Rewards')}}</h3>
                        <p class="use-case-description">{{__('Turn user earnings or points into thousands of digital gift cards or mobile top-ups instantly.')}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="use-case-card">
                        <div class="use-case-icon"><i class="bi bi-wallet-fill"></i></div>
                        <h3 class="use-case-title">{{__('Web3 Onboarding')}}</h3>
                        <p class="use-case-description">{{__('Seamlessly generate wallets and allow users to off-ramp crypto into everyday purchases.')}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="use-case-card">
                        <div class="use-case-icon"><i class="bi bi-people-fill"></i></div>
                        <h3 class="use-case-title">{{__('Employee Incentives')}}</h3>
                        <p class="use-case-description">{{__('Enhance productivity and retain top talent with meaningful, globally accessible rewards.')}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="use-case-card">
                        <div class="use-case-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <h3 class="use-case-title">{{__('Affiliate Payouts')}}</h3>
                        <p class="use-case-description">{{__('Streamline your affiliate and creator payouts using flexible digital assets and crypto.')}}</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="use-case-card">
                        <div class="use-case-icon"><i class="bi bi-star-fill"></i></div>
                        <h3 class="use-case-title">{{__('Customer Acquisition')}}</h3>
                        <p class="use-case-description">{{__('Influence every touchpoint in the customer journey with instant airtime or gift card incentives.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
