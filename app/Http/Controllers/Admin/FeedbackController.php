<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display customer feedback for admin moderation.
     */
    public function index()
    {
        $feedbacks = Feedback::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.feedback.index', compact('feedbacks'));
    }

    /**
     * Update the moderation status of a review.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $feedback = Feedback::findOrFail($id);

        $feedback->status = $request->status;
        $feedback->save();

        return redirect()
            ->route('admin.feedback.index')
            ->with('success', 'Review status updated successfully.');
    }
}
