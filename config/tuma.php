<?php

return [
    'base_url' => env('TUMA_BASE_URL', 'https://icrow.nexuraafrica.shop'),
    'api_key' => env('TUMA_API_KEY'),
    'auth_email' => env('TUMA_AUTH_EMAIL'),
    'bearer_token' => env('TUMA_BEARER_TOKEN'),
    'callback_url' => env('TUMA_CALLBACK_URL', env('APP_URL') . '/webhook/tuma'),
    'product_id' => env('TUMA_PRODUCT_ID'),
    'token_endpoint' => env('TUMA_TOKEN_ENDPOINT', '/api/auth/token'),
    'sale_endpoint' => env('TUMA_SALE_ENDPOINT', '/api/pos/payments/stk-push'),
    'payment_status_endpoint' => env('TUMA_PAYMENT_STATUS_ENDPOINT', '/api/pos/orders/{order_id}/payment-status'),
    'token_cache_ttl' => (int) env('TUMA_TOKEN_CACHE_TTL', 600),
];
