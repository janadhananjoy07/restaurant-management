<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Show completed orders that have not been reviewed.
     */
    public function index()
    {
        $pendingOrders = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->whereDoesntHave('feedback')
            ->latest()
            ->get();

        return view('user.feedback.index', compact('pendingOrders'));
    }

    /**
     * Save feedback for a completed order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:3', 'max:1000'],

            'aspects' => ['nullable', 'array'],
            'aspects.*' => [
                'string',
                'in:Food Quality,Taste,Packaging,Portion Size,Value for Money,Service',
            ],

            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        // Ensure the order belongs to the logged-in user
        // and is completed.
        $order = Order::where('id', $validated['order_id'])
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->firstOrFail();

        // Do not allow a second review for the same order.
        if ($order->feedback()->exists()) {
            return redirect()
                ->route('feedback')
                ->with(
                    'success',
                    'Feedback has already been submitted for this order.'
                );
        }

        // Store optional images.
        $imagePaths = [];

        foreach ($request->file('images', []) as $image) {
            $imagePaths[] = $image->store('feedback', 'public');
        }

        // Save feedback with the matching order_id.
        Feedback::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'aspects' => $validated['aspects'] ?? [],
            'images' => $imagePaths ?? [],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('feedback')
            ->with(
                'success',
                'Thank you! Your order feedback has been submitted.'
            );
    }

    /**
     * Dismiss the dashboard feedback popup for an order.
     */
    public function dismiss(Order $order)
    {
        abort_unless(
            (int) $order->user_id === (int) auth()->id(),
            403
        );

        abort_unless($order->status === 'completed', 404);

        // Only dismiss if feedback has not already been submitted.
        if (!$order->feedback()->exists()) {
            $order->feedback_prompt_dismissed_at = now();
            $order->save();
        }

        return back();
    }
}