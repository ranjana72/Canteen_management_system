@extends('layouts.app')

@section('title','Payment Details')
@section('page-title', 'Payment Details')

@section('content')

<div class="mb-5">
    <a href="{{ route('kitchen.payments.index') }}"
       class="inline-flex items-center gap-1 text-[13px] font-medium text-[#002147] hover:underline">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Payments
    </a>
</div>

<div class="bg-white rounded-xl border border-slate-200 max-w-lg p-6">

    <h1 class="text-xl font-bold text-slate-800 mb-5">Payment Details</h1>

    <div class="space-y-4">

        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <span class="text-[13px] text-slate-500">Payment ID</span>
            <span class="text-[13px] font-semibold text-slate-800">#{{ $payment->id }}</span>
        </div>

        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <span class="text-[13px] text-slate-500">Order #</span>
            <span class="text-[13px] font-semibold text-slate-800">{{ $payment->order->order_number ?? '—' }}</span>
        </div>

        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <span class="text-[13px] text-slate-500">Student</span>
            <span class="text-[13px] font-semibold text-slate-800">{{ $payment->user->name }}</span>
        </div>

        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <span class="text-[13px] text-slate-500">Amount</span>
            <span class="text-[13px] font-bold text-slate-800">Rs. {{ number_format($payment->amount, 2) }}</span>
        </div>

        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <span class="text-[13px] text-slate-500">Payment Method</span>
            @if($payment->method === 'cash')
                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 text-[12px] font-semibold px-2.5 py-1 rounded-full">
                    💵 Cash
                </span>
            @elseif($payment->method === 'esewa')
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[12px] font-semibold px-2.5 py-1 rounded-full">
                    📱 eSewa
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 border border-slate-200 text-[12px] font-semibold px-2.5 py-1 rounded-full capitalize">
                    {{ $payment->method ?? 'Unknown' }}
                </span>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <span class="text-[13px] text-slate-500">Status</span>
            @if($payment->status === 'paid')
                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-[12px] font-semibold px-2.5 py-1 rounded-full capitalize">
                    ✓ {{ $payment->status }}
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-200 text-[12px] font-semibold px-2.5 py-1 rounded-full capitalize">
                    {{ $payment->status }}
                </span>
            @endif
        </div>

        @if($payment->paid_at)
        <div class="flex items-center justify-between border-t border-slate-100 pt-3">
            <span class="text-[13px] text-slate-500">Paid At</span>
            <span class="text-[13px] font-medium text-slate-600">{{ $payment->paid_at->format('d M Y, h:i A') }}</span>
        </div>
        @endif

    </div>

</div>

@endsection