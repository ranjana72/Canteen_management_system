@extends('layouts.app')
@section('title', 'Pay for Order')

@section('content')

<div class="mb-6">
    <a href="{{ route('student.orders.show', $order) }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Order</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Pay for {{ $order->order_number }}</h1>
</div>

<div class="max-w-md">

    {{-- Order summary --}}
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-4">
        <h2 class="font-semibold text-gray-700 mb-3">Order Summary</h2>
        @foreach($order->orderItems as $item)
        <div class="flex justify-between text-sm text-gray-600 py-1">
            <span>{{ $item->menuItem->name }} ×{{ $item->quantity }}</span>
            <span>Rs. {{ number_format($item->subtotal, 2) }}</span>
        </div>
        @endforeach
        <div class="mt-3 pt-3 border-t border-gray-200 flex justify-between font-bold text-gray-800">
            <span>Total Due</span>
            <span class="text-orange-600">Rs. {{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Payment method selection --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">

        <label class="block text-sm font-medium text-gray-700 mb-3">Choose Payment Method</label>

        <div class="flex flex-col gap-3" x-data="{ method: 'cash' }">

            {{-- Cash option --}}
            <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition
                          has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 border-gray-200">
                <input type="radio" name="method-selector" value="cash" checked class="text-orange-500"
                    onclick="document.getElementById('cash-form').classList.remove('hidden'); document.getElementById('esewa-form-visible').classList.add('hidden');">
                <div>
                    <div class="font-medium text-sm text-gray-800">💵 Cash on Pickup</div>
                    <div class="text-xs text-gray-400">Pay when you collect your order</div>
                </div>
            </label>

            {{-- eSewa option --}}
            <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition
                          has-[:checked]:border-green-500 has-[:checked]:bg-green-50 border-gray-200">
                <input type="radio" name="method-selector" value="esewa" class="text-green-500"
                    onclick="document.getElementById('cash-form').classList.add('hidden'); document.getElementById('esewa-form-visible').classList.remove('hidden');">
                <div>
                    <div class="font-medium text-sm text-gray-800">🟢 eSewa</div>
                    <div class="text-xs text-gray-400">Pay using your eSewa wallet</div>
                </div>
            </label>

        </div>

        {{-- Cash form (default visible) --}}
        <form id="cash-form" method="POST" action="{{ route('student.payments.store') }}" class="mt-5">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="amount" value="{{ $order->total_amount }}">
            <input type="hidden" name="method" value="cash">

            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition">
                Confirm Cash Payment — Rs. {{ number_format($order->total_amount, 2) }}
            </button>
        </form>

        {{-- eSewa button (hidden by default) --}}
        <div id="esewa-form-visible" class="mt-5 hidden">
            <a href="{{ route('student.payments.esewa.initiate', $order) }}"
                class="block text-center w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition">
                Pay with eSewa — Rs. {{ number_format($order->total_amount, 2) }}
            </a>
            <p class="text-xs text-gray-400 mt-2 text-center">You'll be redirected to eSewa's secure payment page.</p>
        </div>

    </div>
</div>

@endsection