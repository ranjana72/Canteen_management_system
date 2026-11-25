<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * index() — Student sees their own orders, Admin sees all orders
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $orders = Order::with(['user', 'orderItems.menuItem'])
                           ->latest()
                           ->paginate(20);

            return view('admin.orders.index', compact('orders'));
        }

        // Student: only their own orders
        $orders = auth()->user()->orders()
                        ->with('orderItems.menuItem')
                        ->latest()
                        ->paginate(10);

        return view('student.orders.index', compact('orders'));
    }

    /**
     * create() — Show the "Place Order" form (student only)
     */
    public function create()
    {
        $menuItems = MenuItem::where('is_available', true)->get();

        return view('student.orders.create', compact('menuItems'));
    }

    /**
     * store() — Save a new order with its items
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items'                  => 'required|array|min:1',
            'items.*.menu_item_id'   => 'nullable|exists:menu_items,id',
            'items.*.quantity'       => 'nullable|integer|min:1',
            'note'                   => 'nullable|string|max:500',
            'phone'                  => 'nullable|string|max:20',
        ]);

        // Filter out empty rows (rows where no item was selected)
        $items = collect($validated['items'])
                    ->filter(fn ($row) => !empty($row['menu_item_id']));

        if ($items->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Please select at least one item to order.');
        }

        // Generate the next order number, e.g. ORD-00007
        $nextNumber   = (Order::max('id') ?? 0) + 1;
        $orderNumber  = 'ORD-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Calculate total from live menu item prices (never trust client-side totals)
        $total = 0;
        $lineItems = [];

        foreach ($items as $row) {
            $menuItem = MenuItem::find($row['menu_item_id']);
            $quantity = (int) ($row['quantity'] ?? 1);
            $subtotal = $menuItem->price * $quantity;
            $total   += $subtotal;

            $lineItems[] = [
                'menu_item_id' => $menuItem->id,
                'quantity'     => $quantity,
                'unit_price'   => $menuItem->price, // price at time of order
                'subtotal'     => $subtotal,
            ];
        }

        $order = Order::create([
            'user_id'      => auth()->id(),
            'order_number' => $orderNumber,
            'status'       => 'pending',
            'total_amount' => $total,
            'note'         => $validated['note'] ?? null,
            'phone'        => $validated['phone'] ?? null,
        ]);

        foreach ($lineItems as $line) {
            $order->orderItems()->create($line);
        }

        return redirect()
            ->route('student.orders.show', $order)
            ->with('success', "Order {$order->order_number} placed successfully!");
    }

    /**
     * show() — View a single order's details
     */
    public function show(Order $order)
    {
        $order->load(['orderItems.menuItem', 'user', 'payments']);

        if (auth()->user()->role === 'admin') {
            return view('admin.orders.show', compact('order'));
        }

        return view('student.orders.show', compact('order'));
    }

    /**
     * update() — Admin updates an order (e.g. status correction)
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,ready,delivered',
        ]);

        $order->update($validated);

        return back()->with('success', "Order {$order->order_number} updated.");
    }

    /**
     * edit() — Student edits their own order (only while it's still pending)
     */
    public function edit(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'pending', 403, 'This order can no longer be edited.');

        $order->load('orderItems.menuItem');
        $menuItems = MenuItem::where('is_available', true)->get();

        return view('student.orders.edit', compact('order', 'menuItems'));
    }

    /**
     * studentUpdate() — Student saves changes to their own pending order
     */
    public function studentUpdate(Request $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'pending', 403, 'This order can no longer be edited.');

        $validated = $request->validate([
            'items'                  => 'required|array|min:1',
            'items.*.menu_item_id'   => 'nullable|exists:menu_items,id',
            'items.*.quantity'       => 'nullable|integer|min:1',
            'note'                   => 'nullable|string|max:500',
            'phone'                  => 'nullable|string|max:20',
        ]);

        $items = collect($validated['items'])
                    ->filter(fn ($row) => !empty($row['menu_item_id']));

        if ($items->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Please select at least one item to order.');
        }

        $total = 0;
        $lineItems = [];

        foreach ($items as $row) {
            $menuItem = MenuItem::find($row['menu_item_id']);
            $quantity = (int) ($row['quantity'] ?? 1);
            $subtotal = $menuItem->price * $quantity;
            $total   += $subtotal;

            $lineItems[] = [
                'menu_item_id' => $menuItem->id,
                'quantity'     => $quantity,
                'unit_price'   => $menuItem->price,
                'subtotal'     => $subtotal,
            ];
        }

        $order->update([
            'total_amount' => $total,
            'note'         => $validated['note'] ?? null,
            'phone'        => $validated['phone'] ?? null,
        ]);

        // Simplest safe approach: replace all line items with the new set
        $order->orderItems()->delete();
        foreach ($lineItems as $line) {
            $order->orderItems()->create($line);
        }

        return redirect()
            ->route('student.orders.show', $order)
            ->with('success', "Order {$order->order_number} updated successfully!");
    }

    /**
     * cancel() — Student cancels their own order (only while it's still pending)
     */
    public function cancel(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'pending', 403, 'This order can no longer be cancelled.');

        $order->update(['status' => 'cancelled']);

        return redirect()
            ->route('student.orders.index')
            ->with('success', "Order {$order->order_number} was cancelled.");
    }
}