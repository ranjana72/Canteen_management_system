@extends('layouts.app')
@section('title', 'My Payments')

@section('content')

<div class="mb-5">
    <h1 class="text-xl font-bold text-slate-800">My Payments</h1>
    <p class="text-[13px] text-slate-400 mt-0.5">All your order payment records</p>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-[13px]">
        <thead class="bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wider">
            <tr>
                <th class="px-4 py-2.5 text-left font-semibold">Order #</th>
                <th class="px-4 py-2.5 text-left font-semibold">Method</th>
                <th class="px-4 py-2.5 text-left font-semibold">Status</th>
                <th class="px-4 py-2.5 text-left font-semibold">Amount</th>
                <th class="px-4 py-2.5 text-left font-semibold">Paid At</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($payments as $payment)
            <tr class="hover:bg-slate-50/60">
                <td class="px-4 py-2.5 whitespace-nowrap">
                    <a href="{{ route('student.orders.show', $payment->order) }}" class="text-[#002147] font-medium hover:underline">
                        {{ $payment->order->order_number }}
                    </a>
                </td>
                <td class="px-4 py-2.5">@include('components.status-badge', ['status' => $payment->method])</td>
                <td class="px-4 py-2.5">@include('components.status-badge', ['status' => $payment->status])</td>
                <td class="px-4 py-2.5 font-semibold text-slate-800 whitespace-nowrap">Rs. {{ number_format($payment->amount, 2) }}</td>
                <td class="px-4 py-2.5 text-slate-400 whitespace-nowrap">
                    {{ $payment->paid_at ? $payment->paid_at->format('d M Y') : '—' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-10 text-center text-slate-400 text-[13px]">No payments yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($payments->hasPages())
    <div class="px-4 py-3 border-t border-slate-100">{{ $payments->links() }}</div>
    @endif
</div>

@endsection