<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * index() — Show all payments (admin sees all, student sees their own)
     */
    public function index()
    {
        $payments = Auth::user()->role === 'admin'
            ? Payment::with(['order', 'user'])->latest()->paginate(10)
            : Payment::where('user_id', Auth::id())->latest()->paginate(10);

        $view = Auth::user()->role === 'admin'
            ? 'admin.payments.index'
            : 'student.payments.index';

        return view($view, compact('payments'));
    }

    /**
     * create() — Show the payment form for a specific order
     */
    public function create(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        // Student can only pay for their own orders
        if (Auth::user()->role === 'student' && $order->user_id !== Auth::id()) {
            abort(403, 'You can only pay for your own orders.');
        }

        $view = Auth::user()->role === 'admin'
            ? 'admin.payments.create'
            : 'student.payments.create';

        return view($view, compact('order'));
    }

    /**
     * store() — Record a new payment for an order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'       => 'required|exists:orders,id',
            'amount'         => 'required|numeric|min:0',
            'method'         => 'required|in:cash,online',
            'transaction_id' => 'nullable|string|max:100',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        // Student can only pay for their own orders
        if (Auth::user()->role === 'student' && $order->user_id !== Auth::id()) {
            abort(403, 'You can only pay for your own orders.');
        }

        $status = 'pending';
        $paidAt = null;

        if ($validated['method'] === 'cash') {
            $status = 'paid';
            $paidAt = now();
        }

        Payment::create([
            'order_id'       => $validated['order_id'],
            'user_id'        => Auth::id(),
            'amount'         => $validated['amount'],
            'method'         => $validated['method'],
            'status'         => $status,
            'transaction_id' => $validated['transaction_id'] ?? null,
            'paid_at'        => $paidAt,
        ]);

        $route = Auth::user()->role === 'admin'
            ? 'admin.payments.index'
            : 'student.payments.index';

        return redirect()->route($route)
                         ->with('success', 'Payment recorded successfully.');
    }

    /**
     * show() — Show details of a single payment
     */
    public function show(Payment $payment)
    {
        // Student can only view their own payments
        if (Auth::user()->role === 'student' && $payment->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->load(['order.orderItems.menuItem', 'user']);

        $view = Auth::user()->role === 'admin'
            ? 'admin.payments.show'
            : 'student.payments.show';

        return view($view, compact('payment'));
    }

    /**
     * edit() — Show form to edit a payment (admin only)
     */
    public function edit(Payment $payment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.payments.edit', compact('payment'));
    }

    /**
     * update() — Update payment status (admin only)
     */
    public function update(Request $request, Payment $payment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'status'         => 'required|in:pending,paid,failed',
            'transaction_id' => 'nullable|string|max:100',
        ]);

        if ($validated['status'] === 'paid' && !$payment->paid_at) {
            $validated['paid_at'] = now();
        }

        $payment->update($validated);

        return redirect()->route('admin.payments.show', $payment)
                         ->with('success', 'Payment status updated.');
    }

    /**
     * destroy() — Delete a payment record (admin only)
     */
    public function destroy(Payment $payment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $payment->delete();

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Payment deleted successfully.');
    }
}