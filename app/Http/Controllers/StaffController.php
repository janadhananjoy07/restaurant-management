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
        |
        | Staff can see:
        |
        | 1. Unassigned active orders
        | 2. Orders assigned to themselves
        |
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

            /*
            |--------------------------------------------------------------------------
            | ASSIGN ORDER TO STAFF
            |--------------------------------------------------------------------------
            */

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
    */

    public function updateStatus(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE STATUS
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'status' => [
                'required',
                'in:confirmed,preparing,out_for_delivery,completed,cancelled',
            ],
        ], [
            'status.required' => 'Please select an order status.',

            'status.in' => 'The selected order status is invalid.',
        ]);

        $staffId = Auth::id();
        $newStatus = $validated['status'];

        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER INSIDE TRANSACTION
        |--------------------------------------------------------------------------
        */

        $result = DB::transaction(function () use (
            $id,
            $staffId,
            $newStatus
        ) {

            /*
            |--------------------------------------------------------------------------
            | LOCK ORDER
            |--------------------------------------------------------------------------
            */

            $order = Order::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

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
                    'message' => 'This order is assigned to another staff member.',
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

            /*
            |--------------------------------------------------------------------------
            | CHECK CURRENT STATUS
            |--------------------------------------------------------------------------
            */

            if (!array_key_exists($currentStatus, $allowedTransitions)) {
                return [
                    'success' => false,
                    'message' => 'The current order status is invalid.',
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | CHECK STATUS TRANSITION
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
            | ASSIGN UNASSIGNED ORDER
            |--------------------------------------------------------------------------
            */

            if ($order->staff_id === null) {
                $order->staff_id = $staffId;
            }

            /*
            |--------------------------------------------------------------------------
            | COMPLETED ORDER
            |--------------------------------------------------------------------------
            */

            if ($newStatus === 'completed') {
                $order->staff_id = $staffId;
                $order->delivered_by = $staffId;
            }

            /*
            |--------------------------------------------------------------------------
            | SAVE NEW STATUS
            |--------------------------------------------------------------------------
            */

            $order->status = $newStatus;

            $order->save();

            return [
                'success' => true,
                'message' =>
                    'Order #' . $order->id .
                    ' updated to ' .
                    ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $newStatus
                        )
                    ) .
                    '.',
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | HANDLE ERROR
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

