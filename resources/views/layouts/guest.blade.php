<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Academia Canteen')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-50 min-h-screen">

    {{-- PUBLIC NAVBAR --}}
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">

            <a href="{{ route('landing') }}" class="text-xl font-bold text-brand-600">
                🍽️ Academia Canteen
            </a>

            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
                <a href="{{ route('landing') }}" class="hover:text-brand-600 transition {{ request()->routeIs('landing') ? 'text-brand-600' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="hover:text-brand-600 transition {{ request()->routeIs('about') ? 'text-brand-600' : '' }}">About</a>
                <a href="{{ route('contact') }}" class="hover:text-brand-600 transition {{ request()->routeIs('contact') ? 'text-brand-600' : '' }}">Contact</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold bg-brand-600 text-white px-4 py-2 rounded-full hover:bg-brand-700 transition">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-brand-600 transition">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-brand-600 text-white px-4 py-2 rounded-full hover:bg-brand-700 transition">
                        Get Started
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    {{-- PAGE CONTENT --}}
    <main>
        @if(session('success'))
            <div class="max-w-5xl mx-auto mt-4 px-4">
                <div class="px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    ✅ {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-5xl mx-auto mt-4 px-4">
                <div class="px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    ❌ {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>