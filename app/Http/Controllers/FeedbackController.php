<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Kitchen: view all feedback (reviews list)
     * Route: GET /kitchen/feedback
     */
    public function index()
    {
        $feedbacks = Feedback::with(['user', 'order', 'menuItem'])
                             ->latest()
                             ->paginate(20);

        return view('kitchen.feedback.index', compact('feedbacks'));
    }

    /**
     * Kitchen: view ratings summary (average, breakdown by star)
     * Route: GET /kitchen/ratings
     */
    public function ratings()
    {
        $average = Feedback::avg('rating') ?? 0;
        $total   = Feedback::count();

        // Count how many 5-star, 4-star, 3-star, 2-star, 1-star reviews exist
        $breakdown = Feedback::selectRaw('rating, COUNT(*) as count')
                             ->groupBy('rating')
                             ->pluck('count', 'rating');

        $recentFeedback = Feedback::with(['user', 'menuItem'])
                                  ->latest()
                                  ->take(10)
                                  ->get();

        return view('kitchen.feedback.ratings', compact('average', 'total', 'breakdown', 'recentFeedback'));
    }

    /**
     * Student: show the feedback form for a completed order
     * Route: GET /student/orders/{order}/feedback
     */
    public function create(Order $order)
    {
        return view('student.feedback.create', compact('order'));
    }

    /**
     * Student: submit feedback for an order
     * Route: POST /student/orders/{order}/feedback
     */
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Feedback::create([
            'user_id'  => auth()->id(),
            'order_id' => $order->id,
            'rating'   => $validated['rating'],
            'comment'  => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Thanks for your feedback!');
    }

    /**
     * Student: list orders ready for pickup or delivered that don't have feedback yet
     * Route: GET /student/feedback
     */
    public function studentIndex()
    {
        $pendingFeedbackOrders = Order::with('orderItems.menuItem')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['ready', 'delivered'])
            ->whereDoesntHave('feedbacks')
            ->latest()
            ->get();

        return view('student.feedback.index', compact('pendingFeedbackOrders'));
    }

    /**
     * Student: history of feedback this student has already submitted
     * Route: GET /student/ratings
     */
    public function studentRatings()
    {
        $myFeedback = Feedback::with('order.orderItems.menuItem')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $avgRating = $myFeedback->count() ? round($myFeedback->avg('rating'), 1) : 0;

        return view('student.ratings.index', compact('myFeedback', 'avgRating'));
    }
}