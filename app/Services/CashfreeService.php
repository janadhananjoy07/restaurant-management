<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class CashfreeService
{
    protected string $baseUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected string $apiVersion;

    public function __construct()
    {
        $this->clientId = trim(
            (string) config('services.cashfree.client_id')
        );

        $this->clientSecret = trim(
            (string) config('services.cashfree.client_secret')
        );

        $this->apiVersion = trim(
            (string) config(
                'services.cashfree.api_version',
                '2025-01-01'
            )
        );

        $environment = strtolower(
            trim(
                (string) config(
                    'services.cashfree.environment',
                    'sandbox'
                )
            )
        );

        $this->baseUrl =
            $environment === 'production'
                ? 'https://api.cashfree.com/pg'
                : 'https://sandbox.cashfree.com/pg';

        if (
            $this->clientId === '' ||
            $this->clientSecret === ''
        ) {
            throw new RuntimeException(
                'Cashfree API credentials are missing from the .env file.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE CASHFREE ORDER
    |--------------------------------------------------------------------------
    */

    public function createOrder(
        string $orderId,
        float $amount,
        string $customerId,
        string $customerPhone,
        string $customerEmail,
        string $source = 'customer'
    ): array {

        /*
        |--------------------------------------------------------------------------
        | NORMALIZE SOURCE
        |--------------------------------------------------------------------------
        */

        $source = strtolower(trim($source));

        if (!in_array($source, ['customer', 'staff'], true)) {
            $source = 'customer';
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN URL
        |--------------------------------------------------------------------------
        |
        | Cashfree redirects the customer/staff browser here after payment.
        |
        | Cashfree appends:
        |
        | ?order_id=YOUR_CASHFREE_ORDER_ID
        |
        |--------------------------------------------------------------------------
        */

        $returnUrl = route(
            'payment.cashfree.return',
            [
                'order_id' => $orderId,
                'source'   => $source,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | WEBHOOK URL
        |--------------------------------------------------------------------------
        */

        $notifyUrl = route(
            'payment.cashfree.webhook'
        );

        /*
        |--------------------------------------------------------------------------
        | CASHFREE CREATE ORDER REQUEST
        |--------------------------------------------------------------------------
        */

        $response = Http::withHeaders([
            'x-client-id'     => $this->clientId,
            'x-client-secret' => $this->clientSecret,
            'x-api-version'   => $this->apiVersion,
            'Accept'          => 'application/json',
            'Content-Type'    => 'application/json',
        ])
        ->timeout(30)
        ->post(
            $this->baseUrl . '/orders',
            [
                'order_id' => $orderId,

                'order_amount' => round(
                    $amount,
                    2
                ),

                'order_currency' => 'INR',

                'customer_details' => [

                    'customer_id' => $customerId,

                    'customer_phone' => $customerPhone,

                    'customer_email' => $customerEmail,
                ],

                'order_meta' => [

                    'return_url' => $returnUrl,

                    'notify_url' => $notifyUrl,
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | CASHFREE ERROR
        |--------------------------------------------------------------------------
        */

        if ($response->failed()) {

            throw new RuntimeException(
                'Cashfree order creation failed: ' .
                $response->body()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        $data = $response->json();

        if (!is_array($data)) {

            throw new RuntimeException(
                'Invalid response received from Cashfree.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT SESSION CHECK
        |--------------------------------------------------------------------------
        */

        if (
            empty(
                $data['payment_session_id']
                ?? null
            )
        ) {

            throw new RuntimeException(
                'Cashfree did not return a payment session ID.'
            );
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | GET PAYMENTS FOR ORDER
    |--------------------------------------------------------------------------
    */

    public function getPayments(
        string $orderId
    ): array {

        $response = Http::withHeaders([
            'x-client-id' =>
                $this->clientId,

            'x-client-secret' =>
                $this->clientSecret,

            'x-api-version' =>
                $this->apiVersion,

            'Accept' =>
                'application/json',
        ])
        ->timeout(30)
        ->get(
            $this->baseUrl .
            '/orders/' .
            $orderId .
            '/payments'
        );

        /*
        |--------------------------------------------------------------------------
        | ERROR
        |--------------------------------------------------------------------------
        */

        if ($response->failed()) {

            throw new RuntimeException(
                'Cashfree payment status request failed: ' .
                $response->body()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        $data = $response->json();

        if (!is_array($data)) {
            return [];
        }

        return $data;
    }
}