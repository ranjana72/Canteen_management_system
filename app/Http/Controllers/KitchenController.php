<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KitchenController extends Controller
{
    /**
     * Kitchen dashboard — stat cards + active orders + ratings + feedback + popular items + low stock
     * Route: GET /kitchen/dashboard
     */
    public function dashboard()
    {
        // ---------------------------------------------------
        // Active orders (pending + confirmed + ready), newest first
        // ---------------------------------------------------
        $activeOrders = Order::with(['orderItems.menuItem', 'user'])
                             ->whereIn('status', ['pending', 'confirmed', 'ready'])
                             ->latest()
                             ->paginate(8);

        $pendingCount   = Order::where('status', 'pending')->count();
        $preparingCount = Order::where('status', 'confirmed')->count();
        $readyCount     = Order::where('status', 'ready')->count();
        $activeCount    = $pendingCount + $preparingCount + $readyCount;

        // ---------------------------------------------------
        // Today's sales — sum of paid orders placed today
        // ---------------------------------------------------
        $todaysOrders = Order::whereDate('created_at', today())->get();
        $todaysSales  = $todaysOrders->sum('total_amount');
        $todaysCount  = $todaysOrders->count();

        // ---------------------------------------------------
        // Average prep time — time between order creation and ready_at, today only
        // ---------------------------------------------------
        $avgPrepSeconds = Order::whereDate('created_at', today())
                               ->whereNotNull('ready_at')
                               ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, ready_at)) as avg_seconds')
                               ->value('avg_seconds');

        $avgPrepMinutes = $avgPrepSeconds ? round($avgPrepSeconds / 60) : 0;

        // ---------------------------------------------------
        // Ratings summary
        // ---------------------------------------------------
        $avgRating     = round(Feedback::avg('rating') ?? 0, 1);
        $totalRatings  = Feedback::count();

        $recentFeedback = Feedback::with(['user', 'menuItem'])
                                  ->latest()
                                  ->take(3)
                                  ->get();

        // ---------------------------------------------------
        // Popular items today — most ordered items today, by quantity
        // ---------------------------------------------------
        $popularItems = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('menu_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->whereDate('orders.created_at', today())
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('menu_items.name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // ---------------------------------------------------
        // Low stock alert — items with stock <= 5 (includes out of stock)
        // ---------------------------------------------------
        $lowStockItems = MenuItem::where('stock', '<=', 5)
                                 ->orderBy('stock')
                                 ->take(5)
                                 ->get();

        return view('kitchen.dashboard', compact(
            'activeOrders',
            'pendingCount',
            'preparingCount',
            'readyCount',
            'activeCount',
            'todaysSales',
            'todaysCount',
            'avgPrepMinutes',
            'avgRating',
            'totalRatings',
            'recentFeedback',
            'popularItems',
            'lowStockItems'
        ));
    }

    /**
     * All active orders — paginated table view
     * Route: GET /kitchen/orders
     */
    public function orders()
    {
        $orders = Order::with(['orderItems.menuItem', 'user'])
                       ->whereIn('status', ['pending', 'confirmed', 'ready'])
                       ->latest()
                       ->paginate(20);

        return view('kitchen.orders.index', compact('orders'));
    }

    /**
     * Accept order — mark as confirmed (kitchen is preparing)
     * Route: PATCH /kitchen/orders/{order}/confirm
     */
    public function confirm(Order $order)
    {
        $order->update(['status' => 'confirmed']);

        return back()->with('success', "Order {$order->order_number} accepted — now preparing.");
    }

    /**
     * Mark order as ready — food is prepared
     * Route: PATCH /kitchen/orders/{order}/ready
     */
    public function markReady(Order $order)
    {
        $order->update([
            'status'   => 'ready',
            'ready_at' => now(),
        ]);

        return back()->with('success', "Order {$order->order_number} is ready for pickup!");
    }

    /**
     * Mark order as delivered — student has picked it up
     * Route: PATCH /kitchen/orders/{order}/delivered
     */
    public function markDelivered(Order $order)
    {
        $order->update([
            'status' => 'delivered',
        ]);

        return back()->with('success', "Order {$order->order_number} marked as delivered.");
    }

    /**
     * View all payments — kitchen checks if student has paid
     * Route: GET /kitchen/payments
     */
    public function payments()
    {
        $payments = Payment::with(['order', 'user'])
                           ->latest()
                           ->paginate(20);

        return view('kitchen.payments.index', compact('payments'));
    }

    /**
     * View a single payment detail
     * Route: GET /kitchen/payments/{payment}
     */
    public function showPayment(Payment $payment)
    {
        $payment->load(['order.orderItems.menuItem', 'user']);

        return view('kitchen.payments.show', compact('payment'));
    }
}