<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id'     => null,
        'client_secret' => null,
        'redirect'      => null
    ],

    'facebook' => [
        'client_id' => null,
        'client_secret' => null,
        'redirect' => null,
    ],

    'reloadly' => [
        'client_id' => env('RELOADLY_CLIENT_ID'),
        'client_secret' => env('RELOADLY_CLIENT_SECRET'),
        'auth_url' => env('RELOADLY_AUTH_URL', 'https://auth.reloadly.com'),
        'airtime_url' => env('RELOADLY_AIRTIME_URL', 'https://topups.reloadly.com'),
        'base_url' => env('RELOADLY_GIFTCARDS_URL', 'https://giftcards.reloadly.com'),
        'audience' => env('RELOADLY_GIFTCARDS_AUDIENCE', 'https://giftcards.reloadly.com'),
        'timeout' => (int) env('RELOADLY_TIMEOUT', 30),
    ],

    'redboxx' => [
        'base_url' => env('REDBOXX_URL'),
        'api_key' => env('REDBOXX_API_KEY'),
        'webhook_hash' => env('REDBOXX_WEBHOOK_HASH'),
    ],

    'hasapay' => [
        'base_url' => env('HASAPAY_URL'),
        'api_key' => env('HASAPAY_API_KEY'),
        'secret_key' => env('HASAPAY_SECRET_KEY'),
        'webhook_hash' => env('HASAPAY_WEBHOOK_HASH'),
    ]
];
