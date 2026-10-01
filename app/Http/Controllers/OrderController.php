<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER - CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkout()
    {
        $cartItems = CartItem::with('menuItem')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('user.cart')
                ->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return (float) $item->price * (int) $item->quantity;
        });

        return view(
            'user.checkout',
            compact('cartItems', 'total')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - PLACE ORDER
    |--------------------------------------------------------------------------
    */

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'address' => [
                'required',
                'string',
                'max:500',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],
        ], [
            'address.required' => 'Please enter your delivery address.',
            'address.max' => 'Delivery address cannot exceed 500 characters.',
            'phone.required' => 'Please enter your phone number.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
        ]);

        $cartItems = CartItem::with('menuItem')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('user.cart')
                ->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return (float) $item->price * (int) $item->quantity;
        });

        DB::transaction(function () use (
            $cartItems,
            $total,
            $validated
        ) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'address' => $validated['address'],
                'phone' => $validated['phone'],
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $cartItem->menu_item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);
            }

            CartItem::where(
                'user_id',
                auth()->id()
            )->delete();
        });

        return redirect()
            ->route('user.orders')
            ->with(
                'success',
                'Your order has been placed successfully!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | USER - ORDER HISTORY
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        $orders = Order::with([
            'items.menuItem',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'user.orders',
            compact('orders')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function adminDashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | ORDER STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalOrders = Order::count();

        $pendingOrders = Order::where(
            'status',
            'pending'
        )->count();

        $confirmedOrders = Order::where(
            'status',
            'confirmed'
        )->count();

        $preparingOrders = Order::where(
            'status',
            'preparing'
        )->count();

        $outForDeliveryOrders = Order::where(
            'status',
            'out_for_delivery'
        )->count();

        $completedOrders = Order::where(
            'status',
            'completed'
        )->count();

        $cancelledOrders = Order::where(
            'status',
            'cancelled'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::where(
            'role',
            'user'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | MENU STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalMenuItems = MenuItem::count();

        $availableMenuItems = MenuItem::where(
            'available',
            true
        )->count();


        /*
        |--------------------------------------------------------------------------
        | RESERVATION STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalReservations = Reservation::count();

        $pendingReservations = Reservation::where(
            'status',
            'pending'
        )->count();

        $confirmedReservations = Reservation::where(
            'status',
            'confirmed'
        )->count();

        $completedReservations = Reservation::where(
            'status',
            'completed'
        )->count();

        $cancelledReservations = Reservation::where(
            'status',
            'cancelled'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | REVENUE
        |--------------------------------------------------------------------------
        */

        $totalRevenue = Order::where(
            'status',
            'completed'
        )->sum('total_amount');


        /*
        |--------------------------------------------------------------------------
        | RECENT ORDERS
        |--------------------------------------------------------------------------
        */

        $recentOrders = Order::with([
            'user',
            'items.menuItem',
        ])
            ->latest()
            ->take(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RECENT RESERVATIONS
        |--------------------------------------------------------------------------
        */

        $recentReservations = Reservation::with('user')
            ->latest()
            ->take(5)
            ->get();


        return view(
            'admin.dashboard',
            compact(
                'totalOrders',

                'pendingOrders',
                'confirmedOrders',
                'preparingOrders',
                'outForDeliveryOrders',
                'completedOrders',
                'cancelledOrders',

                'totalUsers',

                'totalMenuItems',
                'availableMenuItems',

                'totalReservations',
                'pendingReservations',
                'confirmedReservations',
                'completedReservations',
                'cancelledReservations',

                'totalRevenue',

                'recentOrders',
                'recentReservations'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - ALL ORDERS
    |--------------------------------------------------------------------------
    */

    public function adminOrders(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ALLOWED FILTER VALUES
        |--------------------------------------------------------------------------
        */

        $allowedStatuses = [
            'pending',
            'confirmed',
            'preparing',
            'out_for_delivery',
            'completed',
            'cancelled',
        ];

        $allowedSorts = [
            'latest',
            'oldest',
            'amount_high',
            'amount_low',
        ];


        /*
        |--------------------------------------------------------------------------
        | FILTER INPUT
        |--------------------------------------------------------------------------
        |
        | Important:
        | Laravel's ConvertEmptyStringsToNull middleware converts
        | empty form values into NULL.
        |
        | We normalize everything back to strings before checking
        | whether the value is empty.
        |
        */

        $search = trim(
            (string) $request->input('search', '')
        );

        $status = trim(
            (string) $request->input('status', '')
        );

        $dateFrom = trim(
            (string) $request->input('date_from', '')
        );

        $dateTo = trim(
            (string) $request->input('date_to', '')
        );

        $sort = trim(
            (string) $request->input('sort', 'latest')
        );


        /*
        |--------------------------------------------------------------------------
        | NORMALIZE INVALID FILTER VALUES
        |--------------------------------------------------------------------------
        */

        if (!in_array($status, $allowedStatuses, true)) {
            $status = '';
        }

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'latest';
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE DATE FILTERS
        |--------------------------------------------------------------------------
        */

        if ($dateFrom !== '') {
            $fromDate = \DateTime::createFromFormat(
                'Y-m-d',
                $dateFrom
            );

            $isValidFromDate = $fromDate
                && $fromDate->format('Y-m-d') === $dateFrom;

            if (!$isValidFromDate) {
                $dateFrom = '';
            }
        }

        if ($dateTo !== '') {
            $toDate = \DateTime::createFromFormat(
                'Y-m-d',
                $dateTo
            );

            $isValidToDate = $toDate
                && $toDate->format('Y-m-d') === $dateTo;

            if (!$isValidToDate) {
                $dateTo = '';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $query = Order::with([
            'user',
            'items.menuItem',
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEARCH FILTER
        |--------------------------------------------------------------------------
        |
        | Search by:
        |
        | - Order ID
        | - Customer name
        | - Customer email
        | - Phone number
        |
        */

        if ($search !== '') {
            $query->where(function ($orderQuery) use ($search) {

                /*
                |--------------------------------------------------------------------------
                | ORDER ID
                |--------------------------------------------------------------------------
                */

                if (is_numeric($search)) {
                    $orderQuery->where(
                        'id',
                        (int) $search
                    );
                } else {
                    /*
                    |--------------------------------------------------------------
                    | If search is not numeric, don't add an invalid ID condition.
                    |--------------------------------------------------------------
                    */
                    $orderQuery->whereRaw(
                        '1 = 0'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | CUSTOMER NAME / EMAIL
                |--------------------------------------------------------------------------
                */

                $orderQuery->orWhereHas(
                    'user',
                    function ($userQuery) use ($search) {

                        $userQuery
                            ->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'email',
                                'like',
                                '%' . $search . '%'
                            );
                    }
                );


                /*
                |--------------------------------------------------------------------------
                | PHONE
                |--------------------------------------------------------------------------
                */

                $orderQuery->orWhere(
                    'phone',
                    'like',
                    '%' . $search . '%'
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($status !== '') {
            $query->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATE FROM FILTER
        |--------------------------------------------------------------------------
        */

        if ($dateFrom !== '') {
            $query->whereDate(
                'created_at',
                '>=',
                $dateFrom
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATE TO FILTER
        |--------------------------------------------------------------------------
        */

        if ($dateTo !== '') {
            $query->whereDate(
                'created_at',
                '<=',
                $dateTo
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATE RANGE SAFETY
        |--------------------------------------------------------------------------
        |
        | If both dates exist but date_from is after date_to,
        | don't generate an invalid/empty filter combination.
        |
        */

        if (
            $dateFrom !== '' &&
            $dateTo !== '' &&
            $dateFrom > $dateTo
        ) {
            /*
            |--------------------------------------------------------------
            | Swap the dates automatically.
            |--------------------------------------------------------------
            */

            [$dateFrom, $dateTo] = [
                $dateTo,
                $dateFrom,
            ];

            /*
            |--------------------------------------------------------------
            | Rebuild query because the previous date conditions
            | were based on the old order.
            |--------------------------------------------------------------
            */

            $query = Order::with([
                'user',
                'items.menuItem',
            ]);

            /*
            |--------------------------------------------------------------
            | Re-apply search
            |--------------------------------------------------------------
            */

            if ($search !== '') {
                $query->where(function ($orderQuery) use ($search) {

                    if (is_numeric($search)) {
                        $orderQuery->where(
                            'id',
                            (int) $search
                        );
                    } else {
                        $orderQuery->whereRaw(
                            '1 = 0'
                        );
                    }

                    $orderQuery->orWhereHas(
                        'user',
                        function ($userQuery) use ($search) {

                            $userQuery
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $search . '%'
                                );
                        }
                    );

                    $orderQuery->orWhere(
                        'phone',
                        'like',
                        '%' . $search . '%'
                    );
                });
            }

            /*
            |--------------------------------------------------------------
            | Re-apply status
            |--------------------------------------------------------------
            */

            if ($status !== '') {
                $query->where(
                    'status',
                    $status
                );
            }

            /*
            |--------------------------------------------------------------
            | Re-apply corrected date range
            |--------------------------------------------------------------
            */

            $query
                ->whereDate(
                    'created_at',
                    '>=',
                    $dateFrom
                )
                ->whereDate(
                    'created_at',
                    '<=',
                    $dateTo
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            case 'oldest':

                $query
                    ->orderBy('created_at', 'asc')
                    ->orderBy('id', 'asc');

                break;


            case 'amount_high':

                $query
                    ->orderByDesc('total_amount')
                    ->orderByDesc('id');

                break;


            case 'amount_low':

                $query
                    ->orderBy('total_amount', 'asc')
                    ->orderByDesc('id');

                break;


            case 'latest':

            default:

                $sort = 'latest';

                $query
                    ->orderByDesc('created_at')
                    ->orderByDesc('id');

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | 10 orders per page.
        |
        | withQueryString() keeps all filter values
        | when moving between pages.
        |
        */

        $orders = $query
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | GLOBAL SUMMARY STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalOrders = Order::count();

        $pendingCount = Order::where(
            'status',
            'pending'
        )->count();

        $confirmedCount = Order::where(
            'status',
            'confirmed'
        )->count();

        $preparingCount = Order::where(
            'status',
            'preparing'
        )->count();

        $outForDeliveryCount = Order::where(
            'status',
            'out_for_delivery'
        )->count();

        $completedCount = Order::where(
            'status',
            'completed'
        )->count();

        $cancelledCount = Order::where(
            'status',
            'cancelled'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | FILTERED ORDER COUNT
        |--------------------------------------------------------------------------
        */

        $filteredOrdersCount = $orders->total();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.orders.index',
            compact(
                'orders',

                'search',
                'status',
                'dateFrom',
                'dateTo',
                'sort',

                'totalOrders',
                'pendingCount',
                'confirmedCount',
                'preparingCount',
                'outForDeliveryCount',
                'completedCount',
                'cancelledCount',

                'filteredOrdersCount'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN - UPDATE ORDER STATUS
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        Request $request,
        $id
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,preparing,out_for_delivery,completed,cancelled',
            ],
        ], [
            'status.required' => 'Please select an order status.',
            'status.in' => 'The selected order status is invalid.',
        ]);

        $order = Order::findOrFail($id);

        $order->status = $validated['status'];

        $order->save();

        return redirect()
            ->route('admin.orders')
            ->with(
                'success',
                'Order #' . $order->id .
                ' status updated successfully!'
            );
    }
}

