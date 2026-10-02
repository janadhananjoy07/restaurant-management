<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CashfreeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentController extends Controller
{
    protected CashfreeService $cashfree;

    public function __construct(CashfreeService $cashfree)
    {
        $this->cashfree = $cashfree;
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - CREATE CASHFREE PAYMENT
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        Log::info('CASHFREE CREATE CALLED', [
            'method'   => $request->method(),
            'url'      => $request->fullUrl(),
            'order_id' => $request->input('order_id'),
            'user_id'  => Auth::id(),
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Please login before making a payment.'
                );
        }

        $validated = $request->validate([
            'order_id' => [
                'required',
                'integer',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | FIND CUSTOMER ORDER
        |--------------------------------------------------------------------------
        */

        $order = Order::where('id', $validated['order_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return redirect()
                ->route('user.orders')
                ->with(
                    'error',
                    'Order could not be found.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | ALREADY PAID
        |--------------------------------------------------------------------------
        */

        if ($order->payment_status === 'paid') {
            return redirect()
                ->route('user.orders')
                ->with(
                    'success',
                    'This order has already been paid.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CANCELLED ORDER
        |--------------------------------------------------------------------------
        */

        if ($order->status === 'cancelled') {
            return redirect()
                ->route('user.orders')
                ->with(
                    'error',
                    'Cancelled orders cannot be paid.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE CASHFREE PAYMENT
        |--------------------------------------------------------------------------
        */

        return $this->createCashfreePayment(
            $order,
            $user,
            'customer'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STAFF - CREATE ONLINE PAYMENT DURING DELIVERY
    |--------------------------------------------------------------------------
    */

    public function staffOnlinePayment($id)
    {
        $staff = Auth::user();

        if (!$staff) {
            return redirect()
                ->route('staff.login')
                ->with(
                    'error',
                    'Please login as staff.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | FIND ORDER
        |--------------------------------------------------------------------------
        */

        $order = Order::with('user')
            ->where('id', $id)
            ->first();

        if (!$order) {
            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'error',
                    'Order could not be found.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | STAFF OWNERSHIP
        |--------------------------------------------------------------------------
        */

        if (
            $order->staff_id !== null &&
            (int) $order->staff_id !== (int) $staff->id
        ) {
            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'error',
                    'This order is assigned to another delivery partner.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | ORDER MUST BE OUT FOR DELIVERY
        |--------------------------------------------------------------------------
        */

        if ($order->status !== 'out_for_delivery') {
            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'error',
                    'Online payment can only be collected when the order is out for delivery.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | ALREADY PAID
        |--------------------------------------------------------------------------
        */

        if ($order->payment_status === 'paid') {
            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'success',
                    'This order has already been paid.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER
        |--------------------------------------------------------------------------
        */

        $customer = $order->user;

        if (!$customer) {
            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'error',
                    'Customer information could not be found.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | ASSIGN DELIVERY STAFF
        |--------------------------------------------------------------------------
        */

        if ($order->staff_id === null) {
            $order->staff_id = $staff->id;
            $order->save();
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE CASHFREE PAYMENT
        |--------------------------------------------------------------------------
        */

        return $this->createCashfreePayment(
            $order,
            $customer,
            'staff'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COMMON CASHFREE PAYMENT CREATION
    |--------------------------------------------------------------------------
    */

    private function createCashfreePayment(
        Order $order,
        $user,
        string $source = 'customer'
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALID SOURCE
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $source,
            ['customer', 'staff'],
            true
        )) {
            $source = 'customer';
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER CHECK
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return back()->withErrors([
                'payment' =>
                    'Customer information could not be found.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CANCELLED
        |--------------------------------------------------------------------------
        */

        if ($order->status === 'cancelled') {
            return back()->withErrors([
                'payment' =>
                    'Cancelled orders cannot be paid.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ALREADY PAID
        |--------------------------------------------------------------------------
        */

        if ($order->payment_status === 'paid') {
            return back()->with(
                'success',
                'This order has already been paid.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATE ORDER AMOUNT
        |--------------------------------------------------------------------------
        */

        $amount = round(
            (float) $order->total_amount,
            2
        );

        if ($amount <= 0) {
            Log::error(
                'Cashfree payment rejected because order amount is invalid.',
                [
                    'order_id' => $order->id,
                    'amount'   => $amount,
                ]
            );

            return back()->withErrors([
                'payment' =>
                    'Invalid order amount.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER PHONE
        |--------------------------------------------------------------------------
        */

        $customerPhone =
            $order->phone
            ?: ($user->phone ?? null);

        if (!$customerPhone) {
            return back()->withErrors([
                'payment' =>
                    'Customer phone number is missing.',
            ]);
        }

        $customerPhone = trim(
            (string) $customerPhone
        );

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER EMAIL
        |--------------------------------------------------------------------------
        */

        $customerEmail =
            $user->email
            ?: 'customer@example.com';

        $customerEmail = trim(
            (string) $customerEmail
        );

        /*
        |--------------------------------------------------------------------------
        | CASHFREE ORDER ID
        |--------------------------------------------------------------------------
        */

        $prefix =
            $source === 'staff'
                ? 'DELIVERY_'
                : 'BENSTOKE_';

        $cashfreeOrderId =
            $prefix
            . $order->id
            . '_'
            . now()->format('YmdHis')
            . '_'
            . random_int(1000, 9999);

        /*
        |--------------------------------------------------------------------------
        | CREATE CASHFREE ORDER
        |--------------------------------------------------------------------------
        */

        try {

            $cashfreeOrder =
                $this->cashfree->createOrder(
                    $cashfreeOrderId,
                    $amount,
                    'USER_' . $user->id,
                    $customerPhone,
                    $customerEmail,
                    $source
                );

        } catch (Throwable $e) {

            Log::error(
                'Cashfree order creation failed.',
                [
                    'order_id' =>
                        $order->id,

                    'user_id' =>
                        $user->id,

                    'source' =>
                        $source,

                    'amount' =>
                        $amount,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return back()->withErrors([
                'payment' =>
                    'Unable to start online payment. Please try again.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT SESSION ID
        |--------------------------------------------------------------------------
        */

        $paymentSessionId =
            $cashfreeOrder['payment_session_id']
            ?? null;

        if (!$paymentSessionId) {

            Log::error(
                'Cashfree payment session ID missing.',
                [
                    'order_id' =>
                        $order->id,

                    'cashfree_order_id' =>
                        $cashfreeOrderId,

                    'cashfree_response' =>
                        $cashfreeOrder,
                ]
            );

            return back()->withErrors([
                'payment' =>
                    'Cashfree payment session could not be created.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE CASHFREE ORDER
        |--------------------------------------------------------------------------
        */

        $order->cashfree_order_id =
            $cashfreeOrder['order_id']
            ?? $cashfreeOrderId;

        /*
        |--------------------------------------------------------------------------
        | PAYMENT PENDING
        |--------------------------------------------------------------------------
        */

        $order->payment_status = 'pending';

        /*
        |--------------------------------------------------------------------------
        | PAYMENT METHOD
        |--------------------------------------------------------------------------
        |
        | We do not mark the order paid here.
        | Payment is marked paid only after server-side verification.
        |
        */

        if ($source === 'staff') {
            $order->staff_id = Auth::id();
        }

        $order->save();

        /*
        |--------------------------------------------------------------------------
        | PAYMENT PAGE
        |--------------------------------------------------------------------------
        */

        $viewData = [
            'order' =>
                $order,

            'paymentSessionId' =>
                $paymentSessionId,

            'paymentSource' =>
                $source,
        ];

        if ($source === 'staff') {
            return view(
                'staff.payment',
                $viewData
            );
        }

        return view(
            'user.payment',
            $viewData
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CASHFREE RETURN
    |--------------------------------------------------------------------------
    */

    public function return(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CASHFREE ORDER ID
        |--------------------------------------------------------------------------
        */

        $cashfreeOrderId =
            trim(
                (string) $request->query('order_id')
            );

        /*
        |--------------------------------------------------------------------------
        | PAYMENT SOURCE
        |--------------------------------------------------------------------------
        */

        $source =
            (string) $request->query(
                'source',
                'customer'
            );

        if (!in_array(
            $source,
            ['customer', 'staff'],
            true
        )) {
            $source = 'customer';
        }

        /*
        |--------------------------------------------------------------------------
        | ORDER ID MISSING
        |--------------------------------------------------------------------------
        */

        if ($cashfreeOrderId === '') {

            return $this->paymentReturnRedirect(
                null,
                $source,
                'Payment order information is missing.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FIND LOCAL ORDER
        |--------------------------------------------------------------------------
        */

        $order = Order::where(
            'cashfree_order_id',
            $cashfreeOrderId
        )->first();

        if (!$order) {

            Log::warning(
                'Cashfree return order not found.',
                [
                    'cashfree_order_id' =>
                        $cashfreeOrderId,

                    'source' =>
                        $source,
                ]
            );

            return $this->paymentReturnRedirect(
                null,
                $source,
                'Order could not be found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFY PAYMENT FROM CASHFREE
        |--------------------------------------------------------------------------
        |
        | Never trust the browser return alone.
        | Cashfree recommends checking payment status from the server.
        |
        */

        try {

            $payments =
                $this->cashfree->getPayments(
                    $cashfreeOrderId
                );

        } catch (Throwable $e) {

            Log::error(
                'Cashfree payment verification failed.',
                [
                    'order_id' =>
                        $order->id,

                    'cashfree_order_id' =>
                        $cashfreeOrderId,

                    'source' =>
                        $source,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return $this->paymentReturnRedirect(
                $order,
                $source,
                'Unable to verify your payment right now.'
            );
        }

        if (!is_array($payments)) {
            $payments = [];
        }

        /*
        |--------------------------------------------------------------------------
        | FIND SUCCESS PAYMENT
        |--------------------------------------------------------------------------
        */

        $successfulPayment =
            collect($payments)->first(
                function ($payment) {

                    return strtoupper(
                        (string) (
                            $payment['payment_status']
                            ?? ''
                        )
                    ) === 'SUCCESS';
                }
            );

        /*
        |--------------------------------------------------------------------------
        | FIND PENDING PAYMENT
        |--------------------------------------------------------------------------
        */

        $pendingPayment =
            collect($payments)->first(
                function ($payment) {

                    return strtoupper(
                        (string) (
                            $payment['payment_status']
                            ?? ''
                        )
                    ) === 'PENDING';
                }
            );

        /*
        |--------------------------------------------------------------------------
        | FIND USER DROPPED PAYMENT
        |--------------------------------------------------------------------------
        */

        $userDroppedPayment =
            collect($payments)->first(
                function ($payment) {

                    return strtoupper(
                        (string) (
                            $payment['payment_status']
                            ?? ''
                        )
                    ) === 'USER_DROPPED';
                }
            );

        /*
        |--------------------------------------------------------------------------
        | FIND FAILED PAYMENT
        |--------------------------------------------------------------------------
        */

        $failedPayment =
            collect($payments)->first(
                function ($payment) {

                    $status =
                        strtoupper(
                            (string) (
                                $payment['payment_status']
                                ?? ''
                            )
                        );

                    return in_array(
                        $status,
                        [
                            'FAILED',
                            'CANCELLED',
                        ],
                        true
                    );
                }
            );

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        if ($successfulPayment) {

            /*
            |--------------------------------------------------------------------------
            | VERIFY PAYMENT AMOUNT
            |--------------------------------------------------------------------------
            */

            $paymentAmount =
                $successfulPayment['payment_amount']
                ?? $successfulPayment['order_amount']
                ?? null;

            $expectedAmount =
                round(
                    (float) $order->total_amount,
                    2
                );

            if (
                $paymentAmount !== null &&
                round(
                    (float) $paymentAmount,
                    2
                ) !== $expectedAmount
            ) {

                Log::critical(
                    'Cashfree payment amount mismatch.',
                    [
                        'order_id' =>
                            $order->id,

                        'cashfree_order_id' =>
                            $cashfreeOrderId,

                        'expected_amount' =>
                            $expectedAmount,

                        'received_amount' =>
                            $paymentAmount,
                    ]
                );

                return $this->paymentReturnRedirect(
                    $order,
                    $source,
                    'Payment amount verification failed. Please contact support.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | SAVE PAID STATUS
            |--------------------------------------------------------------------------
            */

            DB::transaction(
                function () use (
                    $order,
                    $successfulPayment
                ) {

                    $lockedOrder =
                        Order::where(
                            'id',
                            $order->id
                        )
                        ->lockForUpdate()
                        ->first();

                    if (!$lockedOrder) {
                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | NEVER DOWNGRADE PAID ORDER
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $lockedOrder->payment_status
                        === 'paid'
                    ) {
                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | MARK PAID
                    |--------------------------------------------------------------------------
                    */

                    $lockedOrder->payment_status =
                        'paid';

                    /*
                    |--------------------------------------------------------------------------
                    | ONLINE PAYMENT
                    |--------------------------------------------------------------------------
                    */

                    $lockedOrder->payment_method =
                        'online';

                    /*
                    |--------------------------------------------------------------------------
                    | PAYMENT ID
                    |--------------------------------------------------------------------------
                    */

                    $paymentId =
                        $successfulPayment['cf_payment_id']
                        ?? $successfulPayment['payment_id']
                        ?? null;

                    if ($paymentId) {
                        $lockedOrder->payment_id =
                            $paymentId;
                    }

                    $lockedOrder->save();
                }
            );

            /*
            |--------------------------------------------------------------------------
            | REFRESH ORDER
            |--------------------------------------------------------------------------
            */

            $order->refresh();

            Log::info(
                'Cashfree payment successful.',
                [
                    'order_id' =>
                        $order->id,

                    'cashfree_order_id' =>
                        $cashfreeOrderId,

                    'source' =>
                        $source,

                    'payment_id' =>
                        $order->payment_id,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | STAFF RETURN
            |--------------------------------------------------------------------------
            */

            if ($source === 'staff') {

                return redirect()
                    ->route('staff.dashboard')
                    ->with(
                        'success',
                        'Online payment successful. Order #'
                        . $order->id
                        . ' is now marked as paid.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | CUSTOMER RETURN
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('user.orders')
                ->with(
                    'success',
                    'Payment successful! Your order has been confirmed.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PENDING
        |--------------------------------------------------------------------------
        */

        if ($pendingPayment) {

            if (
                $order->payment_status !== 'paid'
            ) {
                $order->payment_status =
                    'pending';

                $order->save();
            }

            return $this->paymentReturnRedirect(
                $order,
                $source,
                'Payment is still pending. Please check again shortly.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | USER DROPPED
        |--------------------------------------------------------------------------
        */

        if ($userDroppedPayment) {

            if (
                $order->payment_status !== 'paid'
            ) {
                $order->payment_status =
                    'pending';

                $order->save();
            }

            return $this->paymentReturnRedirect(
                $order,
                $source,
                'Payment was not completed. You can try again.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FAILED / CANCELLED
        |--------------------------------------------------------------------------
        */

        if ($failedPayment) {

            if (
                $order->payment_status !== 'paid'
            ) {

                $order->payment_status =
                    'failed';

                $paymentId =
                    $failedPayment['cf_payment_id']
                    ?? $failedPayment['payment_id']
                    ?? null;

                if ($paymentId) {
                    $order->payment_id =
                        $paymentId;
                }

                $order->save();
            }

            return $this->paymentReturnRedirect(
                $order,
                $source,
                'Payment failed. You can try again.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | UNKNOWN STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $order->payment_status !== 'paid'
        ) {
            $order->payment_status =
                'pending';

            $order->save();
        }

        return $this->paymentReturnRedirect(
            $order,
            $source,
            'Payment status is not final yet.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT RETURN REDIRECT
    |--------------------------------------------------------------------------
    */

    private function paymentReturnRedirect(
        ?Order $order,
        string $source,
        string $message
    ) {
        /*
        |--------------------------------------------------------------------------
        | STAFF
        |--------------------------------------------------------------------------
        */

        if ($source === 'staff') {

            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'error',
                    $message
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {

            return redirect()
                ->route('user.orders')
                ->with(
                    'error',
                    $message
                );
        }

        /*
        |--------------------------------------------------------------------------
        | GUEST
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('home')
            ->with(
                'error',
                $message
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CASHFREE WEBHOOK
    |--------------------------------------------------------------------------
    */

    public function webhook(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | RAW BODY
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Signature must be calculated using the ORIGINAL raw request body.
        |
        */

        $rawBody =
            $request->getContent();

        /*
        |--------------------------------------------------------------------------
        | CASHFREE SIGNATURE HEADERS
        |--------------------------------------------------------------------------
        */

        $signature =
            trim(
                (string) $request->header(
                    'x-webhook-signature'
                )
            );

        $timestamp =
            trim(
                (string) $request->header(
                    'x-webhook-timestamp'
                )
            );

        /*
        |--------------------------------------------------------------------------
        | CHECK SIGNATURE HEADERS
        |--------------------------------------------------------------------------
        */

        if (
            $signature === '' ||
            $timestamp === ''
        ) {

            Log::warning(
                'Cashfree webhook rejected: missing signature headers.'
            );

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Missing webhook signature.',
                ],
                401
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CASHFREE SECRET
        |--------------------------------------------------------------------------
        */

        $secret =
            trim(
                (string) config(
                    'services.cashfree.client_secret'
                )
            );

        if ($secret === '') {

            Log::error(
                'Cashfree webhook rejected: client secret missing.'
            );

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Webhook configuration error.',
                ],
                500
            );
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFY SIGNATURE
        |--------------------------------------------------------------------------
        |
        | Cashfree webhook signature:
        |
        | Base64(
        |     HMAC-SHA256(
        |         timestamp + rawBody,
        |         clientSecret
        |     )
        | )
        |
        */

        $expectedSignature =
            base64_encode(
                hash_hmac(
                    'sha256',
                    $timestamp . $rawBody,
                    $secret,
                    true
                )
            );

        if (
            !hash_equals(
                $expectedSignature,
                $signature
            )
        ) {

            Log::warning(
                'Cashfree webhook rejected: invalid signature.'
            );

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Invalid webhook signature.',
                ],
                401
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PARSE JSON
        |--------------------------------------------------------------------------
        */

        $payload =
            json_decode(
                $rawBody,
                true
            );

        if (!is_array($payload)) {

            Log::warning(
                'Cashfree webhook rejected: invalid JSON payload.'
            );

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Invalid webhook payload.',
                ],
                400
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CASHFREE ORDER ID
        |--------------------------------------------------------------------------
        */

        $cashfreeOrderId =
            data_get(
                $payload,
                'data.order.order_id'
            )
            ??
            data_get(
                $payload,
                'order_id'
            );

        $cashfreeOrderId =
            trim(
                (string) $cashfreeOrderId
            );

        if ($cashfreeOrderId === '') {

            Log::warning(
                'Cashfree webhook rejected: order ID missing.',
                [
                    'payload' =>
                        $payload,
                ]
            );

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'Order ID missing.',
                ],
                400
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FIND LOCAL ORDER
        |--------------------------------------------------------------------------
        */

        $order =
            Order::where(
                'cashfree_order_id',
                $cashfreeOrderId
            )->first();

        if (!$order) {

            Log::warning(
                'Cashfree webhook order not found.',
                [
                    'cashfree_order_id' =>
                        $cashfreeOrderId,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Return 200 so Cashfree does not repeatedly retry an unknown
            | order that does not belong to this application.
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' =>
                    true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT STATUS
        |--------------------------------------------------------------------------
        */

        $paymentStatus =
            strtoupper(
                (string) (
                    data_get(
                        $payload,
                        'data.payment.payment_status'
                    )
                    ??
                    data_get(
                        $payload,
                        'payment_status'
                    )
                    ??
                    ''
                )
            );

        /*
        |--------------------------------------------------------------------------
        | PAYMENT ID
        |--------------------------------------------------------------------------
        */

        $paymentId =
            data_get(
                $payload,
                'data.payment.cf_payment_id'
            )
            ??
            data_get(
                $payload,
                'cf_payment_id'
            );

        /*
        |--------------------------------------------------------------------------
        | SUCCESS WEBHOOK
        |--------------------------------------------------------------------------
        */

        if ($paymentStatus === 'SUCCESS') {

            /*
            |--------------------------------------------------------------------------
            | VERIFY AMOUNT IF PRESENT
            |--------------------------------------------------------------------------
            */

            $webhookAmount =
                data_get(
                    $payload,
                    'data.payment.payment_amount'
                );

            $expectedAmount =
                round(
                    (float) $order->total_amount,
                    2
                );

            if (
                $webhookAmount !== null &&
                round(
                    (float) $webhookAmount,
                    2
                ) !== $expectedAmount
            ) {

                Log::critical(
                    'Cashfree webhook payment amount mismatch.',
                    [
                        'order_id' =>
                            $order->id,

                        'cashfree_order_id' =>
                            $cashfreeOrderId,

                        'expected_amount' =>
                            $expectedAmount,

                        'received_amount' =>
                            $webhookAmount,
                    ]
                );

                return response()->json(
                    [
                        'success' =>
                            false,

                        'message' =>
                            'Payment amount mismatch.',
                    ],
                    400
                );
            }

            /*
            |--------------------------------------------------------------------------
            | TRANSACTION
            |--------------------------------------------------------------------------
            */

            DB::transaction(
                function () use (
                    $order,
                    $paymentId
                ) {

                    $lockedOrder =
                        Order::where(
                            'id',
                            $order->id
                        )
                        ->lockForUpdate()
                        ->first();

                    if (!$lockedOrder) {
                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | IDEMPOTENCY
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $lockedOrder->payment_status
                        === 'paid'
                    ) {
                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | MARK PAID
                    |--------------------------------------------------------------------------
                    */

                    $lockedOrder->payment_status =
                        'paid';

                    /*
                    |--------------------------------------------------------------------------
                    | ONLINE PAYMENT
                    |--------------------------------------------------------------------------
                    */

                    $lockedOrder->payment_method =
                        'online';

                    /*
                    |--------------------------------------------------------------------------
                    | PAYMENT ID
                    |--------------------------------------------------------------------------
                    */

                    if ($paymentId) {
                        $lockedOrder->payment_id =
                            $paymentId;
                    }

                    $lockedOrder->save();
                }
            );

            Log::info(
                'Cashfree SUCCESS webhook processed.',
                [
                    'order_id' =>
                        $order->id,

                    'cashfree_order_id' =>
                        $cashfreeOrderId,

                    'payment_id' =>
                        $paymentId,
                ]
            );

            return response()->json([
                'success' =>
                    true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PENDING
        |--------------------------------------------------------------------------
        */

        if ($paymentStatus === 'PENDING') {

            if (
                $order->payment_status !== 'paid'
            ) {

                $order->payment_status =
                    'pending';

                $order->save();
            }

            return response()->json([
                'success' =>
                    true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | USER DROPPED
        |--------------------------------------------------------------------------
        */

        if ($paymentStatus === 'USER_DROPPED') {

            if (
                $order->payment_status !== 'paid'
            ) {

                $order->payment_status =
                    'pending';

                $order->save();
            }

            return response()->json([
                'success' =>
                    true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FAILED / CANCELLED
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $paymentStatus,
                [
                    'FAILED',
                    'CANCELLED',
                ],
                true
            )
        ) {

            if (
                $order->payment_status !== 'paid'
            ) {

                $order->payment_status =
                    'failed';

                if ($paymentId) {
                    $order->payment_id =
                        $paymentId;
                }

                $order->save();
            }

            return response()->json([
                'success' =>
                    true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UNKNOWN STATUS
        |--------------------------------------------------------------------------
        */

        Log::warning(
            'Cashfree webhook received unknown payment status.',
            [
                'order_id' =>
                    $order->id,

                'cashfree_order_id' =>
                    $cashfreeOrderId,

                'payment_status' =>
                    $paymentStatus,

                'payload' =>
                    $payload,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ACKNOWLEDGE WEBHOOK
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' =>
                true,
        ]);
    }
}

