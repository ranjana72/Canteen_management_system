@extends('layouts.app')

@section('title', 'Kitchen Payments')

@section('content')

<div class="mb-5">
    <h1 class="text-xl font-bold text-slate-800">Kitchen Payments</h1>
    <p class="text-[13px] text-slate-400 mt-0.5">All payment records for kitchen orders</p>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

    <table class="w-full text-[13px]">

        <thead class="bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wider">
            <tr>
                <th class="px-4 py-2.5 text-left font-semibold">Payment ID</th>
                <th class="px-4 py-2.5 text-left font-semibold">Student</th>
                <th class="px-4 py-2.5 text-left font-semibold">Phone</th>
                <th class="px-4 py-2.5 text-left font-semibold">Order</th>
                <th class="px-4 py-2.5 text-left font-semibold">Amount</th>
                <th class="px-4 py-2.5 text-left font-semibold">Status</th>
                <th class="px-4 py-2.5 text-left font-semibold">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100">

        @forelse($payments as $payment)

            <tr class="hover:bg-slate-50/60">

                <td class="px-4 py-2.5 text-slate-500 whitespace-nowrap">
                    #{{ $payment->id }}
                </td>

                <td class="px-4 py-2.5 text-slate-700 whitespace-nowrap">
                    {{ $payment->user->name ?? '-' }}
                </td>

                <td class="px-4 py-2.5 text-slate-400 text-[12px] whitespace-nowrap">
                    {{ $payment->order->phone ?? '—' }}
                </td>

                <td class="px-4 py-2.5 text-slate-600 font-medium whitespace-nowrap">
                    {{ $payment->order->order_number ?? '-' }}
                </td>

                <td class="px-4 py-2.5 font-semibold text-slate-800 whitespace-nowrap">
                    Rs. {{ number_format($payment->amount, 2) }}
                </td>

                <td class="px-4 py-2.5">
                    @if($payment->status === 'paid')
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Paid
                        </span>
                    @elseif($payment->status === 'pending')
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Pending
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-600 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            {{ ucfirst($payment->status) }}
                        </span>
                    @endif
                </td>

                <td class="px-4 py-2.5 whitespace-nowrap">
                    <a href="{{ route('kitchen.payments.show', $payment) }}"
                       class="text-[12px] font-medium text-[#002147] hover:underline">
                        View
                    </a>
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="text-center py-10 text-slate-400 text-[13px]">
                    No payments found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    @if($payments->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">
        {{ $payments->links() }}
    </div>
    @endif

</div>

@endsection