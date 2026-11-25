<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * index() — Show all items inside a specific order
     * Route: GET /orders/{order}/items
     * View:  resources/views/order-items/index.blade.php
     */
    public function index(Order $order)
    {
        $orderItems = $order->orderItems()->with('menuItem')->get();

        return view('order-items.index', compact('order', 'orderItems'));
    }

    /**
     * create() — Show form to add an item to an existing order
     * Route: GET /orders/{order}/items/create
     * View:  resources/views/order-items/create.blade.php
     */
    public function create(Order $order)
    {
        $menuItems = MenuItem::where('is_available', true)->get();

        return view('order-items.create', compact('order', 'menuItems'));
    }

    /**
     * store() — Add a new item to an existing order
     * Route: POST /orders/{order}/items
     */
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity'     => 'required|integer|min:1',
        ]);

        $menuItem  = MenuItem::findOrFail($validated['menu_item_id']);
        $unitPrice = $menuItem->price;
        $subtotal  = $unitPrice * $validated['quantity'];

        // Create the order item
        $order->orderItems()->create([
            'menu_item_id' => $menuItem->id,
            'quantity'     => $validated['quantity'],
            'unit_price'   => $unitPrice,
            'subtotal'     => $subtotal,
        ]);

        // Recalculate and update the order total
        $order->update([
            'total_amount' => $order->orderItems()->sum('subtotal'),
        ]);

        return redirect()->route('orders.show', $order)
                         ->with('success', 'Item added to order.');
    }

    /**
     * show() — Show details of a single order item
     * Route: GET /order-items/{orderItem}
     * View:  resources/views/order-items/show.blade.php
     */
    public function show(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'menuItem']);

        return view('order-items.show', compact('orderItem'));
    }

    /**
     * edit() — Show form to edit an order item (change quantity)
     * Route: GET /order-items/{orderItem}/edit
     * View:  resources/views/order-items/edit.blade.php
     */
    public function edit(OrderItem $orderItem)
    {
        return view('order-items.edit', compact('orderItem'));
    }

    /**
     * update() — Update quantity of an order item and recalculate subtotal
     * Route: PUT /order-items/{orderItem}
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $subtotal = $orderItem->unit_price * $validated['quantity'];

        $orderItem->update([
            'quantity' => $validated['quantity'],
            'subtotal' => $subtotal,
        ]);

        // Recalculate and update the parent order total
        $order = $orderItem->order;
        $order->update([
            'total_amount' => $order->orderItems()->sum('subtotal'),
        ]);

        return redirect()->route('orders.show', $order)
                         ->with('success', 'Order item updated.');
    }

    /**
     * destroy() — Remove an item from an order
     * Route: DELETE /order-items/{orderItem}
     */
    public function destroy(OrderItem $orderItem)
    {
        $order = $orderItem->order;

        $orderItem->delete();

        // Recalculate the order total after removal
        $order->update([
            'total_amount' => $order->orderItems()->sum('subtotal'),
        ]);

        return redirect()->route('orders.show', $order)
                         ->with('success', 'Item removed from order.');
    }
}