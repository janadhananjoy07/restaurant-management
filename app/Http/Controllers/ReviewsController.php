<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Feedback::with('user')
            ->where('status', 'approved')
            ->whereNotNull('order_id')
            ->latest()
            ->paginate(9);

        $averageRating = Feedback::where('status', 'approved')
            ->whereNotNull('order_id')
            ->avg('rating');

        $totalReviews = Feedback::where('status', 'approved')
            ->whereNotNull('order_id')
            ->count();

        return view('reviews.index', compact(
            'reviews',
            'averageRating',
            'totalReviews'
        ));
    }
}