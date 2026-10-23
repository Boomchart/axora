@push('ld')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => $landing['service_name'],
    'description' => $landing['meta_description'],
    'provider' => [
        '@type' => 'Organization',
        'name' => $set->site_name ?? config('app.name'),
        'url' => url('/'),
    ],
    'url' => url()->current(),
    'audience' => [
        '@type' => 'BusinessAudience',
        'audienceType' => 'Businesses and software platforms',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

<section class="azora-product-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="azora-product-eyebrow">
                    <i class="bi {{ $landing['icon'] }}"></i>
                    {{ __($landing['eyebrow']) }}
                </span>
                <h1>{{ __($landing['headline']) }}</h1>
                <p class="azora-product-lead">{{ __($landing['lead']) }}</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">{{ __('Get API Access') }}</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg">{{ __('Contact Sales') }}</a>
                </div>
                <ul class="azora-product-trust-list">
                    @foreach($landing['trust_points'] as $point)
                        <li><i class="bi bi-check-circle-fill"></i>{{ __($point) }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-5">
                <div class="azora-product-visual" aria-label="{{ __($landing['visual_label']) }}">
                    <div class="azora-product-visual-glow"></div>
                    <div class="azora-product-visual-top">
                        <span>{{ config('app.name') }} API</span>
                        <span class="azora-product-status"><i></i>{{ __('Ready') }}</span>
                    </div>
                    <div class="azora-product-visual-icon"><i class="bi {{ $landing['icon'] }}"></i></div>
                    <h2>{{ __($landing['visual_title']) }}</h2>
                    <p>{{ __($landing['visual_copy']) }}</p>
                    <div class="azora-product-mini-grid">
                        @foreach($landing['visual_points'] as $point)
                            <div>
                                <i class="bi {{ $point['icon'] }}"></i>
                                <span>{{ __($point['label']) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="azora-product-visual-footer">
                        <span><i class="bi bi-code-slash"></i>{{ __('REST API') }}</span>
                        <span><i class="bi bi-braces"></i>{{ __('JSON') }}</span>
                        <span><i class="bi bi-shield-check"></i>{{ __('Secure') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="azora-product-proof">
    <div class="container">
        <div class="row g-3">
            @foreach($landing['proof_points'] as $point)
                <div class="col-md-4">
                    <div class="azora-product-proof-item">
                        <strong>{{ __($point['title']) }}</strong>
                        <span>{{ __($point['copy']) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="azora-product-section">
    <div class="container">
        <div class="azora-product-section-heading">
            <span>{{ __('Built for business') }}</span>
            <h2>{{ __($landing['use_cases_title']) }}</h2>
            <p>{{ __($landing['use_cases_intro']) }}</p>
        </div>
        <div class="row g-4">
            @foreach($landing['use_cases'] as $useCase)
                <div class="col-md-6 col-lg-3">
                    <article class="azora-product-card">
                        <div class="azora-product-card-icon"><i class="bi {{ $useCase['icon'] }}"></i></div>
                        <h3>{{ __($useCase['title']) }}</h3>
                        <p>{{ __($useCase['copy']) }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="azora-product-section azora-product-section-soft">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="azora-product-kicker">{{ __('One integration, practical controls') }}</span>
                <h2 class="azora-product-content-title">{{ __($landing['capabilities_title']) }}</h2>
                <p class="azora-product-content-copy">{{ __($landing['capabilities_intro']) }}</p>
                <ul class="azora-product-feature-list">
                    @foreach($landing['capabilities'] as $capability)
                        <li>
                            <i class="bi bi-check2"></i>
                            <div>
                                <strong>{{ __($capability['title']) }}</strong>
                                <span>{{ __($capability['copy']) }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="azora-product-code-card">
                    <div class="azora-product-code-head">
                        <div class="azora-product-code-dots"><i></i><i></i><i></i></div>
                        <span>{{ __($landing['endpoint_label']) }}</span>
                    </div>
                    <pre><code>{{ $landing['code_sample'] }}</code></pre>
                    <div class="azora-product-code-action">
                        <span><i class="bi bi-check-circle-fill"></i>{{ __('Developer-friendly integration') }}</span>
                        <a href="{{ route($landing['guide_route']) }}" target="_blank" rel="noopener">{{ __('Read the guide') }} <i class="bi bi-arrow-up-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="azora-product-section">
    <div class="container">
        <div class="azora-product-section-heading">
            <span>{{ __('From sandbox to launch') }}</span>
            <h2>{{ __('Start in three clear steps') }}</h2>
            <p>{{ __('Explore the product, connect your application and move to production with support from our team.') }}</p>
        </div>
        <div class="row g-4">
            @foreach($landing['steps'] as $index => $step)
                <div class="col-md-4">
                    <div class="azora-product-step">
                        <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ __($step['title']) }}</h3>
                        <p>{{ __($step['copy']) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="azora-product-section azora-product-faq-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <span class="azora-product-kicker">{{ __('Questions answered') }}</span>
                <h2 class="azora-product-content-title">{{ __($landing['faq_title']) }}</h2>
                <p class="azora-product-content-copy">{{ __('Need an answer specific to your product or market? Our sales team can help.') }}</p>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary">{{ __('Talk to our team') }}</a>
            </div>
            <div class="col-lg-8">
                <div class="accordion azora-product-accordion" id="{{ $landing['slug'] }}-faq">
                    @foreach($landing['faqs'] as $index => $faq)
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="{{ $landing['slug'] }}-faq-heading-{{ $index }}">
                                <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $landing['slug'] }}-faq-answer-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $landing['slug'] }}-faq-answer-{{ $index }}">
                                    {{ __($faq['question']) }}
                                </button>
                            </h3>
                            <div id="{{ $landing['slug'] }}-faq-answer-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $landing['slug'] }}-faq-heading-{{ $index }}" data-bs-parent="#{{ $landing['slug'] }}-faq">
                                <div class="accordion-body">{{ __($faq['answer']) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@section('page_cta')
<section class="azora-product-final-cta">
    <div class="container">
        <div class="azora-product-final-cta-inner">
            <span>{{ __($landing['cta_kicker']) }}</span>
            <h2>{{ __($landing['cta_title']) }}</h2>
            <p>{{ __($landing['cta_copy']) }}</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">{{ __('Create a Business Account') }}</a>
                <a href="{{ route($landing['guide_route']) }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-lg">{{ __('View Integration Guide') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
