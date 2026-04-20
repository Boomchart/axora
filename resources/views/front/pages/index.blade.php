@extends('front.menu', ['title' => $set->site_desc])

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">{{__('Deliver Rewards & Incentives Instantly')}}</h1>
                <p class="hero-subtitle">{{__('Our award-winning ')}} {{config('app.name')}} {{__('gift card API connects you to 3,000+ global brands. Effortlessly integrated, instantly impactful — just plug and go.')}}</p>
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
                        <span class="hero-stat-label">{{__('Global Brands')}}</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">200+</span>
                        <span class="hero-stat-label">{{__('Businesses')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{asset('front/img/dash.png')}}" alt="API Dashboard" class="img-fluid rounded-5 shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Logo Carousel -->
{{--<section class="logo-carousel">
        <div class="container">
            <p class="logo-carousel-title">{{__('Trusted by businesses and platforms worldwide')}}</p>
</div>
<div class="logo-track">
    <div class="logo-item">
        <img src="{{asset('front/img/brands/paypal.svg')}}" alt="PayPal">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/visa.svg')}}" alt="Visa">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/square.svg')}}" alt="Square">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/mit.jpeg')}}" alt="MIT">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/revolut.svg')}}" alt="Revolut">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/prudential.svg')}}" alt="Prudential">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/paypal.svg')}}" alt="PayPal">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/visa.svg')}}" alt="Visa">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/square.svg')}}" alt="Square">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/mit.jpeg')}}" alt="MIT">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/revolut.svg')}}" alt="Revolut">
    </div>
    <div class="logo-item">
        <img src="{{asset('front/img/brands/prudential.svg')}}" alt="Prudential">
    </div>
</div>
</section>--}}
<!-- Getting Started with Code Section -->
<section class="code-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="section-title text-start">{{__('Getting Started with ')}} {{config('app.name')}} {{__(' Gift Card API')}}</h2>
                <p class="content-text">{{__('Integrate our API in minutes with your preferred programming language. Our simple, developer-friendly endpoints make it easy to start sending gift cards.')}}</p>
                <ul class="feature-list">
                    <li><i class="bi bi-check-circle-fill"></i><span>{{__('RESTful API with JSON responses')}}</span></li>
                    <li><i class="bi bi-check-circle-fill"></i><span>{{__('Comprehensive documentation')}}</span></li>
                    <li><i class="bi bi-check-circle-fill"></i><span>{{__('Sandbox environment for testing')}}</span></li>
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
    --url {{route('home')}}/v1/order \
    --header 'Authorization: Bearer YOUR_API_KEY' \
    --header 'Content-Type: application/json' \
    --data '{
        "card_id": "1430b926-3faf-49dc-b0d3-1f801ea7fd12",
        "quantity": 2,
        "amount": 254.50,
        "name": "John Doe",
        "email": "john@somebody.live",
        "phone": "+12025550125",
        "phone_code": "US",
    }'
</code></pre>
                        </div>
                        <div class="code-block" data-lang="javascript">
<pre><code class="language-javascript">const axios = require('axios');

