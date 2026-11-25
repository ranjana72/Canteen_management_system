{{--
    Reusable status badge.
    Usage: @include('components.status-badge', ['status' => $order->status])
--}}
@php
    $colors = [
        'pending'   => 'bg-yellow-100 text-yellow-700',
        'confirmed' => 'bg-blue-100 text-blue-700',
        'ready'     => 'bg-purple-100 text-purple-700',
        'delivered' => 'bg-green-100 text-green-700',
        'paid'      => 'bg-green-100 text-green-700',
        'failed'    => 'bg-red-100 text-red-700',
        'cash'      => 'bg-gray-100 text-gray-700',
        'online'    => 'bg-blue-100 text-blue-700',
        'admin'     => 'bg-purple-100 text-purple-700',
        'student'   => 'bg-orange-100 text-orange-700',
        'kitchen'   => 'bg-green-100 text-green-700',
    ];
    $color = $colors[$status] ?? 'bg-gray-100 text-gray-600';
@endphp

<span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $color }}">
    {{ $status }}
</span>