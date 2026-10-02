<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STAFF DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $staffId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | ACTIVE ORDERS
        |--------------------------------------------------------------------------
        */

        $activeOrders = Order::with([
            'user',
            'items.menuItem',
        ])
            ->whereIn('status', [
                'pending',
                'confirmed',
                'preparing',
                'out_for_delivery',
            ])
            ->where(function ($query) use ($staffId) {
                $query->whereNull('staff_id')
                    ->orWhere('staff_id', $staffId);
            })
            ->latest('created_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PREVIOUS / COMPLETED ORDERS
        |--------------------------------------------------------------------------
        */

        $previousOrders = Order::with([
            'user',
            'items.menuItem',
        ])
            ->where('status', 'completed')
            ->where('delivered_by', $staffId)
            ->latest('updated_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | NEW ORDERS
        |--------------------------------------------------------------------------
        */

        $newOrders = Order::where('status', 'pending')
            ->whereNull('staff_id')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | MY ACTIVE ORDERS
        |--------------------------------------------------------------------------
        */

        $myActiveOrders = Order::whereIn('status', [
            'pending',
            'confirmed',
            'preparing',
            'out_for_delivery',
        ])
            ->where('staff_id', $staffId)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | MY COMPLETED ORDERS
        |--------------------------------------------------------------------------
        */

        $myCompletedOrders = Order::where('status', 'completed')
            ->where('delivered_by', $staffId)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | COMPLETED TODAY
        |--------------------------------------------------------------------------
        */

        $completedToday = Order::where('status', 'completed')
            ->where('delivered_by', $staffId)
            ->whereDate('updated_at', today())
            ->count();

        return view('staff.dashboard', compact(
            'activeOrders',
            'previousOrders',
            'newOrders',
            'myActiveOrders',
            'myCompletedOrders',
            'completedToday'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | CLAIM ORDER
    |--------------------------------------------------------------------------
    */

    public function claimOrder($id)
    {
        $staffId = Auth::id();

        $success = DB::transaction(function () use ($id, $staffId) {

            $order = Order::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | ORDER MUST BE UNASSIGNED
            |--------------------------------------------------------------------------
            */

            if ($order->staff_id !== null) {
                return false;
            }

            /*
            |--------------------------------------------------------------------------
            | ORDER MUST BE ACTIVE
            |--------------------------------------------------------------------------
            */

            if (!in_array($order->status, [
                'pending',
                'confirmed',
                'preparing',
                'out_for_delivery',
            ], true)) {
                return false;
            }

            $order->staff_id = $staffId;
            $order->save();

            return true;
        });

        if (!$success) {
            return back()->withErrors([
                'order' => 'This order is no longer available to claim.',
            ]);
        }

        return back()->with(
            'success',
            'Order #' . $id . ' has been assigned to you.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE ORDER STATUS
    |--------------------------------------------------------------------------
    |
    | This method handles:
    |
    | confirmed
    | preparing
    | out_for_delivery
    | completed
    | cancelled
    |
    | For completed orders:
    |
    | cash          -> staff collected cash
    | upi           -> staff received UPI
    | already_paid  -> customer already paid online
    |
    | IMPORTANT:
    | "online" is NOT completed directly here.
    |
    | Online payment must first go through Cashfree.
    |
    |--------------------------------------------------------------------------
    */

    public function updateStatus(Request $request, $id)
{
    $validated = $request->validate([
        'status' => [
            'required',
            'in:confirmed,preparing,out_for_delivery,completed,cancelled',
        ],

        'payment_method' => [
            'nullable',
            'required_if:status,completed',
            'in:cash,upi,online,already_paid',
        ],
    ], [
        'status.required' =>
            'Please select an order status.',

        'status.in' =>
            'The selected order status is invalid.',

        'payment_method.required_if' =>
            'Please select how the payment was completed.',

        'payment_method.in' =>
            'The selected payment method is invalid.',
    ]);

    $staffId = Auth::id();

    $newStatus = $validated['status'];

    $paymentMethod =
        $validated['payment_method'] ?? null;


    /*
    |--------------------------------------------------------------------------
    | FIND ORDER FIRST
    |--------------------------------------------------------------------------
    |
    | We must check the current payment status before deciding whether
    | to redirect to Cashfree.
    |
    */

    $existingOrder = Order::find($id);

    if (!$existingOrder) {
        return back()->withErrors([
            'status' => 'Order could not be found.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STAFF OWNERSHIP CHECK
    |--------------------------------------------------------------------------
    */

    if (
        $existingOrder->staff_id !== null &&
        (int) $existingOrder->staff_id !== (int) $staffId
    ) {
        return back()->withErrors([
            'status' =>
                'This order is assigned to another delivery partner.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ONLINE PAYMENT
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | If the order is NOT paid yet and staff chooses Online,
    | open Cashfree.
    |
    | If the order is ALREADY paid through Cashfree,
    | DO NOT open Cashfree again.
    |
    | Allow the delivery to complete.
    |
    */

    if (
        $newStatus === 'completed' &&
        $paymentMethod === 'online' &&
        $existingOrder->payment_status !== 'paid'
    ) {
        return redirect()->route(
            'staff.payment.online',
            [
                'id' => $id,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TRANSACTION
    |--------------------------------------------------------------------------
    */

    $result = DB::transaction(function () use (
        $id,
        $staffId,
        $newStatus,
        $paymentMethod
    ) {

        $order = Order::where('id', $id)
            ->lockForUpdate()
            ->first();

        if (!$order) {
            return [
                'success' => false,
                'message' => 'Order could not be found.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | OWNERSHIP CHECK
        |--------------------------------------------------------------------------
        */

        if (
            $order->staff_id !== null &&
            (int) $order->staff_id !== (int) $staffId
        ) {
            return [
                'success' => false,
                'message' =>
                    'This order is assigned to another delivery partner.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | ALLOWED STATUS TRANSITIONS
        |--------------------------------------------------------------------------
        */

        $allowedTransitions = [

            'pending' => [
                'confirmed',
                'cancelled',
            ],

            'confirmed' => [
                'preparing',
                'cancelled',
            ],

            'preparing' => [
                'out_for_delivery',
            ],

            'out_for_delivery' => [
                'completed',
            ],

            'completed' => [],

            'cancelled' => [],
        ];


        $currentStatus = $order->status;


        if (!array_key_exists(
            $currentStatus,
            $allowedTransitions
        )) {
            return [
                'success' => false,
                'message' =>
                    'The current order status is invalid.',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS TRANSITION CHECK
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $newStatus,
            $allowedTransitions[$currentStatus],
            true
        )) {
            return [
                'success' => false,
                'message' =>
                    'Invalid order status transition. Current status: ' .
                    ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $currentStatus
                        )
                    ),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | ASSIGN STAFF
        |--------------------------------------------------------------------------
        */

        if ($order->staff_id === null) {
            $order->staff_id = $staffId;
        }


        /*
        |--------------------------------------------------------------------------
        | COMPLETE DELIVERY
        |--------------------------------------------------------------------------
        */

        if ($newStatus === 'completed') {

            if (!$paymentMethod) {
                return [
                    'success' => false,
                    'message' =>
                        'Please select a payment method before completing delivery.',
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | ALREADY PAID
            |--------------------------------------------------------------------------
            |
            | This includes:
            |
            | - Customer paid online before delivery
            | - Staff collected online payment through Cashfree
            |
            | Both are already paid.
            |
            */

            if ($paymentMethod === 'already_paid') {

                if ($order->payment_status !== 'paid') {
                    return [
                        'success' => false,
                        'message' =>
                            'This order is not marked as paid. Please collect Cash or UPI, or use Online Payment.',
                    ];
                }

                /*
                | Keep existing payment method.
                */
            }


            /*
            |--------------------------------------------------------------------------
            | ONLINE
            |--------------------------------------------------------------------------
            |
            | If we reach here with online, payment MUST already be paid.
            |
            */

            elseif ($paymentMethod === 'online') {

                if ($order->payment_status !== 'paid') {
                    return [
                        'success' => false,
                        'message' =>
                            'Online payment has not been completed.',
                    ];
                }

                $order->payment_method = 'online';

                $order->payment_status = 'paid';
            }


            /*
            |--------------------------------------------------------------------------
            | CASH
            |--------------------------------------------------------------------------
            */

            elseif ($paymentMethod === 'cash') {

                $order->payment_method = 'cash';

                $order->payment_status = 'paid';
            }


            /*
            |--------------------------------------------------------------------------
            | UPI
            |--------------------------------------------------------------------------
            */

            elseif ($paymentMethod === 'upi') {

                $order->payment_method = 'upi';

                $order->payment_status = 'paid';
            }


            /*
            |--------------------------------------------------------------------------
            | DELIVERY INFORMATION
            |--------------------------------------------------------------------------
            */

            $order->delivered_by = $staffId;

            $order->staff_id = $staffId;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */

        $order->status = $newStatus;

        $order->save();


        /*
        |--------------------------------------------------------------------------
        | SUCCESS MESSAGE
        |--------------------------------------------------------------------------
        */

        $message =
            'Order #' .
            $order->id .
            ' updated to ' .
            ucwords(
                str_replace(
                    '_',
                    ' ',
                    $newStatus
                )
            ) .
            '.';


        if ($newStatus === 'completed') {

            $paymentName = match ($paymentMethod) {

                'cash' =>
                    'Cash collected.',

                'upi' =>
                    'UPI payment received.',

                'already_paid' =>
                    'Payment was already completed.',

                'online' =>
                    'Online payment completed.',

                default =>
                    'Payment completed.',
            };

            $message .= ' ' . $paymentName;
        }


        return [
            'success' => true,
            'message' => $message,
        ];
    });


    /*
    |--------------------------------------------------------------------------
    | ERROR
    |--------------------------------------------------------------------------
    */

    if (!$result['success']) {
        return back()->withErrors([
            'status' => $result['message'],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    return back()->with(
        'success',
        $result['message']
    );
}
}