const response = await axios.post(
'{{route('home')}}/v1/order',
    {
        "card_id": "1430b926-3faf-49dc-b0d3-1f801ea7fd12",
        "quantity": 2,
        "amount": 254.50,
        "name": "John Doe",
        "email": "john@somebody.live",
        "phone": "+12025550125",
        "phone_code": "US",
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
        CURLOPT_URL => "{{route('home')}}/v1/order",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer YOUR_API_KEY",
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode([
            'card_id' => '1430b926-3faf-49dc-b0d3-1f801ea7fd12',
            'amount' => 254.50,
            'quantity' => 2,
            'name' => 'John Doe',
            'email' => 'john@somebody.live',
            'phone' => '+12025550125',
            'phone_code' => 'US',
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
    url = "{{route('home')}}/v1/order"

    headers = {
        "Authorization": "Bearer YOUR_API_KEY",
        "Content-Type": "application/json"
    }

    payload = {
        "card_id": "1430b926-3faf-49dc-b0d3-1f801ea7fd12",
        "quantity": 2,
        "amount": 254.50,
        "name": "John Doe",
        "email": "john@somebody.live",
        "phone": "+12025550125",
        "phone_code": "US",
    }

    response = requests.post(url, json=payload, headers=headers)
    print(response.json())
</code></pre>
                        </div>
                        <div class="code-block" data-lang="ruby">
                            <pre><code class="language-ruby">
    require 'net/http'
    require 'json'

    uri = URI('{{route('home')}}/v1/order')
    http = Net::HTTP.new(uri.host, uri.port)
    http.use_ssl = true

    request = Net::HTTP::Post.new(uri.path)
    request['Authorization'] = 'Bearer YOUR_API_KEY'
    request['Content-Type'] = 'application/json'

    request.body = {
        card_id: '1430b926-3faf-49dc-b0d3-1f801ea7fd12',
        amount: 254.50,
        quantity: 2,
        name: 'John Doe',
        email: 'john@somebody.live',
        phone: '+12025550125',
        phone_code: 'US',
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
<!-- Platform -->
<section id="platform" class="features-section">
    <div class="container">
        <h2 class="section-title">{{__('A Gift Card API That Does More')}}</h2>
        <p class="section-subtitle">{{__('Simplify the complexities of individual brand agreements and deliver exceptional rewards experiences')}}</p>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <h3 class="feature-title">{{__('Quick Setup')}}</h3>
                    <p class="feature-description">{{__('Build an integration fast with our simple API documentation and get started in minutes.')}}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-globe"></i></div>
                    <h3 class="feature-title">{{__('Global Reach')}}</h3>
                    <p class="feature-description">{{__('Connect seamlessly to')}} 3,000+ {{__('global brands across')}} 40 {{__('countries and ')}} 25 {{__('currencies.')}}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <h3 class="feature-title">{{__('Secure & Reliable')}}</h3>
                    <p class="feature-description">{{__('99.999% uptime with multi-layered security and fraud prevention to protect your data.')}}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-gear-fill"></i></div>
                    <h3 class="feature-title">{{__('Flexible')}}</h3>
                    <p class="feature-description">{{__('Synchronous and asynchronous connections for unrivaled flexibility as you scale.')}}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="platform" class="how-it-works-section">
    <div class="container">
        <h2 class="section-title">{{__('How Our Gift Card API Works')}}</h2>
        <p class="section-subtitle">{{__('Get up and running in three simple steps')}}</p>
        <div class="row g-5">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3 class="step-title">{{__('Get Sandbox Credentials')}}</h3>
                    <p class="step-description">{{__('Our sandbox is free, fully-featured, and ready for you to start building right away.')}}</p>
                    <div class="step-connector"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3 class="step-title">{{__('Develop Your Integration')}}</h3>
                    <p class="step-description">{{__('Follow our API documentation. Our developer support team is on standby if you need help.')}}</p>
                    <div class="step-connector"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3 class="step-title">{{__('Go Live')}}</h3>
                    <p class="step-description">{{__('Obtain a production API key and send your first reward in minutes.')}}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Brand Catalog Showcase Section -->
<section class="brand-catalog-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="section-title text-start">{{__('Every brand your customers love, instantly accessible')}}</h2>
                <p class="content-text mb-4">
                    {{__("Our platform features gift cards from the world's leading retailers—Apple, IKEA, Amazon, Xbox, Airbnb, and over 2,000 additional brands spanning entertainment, fashion, dining, and beyond.")}}
                </p>
                <p class="content-text mb-4">
                    {{__('With new brands added regularly, your customers will always discover the perfect gift card for any occasion or preference.')}}
                </p>
                <a href="{{route('contact')}}" class="btn btn-primary btn-lg">{{__('Contact Sales')}}</a>
            </div>
            <div class="col-lg-6">
                <div class="gift-cards-stack">
                    <div class="gift-card-item card-1">
                        <div class="gift-card-brand spotify"><i class="bi bi-spotify"></i><span>Spotify</span></div>
                    </div>
                    <div class="gift-card-item card-2">
                        <div class="gift-card-brand xbox"><span>XBOX</span><small>EA ACCESS</small></div>
                    </div>
                    <div class="gift-card-item card-3">
                        <div class="gift-card-brand roblox"><i class="bi bi-controller"></i><span>Roblox</span></div>
                    </div>
                    <div class="gift-card-item card-4">
                        <div class="gift-card-brand nintendo"><span>Nintendo eShop</span></div>
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

<!-- Use Cases Section -->
<section id="solutions" class="use-cases-section">
    <div class="container">
        <h2 class="section-title">{{__('Where Could a Gift Card API Take You?')}}</h2>
        <p class="section-subtitle">{{__('Discover the endless possibilities for rewards and incentives')}}</p>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="use-case-card">
                    <div class="use-case-icon"><i class="bi bi-people-fill"></i></div>
                    <h3 class="use-case-title">{{__('Employee Rewards')}}</h3>
                    <p class="use-case-description">{{__('Enhance productivity and retain top talent with meaningful rewards.')}}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="use-case-card">
                    <div class="use-case-icon">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h3 class="use-case-title">{{__('Customer Incentives')}}</h3>
                    <p class="use-case-description">{{__('Influence every touchpoint in the customer journey with tailored rewards.')}}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="use-case-card">
                    <div class="use-case-icon"><i class="bi bi-trophy-fill"></i></div>
                    <h3 class="use-case-title">{{__('Loyalty Programs')}}</h3>
                    <p class="use-case-description">{{__('Turn earnings or points into 3,000+ digital gift cards instantly.')}}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="use-case-card">
                    <div class="use-case-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <h3 class="use-case-title">{{__('Affiliate Marketing')}}</h3>
                    <p class="use-case-description">{{__('Power and fund your affiliate marketing strategy effectively.')}}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="use-case-card">
                    <div class="use-case-icon"><i class="bi bi-search"></i></div>
                    <h3 class="use-case-title">{{__('Research Studies')}}</h3>
                    <p class="use-case-description">{{__('Automate gift card delivery for research participants and surveys.')}}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="use-case-card">
                    <div class="use-case-icon"><i class="bi bi-currency-bitcoin"></i></div>
                    <h3 class="use-case-title">{{__('Crypto Off Ramp')}}</h3>
                    <p class="use-case-description">{{__('Transform crypto into gift cards for everyday purchases seamlessly.')}}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
{{--<section class="testimonial-section">
        <div class="container">
            <div class="testimonial-card">
                <p class="testimonial-quote">
                    "{{__("Integrating with their API was super easy. There's great documentation, tons of examples,
                and the team has been incredibly responsive since day one. It's the simplest, most effective
                way to get gift cards into your platform.")}}"
</p>
<div class="testimonial-author">
    <div class="testimonial-avatar">JL</div>
    <div class="testimonial-info">
        <h4>Jake Levin</h4>
        <p>{{__('Founder & COO')}}, SparkPlug</p>
    </div>
</div>
</div>
</div>
</section>--}}
@endsection