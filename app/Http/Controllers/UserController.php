<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Recommended menu items
        $recommendedItems = MenuItem::where('available', true)
            ->latest()
            ->take(4)
            ->get();

        // User's orders
        $userOrders = Order::where('user_id', $user->id)->get();

        // Total table reservations
        $totalBookings = Reservation::where('user_id', $user->id)
            ->count();

        // Completed orders only
        $completedOrders = $userOrders->where('status', 'completed');

        $completedOrderCount = $completedOrders->count();

        // Total spent on completed orders
        $totalSpent = $completedOrders->sum(function ($order) {
            return (float) $order->total_amount;
        });

        // ₹100 spent = 2 reward points
        $rewardPoints = floor($totalSpent / 100) * 2;

        // Loyalty tier based on completed order count
        if ($completedOrderCount >= 10) {
            $loyaltyTier = 'Gold Member';
        } elseif ($completedOrderCount >= 5) {
            $loyaltyTier = 'Silver Member';
        } else {
            $loyaltyTier = 'Normal Member';
        }

        // Completed orders without feedback
        $pendingFeedbackOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereDoesntHave('feedback')
            ->latest()
            ->get();

        // Latest eligible order for the feedback popup
        $activeFeedbackOrder = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereDoesntHave('feedback')
            ->whereNull('feedback_prompt_dismissed_at')
            ->latest()
            ->first();

        return view('user.dashboard', compact(
            'recommendedItems',
            'loyaltyTier',
            'totalBookings',
            'rewardPoints',
            'totalSpent',
            'pendingFeedbackOrders',
            'activeFeedbackOrder'
        ));
    }

    /**
     * Display the authenticated user's order history.
     */
    public function orders()
    {
        $orders = Order::with([
            'items.menuItem',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.orders', compact('orders'));
    }

    /**
     * Display restaurant menu with filters.
     */
    public function menu(Request $request)
    {
        // Selected item from dashboard
        $selectedItemId = $request->query('item');

        // Filter values
        $search = trim((string) $request->query('search', ''));
        $category = trim((string) $request->query('category', ''));
        $subcategory = trim(
            (string) $request->query('subcategory', '')
        );

        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $priceRange = $request->query('price_range');

        // Base query
        $query = MenuItem::where('available', true);

        // Search by dish name or description
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        // Category filter
        if ($category !== '') {
            $query->where('category', $category);
        }

        // Subcategory filter
        if ($subcategory !== '') {
            $query->where('subcategory', $subcategory);
        }

        // Quick price-range filter
        switch ($priceRange) {
            case 'under_100':
                $query->where('price', '<', 100);
                break;

            case '100_250':
                $query->whereBetween('price', [100, 250]);
                break;

            case '250_500':
                $query->whereBetween('price', [250, 500]);
                break;

            case 'above_500':
                $query->where('price', '>', 500);
                break;
        }

        // Custom minimum price
        if (
            $minPrice !== null &&
            $minPrice !== '' &&
            is_numeric($minPrice)
        ) {
            $query->where('price', '>=', (float) $minPrice);
        }

        // Custom maximum price
        if (
            $maxPrice !== null &&
            $maxPrice !== '' &&
            is_numeric($maxPrice)
        ) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        // Get filtered menu items
        $menuItems = $query
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        // Move selected dashboard item to the top
        if ($selectedItemId) {
            $selectedItem = $menuItems->firstWhere(
                'id',
                (int) $selectedItemId
            );

            if ($selectedItem) {
                $menuItems = collect([$selectedItem])
                    ->merge(
                        $menuItems->where(
                            'id',
                            '!=',
                            $selectedItem->id
                        )
                    )
                    ->values();
            }
        }

        // Dynamic categories
        $categories = MenuItem::where('available', true)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Dynamic subcategories
        $subcategoryQuery = MenuItem::where('available', true)
            ->whereNotNull('subcategory')
            ->where('subcategory', '!=', '');

        if ($category !== '') {
            $subcategoryQuery->where('category', $category);
        }

        $subcategories = $subcategoryQuery
            ->select('subcategory')
            ->distinct()
            ->orderBy('subcategory')
            ->pluck('subcategory');

        $resultCount = $menuItems->count();

        return view('user.menu', compact(
            'menuItems',
            'selectedItemId',
            'search',
            'category',
            'subcategory',
            'minPrice',
            'maxPrice',
            'priceRange',
            'categories',
            'subcategories',
            'resultCount'
        ));
    }

    /**
     * Display user's profile.
     */
    public function profile()
    {
        return view('user.profile');
    }

    /**
     * Update user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('user.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | BOOK TABLE
    |--------------------------------------------------------------------------
    */

    /**
     * Display the book table page.
     */
    public function showBookTable()
    {
        return view('user.book-table');
    }

    /**
     * Save a new table reservation.
     */
    public function bookTable(Request $request)
    {
        $validated = $request->validate([
            'guests' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],

            'date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'time' => [
                'required',
                'date_format:H:i',
            ],
        ]);

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'guests' => $validated['guests'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.reservations')
            ->with(
                'success',
                'Your table has been booked successfully! Reservation #' .
                $reservation->id
            );
    }

    /*
    |--------------------------------------------------------------------------
    | MY RESERVATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Display logged-in user's reservations.
     */
    public function reservations()
    {
        $reservations = Reservation::where(
            'user_id',
            auth()->id()
        )
            ->latest()
            ->get();

        return view(
            'user.reservations',
            compact('reservations')
        );
    }

    /**
     * Cancel user's reservation.
     */
    public function cancelReservation($id)
    {
        $reservation = Reservation::where(
            'user_id',
            auth()->id()
        )
            ->where('id', $id)
            ->firstOrFail();

        // Only pending reservations can be cancelled
        if ($reservation->status !== 'pending') {
            return redirect()
                ->route('user.reservations')
                ->with(
                    'error',
                    'Only pending reservations can be cancelled.'
                );
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('user.reservations')
            ->with(
                'success',
                'Reservation cancelled successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN RESERVATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Display all reservations for admin.
     */
    public function adminReservations()
    {
        $reservations = Reservation::with('user')
            ->latest()
            ->get();

        return view(
            'admin.reservations.index',
            compact('reservations')
        );
    }

    /**
     * Update reservation status from admin panel.
     */
    public function updateReservationStatus(
        Request $request,
        $id
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,completed,cancelled',
            ],
        ]);

        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.reservations')
            ->with(
                'success',
                'Reservation status updated successfully.'
            );
    }
}
