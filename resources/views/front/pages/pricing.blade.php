@extends('front.pages')

<meta name="description" content="Pricing" />

@section('css')

@stop

@section('content')
    <section class="axora-pricing-hero text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="axora-pricing-badge"><i class="bi bi-credit-card"></i>{{ __('Pricing') }}</span>
                    <h1 class="axora-pricing-title">{{ __('Simple Pricing for Digital Asset Infrastructure') }}</h1>
                    <p class="axora-pricing-subtitle">{{ __('Pricing is built around your transaction activity, including purchase volume, asset type, provider costs, supported regions, currencies, and the specific needs of your business.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="axora-pricing-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="axora-pricing-explainer">
                        <div class="axora-pricing-explainer-icon">
                            <i class="bi bi-slash-circle"></i>
                        </div>

                        <div>
                            <span class="axora-pricing-kicker">{{ __('Usage-Based Pricing') }}</span>
                            <h2>{{ __('Pricing that scales with your transaction volume') }}</h2>
                            <p>{{ __('Your pricing is calculated around how your business uses our Unified API. This may include the volume and value of gift cards, airtime, data bundles, and crypto transactions, applicable provider or network costs, transaction fees, supported countries, available currencies, and your approved business use case.') }}</p>
                        </div>
                    </div>

                    <div class="axora-pricing-breakdown mt-5">
                        <div class="axora-section-header text-center mb-4">
                        <span class="axora-pricing-badge">
                            <i class="bi bi-calculator"></i>
                            {{ __('Pricing Breakdown') }}
                        </span>

                            <h2 class="axora-pricing-title h1">{{ __('How pricing is calculated') }}</h2>
                            <p class="axora-pricing-subtitle">{{ __('We create a fee structure around your expected transaction volume, supported digital assets, and business requirements.') }}</p>
                        </div>

                        <div class="axora-pricing-flow">
                            <div class="axora-pricing-step">
                                <div class="axora-pricing-step-number">1</div>
                                <h3>{{ __('Asset Value') }}</h3>
                                <p>{{ __('The face value of the gift card, airtime top-up, data bundle, or crypto requested is the base amount used for each transaction.') }}</p>
                            </div>

                            <div class="axora-pricing-step">
                                <div class="axora-pricing-step-number">2</div>
                                <h3>{{ __('Provider & Network Fees') }}</h3>
                                <p>{{ __('Different retail brands, telecom operators, blockchain networks, and currencies may have different baseline costs or exchange rates.') }}</p>
                            </div>

                            <div class="axora-pricing-step">
                                <div class="axora-pricing-step-number">3</div>
                                <h3>{{ __('Transaction Fees') }}</h3>
                                <p>{{ __('A transaction or processing fee may apply depending on the purchase request, payment method, provider setup, and business arrangement.') }}</p>
                            </div>

                            <div class="axora-pricing-step">
                                <div class="axora-pricing-step-number">4</div>
                                <h3>{{ __('Volume & Custom Terms') }}</h3>
                                <p>{{ __('Businesses with higher transaction volumes may qualify for custom commercial terms based on expected usage and approval.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="axora-fee-factors mt-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="axora-fee-factor">
                                    <i class="bi bi-activity"></i>
                                    <div>
                                        <h4>{{ __('Number of transactions') }}</h4>
                                        <p>{{ __('Pricing may vary based on how many gift cards, airtime top-ups, or crypto wallets your business processes over time.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="axora-fee-factor">
                                    <i class="bi bi-cash-stack"></i>
                                    <div>
                                        <h4>{{ __('Total purchase value') }}</h4>
                                        <p>{{ __('The total value of digital assets and rewards purchased can affect your fee setup and commercial terms.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="axora-fee-factor">
                                    <i class="bi bi-globe2"></i>
                                    <div>
                                        <h4>{{ __('Supported regions and networks') }}</h4>
                                        <p>{{ __('Asset availability and cost may differ by country, telecom region, currency, and blockchain network.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="axora-fee-factor">
                                    <i class="bi bi-diagram-3"></i>
                                    <div>
                                        <h4>{{ __('Integration and operational needs') }}</h4>
                                        <p>{{ __('Custom workflows, scaling limits, settlement requirements, or advanced business needs may affect pricing.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="axora-pricing-example mt-5">
                        <div class="row align-items-center g-4">
                            <div class="col-lg-5">
                                <span class="axora-pricing-kicker">{{ __('Example Fee Logic') }}</span>
                                <h2>{{ __('Your final cost is built around each transaction') }}</h2>
                                <p>{{ __('For each API request, your cost may include the asset face value, applicable provider or network costs, transaction fees, and any agreed commercial margin or service fee.') }}</p>
                            </div>

                            <div class="col-lg-7">
                                <div class="axora-cost-formula">
                                    <div class="axora-cost-item"><span>{{ __('Asset Face Value') }}</span></div>
                                    <i class="bi bi-plus-lg"></i>

                                    <div class="axora-cost-item"><span>{{ __('Provider / Network Fees') }}</span></div>
                                    <i class="bi bi-plus-lg"></i>

                                    <div class="axora-cost-item"><span>{{ __('Transaction Fee') }}</span></div>
                                    <i class="bi bi-plus-lg"></i>

                                    <div class="axora-cost-item axora-cost-item-dark"><span>{{ __('Custom Terms') }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="axora-pricing-cta">
                        <h3>{{ __('Request pricing for your business') }}</h3>
                        <p>{{ __('Tell us your expected volume, preferred assets (airtime, crypto, gift cards), currencies, countries, and integration needs. We will provide a fee setup based on your approved business use case.') }}</p>
                        <a href="{{ route('contact') }}" class="btn btn-light">{{ __('Request Pricing') }}</a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="axora-pricing-faq">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-9 text-center">
                    <span class="axora-pricing-badge">
                        <i class="bi bi-question-circle"></i>
                        {{ __('Pricing FAQ') }}
                    </span>

                    <h2 class="axora-pricing-title h1">{{ __('Frequently Asked Questions') }}</h2>
                    <p class="axora-pricing-subtitle">{{ __('A few common questions about pricing, access, and business usage.') }}</p>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-12 col-md-6">
                    <div class="axora-faq-card">
                        <h4>{{ __('Is there a fixed monthly plan?') }}</h4>
                        <p>{{ __('Our fees are structured around actual API usage, including purchase activity, transaction volume, provider fees, supported services, and your approved business use case.') }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="axora-faq-card">
                        <h4>{{ __('What determines the final pricing?') }}</h4>
                        <p>{{ __('Final pricing may depend on the number and value of assets purchased, supported networks, telcos, brands, currencies, transaction fees, and your expected business volume.') }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="axora-faq-card">
                        <h4>{{ __('Can high-volume businesses get custom pricing?') }}</h4>
                        <p>{{ __('Yes. Businesses with higher expected volume or special integration requirements can request custom pricing and commercial terms based on their use case.') }}</p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="axora-faq-card">
                        <h4>{{ __('Will fees be explained before we go live?') }}</h4>
                        <p>{{ __('Yes. During onboarding, we provide the applicable fee setup for your approved use case so your business understands the pricing across all asset classes before live usage begins.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop