<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Canteen — Order Ahead, Skip the Line</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-text-primary antialiased">

    {{-- ===================== NAVBAR ===================== --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-[10px] bg-[#0047AB] flex items-center justify-center text-white text-lg">
                    🍽️
                </div>
                <div class="leading-tight">
                    <span class="block font-extrabold text-text-primary text-base">Academia Canteen</span>
                    <span class="block text-[11px] text-text-tertiary font-medium tracking-wide">ACADEMIA INTERNATIONAL COLLEGE</span>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-text-tertiary">
                <a href="#how-it-works" class="hover:text-[#0047AB] transition">How it works</a>
                <a href="#menu-preview" class="hover:text-[#0047AB] transition">Today's Menu</a>
                <a href="{{ route('about') }}" class="hover:text-[#0047AB] transition">About</a>
                <a href="{{ route('contact') }}" class="hover:text-[#0047AB] transition">Contact</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-text-primary hover:text-[#0047AB] transition">Log in</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold bg-[#0047AB] text-white px-4 py-2 rounded-[10px] hover:bg-[#003a8c] transition shadow-sm">Get Started</a>
            </div>
        </div>
    </nav>

    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden bg-slate-50">
        <div class="max-w-6xl mx-auto px-6 pt-20 pb-24 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#0047AB] bg-blue-50 px-3 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live at Academia International College
                </span>
                <h1 class="mt-5 text-5xl md:text-6xl font-black tracking-tight leading-[1.05] text-text-primary">
                    Order ahead.
                    <span class="text-[#0047AB]">Skip the line.</span>
                </h1>
                <p class="mt-5 text-lg text-text-tertiary max-w-md">
                    Browse real-time canteen stock, place your order between classes, and pick it up hot — no queue, no waiting.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="bg-[#0047AB] text-white font-semibold px-6 py-3 rounded-[10px] hover:bg-[#003a8c] transition shadow-md shadow-blue-100">
                        Order Now
                    </a>
                    <a href="#how-it-works" class="border border-slate-300 font-semibold px-6 py-3 rounded-[10px] text-text-primary hover:border-[#0047AB] hover:text-[#0047AB] transition">
                        See how it works
                    </a>
                </div>
            </div>

            {{-- Text content replacing the card --}}
            <div class="relative flex justify-center">
                <div class="w-full max-w-[380px] space-y-6">

                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 shrink-0 rounded-[10px] bg-[#0047AB]/10 flex items-center justify-center text-[#0047AB] text-lg">
                            ⚡
                        </div>
                        <div>
                            <h3 class="font-bold text-text-primary text-[15px]">Built for busy class breaks</h3>
                            <p class="text-text-tertiary text-sm mt-0.5">Order in seconds and never miss your next class waiting in line.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 shrink-0 rounded-[10px] bg-[#0047AB]/10 flex items-center justify-center text-[#0047AB] text-lg">
                            📦
                        </div>
                        <div>
                            <h3 class="font-bold text-text-primary text-[15px]">Live kitchen stock</h3>
                            <p class="text-text-tertiary text-sm mt-0.5">See exactly what's available before you order — no surprises at pickup.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 shrink-0 rounded-[10px] bg-[#0047AB]/10 flex items-center justify-center text-[#0047AB] text-lg">
                            🎓
                        </div>
                        <div>
                            <h3 class="font-bold text-text-primary text-[15px]">Made for Academia students</h3>
                            <p class="text-text-tertiary text-sm mt-0.5">Trusted by students and staff right here at Academia International College.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- ===================== HOW IT WORKS ===================== --}}
    <section id="how-it-works" class="bg-white border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <h2 class="text-3xl font-black text-center mb-2 text-text-primary">How it works</h2>
            <p class="text-center text-text-tertiary mb-14">Three steps between you and lunch.</p>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-14 h-14 mx-auto rounded-[14px] bg-[#0047AB] text-white font-black text-xl flex items-center justify-center mb-4">01</div>
                    <h3 class="font-bold text-lg mb-2 text-text-primary">Browse the menu</h3>
                    <p class="text-text-tertiary text-sm">Check what's available right now with live stock updates from the kitchen.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 mx-auto rounded-[14px] bg-[#0047AB] text-white font-black text-xl flex items-center justify-center mb-4">02</div>
                    <h3 class="font-bold text-lg mb-2 text-text-primary">Place your order</h3>
                    <p class="text-text-tertiary text-sm">Add items to your order and pay securely — no cash needed at the counter.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 mx-auto rounded-[14px] bg-[#0047AB] text-white font-black text-xl flex items-center justify-center mb-4">03</div>
                    <h3 class="font-bold text-lg mb-2 text-text-primary">Pick it up</h3>
                    <p class="text-text-tertiary text-sm">Get notified when it's ready and collect it straight from the kitchen counter.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== TODAY'S AVAILABLE ITEMS PREVIEW ===================== --}}
    <section id="menu-preview" class="max-w-6xl mx-auto px-6 py-20">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-black text-text-primary">Today's Available Items</h2>
            <a href="{{ route('login') }}" class="text-[#0047AB] font-semibold text-sm hover:underline">View full menu →</a>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($previewItems ?? [] as $item)
                <div class="bg-white rounded-[16px] border border-slate-100 shadow-sm hover:shadow-md transition p-4">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                             class="h-32 w-full object-cover rounded-[10px] mb-3">
                    @else
                        <div class="h-32 rounded-[10px] bg-gradient-to-br from-blue-100 to-[#0047AB] mb-3"></div>
                    @endif
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-bold text-text-primary">{{ $item->name }}</p>
                            <span class="inline-block mt-1 text-xs font-semibold bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-[6px]">
                                {{ $item->stock }} left
                            </span>
                        </div>
                        <span class="bg-[#0047AB] text-white text-sm font-bold px-3 py-1.5 rounded-[8px]">Rs. {{ $item->price }}</span>
                    </div>
                </div>
            @empty
                @foreach ([['Veg Thukpa','95','18'], ['Chicken Sandwich','80','12'], ['Milk Tea','35','40']] as [$name, $price, $stock])
                    <div class="bg-white rounded-[16px] border border-slate-100 shadow-sm hover:shadow-md transition p-4">
                        <div class="h-32 rounded-[10px] bg-gradient-to-br from-blue-100 to-[#0047AB] mb-3"></div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-text-primary">{{ $name }}</p>
                                <span class="inline-block mt-1 text-xs font-semibold bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-[6px]">
                                    {{ $stock }} left
                                </span>
                            </div>
                            <span class="bg-[#0047AB] text-white text-sm font-bold px-3 py-1.5 rounded-[8px]">Rs. {{ $price }}</span>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </section>

    {{-- ===================== FEATURES ===================== --}}
    <section class="bg-slate-900 text-white">
        <div class="max-w-6xl mx-auto px-6 py-20 grid md:grid-cols-3 gap-10">
            <div>
                <div class="w-10 h-10 rounded-[10px] bg-[#0047AB] flex items-center justify-center mb-4">📊</div>
                <h3 class="font-bold text-lg mb-2">Real-time stock</h3>
                <p class="text-slate-400 text-sm">Never order something that's already sold out — stock updates live from the kitchen.</p>
            </div>
            <div>
                <div class="w-10 h-10 rounded-[10px] bg-[#0047AB] flex items-center justify-center mb-4">🔐</div>
                <h3 class="font-bold text-lg mb-2">Role-based access</h3>
                <p class="text-slate-400 text-sm">Admins, kitchen staff, and students each get a workspace built for their job.</p>
            </div>
            <div>
                <div class="w-10 h-10 rounded-[10px] bg-[#0047AB] flex items-center justify-center mb-4">💳</div>
                <h3 class="font-bold text-lg mb-2">Simple payments</h3>
                <p class="text-slate-400 text-sm">Track every order and payment in one place — no more end-of-day cash counting.</p>
            </div>
        </div>
    </section>

    {{-- ===================== CTA ===================== --}}
    <section class="max-w-6xl mx-auto px-6 py-20 text-center">
        <h2 class="text-4xl font-black mb-4 text-text-primary">Hungry? We'll have it ready.</h2>
        <p class="text-text-tertiary mb-8">Create your account and place your first order in under a minute.</p>
        <a href="{{ route('register') }}" class="inline-block bg-[#0047AB] text-white font-semibold px-8 py-3 rounded-[10px] hover:bg-[#003a8c] transition shadow-md shadow-blue-100">
            Create Free Account
        </a>
    </section>

    {{-- ===================== FOOTER ===================== --}}
    @include('partials.footer')

</body>
</html>