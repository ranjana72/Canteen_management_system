<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Student dashboard — real data, same tables Kitchen uses.
     * Route: GET /student/dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();

        // ---------------------------------------------------
        // Today's Menu — same source Kitchen manages (is_available)
        // ---------------------------------------------------
        $allAvailableItems = MenuItem::where('is_available', true)->latest()->get();
        $todaysMenu         = $allAvailableItems->take(4);
        $todaysMenuCount    = $allAvailableItems->count();

        // ---------------------------------------------------
        // My Orders — this student's active orders
        // ---------------------------------------------------
        $myActiveOrdersCount = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'ready'])
            ->count();

        // ---------------------------------------------------
        // Recent Orders — last 3 orders placed by this student
        // ---------------------------------------------------
        $recentOrders = Order::with('orderItems.menuItem')
            ->where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        // ---------------------------------------------------
        // Active Order — most recent not-yet-picked-up order (status tracker panel)
        // ---------------------------------------------------
        $activeOrder = Order::with('orderItems.menuItem')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'ready'])
            ->latest()
            ->first();

        // ---------------------------------------------------
        // Popular Items — most-ordered items overall
        // (now includes image so the dashboard can render a thumbnail)
        // ---------------------------------------------------
        $popularItems = DB::table('order_items')
            ->join('menu_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->select(
                'menu_items.id',
                'menu_items.name',
                'menu_items.image',
                DB::raw('SUM(order_items.quantity) as total_qty')
            )
            ->groupBy('menu_items.id', 'menu_items.name', 'menu_items.image')
            ->orderByDesc('total_qty')
            ->take(4)
            ->get();

        // ---------------------------------------------------
        // Latest Announcement
        // ---------------------------------------------------
        $announcement = Notification::latest()->first();

        return view('student.dashboard', compact(
            'todaysMenu',
            'todaysMenuCount',
            'myActiveOrdersCount',
            'recentOrders',
            'activeOrder',
            'popularItems',
            'announcement'
        ));
    }
}