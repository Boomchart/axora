@extends('front.menu', ['title' => __('Airtime API for Businesses')])

@section('seo_title', __('Airtime API for Businesses - Azora'))
@section('meta_description', __('Send mobile airtime top-ups through the Azora business API for rewards, remittance, customer engagement and digital platforms.'))
@section('footer_description', __('Business infrastructure for distributing mobile airtime, data bundles and digital gift cards through reliable APIs.'))

@php
    $landing = [
        'slug' => 'airtime',
        'service_name' => 'Azora Airtime API',
        'meta_description' => 'Send mobile airtime top-ups through the Azora business API for rewards, remittance, customer engagement and digital platforms.',
        'icon' => 'bi-phone-fill',
        'eyebrow' => 'Airtime API for Businesses',
        'headline' => 'Send mobile airtime from your platform through one API',
        'lead' => 'Connect your business to mobile operators and deliver airtime top-ups as part of a rewards, remittance or customer engagement experience.',
        'trust_points' => ['Built for approved business use', 'Sandbox access for testing', 'Transaction-level status tracking'],
        'visual_label' => 'Airtime API product overview',
        'visual_title' => 'Airtime delivery, built into your workflow',
        'visual_copy' => 'Look up a mobile number, identify the operator, request a quote and submit the top-up from your application.',
        'visual_points' => [
            ['icon' => 'bi-search', 'label' => 'Number lookup'],
            ['icon' => 'bi-broadcast-pin', 'label' => 'Operator match'],
            ['icon' => 'bi-phone', 'label' => 'Instant top-up'],
        ],
        'proof_points' => [
            ['title' => 'Global reach', 'copy' => 'Connect to supported mobile operators across multiple countries'],
            ['title' => 'One API', 'copy' => 'Use a consistent integration flow across supported markets'],
            ['title' => 'Clear records', 'copy' => 'Track airtime orders and transaction status from your platform'],
        ],
        'use_cases_title' => 'Make airtime part of the service your business already provides',
        'use_cases_intro' => 'Support practical mobile value delivery without building separate operator connections for every market.',
        'use_cases' => [
            ['icon' => 'bi-globe2', 'title' => 'Remittance platforms', 'copy' => 'Give customers a direct way to send airtime to supported mobile numbers.'],
            ['icon' => 'bi-award', 'title' => 'Rewards programs', 'copy' => 'Offer airtime as an accessible reward within loyalty and engagement campaigns.'],
            ['icon' => 'bi-window-stack', 'title' => 'Digital platforms', 'copy' => 'Add airtime top-ups to an existing application, portal or service marketplace.'],
            ['icon' => 'bi-headset', 'title' => 'Customer engagement', 'copy' => 'Use airtime for promotions, service recovery and customer appreciation.'],
        ],
        'capabilities_title' => 'A reliable flow from lookup to fulfilment',
        'capabilities_intro' => 'Build the complete airtime journey with endpoints designed for business applications and operational visibility.',
        'capabilities' => [
            ['title' => 'Mobile number lookup', 'copy' => 'Check the destination and identify relevant service details before ordering.'],
            ['title' => 'Operator discovery', 'copy' => 'Retrieve supported operators and the information required for your top-up flow.'],
            ['title' => 'Quotes and orders', 'copy' => 'Review transaction details and submit airtime requests from your application.'],
            ['title' => 'Transaction history', 'copy' => 'Retrieve individual transactions or review your airtime activity over time.'],
        ],
        'endpoint_label' => 'Airtime order',
        'code_sample' => <<<'CODE'
POST /api/v1/airtime-order
Authorization: Bearer your_api_key
Content-Type: application/json

{
  "data": [{
    "external_reference": "topup-001",
    "operator_id": "airtime-operator-id",
    "amount": 1000,
    "phone": "09000000000",
    "phone_code": "NG"
  }]
}
CODE,
        'guide_route' => 'developer.guides.airtime',
        'steps' => [
            ['title' => 'Create your account', 'copy' => 'Register your business and access the sandbox environment for testing.'],
            ['title' => 'Build the top-up flow', 'copy' => 'Connect lookup, operator, quote and airtime order endpoints to your product.'],
            ['title' => 'Complete onboarding', 'copy' => 'Finish business verification, receive production access and send your first live top-up.'],
        ],
        'faq_title' => 'Airtime API questions',
        'faqs' => [
            ['question' => 'Who can use the airtime API?', 'answer' => 'The API is intended for approved businesses, platforms and developers integrating airtime into a legitimate business use case.'],
            ['question' => 'Can we check the operator before sending airtime?', 'answer' => 'Yes. The integration flow includes lookup and operator endpoints to help your application collect the appropriate order details.'],
            ['question' => 'Can airtime orders be tracked?', 'answer' => 'Yes. Transaction endpoints allow your system to retrieve airtime activity and the status of individual orders.'],
            ['question' => 'Is a sandbox available?', 'answer' => 'Yes. The sandbox and integration guide allow your development team to test the flow before requesting production access.'],
        ],
        'cta_kicker' => 'Launch your airtime experience',
        'cta_title' => 'Connect airtime delivery to your product',
        'cta_copy' => 'Create a business account to begin testing, or give the integration guide to your development team.',
    ];
@endphp

@section('content')
    @include('front.pages.products._landing', ['landing' => $landing])
@endsection
