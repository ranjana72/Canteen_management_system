@extends('layouts.app')
@section('title', 'Active Orders')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-xl font-bold text-slate-800">Active Orders</h1>
        <p class="text-[13px] text-slate-400 mt-0.5">All pending, preparing and ready orders</p>
    </div>
    <a href="{{ route('kitchen.dashboard') }}"
       class="inline-flex items-center gap-1 text-[13px] font-medium text-[#002147] hover:underline">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Dashboard
    </a>
</div>

@if($orders->count() > 0)
<div class="bg-white rounded-xl border border-slate-200 overflow-x-auto">
    <table class="w-full text-[13px]">
        <thead class="bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wider">
            <tr>
                <th class="px-4 py-2.5 text-left font-semibold">Order #</th>
                <th class="px-4 py-2.5 text-left font-semibold">Student</th>
                <th class="px-4 py-2.5 text-left font-semibold">Phone</th>
                <th class="px-4 py-2.5 text-left font-semibold">Items</th>
                <th class="px-4 py-2.5 text-left font-semibold">Note</th>
                <th class="px-4 py-2.5 text-left font-semibold">Type</th>
                <th class="px-4 py-2.5 text-left font-semibold">Total</th>
                <th class="px-4 py-2.5 text-left font-semibold">Status</th>
                <th class="px-4 py-2.5 text-left font-semibold">Placed</th>
                <th class="px-4 py-2.5 text-left font-semibold">Ready At</th>
                <th class="px-4 py-2.5 text-left font-semibold">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($orders as $order)
            <tr class="hover:bg-slate-50/60">
                <td class="px-4 py-2.5 font-semibold text-slate-800 whitespace-nowrap">{{ $order->order_number }}</td>
                <td class="px-4 py-2.5 text-slate-600 whitespace-nowrap">{{ $order->user->name }}</td>
                <td class="px-4 py-2.5 text-slate-400 text-[12px] whitespace-nowrap">
                    {{ $order->phone ?? '—' }}
                </td>
                <td class="px-4 py-2.5">
                    <div class="space-y-0.5">
                        @foreach($order->orderItems as $item)
                        <div class="flex items-center gap-1.5 whitespace-nowrap">
                            <span class="text-slate-700">{{ $item->menuItem->name }}</span>
                            <span class="bg-slate-100 text-slate-600 text-[11px] font-semibold px-1.5 py-0.5 rounded">
                                ×{{ $item->quantity }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </td>
                <td class="px-4 py-2.5 text-slate-400 italic text-[12px]">
                    {{ $order->note ?? '—' }}
                </td>
                <td class="px-4 py-2.5">
                    <span class="inline-flex items-center gap-1 bg-[#eef2ff] text-[#002147] text-[11px] font-semibold px-2 py-1 rounded whitespace-nowrap">
                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Pickup
                    </span>
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
                <td class="px-4 py-2.5 text-slate-500 text-[12px] whitespace-nowrap">
                    @if($order->ready_at)
                        {{ $order->ready_at->format('g:i A') }}
                    @else
                        —
                    @endif
                </td>
                <td class="px-4 py-2.5 whitespace-nowrap">
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('kitchen.confirm', $order) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="bg-[#002147] hover:bg-[#003a75] text-white text-[12px] font-semibold px-2.5 py-1.5 rounded-md transition">
                                Accept
                            </button>
                        </form>
                    @elseif($order->status === 'confirmed')
                        <form method="POST" action="{{ route('kitchen.ready', $order) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white text-[12px] font-semibold px-2.5 py-1.5 rounded-md transition">
                                Mark Ready
                            </button>
                        </form>
                    @else
                        <span class="inline-flex items-center gap-1 text-emerald-600 text-[12px] font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Ready
                        </span>
                    @endif
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
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    </svg>
    <h3 class="text-[15px] font-semibold text-slate-700 mb-1">No active orders</h3>
    <p class="text-slate-400 text-[13px]">All orders have been completed!</p>
</div>
@endif

@endsection