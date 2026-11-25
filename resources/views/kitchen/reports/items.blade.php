@extends('layouts.app')

@section('title', 'Items Report')
@section('page-title', 'Items Report')

@section('content')

    {{-- Filters --}}
    <form method="GET" action="{{ route('kitchen.reports.items') }}" class="flex flex-wrap items-end gap-3 mb-6">

        <div>
            <label class="block text-[13px] font-medium text-slate-600 mb-1">From</label>
            <input type="date" name="from" value="{{ $from->format('Y-m-d') }}"
                class="px-3 py-2 rounded-lg border border-slate-200 text-[13px] focus:outline-none focus:ring-2 focus:ring-[#002147]/20">
        </div>

        <div>
            <label class="block text-[13px] font-medium text-slate-600 mb-1">To</label>
            <input type="date" name="to" value="{{ $to->format('Y-m-d') }}"
                class="px-3 py-2 rounded-lg border border-slate-200 text-[13px] focus:outline-none focus:ring-2 focus:ring-[#002147]/20">
        </div>

        <div>
            <label class="block text-[13px] font-medium text-slate-600 mb-1">Sort By</label>
            <select name="sort"
                class="px-3 py-2 rounded-lg border border-slate-200 text-[13px] focus:outline-none focus:ring-2 focus:ring-[#002147]/20">
                <option value="qty" @selected($sort === 'qty')>Quantity Sold</option>
                <option value="revenue" @selected($sort === 'revenue')>Revenue</option>
                <option value="name" @selected($sort === 'name')>Item Name (A-Z)</option>
            </select>
        </div>

        <button type="submit"
            class="px-4 py-2 rounded-lg text-[13px] font-semibold bg-[#002147] text-white hover:bg-[#00305f] transition">
            View
        </button>

    </form>

    {{-- Summary cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Total Items Sold</p>
            <p class="text-[24px] font-bold text-slate-800">{{ number_format($totalQty) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Total Revenue</p>
            <p class="text-[24px] font-bold text-slate-800">Rs. {{ number_format($totalRevenue, 0) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Distinct Menu Items</p>
            <p class="text-[24px] font-bold text-slate-800">{{ $totalItems }}</p>
        </div>

    </div>

    {{-- Items table --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="text-[16px] font-bold text-slate-800">All Items</h2>
            <p class="text-[12px] text-slate-400">{{ $from->format('M j, Y') }} – {{ $to->format('M j, Y') }}</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                        <th class="px-4 py-2.5 font-semibold">#</th>
                        <th class="px-4 py-2.5 font-semibold">Item</th>
                        <th class="px-4 py-2.5 font-semibold text-right">Qty Sold</th>
                        <th class="px-4 py-2.5 font-semibold text-right">Orders</th>
                        <th class="px-4 py-2.5 font-semibold text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $index => $item)
                        <tr>
                            <td class="px-4 py-2.5 text-[13px] text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-4 py-2.5 text-[13px] text-slate-700 font-medium">{{ $item->name }}</td>
                            <td class="px-4 py-2.5 text-[13px] text-slate-600 text-right">{{ number_format($item->total_qty) }}</td>
                            <td class="px-4 py-2.5 text-[13px] text-slate-600 text-right">{{ number_format($item->order_count) }}</td>
                            <td class="px-4 py-2.5 text-[13px] text-slate-600 text-right">Rs. {{ number_format($item->total_revenue, 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-[13px] text-slate-400">
                                No items sold in this date range.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection