@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500 text-sm mt-1">Welcome back, {{ auth()->user()->name }}</p>
</div>

{{-- Stats cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-sm text-gray-500">Total Users</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\User::count() }}</p>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-orange-500 hover:underline mt-2 block">View all →</a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-sm text-gray-500">Menu Items</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\MenuItem::count() }}</p>
        <p class="text-xs text-gray-400 mt-2">Managed by Kitchen</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-sm text-gray-500">Total Orders</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Order::count() }}</p>
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-orange-500 hover:underline mt-2 block">View all →</a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-sm text-gray-500">Total Revenue</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">
            Rs. {{ number_format(\App\Models\Payment::where('status','paid')->sum('amount'), 2) }}
        </p>
        <a href="{{ route('admin.payments.index') }}" class="text-xs text-orange-500 hover:underline mt-2 block">View all →</a>
    </div>
</div>

{{-- Recent orders --}}
<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">Recent Orders</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-orange-500 hover:underline">View all</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Order #</th>
                    <th class="px-6 py-3 text-left">Student</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\Order::with('user')->latest()->take(5)->get() as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 font-medium">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-500 hover:underline">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td class="px-6 py-3 text-gray-600">{{ $order->user->name }}</td>
                    <td class="px-6 py-3">
                        @include('components.status-badge', ['status' => $order->status])
                    </td>
                    <td class="px-6 py-3 text-gray-800">Rs. {{ number_format($order->total_amount, 2) }}</td>
                    <td class="px-6 py-3 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">No orders yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection