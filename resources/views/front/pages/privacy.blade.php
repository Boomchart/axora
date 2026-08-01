{{--
    @extends('front.pages')

    @section('content')
        <section class="hero-section text-center py-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold"
                              style="background-color: var(--secondary-lighter) !important; color: var(--primary-dark) !important;">
                            {{ __('Privacy Policy') }}
                        </span>
                        <h1 class="hero-title mb-3">{{ __('How We Protect Your Privacy') }}</h1>
                        <p class="hero-subtitle mx-auto">
                            {{ __('Your privacy matters to us. Learn how we collect, use, and protect your data when you use our unified API platform for digital assets, global rewards, and crypto services.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="image-content-section">
            <div class="container">
                <div class="row align-items-center justify-content-center g-5">
                    <div class="col-lg-9">
                        {!! $set->privacy !!}
                    </div>
                </div>
            </div>
        </section>
    @stop
--}}

@extends('front.pages')

@section('meta_description', 'Learn how Azora collects, uses, shares, and protects personal data when you use our website, dashboard, APIs, and related services.')

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
                <i class="bi bi-shield-check"></i>
                Privacy Policy
            </span>

            <h1 class="legal-title">How Azora Handles Your Information</h1>

            <p class="legal-subtitle">
                This policy explains the personal data we collect, why we use it, when we share it, and the choices available to you when you use Azora.
            </p>

            <span class="legal-updated">Effective and last updated: July 31, 2026</span>
        </div>
    </section>

    <section class="legal-page">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-3">
                    <nav class="legal-navigation" aria-label="Privacy policy sections">
                        <h5>On this page</h5>
                        <a href="#scope">1. Scope</a>
                        <a href="#data-we-collect">2. Data we collect</a>
                        <a href="#how-we-use-data">3. How we use data</a>
                        <a href="#lawful-bases">4. Lawful bases</a>
                        <a href="#sharing">5. How we share data</a>
                        <a href="#transfers">6. International transfers</a>
                        <a href="#retention">7. Retention</a>
                        <a href="#security">8. Security</a>
                        <a href="#cookies">9. Cookies</a>
                        <a href="#rights">10. Your rights</a>
                        <a href="#blockchain">11. Blockchain data</a>
                        <a href="#children">12. Children</a>
                        <a href="#changes">13. Changes</a>
                        <a href="#contact">14. Contact us</a>
                    </nav>
                </div>

                <div class="col-lg-9">
                    <article class="legal-card">
                        <div class="legal-callout">
                            This policy applies to Azora's website, dashboard, APIs, support channels, and related services. Business customers remain responsible for the personal data they submit to Azora or process through their own applications.
                        </div>

                        <section class="legal-section" id="scope">
                            <h2>1. Scope and who is responsible</h2>
                            <p>
                                This Privacy Policy applies when you visit our website, create or use an account, integrate with our APIs, make or receive supported transactions, contact our team, or otherwise interact with Azora's services.
                            </p>
                            <p>
                                Azora acts as a data controller for information used to operate accounts, provide our platform, prevent misuse, comply with legal obligations, and communicate with customers. In some integrations, Azora may process information on a business customer's instructions. In that situation, the business customer is responsible for providing any required privacy notice and establishing a lawful basis for the data it sends to us.
                            </p>
                        </section>

                        <section class="legal-section" id="data-we-collect">
                            <h2>2. Personal data we collect</h2>

                            <h3>Account and contact information</h3>
                            <p>We may collect your name, business name, email address, telephone number, username, account preferences, and communications with us.</p>

                            <h3>Business verification and compliance information</h3>
                            <p>Where required, we may collect company registration details, beneficial ownership information, government-issued identification, proof of address, source-of-funds information, and other records needed for identity verification, fraud prevention, sanctions screening, or regulatory compliance.</p>

                            <h3>Transaction and service information</h3>
                            <p>We may process account balances, quotes, orders, gift card details, airtime and data top-up information, beneficiary or recipient information, transaction references, crypto asset and network details, wallet addresses, and associated transaction records.</p>

                            <h3>Technical and usage information</h3>
                            <p>We may collect IP addresses, browser and device information, operating system, API request metadata, authentication events, access logs, approximate location derived from IP address, cookie identifiers, error reports, and information about how you use the platform.</p>

                            <h3>Information from other sources</h3>
                            <p>We may receive information from business customers, identity and compliance providers, payment and banking partners, telecommunications operators, gift card suppliers, blockchain infrastructure providers, fraud-prevention services, public blockchains, and publicly available sources.</p>
                        </section>

                        <section class="legal-section" id="how-we-use-data">
                            <h2>3. How we use personal data</h2>
                            <p>We may use personal data to:</p>
                            <ul>
                                <li>create, authenticate, administer, and support accounts;</li>
                                <li>provide quotes and process gift card, airtime, data, crypto, payout, and related transactions;</li>
                                <li>generate and maintain supported deposit addresses and transaction records;</li>
                                <li>verify identity and business information and conduct compliance checks;</li>
                                <li>detect, investigate, and prevent fraud, abuse, security incidents, and unlawful activity;</li>
                                <li>operate, secure, troubleshoot, analyse, and improve our website, dashboard, APIs, and services;</li>
                                <li>send service messages, security notices, transaction updates, and support responses;</li>
                                <li>send marketing communications where permitted, subject to your communication preferences;</li>
                                <li>enforce our agreements and protect our users, partners, rights, and property; and</li>
                                <li>comply with legal, regulatory, tax, accounting, reporting, and record-keeping obligations.</li>
                            </ul>
                        </section>

                        <section class="legal-section" id="lawful-bases">
                            <h2>4. Lawful bases for processing</h2>
                            <p>Depending on the context and applicable law, we rely on one or more of the following bases:</p>
                            <ul>
                                <li><strong>Contract:</strong> processing needed to provide the services you request or to take steps before entering into an agreement.</li>
                                <li><strong>Legal obligation:</strong> processing needed to satisfy legal, regulatory, compliance, tax, or reporting duties.</li>
                                <li><strong>Legitimate interests:</strong> operating and improving the platform, protecting accounts, preventing fraud, supporting customers, and defending legal rights, where those interests are not overridden by your rights.</li>
                                <li><strong>Consent:</strong> where we specifically ask for permission, including for certain cookies or communications. You may withdraw consent without affecting earlier lawful processing.</li>
                            </ul>
                        </section>

                        <section class="legal-section" id="sharing">
                            <h2>5. How we share personal data</h2>
                            <p>We may share relevant data with:</p>
                            <ul>
                                <li>vendors that provide hosting, cloud infrastructure, communications, analytics, customer support, security, identity verification, compliance screening, and fraud prevention;</li>
                                <li>payment providers, financial institutions, telecommunications operators, gift card suppliers, blockchain infrastructure providers, liquidity or payout partners, and other parties needed to complete a requested transaction;</li>
                                <li>professional advisers, auditors, insurers, and potential participants in a corporate financing, restructuring, merger, acquisition, or sale;</li>
                                <li>regulators, courts, law enforcement, tax authorities, and other public bodies where disclosure is required or legally justified; and</li>
                                <li>other parties when you direct us to share information or provide valid consent.</li>
                            </ul>
                            <p>We require service providers to handle personal data only for authorised purposes and with appropriate safeguards, subject to applicable law and contractual arrangements.</p>
                        </section>

                        <section class="legal-section" id="transfers">
                            <h2>6. International data transfers</h2>
                            <p>
                                Azora and its service providers may process information in countries other than the country where you live. Where personal data is transferred internationally, we take reasonable steps to use an approved transfer mechanism or other appropriate safeguard required by applicable data protection law.
                            </p>
                        </section>

                        <section class="legal-section" id="retention">
                            <h2>7. How long we retain data</h2>
                            <p>
                                We retain personal data only for as long as reasonably necessary for the purposes described in this policy. Retention periods depend on the type of data, the services involved, account status, security and dispute-resolution needs, and legal, regulatory, tax, accounting, anti-fraud, and anti-money-laundering requirements.
                            </p>
                            <p>When information is no longer required, we delete, anonymise, or securely isolate it, unless continued retention is required or permitted by law.</p>
                        </section>

                        <section class="legal-section" id="security">
                            <h2>8. Security</h2>
                            <p>
                                We use reasonable administrative, organisational, and technical measures designed to protect personal data against unauthorised access, loss, misuse, alteration, or disclosure. These measures may include access controls, authentication safeguards, encryption in transit, monitoring, logging, vendor reviews, and incident-response procedures.
                            </p>
                            <p>No system is completely secure. You are responsible for protecting your password, API keys, devices, and account access, and for notifying us promptly if you suspect unauthorised use.</p>
                        </section>

                        <section class="legal-section" id="cookies">
                            <h2>9. Cookies and similar technologies</h2>
                            <p>
                                We may use necessary cookies to operate the website and maintain sessions, as well as preference, analytics, security, and fraud-prevention technologies where permitted. Our forms may use Google reCAPTCHA to help distinguish legitimate activity from automated abuse; Google's own privacy terms may apply to information it processes.
                            </p>
                            <p>You can control non-essential cookies through our cookie controls, where available, and through your browser settings. Disabling necessary cookies may prevent parts of the platform from working correctly.</p>
                        </section>

                        <section class="legal-section" id="rights">
                            <h2>10. Your privacy rights</h2>
                            <p>Subject to applicable law and relevant exceptions, you may have the right to:</p>
                            <ul>
                                <li>be informed about how your personal data is processed;</li>
                                <li>request access to or a copy of your personal data;</li>
                                <li>request correction of inaccurate or incomplete data;</li>
                                <li>request deletion, restriction, or cessation of certain processing;</li>
                                <li>object to processing based on legitimate interests or to direct marketing;</li>
                                <li>withdraw consent where processing relies on consent;</li>
                                <li>request data portability where applicable;</li>
                                <li>seek human review of certain automated decisions where applicable; and</li>
                                <li>complain to the relevant data protection authority.</li>
                            </ul>
                            <p>We may need to verify your identity before responding. Some rights may be limited where we must retain information to comply with law, complete transactions, protect security, or establish or defend legal claims.</p>
                        </section>

                        <section class="legal-section" id="blockchain">
                            <h2>11. Public blockchain information</h2>
                            <p>
                                Crypto transactions may be recorded on public blockchains. Wallet addresses, transaction hashes, amounts, timestamps, and related information recorded on a blockchain may be publicly visible and cannot generally be altered or deleted by Azora. Avoid including unnecessary personal information in blockchain transaction data.
                            </p>
                        </section>

                        <section class="legal-section" id="children">
                            <h2>12. Children's privacy</h2>
                            <p>
                                Azora's services are not directed to children, and you must be at least 18 years old or the legal age required to enter into a binding agreement in your jurisdiction. We do not knowingly provide accounts to children. If you believe a child has provided personal data to us, please contact us.
                            </p>
                        </section>

                        <section class="legal-section" id="changes">
                            <h2>13. Changes to this policy</h2>
                            <p>
                                We may update this Privacy Policy to reflect changes to our services, practices, technology, or legal obligations. We will post the revised policy on this page and update the date above. Where required, we will provide additional notice of material changes.
                            </p>
                        </section>

                        <section class="legal-section" id="contact">
                            <h2>14. Contact us</h2>
                            <p>
                                To ask a privacy question or exercise a privacy right, use our <a href="{{ route('contact') }}">contact form</a> and clearly mark your request as a privacy request.
                            </p>
                            <p>
                                If you are in Nigeria and believe your concern has not been resolved, you may contact the <a href="https://ndpc.gov.ng/" target="_blank" rel="noopener noreferrer">Nigeria Data Protection Commission</a>.
                            </p>
                        </section>
                    </article>
                </div>
            </div>
        </div>
    </section>
@stop
