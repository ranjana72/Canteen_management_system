@extends('layouts.app')
@section('title', 'User Details')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Users</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $user->name }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- User info card --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-semibold text-gray-700 mb-4">Profile</h2>
        <dl class="space-y-3 text-sm">
            <div><dt class="text-gray-400">Name</dt><dd class="font-medium text-gray-800">{{ $user->name }}</dd></div>
            <div><dt class="text-gray-400">Email</dt><dd class="text-gray-800">{{ $user->email }}</dd></div>
            <div><dt class="text-gray-400">Role</dt><dd>@include('components.status-badge', ['status' => $user->role])</dd></div>
            <div><dt class="text-gray-400">Joined</dt><dd class="text-gray-800">{{ $user->created_at->format('d M Y') }}</dd></div>
        </dl>
        <div class="mt-5 flex gap-3">
            <a href="{{ route('admin.users.edit', $user) }}"
               class="text-sm bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition">Edit</a>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Delete this user?')">
                @csrf @method('DELETE')
                <button class="text-sm text-red-400 hover:text-red-600 px-4 py-2">Delete</button>
            </form>
        </div>
    </div>

    {{-- Orders list --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-700">Orders ({{ $user->orders->count() }})</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Order #</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($user->orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-500 hover:underline">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td class="px-6 py-3">@include('components.status-badge', ['status' => $order->status])</td>
                    <td class="px-6 py-3">Rs. {{ number_format($order->total_amount, 2) }}</td>
                    <td class="px-6 py-3 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection