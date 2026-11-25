<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Academia Canteen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen text-slate-800 antialiased overflow-x-hidden">

    @php
        $studentName  = auth()->user()->name;
        $studentClass = auth()->user()->role;
    @endphp

    <div class="flex min-h-screen">

        {{-- ============================================= --}}
        {{-- SIDEBAR --}}
        {{-- ============================================= --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0e3a8a] text-white flex flex-col -translate-x-full md:translate-x-0 transition-transform duration-200">

            <div class="px-5 py-5 border-b border-white/10 shrink-0">
                <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-white/10 shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18M8 3v4a2 2 0 002 2h0a2 2 0 002-2V3M16 3v6a3 3 0 01-3 3v6"/>
                        </svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-[14px] font-bold tracking-tight text-white">ACADEMIA</span>
                        <span class="block text-[14px] font-bold tracking-tight text-white -mt-0.5">CANTEEN</span>
                    </span>
                </a>
                <p class="text-[11px] text-blue-200 mt-3">Good Food, Better Mood</p>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4">

                <a href="{{ route('student.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium mb-1
                    {{ request()->routeIs('student.dashboard') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <p class="px-3 pt-5 pb-2 text-[11px] font-semibold text-blue-300 uppercase tracking-wider">Ordering</p>

                <a href="{{ route('menu.today') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium mb-1 text-blue-100 hover:bg-white/5 hover:text-white">
                    <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Today's Menu
                </a>

                <a href="{{ route('student.orders.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium mb-1
                    {{ request()->routeIs('student.orders.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    My Orders
                </a>

                <p class="px-3 pt-5 pb-2 text-[11px] font-semibold text-blue-300 uppercase tracking-wider">Account</p>

                <a href="{{ route('student.feedback.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium mb-1
                    {{ request()->routeIs('student.feedback.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Feedback
                </a>

                <a href="{{ route('student.ratings.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium mb-1
                    {{ request()->routeIs('student.ratings.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Ratings
                </a>

                <a href="{{ route('student.payments.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium mb-1
                    {{ request()->routeIs('student.payments.*') ? 'bg-white/15 text-white' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Payments
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium text-blue-100 hover:bg-white/5 hover:text-white transition">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>

        </aside>

        <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden"></div>

        {{-- ============================================= --}}
        {{-- MAIN COLUMN --}}
        {{-- ============================================= --}}
        <div class="flex-1 flex flex-col min-w-0 md:ml-64">

            <nav class="bg-white border-b border-slate-200 sticky top-0 z-20">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center gap-4 min-w-0">
                        <button id="sidebar-toggle" type="button" class="md:hidden text-slate-500 hover:text-slate-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="text-[18px] font-bold text-slate-800 truncate">Feedback</h1>
                    </div>
                    <div class="flex items-center gap-4 shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#0e3a8a] text-white text-[13px] font-semibold uppercase">
                                {{ substr($studentName, 0, 2) }}
                            </div>
                            <div class="hidden sm:block leading-tight">
                                <p class="text-[13px] font-medium text-slate-700">{{ $studentName }}</p>
                                <p class="text-[11px] text-slate-400 capitalize">{{ $studentClass }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-1 min-w-0 p-6">

                @if(session('success'))
                    <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-[14px] rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <h2 class="text-[16px] font-bold text-slate-800">Leave Feedback</h2>
                    <p class="text-[13px] text-slate-500">Orders ready for pickup that don't have feedback yet</p>
                </div>

                @if($pendingFeedbackOrders->isEmpty())
                    <div class="bg-white rounded-xl border border-slate-200 p-10 text-center">
                        <p class="text-[14px] font-semibold text-slate-700">Nothing to review right now</p>
                        <p class="text-[13px] text-slate-400 mt-1">
                            Once one of your orders is ready for pickup, you can leave feedback here.
                        </p>
                        <a href="{{ route('student.ratings.index') }}" class="text-blue-600 font-semibold text-[13px] hover:underline mt-2 inline-block">
                            View your past ratings &rarr;
                        </a>
                    </div>
                @else
                    <div class="flex flex-col gap-4">
                        @foreach($pendingFeedbackOrders as $order)
                            <div class="bg-white rounded-xl border border-slate-200 p-5 flex flex-wrap items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-[13px] font-semibold text-slate-700">{{ $order->order_number }}</p>
                                    <p class="text-[13px] text-slate-500">
                                        @foreach($order->orderItems as $item)
                                            {{ $item->menuItem->name ?? 'Item' }} x{{ $item->quantity }}@if(!$loop->last), @endif
                                        @endforeach
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-1">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                <a href="{{ route('student.orders.feedback.create', $order) }}"
                                    class="px-4 py-2 rounded-lg text-[13px] font-semibold bg-[#0e3a8a] text-white hover:bg-[#0c3175] transition shrink-0">
                                    Leave Feedback
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

            </main>

            @include('partials.footer')

        </div>

    </div>

    <script>
        document.getElementById('sidebar-toggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        });
        document.getElementById('sidebar-overlay')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            this.classList.add('hidden');
        });
    </script>

</body>
</html>