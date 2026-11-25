@extends('layouts.app')

@section('title', 'Student Dashboard')
@section('page-title', 'Student Dashboard')

@section('content')

@php
    // Static extras not yet backed by DB tables — replace when ready
    $studentName  = auth()->user()->name;
    $studentClass = 'BCA 7th Semester';
    $rewardPoints = 250;

    $stats = [
        ['label' => "Today's Menu", 'value' => $todaysMenuCount, 'sub' => 'Items Available', 'link' => 'View Menu', 'route' => 'menu.today', 'icon' => 'menu', 'bg' => 'bg-blue-50', 'fg' => 'text-blue-600'],
        ['label' => 'My Orders', 'value' => $myActiveOrdersCount, 'sub' => 'Active Orders', 'link' => 'View Orders', 'route' => 'student.orders.index', 'icon' => 'bag', 'bg' => 'bg-green-50', 'fg' => 'text-green-600'],
        ['label' => 'Reward Points', 'value' => $rewardPoints . ' pts', 'sub' => 'Keep Ordering', 'link' => 'View Rewards', 'route' => 'student.dashboard', 'icon' => 'star', 'bg' => 'bg-amber-50', 'fg' => 'text-amber-500'],
    ];

    $statusStyle = fn($s) => match($s) {
        'ready'     => 'bg-green-50 text-green-700 border-green-200',
        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
        'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
        default     => 'bg-slate-100 text-slate-500 border-slate-200',
    };

    $statusLabel = fn($s) => match($s) {
        'ready'     => 'Ready for Pickup',
        'confirmed' => 'Preparing',
        'pending'   => 'Pending',
        default     => ucfirst($s),
    };
@endphp

{{-- Stat cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 mb-6">
    @foreach($stats as $stat)
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <span class="flex items-center justify-center w-11 h-11 rounded-full {{ $stat['bg'] }} shrink-0">
                    @switch($stat['icon'])
                        @case('menu')
                            <svg class="w-5 h-5 {{ $stat['fg'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            @break
                        @case('bag')
                            <svg class="w-5 h-5 {{ $stat['fg'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z"/></svg>
                            @break
                        @case('star')
                            <svg class="w-5 h-5 {{ $stat['fg'] }}" fill="currentColor" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            @break
                    @endswitch
                </span>
                <p class="text-[13px] text-slate-500 font-medium">{{ $stat['label'] }}</p>
            </div>
            <p class="text-[26px] font-bold text-slate-800 leading-tight">{{ $stat['value'] }}</p>
            <p class="text-[12px] text-slate-400 mb-2">{{ $stat['sub'] }}</p>
            <a href="{{ route($stat['route']) }}" class="text-[12px] font-semibold text-blue-600 hover:underline inline-flex items-center gap-1">
                {{ $stat['link'] }} <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6 items-start">

    <div class="flex flex-col gap-6 min-w-0">

        {{-- Today's Menu — LIVE from Kitchen's MenuItem table --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-[16px] font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-4.5 h-4.5 text-blue-600" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M7 15l4-4 3 3 5-6"/></svg>
                    Today's Menu
                </h2>
                <a href="{{ route('menu.today') }}" class="text-[12px] font-semibold text-blue-600 hover:underline">View All</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($todaysMenu as $item)
                    <div class="border border-slate-100 rounded-xl overflow-hidden hover:shadow-sm transition-shadow duration-200">
                        <div class="relative h-36 bg-slate-100">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-3.5 text-center">
                            <p class="text-[14px] font-semibold text-slate-800 truncate">{{ $item->name }}</p>
                            <p class="text-[14px] font-bold text-[#0e3a8a] mt-1">Rs. {{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-[13px] text-slate-400">
                        No items available right now.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Orders — LIVE, this student's own orders --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="text-[16px] font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-4.5 h-4.5 text-blue-600" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Recent Orders
                </h2>
                <a href="{{ route('student.orders.index') }}" class="text-[12px] font-semibold text-blue-600 hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                            <th class="px-4 py-2.5 font-semibold">Order ID</th>
                            <th class="px-4 py-2.5 font-semibold">Items</th>
                            <th class="px-4 py-2.5 font-semibold">Status</th>
                            <th class="px-4 py-2.5 font-semibold">Placed</th>
                            <th class="px-4 py-2.5 font-semibold">Total</th>
                            <th class="px-4 py-2.5 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-4 py-2.5 text-[13px] font-semibold text-slate-700">{{ $order->order_number }}</td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-600">
                                    @foreach($order->orderItems as $oi)
                                        {{ $oi->menuItem->name ?? 'Item' }} x{{ $oi->quantity }}@if(!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td class="px-4 py-2.5">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $statusStyle($order->status) }}">
                                        {{ $statusLabel($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2.5 text-[13px] text-slate-500">{{ $order->created_at->format('d M, h:i A') }}</td>
                                <td class="px-4 py-2.5 text-[13px] font-semibold text-slate-700">Rs. {{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-4 py-2.5 text-right">
                                    <a href="{{ route('student.orders.show', $order) }}" class="px-3 py-1.5 rounded-lg text-[12px] font-semibold border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition inline-block">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-[13px] text-slate-400">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-3 border-t border-slate-100 text-center">
                <a href="{{ route('student.orders.index') }}" class="text-[13px] font-semibold text-blue-600 hover:underline">View All Orders &rarr;</a>
            </div>
        </div>

        {{-- Feedback + Canteen Timings --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <h3 class="text-[14px] font-bold text-slate-800 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Share Your Feedback
                </h3>
                <p class="text-[13px] text-slate-500 mb-3">How was your recent meal?</p>
                <a href="{{ route('student.feedback.index') }}" class="inline-block px-4 py-2 rounded-lg bg-[#0e3a8a] text-white text-[13px] font-semibold hover:bg-[#0c3175] transition">
                    Write a Review
                </a>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <h3 class="text-[14px] font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Canteen Timings
                </h3>
                <p class="text-[12px] text-slate-400">Monday – Saturday</p>
                <p class="text-[16px] font-bold text-slate-800 mb-3">7:30 AM – 5:30 PM</p>
                <p class="text-[12px] text-slate-400">Sunday</p>
                <p class="text-[14px] font-bold text-red-500">Closed</p>
            </div>
        </div>

    </div>

    {{-- Right sidebar panels --}}
    <div class="flex flex-col gap-5">

        {{-- My Order Status — LIVE --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-[14px] font-bold text-slate-800">My Order Status</h3>
                <a href="{{ route('student.orders.index') }}" class="text-[12px] font-semibold text-blue-600 hover:underline">View All Orders</a>
            </div>

            @if($activeOrder)
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[13px] font-semibold text-slate-700">Order #{{ $activeOrder->order_number }}</span>
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $statusStyle($activeOrder->status) }}">
                        {{ $statusLabel($activeOrder->status) }}
                    </span>
                </div>

                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100">
                    <div class="w-11 h-11 rounded-lg bg-slate-100 shrink-0"></div>
                    <div class="min-w-0">
                        <p class="text-[13px] font-medium text-slate-700 truncate">
                            @foreach($activeOrder->orderItems as $oi)
                                {{ $oi->menuItem->name ?? 'Item' }} x{{ $oi->quantity }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                        <p class="text-[11px] text-slate-400">Ordered on: {{ $activeOrder->created_at->format('d M, Y h:i A') }}</p>
                    </div>
                </div>

                <a href="{{ route('student.orders.show', $activeOrder) }}" class="block text-center w-full py-2.5 rounded-lg bg-[#0e3a8a] text-white text-[13px] font-semibold hover:bg-[#0c3175] transition mb-4">
                    View Details
                </a>

                <div class="flex flex-col gap-3">
                    @php
                        $steps = [
                            ['key' => 'pending',   'label' => 'Order Placed'],
                            ['key' => 'confirmed', 'label' => 'Preparing'],
                            ['key' => 'ready',     'label' => 'Ready for Pickup'],
                        ];
                        $orderMap = ['pending' => 0, 'confirmed' => 1, 'ready' => 2];
                        $currentIdx = $orderMap[$activeOrder->status] ?? 0;
                    @endphp
                    @foreach($steps as $i => $step)
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0
                                {{ $i < $currentIdx ? 'bg-green-500' : ($i === $currentIdx ? 'bg-white border-2 border-blue-600' : 'bg-slate-100 border-2 border-slate-200') }}">
                                @if($i < $currentIdx)
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                @elseif($i === $currentIdx)
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                @endif
                            </span>
                            <span class="flex-1 text-[13px] {{ $i === $currentIdx ? 'font-semibold text-blue-600' : ($i < $currentIdx ? 'text-slate-700' : 'text-slate-400') }}">
                                {{ $step['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-[13px] text-slate-400 py-4 text-center">No active orders right now.</p>
            @endif
        </div>

        {{-- Popular Items — LIVE (image thumbnail added) --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-[14px] font-bold text-slate-800">Popular Items</h3>
            </div>
            <div class="flex flex-col gap-3">
                @forelse($popularItems as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-9 h-9 rounded-lg bg-slate-100 shrink-0 overflow-hidden">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <p class="text-[13px] font-medium text-slate-700 truncate">{{ $item->name }}</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 shrink-0">
                            {{ $item->total_qty }}
                        </span>
                    </div>
                @empty
                    <p class="text-[13px] text-slate-400">No orders yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Latest Announcement — LIVE --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h3 class="text-[14px] font-bold text-slate-800 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Latest Announcements
            </h3>
            @if($announcement)
                <div class="border border-slate-100 rounded-lg p-3">
                    <p class="text-[13px] font-semibold text-slate-700">{{ $announcement->title }}</p>
                    <p class="text-[12px] text-slate-500 mt-0.5">{{ $announcement->message }}</p>
                    <p class="text-[11px] text-slate-400 mt-2">{{ $announcement->created_at->diffForHumans() }}</p>
                </div>
            @else
                <p class="text-[13px] text-slate-400">No announcements yet.</p>
            @endif
        </div>

    </div>

</div>

@endsection