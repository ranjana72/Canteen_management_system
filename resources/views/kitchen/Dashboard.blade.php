@extends('layouts.app')

@section('title', 'Kitchen Dashboard')
@section('page-title', 'Kitchen Dashboard')

@section('content')

    {{-- ============================================= --}}
    {{-- STAT CARDS --}}
    {{-- ============================================= --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

        {{-- Active Orders --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
            <span class="flex items-center justify-center w-11 h-11 rounded-full bg-blue-50 shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[13px] text-slate-500">Active Orders</p>
                <p class="text-[22px] font-bold text-slate-800 leading-tight">{{ $activeCount }}</p>
                <p class="text-[11px] text-slate-400">All pending orders</p>
            </div>
        </div>

        {{-- Preparing --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
            <span class="flex items-center justify-center w-11 h-11 rounded-full bg-amber-50 shrink-0">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[13px] text-slate-500">Preparing</p>
                <p class="text-[22px] font-bold text-slate-800 leading-tight">{{ $preparingCount }}</p>
                <p class="text-[11px] text-slate-400">Being prepared</p>
            </div>
        </div>

        {{-- Ready --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
            <span class="flex items-center justify-center w-11 h-11 rounded-full bg-green-50 shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[13px] text-slate-500">Ready</p>
                <p class="text-[22px] font-bold text-slate-800 leading-tight">{{ $readyCount }}</p>
                <p class="text-[11px] text-slate-400">Ready for pickup</p>
            </div>
        </div>

        {{-- Today's Sales --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
            <span class="flex items-center justify-center w-11 h-11 rounded-full bg-violet-50 shrink-0">
                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 012-2h2a2 2 0 012 2v6m-9 0h10a2 2 0 002-2V9.5a1 1 0 00-.4-.8l-5-3.75a1 1 0 00-1.2 0l-5 3.75a1 1 0 00-.4.8V17a2 2 0 002 2z"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[13px] text-slate-500">Today's Sales</p>
                <p class="text-[20px] font-bold text-slate-800 leading-tight">Rs. {{ number_format($todaysSales, 0) }}</p>
                <p class="text-[11px] text-slate-400">{{ $todaysCount }} orders</p>
            </div>
        </div>

        {{-- Avg Prep Time --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
            <span class="flex items-center justify-center w-11 h-11 rounded-full bg-sky-50 shrink-0">
                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-[13px] text-slate-500">Avg. Prep Time</p>
                <p class="text-[22px] font-bold text-slate-800 leading-tight">{{ $avgPrepMinutes }} mins</p>
                <p class="text-[11px] text-slate-400">Today's average</p>
            </div>
        </div>

    </div>

    {{-- ============================================= --}}
    {{-- MAIN GRID: Active Orders + Sidebar Panels --}}
    {{-- ============================================= --}}
    <div class="grid grid-cols-1 xl:grid-cols-[1fr_320px] gap-6 items-start">

        {{-- ---------------- Active Orders Table ---------------- --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <div>
                    <h2 class="text-[16px] font-bold text-slate-800">Active Orders</h2>
                    <p class="text-[12px] text-slate-400">All pending, preparing and ready orders</p>
                </div>
                <a href="{{ route('kitchen.orders.index') }}"
                    class="text-[13px] font-medium text-[#002147] hover:underline shrink-0">
                    View all
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                            <th class="px-4 py-2.5 font-semibold">Order #</th>
                            <th class="px-4 py-2.5 font-semibold">Student</th>
                            <th class="px-4 py-2.5 font-semibold">Phone</th>
                            <th class="px-4 py-2.5 font-semibold">Items</th>
                            <th class="px-4 py-2.5 font-semibold">Status</th>
                            <th class="px-4 py-2.5 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($activeOrders as $order)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-4 py-2.5 text-[13px] font-semibold text-slate-700">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-600">
                                    {{ $order->user->name ?? '—' }}
                                </td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-500">
                                    @if($order->phone)
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $order->phone }}
                                        </span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-600">
                                    @foreach($order->orderItems as $item)
                                        <span class="inline-flex items-center gap-1">
                                            {{ $item->menuItem->name ?? 'Item' }}
                                            <span class="text-slate-400">x{{ $item->quantity }}</span>
                                        </span>@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="px-4 py-2.5">
                                    @if($order->status === 'pending')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            Pending
                                        </span>
                                    @elseif($order->status === 'confirmed')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            Preparing
                                        </span>
                                    @elseif($order->status === 'ready')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-green-50 text-green-700 border border-green-200">
                                            Ready
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 text-right">
                                    @if($order->status === 'pending')
                                        <form method="POST" action="{{ route('kitchen.confirm', $order) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-lg text-[12px] font-semibold bg-[#002147] text-white hover:bg-[#00305f] transition">
                                                Start
                                            </button>
                                        </form>
                                    @elseif($order->status === 'confirmed')
                                        <form method="POST" action="{{ route('kitchen.ready', $order) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-lg text-[12px] font-semibold border border-[#002147] text-[#002147] hover:bg-[#002147] hover:text-white transition">
                                                Mark Ready
                                            </button>
                                        </form>
                                    @elseif($order->status === 'ready')
                                        <form method="POST" action="{{ route('kitchen.delivered', $order) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-lg text-[12px] font-semibold bg-[#002147] text-white hover:bg-[#00305f] transition">
                                                Mark Delivered
                                            </button>
                                        </form>
                                    @else
                                        <span class="px-3 py-1.5 rounded-lg text-[12px] font-semibold bg-slate-100 text-slate-400">
                                            Delivered
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-[13px] text-slate-400">
                                    No active orders right now.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($activeOrders->hasPages())
                <div class="px-5 py-3 border-t border-slate-100">
                    {{ $activeOrders->links() }}
                </div>
            @endif

        </div>

        {{-- ---------------- Right Sidebar Panels ---------------- --}}
        <div class="flex flex-col gap-5">

            {{-- Average Rating --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <div class="flex items-center gap-1.5 mb-3">
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <h3 class="text-[14px] font-bold text-slate-800">Average Rating</h3>
                </div>
                <p class="text-[26px] font-bold text-slate-800">
                    {{ $avgRating }} <span class="text-[14px] font-medium text-slate-400">/ 5</span>
                </p>
                <div class="flex items-center gap-0.5 mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-[12px] text-slate-400 mt-1">Based on {{ $totalRatings }} reviews</p>
            </div>

            {{-- Recent Feedback --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-[14px] font-bold text-slate-800">Recent Feedback</h3>
                    <a href="{{ route('kitchen.feedback.index') }}" class="text-[12px] font-medium text-[#002147] hover:underline">
                        View all
                    </a>
                </div>
                <div class="flex flex-col divide-y divide-slate-100">
                    @forelse($recentFeedback as $fb)
                        <div class="py-3 first:pt-0 last:pb-0">
                            <div class="flex items-center gap-0.5 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $fb->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-[13px] text-slate-600 line-clamp-2">
                                {{ $fb->comment ?? 'No comment left.' }}
                            </p>
                            <p class="text-[11px] text-slate-400 mt-1">{{ $fb->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-[13px] text-slate-400 py-2">No feedback yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Popular Items Today --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <h3 class="text-[14px] font-bold text-slate-800 mb-3">Popular Items Today</h3>
                <div class="flex flex-col gap-2.5">
                    @forelse($popularItems as $item)
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] text-slate-600">{{ $item->name }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                {{ $item->total_qty }}
                            </span>
                        </div>
                    @empty
                        <p class="text-[13px] text-slate-400">No orders yet today.</p>
                    @endforelse
                </div>
            </div>

            {{-- Low Stock Alert --}}
            <div class="bg-white rounded-xl border border-red-200 p-5">
                <div class="flex items-center gap-1.5 mb-3">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <h3 class="text-[14px] font-bold text-red-600">Low Stock Alert</h3>
                </div>
                <div class="flex flex-col gap-2.5">
                    @forelse($lowStockItems as $item)
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] text-slate-600">{{ $item->name }}</span>
                            @if($item->stock <= 0)
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-500 text-white">
                                    Out of Stock
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-50 text-red-600 border border-red-200">
                                    {{ $item->stock }} left
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="text-[13px] text-slate-400">Stock levels look good.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

@endsection