@extends('layouts.app')

@section('title', 'Sales Report')
@section('page-title', 'Sales Report')

@section('content')

    {{-- Date range picker --}}
    <form method="GET" action="{{ route('kitchen.reports.sales') }}" class="flex flex-wrap items-center gap-3 mb-6">
        <label class="text-[13px] font-medium text-slate-600">From:</label>
        <input type="date" name="from" value="{{ $from->format('Y-m-d') }}"
            class="px-3 py-2 rounded-lg border border-slate-200 text-[13px] focus:outline-none focus:ring-2 focus:ring-[#002147]/20">

        <label class="text-[13px] font-medium text-slate-600">To:</label>
        <input type="date" name="to" value="{{ $to->format('Y-m-d') }}"
            class="px-3 py-2 rounded-lg border border-slate-200 text-[13px] focus:outline-none focus:ring-2 focus:ring-[#002147]/20">

        <button type="submit"
            class="px-4 py-2 rounded-lg text-[13px] font-semibold bg-[#002147] text-white hover:bg-[#00305f] transition">
            View
        </button>
    </form>

    {{-- Summary cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Total Revenue (orders)</p>
            <p class="text-[24px] font-bold text-slate-800">Rs. {{ number_format($totalRevenue, 0) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Total Orders</p>
            <p class="text-[24px] font-bold text-slate-800">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-[13px] text-slate-500">Total Collected (paid)</p>
            <p class="text-[24px] font-bold text-green-600">Rs. {{ number_format($paidTotal, 0) }}</p>
        </div>

    </div>

    {{-- Daily breakdown table --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="text-[16px] font-bold text-slate-800">Revenue by Day</h2>
            <p class="text-[12px] text-slate-400">
                {{ $from->format('M j, Y') }} — {{ $to->format('M j, Y') }}
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                        <th class="px-4 py-2.5 font-semibold">Date</th>
                        <th class="px-4 py-2.5 font-semibold text-right">Orders</th>
                        <th class="px-4 py-2.5 font-semibold text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dailySales as $day)
                        <tr>
                            <td class="px-4 py-2.5 text-[13px] text-slate-700">
                                {{ \Carbon\Carbon::parse($day->day)->format('D, M j Y') }}
                            </td>
                            <td class="px-4 py-2.5 text-[13px] text-slate-600 text-right">{{ $day->order_count }}</td>
                            <td class="px-4 py-2.5 text-[13px] text-slate-600 text-right">Rs. {{ number_format($day->revenue, 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-[13px] text-slate-400">
                                No sales in this date range.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($dailySales->count() > 0)
                    <tfoot>
                        <tr class="bg-slate-50 font-semibold">
                            <td class="px-4 py-2.5 text-[13px] text-slate-800">Total</td>
                            <td class="px-4 py-2.5 text-[13px] text-slate-800 text-right">{{ $totalOrders }}</td>
                            <td class="px-4 py-2.5 text-[13px] text-slate-800 text-right">Rs. {{ number_format($totalRevenue, 0) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

@endsection