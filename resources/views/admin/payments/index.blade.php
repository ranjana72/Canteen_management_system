@extends('layouts.app')
@section('title', 'Payments')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Payments</h1>
    <p class="text-sm text-gray-400 mt-1">Check if students have paid before preparing orders</p>
</div>

{{-- Quick stats --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
        <p class="text-2xl font-bold text-green-600">
            {{ \App\Models\Payment::where('status', 'paid')->count() }}
        </p>
        <p class="text-xs text-green-600 font-medium mt-1">✅ Paid</p>
    </div>
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
        <p class="text-2xl font-bold text-yellow-600">
            {{ \App\Models\Payment::where('status', 'pending')->count() }}
        </p>
        <p class="text-xs text-yellow-600 font-medium mt-1">⏳ Pending</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
        <p class="text-2xl font-bold text-red-500">
            {{ \App\Models\Payment::where('status', 'failed')->count() }}
        </p>
        <p class="text-xs text-red-500 font-medium mt-1">❌ Failed</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3 text-left">Order #</th>
                <th class="px-6 py-3 text-left">Student</th>
                <th class="px-6 py-3 text-left">Method</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Amount</th>
                <th class="px-6 py-3 text-left">Paid At</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($payments as $payment)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium text-gray-800">
                    {{ $payment->order->order_number }}
                </td>
                <td class="px-6 py-3 text-gray-600">{{ $payment->user->name }}</td>
                <td class="px-6 py-3">
                    @include('components.status-badge', ['status' => $payment->method])
                </td>
                <td class="px-6 py-3">
                    @include('components.status-badge', ['status' => $payment->status])
                </td>
                <td class="px-6 py-3 font-medium text-gray-800">
                    Rs. {{ number_format($payment->amount, 2) }}
                </td>
                <td class="px-6 py-3 text-gray-400">
                    {{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : '—' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                    No payments found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($payments->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $payments->links() }}
    </div>
    @endif
</div>

@endsection