@extends('layouts.app')
@section('title', 'Order ' . $order->order_number)

@section('content')

@php
    $role = auth()->user()->role;
    $routePrefix = $role === 'admin' ? 'admin' : ($role === 'kitchen' ? 'kitchen' : 'student');
   $ordersRoute = $role === 'admin'
    ? 'admin.orders.index'
    : ($role === 'kitchen'
        ? 'kitchen.orders.index'
        : 'student.orders.index');
@endphp

<div class="mb-6">
    <a href="{{ route($ordersRoute) }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Orders</a>
    <div class="flex items-center gap-4 mt-2">
        <h1 class="text-2xl font-bold text-gray-800">{{ $order->order_number }}</h1>
        @include('components.status-badge', ['status' => $order->status])
    </div>
    <p class="text-sm text-gray-400 mt-1">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Order items table --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-700">Items Ordered</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Item</th>
                    <th class="px-6 py-3 text-right">Unit Price</th>
                    <th class="px-6 py-3 text-right">Qty</th>
                    <th class="px-6 py-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="px-6 py-3 font-medium text-gray-800">{{ $item->menuItem->name }}</td>
                    <td class="px-6 py-3 text-right text-gray-600">Rs. {{ number_format($item->unit_price, 2) }}</td>
                    <td class="px-6 py-3 text-right text-gray-600">{{ $item->quantity }}</td>
                    <td class="px-6 py-3 text-right font-medium">Rs. {{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-3 text-right font-semibold text-gray-700">Total</td>
                    <td class="px-6 py-3 text-right font-bold text-orange-600 text-base">
                        Rs. {{ number_format($order->total_amount, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-4">

        {{-- Order details --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-700 mb-4">Details</h2>
            <dl class="space-y-3 text-sm">
                @if($role === 'admin')
                <div><dt class="text-gray-400">Student</dt><dd class="font-medium">{{ $order->user->name }}</dd></div>
                @endif
                <div><dt class="text-gray-400">Order #</dt><dd class="font-medium">{{ $order->order_number }}</dd></div>
                <div><dt class="text-gray-400">Status</dt><dd>@include('components.status-badge', ['status' => $order->status])</dd></div>
                <div><dt class="text-gray-400">Placed on</dt><dd>{{ $order->created_at->format('d M Y, h:i A') }}</dd></div>
                @if($order->note)
                <div><dt class="text-gray-400">Note</dt><dd class="text-gray-600 italic">{{ $order->note }}</dd></div>
                @endif
            </dl>
        </div>

        {{-- Admin: update status --}}
        @if($role === 'admin')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-700 mb-4">Update Status</h2>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-3">
                @csrf @method('PUT')
                <select name="status"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                    @foreach(['pending','confirmed','ready','delivered'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Update Status
                </button>
            </form>
        </div>
        @endif

        {{-- Kitchen: accept or mark ready --}}
        @if($role === 'kitchen')
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-700 mb-4">Kitchen Action</h2>
            @if($order->status === 'pending')
                <form method="POST" action="{{ route('kitchen.confirm', $order) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg transition">
                        🔥 Accept & Start Preparing
                    </button>
                </form>
            @elseif($order->status === 'confirmed')
                <form method="POST" action="{{ route('kitchen.ready', $order) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-2.5 rounded-lg transition">
                        ✅ Mark as Ready
                    </button>
                </form>
            @else
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
                    <p class="text-green-700 text-sm font-medium">✅ Order is {{ ucfirst($order->status) }}</p>
                </div>
            @endif
        </div>
        @endif

        {{-- Student: pay button --}}
        @if($role === 'student')
            @if($order->payments->where('status','paid')->isEmpty())
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-5">
                <h2 class="font-semibold text-orange-700 mb-2">Payment Required</h2>
                <p class="text-sm text-orange-600 mb-4">
                    Total due: <strong>Rs. {{ number_format($order->total_amount, 2) }}</strong>
                </p>
                <a href="{{ route('student.payments.create', ['order_id' => $order->id]) }}"
                   class="block text-center bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    💳 Pay Now
                </a>
            </div>
            @else
            <div class="bg-green-50 border border-green-200 rounded-xl p-5">
                <h2 class="font-semibold text-green-700 mb-1">✅ Payment Complete</h2>
                <p class="text-sm text-green-600">This order has been paid.</p>
            </div>
            @endif
        @endif

        {{-- Order status tracker — visible to all roles (admin, kitchen, student) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-700 mb-4">Order Progress</h2>
            @php
                $steps = ['pending','confirmed','ready','delivered'];
                $current = array_search($order->status, $steps);
            @endphp
            <div class="space-y-3">
                @foreach($steps as $i => $step)
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold
                        {{ $i <= $current ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                        {{ $i <= $current ? '✓' : ($i + 1) }}
                    </div>
                    <span class="text-sm capitalize {{ $i <= $current ? 'text-gray-800 font-medium' : 'text-gray-400' }}">
                        {{ $step }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Payments summary (admin and kitchen) --}}
        @if($role !== 'student' && $order->payments->count())
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-700 mb-3">Payments</h2>
            @foreach($order->payments as $payment)
            <div class="text-sm flex items-center justify-between py-1">
                <span class="text-gray-600 capitalize">{{ $payment->method }}</span>
                @include('components.status-badge', ['status' => $payment->status])
                <span class="font-medium">Rs. {{ number_format($payment->amount, 2) }}</span>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

@endsection