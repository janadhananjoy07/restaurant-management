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
        $this->clientId =
            (string) config(
                'services.cashfree.client_id'
            );

        $this->clientSecret =
            (string) config(
                'services.cashfree.client_secret'
            );

        $this->apiVersion =
            (string) config(
                'services.cashfree.api_version',
                '2025-01-01'
            );

        $this->baseUrl =
            config(
                'services.cashfree.environment',
                'sandbox'
            ) === 'production'
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
        | RETURN URL
        |--------------------------------------------------------------------------
        */

        $returnUrl = route(
            'payment.cashfree.return',
            [
                'order_id' => $orderId,
                'source' => $source,
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
        | CASHFREE REQUEST
        |--------------------------------------------------------------------------
        */

        $response = Http::withHeaders([
            'x-client-id' =>
                $this->clientId,

            'x-client-secret' =>
                $this->clientSecret,

            'x-api-version' =>
                $this->apiVersion,

            'Accept' =>
                'application/json',

            'Content-Type' =>
                'application/json',
        ])->post(
            $this->baseUrl . '/orders',
            [
                'order_id' =>
                    $orderId,

                'order_amount' =>
                    round(
                        $amount,
                        2
                    ),

                'order_currency' =>
                    'INR',

                'customer_details' => [

                    'customer_id' =>
                        $customerId,

                    'customer_phone' =>
                        $customerPhone,

                    'customer_email' =>
                        $customerEmail,
                ],

                'order_meta' => [

                    'return_url' =>
                        $returnUrl,

                    'notify_url' =>
                        $notifyUrl,
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ERROR
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

        return $response->json();
    }


    /*
    |--------------------------------------------------------------------------
    | GET PAYMENTS
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
        ])->get(
            $this->baseUrl .
            '/orders/' .
            $orderId .
            '/payments'
        );

        if ($response->failed()) {

            throw new RuntimeException(
                'Cashfree payment status request failed: ' .
                $response->body()
            );
        }

        $data = $response->json();

        return is_array($data)
            ? $data
            : [];
    }
}