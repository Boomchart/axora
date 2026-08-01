{{--
    @extends('front.pages')

    @section('css')
    @stop

    @section('content')
        <section class="hero-section text-center py-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold"
                              style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">
                            {{ __('Legal Agreement') }}
                        </span>
                        <h1 class="hero-title mb-3">{{ __('Terms of Service') }}</h1>
                        <p class="hero-subtitle mx-auto">
                            {{ __('Please read our Terms and Conditions carefully. They explain the rules, responsibilities, and guidelines that apply when you access or use our unified API for digital assets, global rewards, and related services.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="image-content-section">
            <div class="container">
                <div class="row align-items-center justify-content-center g-5">
                    <div class="col-lg-9">
                        {!! $set->terms !!}
                    </div>
                </div>
            </div>
        </section>
    @stop
--}}

@extends('front.pages')

@section('meta_description', 'Read the terms that govern access to Azora, including our website, dashboard, APIs, gift card, airtime, data, crypto, and payout services.')

@push('css')
    <style>
        .legal-hero {
            padding: 5rem 0 3.5rem;
            text-align: center;
            background:
                radial-gradient(circle at top left, var(--secondary-lighter), transparent 35%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .legal-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--secondary-lighter);
            font-size: 0.875rem;
            font-weight: 800;
        }

        .legal-title {
            margin-bottom: 1rem;
            color: var(--primary-dark);
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .legal-subtitle {
            max-width: 760px;
            margin: 0 auto;
            color: #64748b;
            font-size: 1.08rem;
            line-height: 1.75;
        }

        .legal-updated {
            display: inline-block;
            margin-top: 1.25rem;
            color: #475569;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .legal-page {
            padding: 4rem 0 5rem;
            background: #f8fafc;
        }

        .legal-navigation,
        .legal-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.05);
        }

        .legal-navigation {
            position: sticky;
            top: 110px;
            padding: 1.5rem;
        }

        .legal-navigation h5 {
            margin-bottom: 1rem;
            color: var(--primary-dark);
            font-size: 0.9rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .legal-navigation a {
            display: block;
            padding: 0.55rem 0;
            color: #64748b;
            font-size: 0.94rem;
            font-weight: 650;
            text-decoration: none;
        }

        .legal-navigation a:hover {
            color: var(--primary-dark);
        }

        .legal-card {
            padding: 2.75rem;
        }

        .legal-callout {
            margin-bottom: 2.5rem;
            padding: 1.25rem 1.4rem;
            border-left: 4px solid var(--primary-dark);
            border-radius: 16px;
            background: var(--secondary-lighter);
            color: #334155;
            line-height: 1.7;
        }

        .legal-section {
            padding: 0.5rem 0 2rem;
            scroll-margin-top: 120px;
        }

        .legal-section + .legal-section {
            padding-top: 2rem;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .legal-section:last-child {
            padding-bottom: 0;
        }

        .legal-section h2 {
            margin-bottom: 1rem;
            color: var(--primary-dark);
            font-size: 1.45rem;
            font-weight: 850;
        }

        .legal-section h3 {
            margin: 1.25rem 0 0.6rem;
            color: #0f172a;
            font-size: 1.05rem;
            font-weight: 800;
        }

        .legal-section p,
        .legal-section li {
            color: #475569;
            line-height: 1.8;
        }

        .legal-section ul {
            margin-bottom: 1rem;
            padding-left: 1.25rem;
        }

        .legal-section li {
            margin-bottom: 0.6rem;
        }

        .legal-section a {
            color: var(--primary-dark);
            font-weight: 750;
        }

        @media (max-width: 991.98px) {
            .legal-navigation {
                position: static;
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 767.98px) {
            .legal-hero {
                padding: 4rem 0 3rem;
            }

            .legal-page {
                padding: 3rem 0;
            }

            .legal-card {
                padding: 1.5rem;
                border-radius: 20px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="legal-hero">
        <div class="container">
            <span class="legal-badge">
                <i class="bi bi-file-earmark-text"></i>
                Legal Agreement
            </span>

            <h1 class="legal-title">Terms of Service</h1>

            <p class="legal-subtitle">
                These terms govern your access to Azora's website, dashboard, APIs, and supported gift card, airtime, data, crypto, and payout services.
            </p>

            <span class="legal-updated">Effective and last updated: July 31, 2026</span>
        </div>
    </section>

    <section class="legal-page">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-3">
                    <nav class="legal-navigation" aria-label="Terms of service sections">
                        <h5>On this page</h5>
                        <a href="#agreement">1. Agreement</a>
                        <a href="#eligibility">2. Eligibility</a>
                        <a href="#accounts">3. Accounts</a>
                        <a href="#services">4. Services</a>
                        <a href="#api-use">5. API use</a>
                        <a href="#compliance">6. Compliance</a>
                        <a href="#fees">7. Fees and funding</a>
                        <a href="#transactions">8. Transactions</a>
                        <a href="#crypto">9. Crypto risks</a>
                        <a href="#prohibited-use">10. Prohibited use</a>
                        <a href="#third-parties">11. Third parties</a>
                        <a href="#intellectual-property">12. Intellectual property</a>
                        <a href="#suspension">13. Suspension</a>
                        <a href="#disclaimers">14. Disclaimers</a>
                        <a href="#liability">15. Liability</a>
                        <a href="#general">16. General terms</a>
                        <a href="#contact">17. Contact us</a>
                    </nav>
                </div>

                <div class="col-lg-9">
                    <article class="legal-card">
                        <div class="legal-callout">
                            These Terms form a binding agreement between you and Azora. If you use Azora on behalf of a company or other organisation, you confirm that you have authority to bind that organisation to these Terms.
                        </div>

                        <section class="legal-section" id="agreement">
                            <h2>1. Agreement to these Terms</h2>
                            <p>
                                By accessing or using Azora, creating an account, obtaining API credentials, or submitting a transaction, you agree to these Terms of Service, our <a href="{{ route('privacy') }}">Privacy Policy</a>, and any product-specific terms, order forms, fee schedules, or written agreements that apply to your account.
                            </p>
                            <p>If you do not agree, do not access or use the services.</p>
                        </section>

                        <section class="legal-section" id="eligibility">
                            <h2>2. Eligibility and authority</h2>
                            <p>You may use Azora only if:</p>
                            <ul>
                                <li>you are at least 18 years old and legally capable of entering into a binding agreement;</li>
                                <li>you are not prohibited from using the services under applicable law;</li>
                                <li>all registration and verification information you provide is accurate and complete; and</li>
                                <li>where you act for a business, you have authority to act for and bind that business.</li>
                            </ul>
                            <p>Azora may restrict particular services by country, customer type, verification status, transaction type, asset, network, or applicable law.</p>
                        </section>

                        <section class="legal-section" id="accounts">
                            <h2>3. Accounts and security</h2>
                            <p>
                                You are responsible for activity performed through your account and credentials. You must use accurate account information, maintain appropriate access controls, protect passwords and API keys, and promptly notify us if you suspect unauthorised access or credential exposure.
                            </p>
                            <p>
                                Do not embed secret API keys in public repositories, client-side applications, or other locations accessible to unauthorised persons. Azora may treat properly authenticated instructions as authorised until we receive and process notice that credentials may have been compromised.
                            </p>
                        </section>

                        <section class="legal-section" id="services">
                            <h2>4. Our services</h2>
                            <p>
                                Azora provides technology that may allow approved customers to access supported products and transaction services through a website, dashboard, or API. These may include gift cards, airtime, mobile data, crypto deposit addresses, crypto payouts, transaction quotes, reporting, and related features.
                            </p>
                            <p>
                                Available products, countries, currencies, assets, networks, providers, limits, settlement times, and functionality may change. A feature appearing in documentation or a test environment does not guarantee that it will be available in production or in every location.
                            </p>
                        </section>

                        <section class="legal-section" id="api-use">
                            <h2>5. API and integration responsibilities</h2>
                            <p>You must:</p>
                            <ul>
                                <li>follow our current documentation, authentication requirements, rate limits, and technical instructions;</li>
                                <li>validate transaction details, recipient information, asset identifiers, and network selections before submitting a request;</li>
                                <li>secure your systems and keep production and sandbox credentials separate;</li>
                                <li>implement reasonable error handling, idempotency, reconciliation, monitoring, and webhook verification;</li>
                                <li>display accurate product, fee, network, timing, and risk information to your users; and</li>
                                <li>obtain all permissions and lawful bases required to send personal data to Azora.</li>
                            </ul>
                            <p>You must not bypass technical restrictions, interfere with platform operation, scrape protected areas, reverse engineer non-public services, or use the API in a manner that creates unreasonable load or security risk.</p>
                        </section>

                        <section class="legal-section" id="compliance">
                            <h2>6. Verification and legal compliance</h2>
                            <p>
                                You must comply with all laws and rules applicable to your business and use of Azora, including requirements relating to consumer protection, privacy, electronic communications, taxation, anti-money-laundering controls, counter-terrorist financing, sanctions, fraud prevention, digital assets, and telecommunications services.
                            </p>
                            <p>
                                We may request identity, business, ownership, source-of-funds, transaction, beneficiary, or other compliance information before or after enabling a service. You must provide accurate information promptly and cooperate with reasonable reviews. We may delay, reject, report, freeze, or restrict activity where required by law or where we reasonably identify fraud, security, compliance, or operational risk.
                            </p>
                        </section>

                        <section class="legal-section" id="fees">
                            <h2>7. Fees, quotes, balances, and funding</h2>
                            <p>
                                You agree to pay the fees, network costs, provider charges, taxes, and other amounts shown in the dashboard, API response, quote, fee schedule, order form, or other applicable agreement. Fees and exchange rates may change before a transaction is accepted.
                            </p>
                            <p>
                                Quotes are estimates or time-limited offers and may expire. A quote does not guarantee execution until the transaction is accepted and any required balance or funding is available. You authorise Azora to deduct applicable amounts from your available balance where the service uses a prefunded account.
                            </p>
                            <p>You are responsible for maintaining sufficient funds and for reviewing balances and transaction records. Notify us promptly of any suspected discrepancy.</p>
                        </section>

                        <section class="legal-section" id="transactions">
                            <h2>8. Transaction instructions, fulfilment, and refunds</h2>
                            <p>
                                You are responsible for the completeness and accuracy of every instruction submitted through your account, including recipient telephone numbers, email addresses, product identifiers, denominations, currencies, wallet addresses, tokens, and blockchain networks.
                            </p>
                            <p>
                                Transactions may be processed by third-party suppliers and may remain pending while a provider or network completes processing. Status updates are based on information available to us and may be delayed. A transaction is not guaranteed until confirmed through the applicable service.
                            </p>
                            <p>
                                Once accepted or fulfilled, airtime, data, gift card, payout, and blockchain transactions are generally final and may not be reversible. Refunds or replacements are available only where required by law, expressly stated for the relevant product, or approved after investigation of a verified processing failure. A recipient error or incorrect instruction supplied by you is not a platform processing failure.
                            </p>
                        </section>

                        <section class="legal-section" id="crypto">
                            <h2>9. Crypto and blockchain risks</h2>
                            <p>
                                Crypto assets and blockchain networks involve significant risks, including price volatility, network congestion, forks, protocol changes, smart-contract defects, cyberattacks, regulatory changes, transaction delays, and permanent loss. Azora does not provide investment, legal, tax, or financial advice and does not guarantee the value or future availability of any asset.
                            </p>
                            <ul>
                                <li>You must use only the token and network shown as supported for the relevant address or transaction.</li>
                                <li>Sending an unsupported token or using an incorrect network may result in permanent loss.</li>
                                <li>Blockchain transactions are generally irreversible once broadcast or confirmed.</li>
                                <li>Network or gas fees may vary and may not be known until a quote or transaction is created.</li>
                                <li>Wallet addresses and transaction information recorded on public blockchains may be publicly visible.</li>
                            </ul>
                            <p>Azora may pause an asset or network for maintenance, security, liquidity, provider, compliance, or blockchain-related reasons.</p>
                        </section>

                        <section class="legal-section" id="prohibited-use">
                            <h2>10. Prohibited use</h2>
                            <p>You must not use Azora to:</p>
                            <ul>
                                <li>violate any law, regulation, court order, sanctions programme, or third-party right;</li>
                                <li>facilitate fraud, scams, deceptive practices, money laundering, terrorist financing, unauthorised gambling, trafficking, exploitation, or other unlawful activity;</li>
                                <li>transact for a prohibited person, territory, product, or purpose;</li>
                                <li>misrepresent your identity, business, transaction purpose, or relationship with Azora;</li>
                                <li>gain unauthorised access, introduce malicious code, disrupt the services, or test vulnerabilities without written permission;</li>
                                <li>resell or expose the services in a way that violates applicable product restrictions or supplier terms; or</li>
                                <li>use Azora to provide investment products, returns, custody, exchange, or other regulated services unless you hold all required approvals.</li>
                            </ul>
                        </section>

                        <section class="legal-section" id="third-parties">
                            <h2>11. Third-party providers</h2>
                            <p>
                                Azora relies on third parties such as telecommunications operators, gift card suppliers, payment providers, financial institutions, identity-verification services, liquidity providers, blockchain networks, and infrastructure vendors. Their availability, rules, processing times, outages, and decisions may affect the services.
                            </p>
                            <p>
                                Third-party products may be subject to separate terms, expiry dates, country restrictions, redemption rules, acceptable-use requirements, or refund policies. You are responsible for reviewing and communicating any terms that apply to your distribution or use of those products.
                            </p>
                        </section>

                        <section class="legal-section" id="intellectual-property">
                            <h2>12. Intellectual property and feedback</h2>
                            <p>
                                Azora and its licensors retain all rights in the platform, software, APIs, documentation, branding, designs, and related materials. Subject to these Terms, Azora grants you a limited, non-exclusive, non-transferable, revocable right to access and use the services for your authorised business purposes.
                            </p>
                            <p>
                                You retain rights in content and data you lawfully submit. You grant Azora the rights reasonably necessary to host, transmit, process, and use that content to provide, secure, and support the services. If you provide feedback, you permit Azora to use it without restriction or compensation.
                            </p>
                        </section>

                        <section class="legal-section" id="suspension">
                            <h2>13. Suspension and termination</h2>
                            <p>
                                You may stop using the services at any time, subject to outstanding transactions, fees, and contractual commitments. Azora may limit, suspend, or terminate access where reasonably necessary to address non-payment, suspected fraud, security risk, unlawful activity, inaccurate verification information, breach of these Terms, provider restrictions, legal requirements, or risk to Azora or others.
                            </p>
                            <p>Termination does not affect accrued rights, payment obligations, completed transactions, or provisions intended to survive termination.</p>
                        </section>

                        <section class="legal-section" id="disclaimers">
                            <h2>14. Service availability and disclaimers</h2>
                            <p>
                                To the maximum extent permitted by law, the services are provided on an “as available” basis. Azora does not guarantee uninterrupted availability, error-free operation, acceptance of every transaction, recovery of incorrectly transferred assets, or compatibility with every system, asset, network, or third-party product.
                            </p>
                            <p>
                                We may perform maintenance, change technical requirements, or discontinue a feature. Sandbox results do not guarantee identical production behaviour. Nothing in these Terms excludes a warranty or right that cannot legally be excluded.
                            </p>
                        </section>

                        <section class="legal-section" id="liability">
                            <h2>15. Limitation of liability and indemnity</h2>
                            <p>
                                To the maximum extent permitted by law, neither party will be liable for indirect, incidental, special, exemplary, punitive, or consequential losses, or for loss of profits, revenue, goodwill, business opportunity, or data, arising from the services.
                            </p>
                            <p>
                                To the maximum extent permitted by law, Azora's aggregate liability arising from the services will not exceed the fees you paid to Azora for the affected services during the three months immediately before the event giving rise to the claim. This limitation does not apply where liability cannot legally be limited.
                            </p>
                            <p>
                                You agree to indemnify Azora and its personnel against third-party claims, penalties, and reasonable costs arising from your unlawful use of the services, your breach of these Terms, your application or end-user offering, or data and instructions submitted through your account, except to the extent caused by Azora's own breach or misconduct.
                            </p>
                        </section>

                        <section class="legal-section" id="general">
                            <h2>16. General terms</h2>

                            <h3>Changes</h3>
                            <p>We may update these Terms as our services or legal obligations change. We will post the revised Terms and update the date above. Where required, we will provide additional notice. Continued use after the effective date of revised Terms constitutes acceptance.</p>

                            <h3>Governing law and disputes</h3>
                            <p>These Terms are governed by the laws of the Federal Republic of Nigeria, without regard to conflict-of-law principles. Before starting formal proceedings, each party will attempt in good faith to resolve a dispute through written notice and reasonable discussions. Unless applicable law requires otherwise, the courts of competent jurisdiction in Nigeria will have jurisdiction.</p>

                            <h3>Force majeure</h3>
                            <p>Neither party is responsible for delay or failure caused by events beyond its reasonable control, including internet or utility failures, natural disasters, labour disputes, government action, war, civil unrest, supplier outages, cyberattacks, or blockchain-network disruption.</p>

                            <h3>Assignment and severability</h3>
                            <p>You may not assign these Terms without Azora's prior written consent. Azora may assign them as part of a merger, reorganisation, financing, sale, or transfer of the relevant business. If a provision is unenforceable, the remaining provisions remain effective.</p>

                            <h3>Entire agreement and waiver</h3>
                            <p>These Terms and any applicable written service agreement constitute the entire agreement concerning the services and replace earlier discussions on the same subject. A failure to enforce a provision is not a waiver of that provision.</p>
                        </section>

                        <section class="legal-section" id="contact">
                            <h2>17. Contact us</h2>
                            <p>
                                Questions about these Terms may be submitted through our <a href="{{ route('contact') }}">contact page</a>. Include your business name and account email so we can respond efficiently.
                            </p>
                        </section>
                    </article>
                </div>
            </div>
        </div>
    </section>
@stop
