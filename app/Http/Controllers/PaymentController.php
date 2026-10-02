<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CashfreeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        'method' => $request->method(),
        'url' => $request->fullUrl(),                   //test 
        'order_id' => $request->input('order_id'),
        'user_id' => Auth::id(),
    ]);
    
        $user = Auth::user();

        if (!$user) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login before making a payment.');
        }

        $validated = $request->validate([
            'order_id' => [
                'required',
                'integer',
            ],
        ]);

        $order = Order::where('id', $validated['order_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return redirect()
                ->route('user.orders')
                ->with('error', 'Order could not be found.');
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
    |
    | Customer originally selected Cash on Delivery.
    |
    | At delivery:
    |
    | Staff clicks:
    |
    |     Pay Online
    |
    | Cashfree Checkout opens.
    |
    | If payment succeeds:
    |
    |     payment_status = paid
    |     payment_method = online
    |
    | The staff can then complete the delivery.
    |
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
        | CUSTOMER INFORMATION
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
        | ASSIGN DELIVERY PARTNER
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
        | CANCELLED ORDER
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

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER EMAIL
        |--------------------------------------------------------------------------
        */

        $customerEmail =
            $user->email
            ?: 'customer@example.com';

        /*
        |--------------------------------------------------------------------------
        | UNIQUE CASHFREE ORDER ID
        |--------------------------------------------------------------------------
        */

        $cashfreeOrderId =
            ($source === 'staff'
                ? 'DELIVERY_'
                : 'BENSTOKE_')
            .
            $order->id
            .
            '_'
            .
            time()
            .
            '_'
            .
            random_int(1000, 9999);

        /*
        |--------------------------------------------------------------------------
        | CREATE CASHFREE ORDER
        |--------------------------------------------------------------------------
        */

        try {

            $cashfreeOrder = $this->cashfree->createOrder(
                $cashfreeOrderId,
                (float) $order->total_amount,
                'USER_' . $user->id,
                (string) $customerPhone,
                (string) $customerEmail,
                $source
            );

        } catch (\Throwable $e) {

            Log::error(
                'Cashfree order creation failed.',
                [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'source' => $source,
                    'error' => $e->getMessage(),
                ]
            );

            return back()->withErrors([
                'payment' =>
                    'Unable to start online payment. Please try again.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE CASHFREE ORDER ID
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
        | KEEP STAFF ASSIGNED
        |--------------------------------------------------------------------------
        */

        if ($source === 'staff') {
            $order->staff_id = Auth::id();
        }

        $order->save();

        /*
        |--------------------------------------------------------------------------
        | PAYMENT SESSION
        |--------------------------------------------------------------------------
        */

        $paymentSessionId =
            $cashfreeOrder['payment_session_id']
            ?? null;

        if (!$paymentSessionId) {

            Log::error(
                'Cashfree payment session ID missing.',
                [
                    'order_id' => $order->id,
                    'cashfree_order_id' =>
                        $order->cashfree_order_id,
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
        | PAYMENT PAGE
        |--------------------------------------------------------------------------
        */

        if ($source === 'staff') {

            return view(
                'staff.payment',
                [
                    'order' => $order,
                    'paymentSessionId' => $paymentSessionId,
                    'paymentSource' => 'staff',
                ]
            );
        }

        return view(
            'user.payment',
            [
                'order' => $order,
                'paymentSessionId' => $paymentSessionId,
                'paymentSource' => 'customer',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CASHFREE RETURN
    |--------------------------------------------------------------------------
    */

    public function return(Request $request)
    {
        $cashfreeOrderId =
            $request->query('order_id');

        $source =
            $request->query('source', 'customer');

        if (!$cashfreeOrderId) {

            if ($source === 'staff') {
                return redirect()
                    ->route('staff.dashboard')
                    ->with(
                        'error',
                        'Payment order information is missing.'
                    );
            }

            return redirect()
                ->route('user.orders')
                ->with(
                    'error',
                    'Payment order information is missing.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | FIND ORDER
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
                ]
            );

            if ($source === 'staff') {
                return redirect()
                    ->route('staff.dashboard')
                    ->with(
                        'error',
                        'Order could not be found.'
                    );
            }

            return redirect()
                ->route('user.orders')
                ->with(
                    'error',
                    'Order could not be found.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFY PAYMENT WITH CASHFREE
        |--------------------------------------------------------------------------
        */

        try {

            $payments =
                $this->cashfree->getPayments(
                    $cashfreeOrderId
                );

        } catch (\Throwable $e) {

            Log::error(
                'Cashfree payment verification failed.',
                [
                    'order_id' => $order->id,
                    'cashfree_order_id' =>
                        $cashfreeOrderId,
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
        | SUCCESS PAYMENT
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
        | PENDING PAYMENT
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
        | USER DROPPED
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
        | FAILED
        |--------------------------------------------------------------------------
        */

        $failedPayment =
            collect($payments)->first(
                function ($payment) {

                    $status = strtoupper(
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
                    |--------------------------------------------------------------
                    | PAYMENT SUCCESS
                    |--------------------------------------------------------------
                    */

                    $lockedOrder->payment_status =
                        'paid';

                    /*
                    |--------------------------------------------------------------
                    | IMPORTANT
                    |--------------------------------------------------------------
                    |
                    | If customer originally selected COD,
                    | this changes it to ONLINE.
                    |
                    */

                    $lockedOrder->payment_method =
                        'online';

                    $lockedOrder->payment_id =
                        $successfulPayment[
                            'cf_payment_id'
                        ]
                        ??
                        $successfulPayment[
                            'payment_id'
                        ]
                        ??
                        $lockedOrder->payment_id;

                    /*
                    |--------------------------------------------------------------
                    | DO NOT COMPLETE DELIVERY HERE
                    |--------------------------------------------------------------
                    |
                    | Staff still has to click Complete Delivery.
                    |
                    */

                    $lockedOrder->save();
                }
            );

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
                        'Online payment successful. Order #' .
                        $order->id .
                        ' is now marked as paid.'
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

            if ($order->payment_status !== 'paid') {

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

            if ($order->payment_status !== 'paid') {

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
        | FAILED
        |--------------------------------------------------------------------------
        */

        if ($failedPayment) {

            if ($order->payment_status !== 'paid') {

                $order->payment_status =
                    'failed';

                $order->payment_id =
                    $failedPayment[
                        'cf_payment_id'
                    ]
                    ??
                    $failedPayment[
                        'payment_id'
                    ]
                    ??
                    $order->payment_id;

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

        if ($order->payment_status !== 'paid') {

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
        Order $order,
        string $source,
        string $message
    ) {

        if ($source === 'staff') {

            return redirect()
                ->route('staff.dashboard')
                ->with(
                    'error',
                    $message
                );
        }

        if (Auth::check()) {

            return redirect()
                ->route('user.orders')
                ->with(
                    'error',
                    $message
                );
        }

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
        $rawBody =
            $request->getContent();

        $signature =
            $request->header(
                'x-webhook-signature'
            );

        $timestamp =
            $request->header(
                'x-webhook-timestamp'
            );

        /*
        |--------------------------------------------------------------------------
        | SIGNATURE CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$signature ||
            !$timestamp
        ) {

            Log::warning(
                'Cashfree webhook rejected: missing signature headers.'
            );

            return response()->json(
                [
                    'success' => false,
                    'message' =>
                        'Missing webhook signature.',
                ],
                401
            );
        }

        $secret =
            (string) config(
                'services.cashfree.client_secret'
            );

        if ($secret === '') {

            Log::error(
                'Cashfree webhook rejected: client secret missing.'
            );

            return response()->json(
                [
                    'success' => false,
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
                    'success' => false,
                    'message' =>
                        'Invalid webhook signature.',
                ],
                401
            );
        }

        /*
        |--------------------------------------------------------------------------
        | JSON
        |--------------------------------------------------------------------------
        */

        $payload =
            json_decode(
                $rawBody,
                true
            );

        if (!is_array($payload)) {

            return response()->json(
                [
                    'success' => false,
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

        if (!$cashfreeOrderId) {

            return response()->json(
                [
                    'success' => false,
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

            return response()->json([
                'success' => true,
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
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        if ($paymentStatus === 'SUCCESS') {

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
                    | Never downgrade paid order.
                    */

                    if (
                        $lockedOrder->payment_status
                        === 'paid'
                    ) {
                        return;
                    }

                    $lockedOrder->payment_status =
                        'paid';

                    /*
                    | COD → ONLINE
                    */

                    $lockedOrder->payment_method =
                        'online';

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
                'success' => true,
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
                'success' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | USER DROPPED
        |--------------------------------------------------------------------------
        */

        if (
            $paymentStatus ===
            'USER_DROPPED'
        ) {

            if (
                $order->payment_status !== 'paid'
            ) {

                $order->payment_status =
                    'pending';

                $order->save();
            }

            return response()->json([
                'success' => true,
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
                'success' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UNKNOWN
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
            ]
        );

        return response()->json([
            'success' => true,
        ]);
    }
}