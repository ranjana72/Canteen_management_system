<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Daily Report — today's orders broken down by status, with totals
     * Route: GET /kitchen/reports/daily
     */
    public function daily(Request $request)
    {
        $date = $request->query('date') ? \Carbon\Carbon::parse($request->query('date')) : today();

        $orders = Order::with(['orderItems.menuItem', 'user'])
                       ->whereDate('created_at', $date)
                       ->latest()
                       ->get();

        $totalOrders  = $orders->count();
        $totalRevenue = $orders->sum('total_amount');

        $statusBreakdown = $orders->groupBy('status')->map->count();

        $itemsSold = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('menu_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->whereDate('orders.created_at', $date)
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->groupBy('menu_items.name')
            ->orderByDesc('total_qty')
            ->get();

        return view('kitchen.reports.daily', compact(
            'date',
            'orders',
            'totalOrders',
            'totalRevenue',
            'statusBreakdown',
            'itemsSold'
        ));
    }

    /**
     * Sales Report — revenue over a date range, grouped by day
     * Route: GET /kitchen/reports/sales
     */
    public function sales(Request $request)
    {
        $from = $request->query('from')
            ? \Carbon\Carbon::parse($request->query('from'))
            : today()->subDays(6);

        $to = $request->query('to')
            ? \Carbon\Carbon::parse($request->query('to'))
            : today();

        $dailySales = Order::whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(total_amount) as revenue'), DB::raw('COUNT(*) as order_count'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $totalRevenue = $dailySales->sum('revenue');
        $totalOrders  = $dailySales->sum('order_count');

        $paidTotal = Payment::whereBetween('created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->where('status', 'paid')
            ->sum('amount');

        return view('kitchen.reports.sales', compact(
            'from',
            'to',
            'dailySales',
            'totalRevenue',
            'totalOrders',
            'paidTotal'
        ));
    }

    /**
     * Items Report — every menu item's sales performance over a date range
     * Route: GET /kitchen/reports/items
     */
    public function items(Request $request)
    {
        $from = $request->query('from')
            ? \Carbon\Carbon::parse($request->query('from'))
            : today()->subDays(29);

        $to = $request->query('to')
            ? \Carbon\Carbon::parse($request->query('to'))
            : today();

        $sort = in_array($request->query('sort'), ['qty', 'revenue', 'name'])
            ? $request->query('sort')
            : 'qty';

        $query = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('menu_items', 'menu_items.id', '=', 'order_items.menu_item_id')
            ->whereBetween('orders.created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->select(
                'menu_items.id',
                'menu_items.name',
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as order_count')
            )
            ->groupBy('menu_items.id', 'menu_items.name');

        switch ($sort) {
            case 'revenue':
                $query->orderByDesc('total_revenue');
                break;
            case 'name':
                $query->orderBy('menu_items.name');
                break;
            default:
                $query->orderByDesc('total_qty');
                break;
        }

        $items = $query->get();

        $totalQty     = $items->sum('total_qty');
        $totalRevenue = $items->sum('total_revenue');
        $totalItems   = $items->count();

        return view('kitchen.reports.items', compact(
            'from',
            'to',
            'sort',
            'items',
            'totalQty',
            'totalRevenue',
            'totalItems'
        ));
    }
}