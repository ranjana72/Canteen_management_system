@extends('layouts.app')
@section('title', 'Order ' . $order->order_number)

@section('content')

<div class="mb-6">
    <a href="{{ route('student.orders.index') }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to My Orders</a>
    <div class="flex items-center gap-4 mt-2">
        <h1 class="text-2xl font-bold text-gray-800">{{ $order->order_number }}</h1>
        @include('components.status-badge', ['status' => $order->status])
    </div>
    <p class="text-sm text-gray-400 mt-1">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Items --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-700">Your Items</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Item</th>
                    <th class="px-6 py-3 text-right">Price</th>
                    <th class="px-6 py-3 text-right">Qty</th>
                    <th class="px-6 py-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="px-6 py-3 font-medium text-gray-800">{{ $item->menuItem->name }}</td>
                    <td class="px-6 py-3 text-right text-gray-500">Rs. {{ number_format($item->unit_price, 2) }}</td>
                    <td class="px-6 py-3 text-right text-gray-500">{{ $item->quantity }}</td>
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

        @if($order->note)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-700 mb-2">Special Note</h2>
            <p class="text-sm text-gray-500 italic">{{ $order->note }}</p>
        </div>
        @endif

        {{-- Pay button (if no paid payment yet) --}}
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

        {{-- Order status tracker --}}
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
                        ✓
                    </div>
                    <span class="text-sm capitalize {{ $i <= $current ? 'text-gray-800 font-medium' : 'text-gray-400' }}">
                        {{ $step }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection