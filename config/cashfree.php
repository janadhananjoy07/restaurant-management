<?php

return [

    'mode' => env('CASHFREE_MODE', 'sandbox'),

    'client_id' => env('CASHFREE_CLIENT_ID'),

    'client_secret' => env('CASHFREE_CLIENT_SECRET'),

    'return_url' => env(
        'CASHFREE_RETURN_URL',
        'http://127.0.0.1:8000/payment/cashfree/return'
    ),

    'webhook_url' => env(
        'CASHFREE_WEBHOOK_URL',
        'http://127.0.0.1:8000/payment/cashfree/webhook'
    ),

];

