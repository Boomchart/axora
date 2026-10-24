@extends('front.menu', ['title' => __('Gift Card API for Businesses')])

@section('seo_title', __('Gift Card API for Businesses - Azora'))
@section('meta_description', __('Access and distribute digital gift cards for rewards, incentives and customer payouts through the Azora business API.'))
@section('footer_description', __('Business infrastructure for distributing digital gift cards, mobile airtime and data through reliable APIs.'))

@php
    $landing = [
        'slug' => 'gift-cards',
        'service_name' => 'Azora Gift Card API',
        'meta_description' => 'Access and distribute digital gift cards for rewards, incentives and customer payouts through the Azora business API.',
        'icon' => 'bi-gift-fill',
        'eyebrow' => 'Gift Card API for Businesses',
        'headline' => 'Deliver digital gift cards through one business-ready API',
        'lead' => 'Build rewards, incentives and customer payout experiences with access to digital gift cards from leading brands across multiple markets and currencies.',
        'trust_points' => ['Sandbox access for integration testing', 'Documentation for every step', 'Support from onboarding to launch'],
        'visual_label' => 'Gift card API product overview',
        'visual_title' => 'Gift cards, ready for your product',
        'visual_copy' => 'Discover products, request a quote, place an order and track fulfilment from your application.',
        'visual_points' => [
            ['icon' => 'bi-search', 'label' => 'Browse catalog'],
            ['icon' => 'bi-receipt', 'label' => 'Get quotes'],
            ['icon' => 'bi-send-check', 'label' => 'Place orders'],
        ],
        'proof_points' => [
            ['title' => '3,000+ brands', 'copy' => 'A broad catalog for business reward and payout experiences'],
            ['title' => '40 countries', 'copy' => 'Products for customers, employees and partners in multiple markets'],
            ['title' => '25 currencies', 'copy' => 'Flexible options for international business use cases'],
        ],
        'use_cases_title' => 'Turn gift cards into a useful part of your customer experience',
        'use_cases_intro' => 'Use one integration to support the moments when your business needs to reward, recognise or compensate people.',
        'use_cases' => [
            ['icon' => 'bi-trophy', 'title' => 'Loyalty and rewards', 'copy' => 'Let customers exchange points, earnings or achievements for relevant digital gift cards.'],
            ['icon' => 'bi-people', 'title' => 'Employee incentives', 'copy' => 'Recognise teams and distribute business-approved rewards without manual fulfilment.'],
            ['icon' => 'bi-heart', 'title' => 'Customer care', 'copy' => 'Resolve service issues with digital compensation that can be delivered quickly.'],
            ['icon' => 'bi-shop', 'title' => 'Marketplaces', 'copy' => 'Add a gift card catalog to your platform and manage orders through your existing product flow.'],
        ],
        'capabilities_title' => 'The building blocks for gift card distribution',
        'capabilities_intro' => 'Azora gives product and operations teams the endpoints they need to build a controlled gift card experience.',
        'capabilities' => [
            ['title' => 'Catalog discovery', 'copy' => 'Retrieve available gift cards and product details for the markets you support.'],
            ['title' => 'Quotes before orders', 'copy' => 'Confirm availability and transaction details before submitting a purchase.'],
            ['title' => 'Order tracking', 'copy' => 'Follow transaction status and keep your own systems in sync.'],
            ['title' => 'Sandbox testing', 'copy' => 'Validate your integration before moving your business workflow to production.'],
        ],
        'endpoint_label' => 'Gift card order',
        'code_sample' => <<<'CODE'
POST /api/v1/giftcard-order
Authorization: Bearer your_api_key
Content-Type: application/json

{
  "data": [{
    "external_reference": "reward-001",
    "card_id": "gift-card-id",
    "quantity": 1,
    "amount": 25
  }]
}
CODE,
        'guide_route' => 'developer.guides.gift-cards',
        'steps' => [
            ['title' => 'Create your account', 'copy' => 'Register your business and access the environment prepared for integration.'],
            ['title' => 'Explore and integrate', 'copy' => 'Review the catalog and connect the required gift card endpoints to your product.'],
            ['title' => 'Complete onboarding', 'copy' => 'Finish business verification, move to production and place your first live order.'],
        ],
        'faq_title' => 'Gift card API questions',
        'faqs' => [
            ['question' => 'Who is the gift card API designed for?', 'answer' => 'It is designed for approved businesses, platforms and developers building rewards, incentives, marketplace or customer payout experiences.'],
            ['question' => 'Can we test before going live?', 'answer' => 'Yes. You can use the sandbox environment and documentation to validate your integration before requesting production access.'],
            ['question' => 'How do we know which products are available?', 'answer' => 'Your integration can retrieve the current product catalog and relevant product details for supported markets.'],
            ['question' => 'Do you support implementation questions?', 'answer' => 'Yes. The Azora team can assist with onboarding and integration questions as your business prepares to launch.'],
        ],
        'cta_kicker' => 'Build your reward experience',
        'cta_title' => 'Add business gift cards to your product',
        'cta_copy' => 'Create your account to explore the API, or review the integration guide with your development team.',
    ];
@endphp

@section('content')
    @include('front.pages.products._landing', ['landing' => $landing])
@endsection
