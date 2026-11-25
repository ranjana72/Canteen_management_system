@extends('layouts.app')
@section('title', 'My Orders')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-xl font-bold text-slate-800">My Orders</h1>
        <p class="text-[13px] text-slate-400 mt-0.5">Your order history and current status</p>
    </div>
    <a href="{{ route('student.orders.create') }}"
       class="inline-flex items-center gap-2 bg-[#002147] hover:bg-[#003a75] text-white font-semibold text-[13px] px-4 py-2 rounded-md transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Place Order
    </a>
</div>

@if(session('success'))
<div class="mb-4 px-4 py-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px]">
    {{ session('success') }}
</div>
@endif

@if($orders->count() > 0)
<div class="bg-white rounded-xl border border-slate-200 overflow-x-auto">
    <table class="w-full text-[13px]">
        <thead class="bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wider">
            <tr>
                <th class="px-4 py-2.5 text-left font-semibold">Order #</th>
                <th class="px-4 py-2.5 text-left font-semibold">Items</th>
                <th class="px-4 py-2.5 text-left font-semibold">Total</th>
                <th class="px-4 py-2.5 text-left font-semibold">Status</th>
                <th class="px-4 py-2.5 text-left font-semibold">Placed</th>
                <th class="px-4 py-2.5 text-left font-semibold">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($orders as $order)
            <tr class="hover:bg-slate-50/60">
                <td class="px-4 py-2.5 font-semibold text-slate-800 whitespace-nowrap">{{ $order->order_number }}</td>
                <td class="px-4 py-2.5">
                    <div class="space-y-0.5">
                        @foreach($order->orderItems as $item)
                        <div class="flex items-center gap-1.5 whitespace-nowrap">
                            <span class="text-slate-700">{{ $item->menuItem->name ?? 'Item removed' }}</span>
                            <span class="bg-slate-100 text-slate-600 text-[11px] font-semibold px-1.5 py-0.5 rounded">
                                ×{{ $item->quantity }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </td>
                <td class="px-4 py-2.5 font-semibold text-slate-800 whitespace-nowrap">
                    Rs. {{ number_format($order->total_amount, 2) }}
                </td>
                <td class="px-4 py-2.5">
                    @include('components.status-badge', ['status' => $order->status])
                </td>
                <td class="px-4 py-2.5 text-slate-400 text-[12px] whitespace-nowrap">
                    {{ $order->created_at->diffForHumans() }}
                </td>
                <td class="px-4 py-2.5 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('student.orders.show', $order) }}"
                           class="text-[#002147] text-[12px] font-semibold hover:underline">
                            View
                        </a>

                        @if($order->status === 'pending')
                            <a href="{{ route('student.orders.edit', $order) }}"
                               class="text-amber-600 text-[12px] font-semibold hover:underline">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('student.orders.cancel', $order) }}"
                                  onsubmit="return confirm('Cancel order {{ $order->order_number }}?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-red-600 text-[12px] font-semibold hover:underline">
                                    Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@else
<div class="bg-white border-2 border-dashed border-slate-200 rounded-xl py-16 text-center">
    <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
    </svg>
    <h3 class="text-[15px] font-semibold text-slate-700 mb-1">No orders yet</h3>
    <p class="text-slate-400 text-[13px] mb-4">You haven't placed any orders.</p>
    <a href="{{ route('student.orders.create') }}"
       class="inline-flex items-center gap-2 bg-[#002147] hover:bg-[#003a75] text-white font-semibold text-[13px] px-4 py-2 rounded-md transition-colors">
        Place Your First Order
    </a>
</div>
@endif

@endsection