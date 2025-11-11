<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Razorpay API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Razorpay payment gateway integration
    |
    */

    'key' => env('RAZORPAY_KEY', ''),
    'secret' => env('RAZORPAY_SECRET', ''),
    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | Default currency for payments
    |
    */
    'currency' => 'INR',

    /*
    |--------------------------------------------------------------------------
    | Payment Options
    |--------------------------------------------------------------------------
    |
    | Configure available payment methods
    |
    */
    'payment_methods' => [
        'upi' => true,
        'card' => true,
        'netbanking' => true,
        'wallet' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Configuration
    |--------------------------------------------------------------------------
    |
    | Customize the Razorpay checkout theme
    |
    */
    'theme' => [
        'color' => '#4f46e5',
    ],

    /*
    |--------------------------------------------------------------------------
    | Company Details
    |--------------------------------------------------------------------------
    |
    | Your company details for payment receipts
    |
    */
    'company' => [
        'name' => env('APP_NAME', 'RoomMitra'),
        'logo' => env('APP_URL', 'http://localhost') . '/images/logo.png',
    ],
];
