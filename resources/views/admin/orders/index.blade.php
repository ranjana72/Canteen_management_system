@extends('layouts.app')

@section('title', 'Orders')

@section('content')

<h1 class="text-2xl font-bold mb-6">Orders</h1>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left">Order No.</th>
                <th class="px-4 py-3 text-left">Student</th>
                <th class="px-4 py-3 text-left">Total</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Date</th>
                <th class="px-4 py-3 text-left">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $order)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $order->order_number }}</td>
                <td class="px-4 py-3">{{ $order->user->name ?? 'N/A' }}</td>
                <td class="px-4 py-3">Rs. {{ number_format($order->total_amount,2) }}</td>
                <td class="px-4 py-3">{{ ucfirst($order->status) }}</td>
                <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('admin.orders.show',$order) }}"
                       class="text-blue-600 hover:underline">
                        View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-6">
                    No orders found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>

@endsection