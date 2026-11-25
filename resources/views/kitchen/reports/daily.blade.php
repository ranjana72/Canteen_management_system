@extends('layouts.app')

@section('title', 'Daily Report')
@section('page-title', 'Daily Report')

@section('content')

    {{-- Date picker --}}
    <form method="GET" action="{{ route('kitchen.reports.daily') }}" class="flex items-center gap-3 mb-6">
        <label class="text-[13px] font-medium text-slate-600">Date:</label>
        <input type="date" name="date" value="{{ $date->format('Y-m-d') }}"
            class="px-3 py-2 rounded-lg border border-slate-200 text-[13px] focus:outline-none focus:ring-2 focus:ring-[#002147]/20">
        <button type="submit"
            class="px-4 py-2 rounded-lg text-[13px] font-semibold bg-[#002147] text-white hover:bg-[#00305f] transition">
            View
        </button>
    </form>

    {{-- Summary cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Total Orders</p>
            <p class="text-[24px] font-bold text-slate-800">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Total Revenue</p>
            <p class="text-[24px] font-bold text-slate-800">Rs. {{ number_format($totalRevenue, 0) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Pending</p>
            <p class="text-[24px] font-bold text-amber-600">{{ $statusBreakdown['pending'] ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Ready</p>
            <p class="text-[24px] font-bold text-green-600">{{ $statusBreakdown['ready'] ?? 0 }}</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Items sold today --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-[16px] font-bold text-slate-800">Items Sold</h2>
                <p class="text-[12px] text-slate-400">{{ $date->format('F j, Y') }}</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                            <th class="px-4 py-2.5 font-semibold">Item</th>
                            <th class="px-4 py-2.5 font-semibold text-right">Qty</th>
                            <th class="px-4 py-2.5 font-semibold text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($itemsSold as $item)
                            <tr>
                                <td class="px-4 py-2.5 text-[13px] text-slate-700">{{ $item->name }}</td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-600 text-right">{{ $item->total_qty }}</td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-600 text-right">Rs. {{ number_format($item->total_revenue, 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-[13px] text-slate-400">
                                    No items sold on this date.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Orders list --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-[16px] font-bold text-slate-800">Orders</h2>
                <p class="text-[12px] text-slate-400">{{ $totalOrders }} orders placed</p>
            </div>
            <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400 sticky top-0">
                            <th class="px-4 py-2.5 font-semibold">Order #</th>
                            <th class="px-4 py-2.5 font-semibold">Student</th>
                            <th class="px-4 py-2.5 font-semibold">Status</th>
                            <th class="px-4 py-2.5 font-semibold text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-4 py-2.5 text-[13px] font-semibold text-slate-700">{{ $order->order_number }}</td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-600">{{ $order->user->name ?? '—' }}</td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-600 capitalize">{{ $order->status }}</td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-600 text-right">Rs. {{ number_format($order->total_amount, 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-[13px] text-slate-400">
                                    No orders on this date.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection