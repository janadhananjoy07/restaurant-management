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
    |
    | COD:
    |   Checkout
    |   -> Create order
    |   -> payment_status = pending
    |   -> Orders
    |
    | ONLINE:
    |   Checkout
    |   -> Create order
    |   -> payment_status = pending
    |   -> Intermediate POST form
    |   -> PaymentController@create
    |   -> Cashfree
    |
    */

    public function placeOrder(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE CHECKOUT
        |--------------------------------------------------------------------------
        */

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

            'payment_method' => [
                'required',
                'in:cod,online',
            ],
        ], [
            'address.required' =>
                'Please enter your delivery address.',

            'address.max' =>
                'Delivery address cannot exceed 500 characters.',

            'phone.required' =>
                'Please enter your phone number.',

            'phone.max' =>
                'Phone number cannot exceed 20 characters.',

            'payment_method.required' =>
                'Please select a payment method.',

            'payment_method.in' =>
                'Invalid payment method selected.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | GET CURRENT USER CART
        |--------------------------------------------------------------------------
        */

        $cartItems = CartItem::with('menuItem')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('user.cart')
                ->with(
                    'error',
                    'Your cart is empty.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CALCULATE TOTAL
        |--------------------------------------------------------------------------
        */

        $total = $cartItems->sum(function ($item) {
            return (float) $item->price
                * (int) $item->quantity;
        });


        /*
        |--------------------------------------------------------------------------
        | CREATE ORDER
        |--------------------------------------------------------------------------
        */

        $order = DB::transaction(function () use (
            $cartItems,
            $total,
            $validated
        ) {

            $order = Order::create([
                'user_id' => auth()->id(),

                'total_amount' => $total,

                'status' => 'pending',

                'payment_status' => 'pending',

                'address' => $validated['address'],

                'phone' => $validated['phone'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | CREATE ORDER ITEMS
            |--------------------------------------------------------------------------
            */

            foreach ($cartItems as $cartItem) {

                OrderItem::create([
                    'order_id' => $order->id,

                    'menu_item_id' => $cartItem->menu_item_id,

                    'quantity' => $cartItem->quantity,

                    'price' => $cartItem->price,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | CLEAR CART
            |--------------------------------------------------------------------------
            */

            CartItem::where(
                'user_id',
                auth()->id()
            )->delete();


            return $order;
        });


        /*
        |--------------------------------------------------------------------------
        | CASH ON DELIVERY
        |--------------------------------------------------------------------------
        */

        if ($validated['payment_method'] === 'cod') {

            $order->update([
                'payment_status' => 'pending',
            ]);

            return redirect()
                ->route('user.orders')
                ->with(
                    'success',
                    'Order #' . $order->id .
                    ' placed successfully. Pay when your order is delivered.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ONLINE PAYMENT
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Do NOT use redirect()->route() here.
        |
        | payment.cashfree.create accepts POST only.
        |
        | We therefore show an intermediate page which automatically
        | submits a POST request to PaymentController@create.
        |
        */

        return view(
            'payment.cashfree-redirect',
            [
                'order' => $order,
            ]
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
            ->where(
                'user_id',
                auth()->id()
            )
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


        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD VIEW
        |--------------------------------------------------------------------------
        */

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
        | NORMALIZE FILTERS
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
        | VALIDATE DATE FROM
        |--------------------------------------------------------------------------
        */

        if ($dateFrom !== '') {

            $fromDate = \DateTime::createFromFormat(
                'Y-m-d',
                $dateFrom
            );

            $isValidFromDate =
                $fromDate &&
                $fromDate->format('Y-m-d') === $dateFrom;

            if (!$isValidFromDate) {
                $dateFrom = '';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE DATE TO
        |--------------------------------------------------------------------------
        */

        if ($dateTo !== '') {

            $toDate = \DateTime::createFromFormat(
                'Y-m-d',
                $dateTo
            );

            $isValidToDate =
                $toDate &&
                $toDate->format('Y-m-d') === $dateTo;

            if (!$isValidToDate) {
                $dateTo = '';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SWAP INVALID DATE RANGE
        |--------------------------------------------------------------------------
        */

        if (
            $dateFrom !== '' &&
            $dateTo !== '' &&
            $dateFrom > $dateTo
        ) {
            [$dateFrom, $dateTo] = [
                $dateTo,
                $dateFrom,
            ];
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
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $query->where(function ($orderQuery) use ($search) {

                /*
                |--------------------------------------------------------------
                | ORDER ID
                |--------------------------------------------------------------
                */

                if (is_numeric($search)) {

                    $orderQuery->where(
                        'id',
                        (int) $search
                    );
                }


                /*
                |--------------------------------------------------------------
                | CUSTOMER
                |--------------------------------------------------------------
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
                |--------------------------------------------------------------
                | PHONE
                |--------------------------------------------------------------
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
        | DATE FROM
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
        | DATE TO
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
        | SORTING
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            case 'oldest':

                $query
                    ->orderBy(
                        'created_at',
                        'asc'
                    )
                    ->orderBy(
                        'id',
                        'asc'
                    );

                break;


            case 'amount_high':

                $query
                    ->orderByDesc(
                        'total_amount'
                    )
                    ->orderByDesc(
                        'id'
                    );

                break;


            case 'amount_low':

                $query
                    ->orderBy(
                        'total_amount',
                        'asc'
                    )
                    ->orderByDesc(
                        'id'
                    );

                break;


            case 'latest':

            default:

                $sort = 'latest';

                $query
                    ->orderByDesc(
                        'created_at'
                    )
                    ->orderByDesc(
                        'id'
                    );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $orders = $query
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | GLOBAL SUMMARY
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
        | FILTERED COUNT
        |--------------------------------------------------------------------------
        */

        $filteredOrdersCount = $orders->total();


        /*
        |--------------------------------------------------------------------------
        | ADMIN ORDERS VIEW
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
            'status.required' =>
                'Please select an order status.',

            'status.in' =>
                'The selected order status is invalid.',
        ]);


        $order = Order::findOrFail($id);


        $order->update([
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('admin.orders')
            ->with(
                'success',
                'Order #' . $order->id .
                ' status updated successfully!'
            );
    }
}

