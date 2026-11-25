<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Canteen Management')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.11/css/jquery.dataTables.min.css">

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">

    <div class="flex min-h-screen">

        {{-- ============================================= --}}
        {{-- SIDEBAR (fixed, full height, navy) --}}
        {{-- ============================================= --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-[#002147] text-white flex flex-col -translate-x-full md:translate-x-0 transition-transform duration-200">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-5 border-b border-white/10 shrink-0">
                <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-white/10 shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18M8 3v4a2 2 0 002 2h0a2 2 0 002-2V3M16 3v6a3 3 0 01-3 3v6"/>
                    </svg>
                </span>
                <span class="leading-tight">
                    <span class="block text-[14px] font-bold tracking-tight text-white">ACADEMIA</span>
                    <span class="block text-[14px] font-bold tracking-tight text-white -mt-0.5">CANTEEN</span>
                </span>
            </a>

            {{-- Scrollable Nav --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4">

                {{-- ========================= --}}
                {{-- ADMIN SIDEBAR --}}
                {{-- ========================= --}}
                @if(auth()->user()->role === 'admin')

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Orders</p>

                    <a href="{{ route('menu.today') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('menu.today') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Today's Menu
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('admin.orders.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Orders
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Management</p>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('admin.users.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-2.5-7.12"/>
                        </svg>
                        Users
                    </a>

                    <a href="{{ route('admin.payments.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('admin.payments.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Payments
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Announcements</p>

                    <a href="{{ route('admin.notifications.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('admin.notifications.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Notifications
                    </a>

                {{-- ========================= --}}
                {{-- KITCHEN SIDEBAR --}}
                {{-- ========================= --}}
                @elseif(auth()->user()->role === 'kitchen')

                    <a href="{{ route('kitchen.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.dashboard') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Orders</p>

                    <a href="{{ route('menu.today') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('menu.today') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Today's Menu
                    </a>

                    <a href="{{ route('kitchen.orders.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.orders.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Active Orders
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Menu &amp; Stock</p>

                    <a href="{{ route('kitchen.menu-items.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.menu-items.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Menu Items
                    </a>

                    <a href="{{ route('kitchen.payments.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.payments.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Payments
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Reviews &amp; Feedback</p>

                    <a href="{{ route('kitchen.feedback.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.feedback.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Feedback
                    </a>

                    <a href="{{ route('kitchen.ratings.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.ratings.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Ratings
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Reports</p>

                    <a href="{{ route('kitchen.reports.daily') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.reports.daily') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Daily Report
                    </a>

                    <a href="{{ route('kitchen.reports.sales') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.reports.sales') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M7 15l4-4 3 3 5-6"/>
                        </svg>
                        Sales Report
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Announcements</p>

                    <a href="{{ route('kitchen.notifications.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('kitchen.notifications.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Notifications
                    </a>

                {{-- ========================= --}}
                {{-- STUDENT SIDEBAR --}}
                {{-- ========================= --}}
                @else

                    <a href="{{ route('student.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('student.dashboard') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Menu</p>

                    <a href="{{ route('menu.today') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('menu.today') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Today's Menu
                    </a>

                    <a href="{{ route('student.menu.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('student.menu.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z"/>
                        </svg>
                        Browse Menu
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Orders &amp; Payments</p>

                    <a href="{{ route('student.orders.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('student.orders.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        My Orders
                    </a>

                    <a href="{{ route('student.payments.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium transition
                        {{ request()->routeIs('student.payments.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        My Payments
                    </a>

                @endif

            </nav>

            {{-- Settings / Logout (bottom of sidebar) --}}
            <div class="px-3 py-4 border-t border-white/10 shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-[14px] font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        {{-- Mobile overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden"></div>

        {{-- ============================================= --}}
        {{-- MAIN COLUMN --}}
        {{-- ============================================= --}}
        <div class="flex-1 flex flex-col min-w-0 md:ml-64">

            {{-- TOP NAVBAR --}}
            <nav class="bg-white border-b border-slate-200 sticky top-0 z-20">
                <div class="flex items-center justify-between h-16 px-6">

                    <div class="flex items-center gap-4 min-w-0">
                        {{-- Mobile menu toggle --}}
                        <button id="sidebar-toggle" type="button" class="md:hidden text-slate-500 hover:text-slate-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <h1 class="text-[18px] font-bold text-slate-800 truncate">
                            @yield('page-title', 'Dashboard')
                        </h1>
                    </div>

                    {{-- User Info + Notification Bell --}}
                    <div class="flex items-center gap-4 shrink-0">

                        {{-- Notification Bell --}}
                        <div class="relative">
                            <button id="notif-bell-btn" type="button" class="relative text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span id="notif-bell-badge" class="hidden absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 items-center justify-center"></span>
                            </button>

                            <div id="notif-bell-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl border border-slate-200 shadow-lg z-50 max-h-96 overflow-y-auto">
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <p class="text-[13px] font-bold text-slate-800">Notifications</p>
                                </div>
                                <div id="notif-bell-list" class="divide-y divide-slate-100">
                                    <p class="px-4 py-6 text-center text-[13px] text-slate-400">Loading...</p>
                                </div>
                            </div>
                        </div>

                        @auth
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#eef2ff] text-[#002147] text-[13px] font-semibold uppercase">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="hidden sm:block leading-tight">
                                    <p class="text-[13px] font-medium text-slate-700">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                                </div>
                            </div>
                        @endauth
                    </div>

                </div>
            </nav>

            {{-- MAIN CONTENT --}}
            <main class="flex-1 min-w-0 p-6">

                @if(session('success'))
                    <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-[14px] rounded-lg">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-[14px] rounded-lg">
                        <svg class="w-4.5 h-4.5 shrink-0" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </main>

            @include('partials.footer')

        </div>

    </div>

    {{-- jQuery (required by DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>

    <script>
        document.getElementById('sidebar-toggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        });
        document.getElementById('sidebar-overlay')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            this.classList.add('hidden');
        });

        // Notification bell — fetch active notifications and render dropdown
        const bellBtn = document.getElementById('notif-bell-btn');
        const bellDropdown = document.getElementById('notif-bell-dropdown');
        const bellList = document.getElementById('notif-bell-list');
        const bellBadge = document.getElementById('notif-bell-badge');

        function loadNotifications() {
            fetch('{{ route("notifications.active") }}')
                .then(res => res.json())
                .then(json => {
                    const items = json.data || [];

                    if (items.length === 0) {
                        bellList.innerHTML = '<p class="px-4 py-6 text-center text-[13px] text-slate-400">No notifications right now.</p>';
                        bellBadge.classList.add('hidden');
                        return;
                    }

                    bellBadge.textContent = items.length;
                    bellBadge.classList.remove('hidden');
                    bellBadge.classList.add('flex');

                    bellList.innerHTML = items.map(n => `
                        <div class="px-4 py-3">
                            <p class="text-[13px] font-semibold text-slate-800">${n.title}</p>
                            <p class="text-[12px] text-slate-500 mt-0.5">${n.message}</p>
                        </div>
                    `).join('');
                })
                .catch(() => {
                    bellList.innerHTML = '<p class="px-4 py-6 text-center text-[13px] text-slate-400">Could not load notifications.</p>';
                });
        }

        bellBtn?.addEventListener('click', function (e) {
            e.stopPropagation();
            bellDropdown.classList.toggle('hidden');
            if (!bellDropdown.classList.contains('hidden')) {
                loadNotifications();
            }
        });

        document.addEventListener('click', function (e) {
            if (!bellDropdown.contains(e.target) && !bellBtn.contains(e.target)) {
                bellDropdown.classList.add('hidden');
            }
        });

        // Load once on page load to show the badge count immediately
        loadNotifications();
    </script>

</body>
</html>