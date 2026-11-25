{{-- Footer — reusable partial --}}
{{-- Usage: @include('partials.footer') --}}

<footer class="bg-[#001529] text-slate-300 mt-16">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">

        {{-- Brand + About --}}
        <div class="md:col-span-2">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('images/canteen-logo.png') }}" alt="Academia Canteen"
                     class="w-10 h-10 rounded-lg object-cover ring-1 ring-white/10"
                     onerror="this.style.display='none'">
                <h2 class="text-white font-bold text-[17px] tracking-tight">Academia Canteen</h2>
            </div>
            <p class="text-[13px] text-slate-400 leading-relaxed max-w-md">
                Welcome to the Academia International College Canteen, where students and
                staff can enjoy fresh, delicious, and affordable meals every day. We serve
                a wide variety of snacks, beverages, and full meals prepared with quality
                ingredients in a clean and welcoming environment. Our canteen is committed
                to providing fast service, hygienic food, and a comfortable space where
                everyone can relax, dine, and recharge between classes.
            </p>

            
        </div>

        {{-- Quick Links --}}
        <div>
            <h3 class="text-white font-semibold text-[12px] uppercase tracking-wider mb-4">Quick Links</h3>
            <ul class="space-y-2 text-[13px]">
                <li><a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors">Home</a></li>
                <li><a href="{{ route('menu.today') }}" class="text-slate-400 hover:text-white transition-colors">Today's Menu</a></li>
                <li><a href="{{ route('about') }}" class="text-slate-400 hover:text-white transition-colors">About Us</a></li>
                <li><a href="{{ route('contact') }}" class="text-slate-400 hover:text-white transition-colors">Contact</a></li>
            </ul>
        </div>

        {{-- Contact / Hours --}}
        <div>
            <h3 class="text-white font-semibold text-[12px] uppercase tracking-wider mb-4">Visit Us</h3>
            <ul class="space-y-3 text-[13px] text-slate-400">
                <li class="flex items-start gap-2.5">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Academia International College<br>Gwarko Chowk, Lalitpur – 7, Nepal</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Mon – Sat: 7:30 AM – 5:30 PM<br>Sunday: Closed</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <a href="mailto:mail@academiacollege.edu.np" class="hover:text-white transition-colors">mail@academiacollege.edu.np</a>
                </li>
                <li class="flex items-start gap-2.5">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>+977 (1) 5425393, 5443037</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-[12px] text-slate-500">
            <p>&copy; {{ date('Y') }} Academia Canteen. All rights reserved.</p>
            <p>Built as part of an internship project.</p>
        </div>
    </div>
</footer>