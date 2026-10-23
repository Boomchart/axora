@extends('front.menu', ['title' => __('Data Bundle API for Businesses')])

@section('seo_title', __('Data Bundle API for Businesses - Azora'))
@section('meta_description', __('Deliver mobile data bundles through the Azora business API for digital platforms, rewards, customer engagement and mobile services.'))
@section('footer_description', __('Business infrastructure for distributing mobile data, airtime and digital gift cards through reliable APIs.'))

@php
    $landing = [
        'slug' => 'data',
        'service_name' => 'Azora Data Bundle API',
        'meta_description' => 'Deliver mobile data bundles through the Azora business API for digital platforms, rewards, customer engagement and mobile services.',
        'icon' => 'bi-reception-4',
        'eyebrow' => 'Data Bundle API for Businesses',
        'headline' => 'Deliver mobile data bundles from your business application',
        'lead' => 'Add mobile data distribution to your product with an API for operator discovery, bundle selection, ordering and transaction tracking.',
        'trust_points' => ['Business-focused integration', 'Sandbox access for testing', 'Documentation and onboarding support'],
        'visual_label' => 'Data bundle API product overview',
        'visual_title' => 'Data bundles, connected to your product',
        'visual_copy' => 'Find the destination operator, retrieve available bundles and submit the order from your application.',
        'visual_points' => [
            ['icon' => 'bi-broadcast-pin', 'label' => 'Find operator'],
            ['icon' => 'bi-list-check', 'label' => 'Select bundle'],
            ['icon' => 'bi-reception-4', 'label' => 'Deliver data'],
        ],
        'proof_points' => [
            ['title' => 'Multiple markets', 'copy' => 'Serve supported mobile destinations through one integration'],
            ['title' => 'Bundle discovery', 'copy' => 'Retrieve available data options for the relevant operator'],
            ['title' => 'Order visibility', 'copy' => 'Track bundle purchases and transaction status from your system'],
        ],
        'use_cases_title' => 'Give customers and teams access to useful mobile connectivity',
        'use_cases_intro' => 'Integrate mobile data where it adds practical value to your platform, campaign or business workflow.',
        'use_cases' => [
            ['icon' => 'bi-grid', 'title' => 'Service marketplaces', 'copy' => 'Let approved users select and purchase available data bundles inside your platform.'],
            ['icon' => 'bi-stars', 'title' => 'Loyalty rewards', 'copy' => 'Offer mobile data as a useful redemption option for customers and community members.'],
            ['icon' => 'bi-megaphone', 'title' => 'Promotional campaigns', 'copy' => 'Use data bundles in acquisition, retention and customer appreciation programs.'],
            ['icon' => 'bi-briefcase', 'title' => 'Business support', 'copy' => 'Distribute connectivity to field teams, partners or approved beneficiaries.'],
        ],
        'capabilities_title' => 'Build a clear data bundle ordering journey',
        'capabilities_intro' => 'Use focused endpoints to identify the mobile service, present available bundles and record each transaction.',
        'capabilities' => [
            ['title' => 'Destination lookup', 'copy' => 'Identify relevant service information before presenting bundle options.'],
            ['title' => 'Operator and bundle discovery', 'copy' => 'Retrieve supported operators and the data products available for them.'],
            ['title' => 'Quotes and orders', 'copy' => 'Confirm transaction details and submit the selected bundle from your application.'],
            ['title' => 'Transaction reporting', 'copy' => 'Retrieve individual orders and maintain visibility across your data activity.'],
        ],
        'endpoint_label' => 'Data bundle order',
        'code_sample' => <<<'CODE'
POST /api/v1/data-order
Authorization: Bearer your_api_key
Content-Type: application/json

{
  "data": [{
    "external_reference": "data-001",
    "operator_id": "data-operator-id",
    "amount": 1000,
    "phone": "09000000000",
    "phone_code": "NG"
  }]
}
CODE,
        'guide_route' => 'developer.guides.data',
        'steps' => [
            ['title' => 'Create your account', 'copy' => 'Register your business and get access to the sandbox environment.'],
            ['title' => 'Build the bundle flow', 'copy' => 'Connect lookup, operator, quote and data order endpoints to your application.'],
            ['title' => 'Complete onboarding', 'copy' => 'Finish business verification, move to production and deliver your first live bundle.'],
        ],
        'faq_title' => 'Data bundle API questions',
        'faqs' => [
            ['question' => 'Who is the data API intended for?', 'answer' => 'It is intended for approved businesses, platforms and developers with a legitimate mobile data distribution use case.'],
            ['question' => 'Can our application show available bundles?', 'answer' => 'Yes. Your integration can retrieve supported operator information and the relevant bundle options for the destination.'],
            ['question' => 'Can we monitor data orders?', 'answer' => 'Yes. Transaction endpoints help your system retrieve individual orders and maintain a record of data activity.'],
            ['question' => 'Can we test the integration first?', 'answer' => 'Yes. Use the sandbox environment and data integration guide before requesting production access.'],
        ],
        'cta_kicker' => 'Build a connected product',
        'cta_title' => 'Add mobile data bundles to your platform',
        'cta_copy' => 'Create a business account to begin testing, or review the integration guide with your development team.',
    ];
@endphp

@section('content')
    @include('front.pages.products._landing', ['landing' => $landing])
@endsection
