@extends('layouts.app')
@section('title', 'Edit Payment')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.payments.index') }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Payments</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Update Payment Status</h1>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-lg">

    {{-- Payment info --}}
    <dl class="grid grid-cols-2 gap-4 text-sm mb-6 pb-6 border-b border-gray-100">
        <div><dt class="text-gray-400">Order</dt><dd class="font-medium">{{ $payment->order->order_number }}</dd></div>
        <div><dt class="text-gray-400">Student</dt><dd class="font-medium">{{ $payment->user->name }}</dd></div>
        <div><dt class="text-gray-400">Amount</dt><dd class="font-medium text-orange-600">Rs. {{ number_format($payment->amount, 2) }}</dd></div>
        <div><dt class="text-gray-400">Method</dt><dd>@include('components.status-badge', ['status' => $payment->method])</dd></div>
        <div><dt class="text-gray-400">Current Status</dt><dd>@include('components.status-badge', ['status' => $payment->status])</dd></div>
    </dl>

    <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
            <select name="status"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                @foreach(['pending','paid','failed'] as $s)
                <option value="{{ $s }}" {{ $payment->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Transaction ID <span class="text-gray-400">(optional, for online payments)</span>
            </label>
            <input type="text" name="transaction_id" value="{{ old('transaction_id', $payment->transaction_id) }}"
                placeholder="Gateway reference number"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                Save Changes
            </button>
            <a href="{{ route('admin.payments.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 px-4 py-2.5">Cancel</a>
        </div>
    </form>
</div>

@endsection