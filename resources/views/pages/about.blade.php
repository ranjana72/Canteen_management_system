@extends('layouts.guest')

@section('title', 'About Us')

@section('content')

<div class="max-w-3xl mx-auto py-12 px-4">

    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-text-primary tracking-tight">About Academia Canteen</h1>
        <p class="text-sm text-text-tertiary mt-2">Serving Academia International College since day one.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8">
        <p class="text-gray-600 leading-relaxed">
            Welcome to the Academia International College Canteen, where students and
            staff can enjoy fresh, delicious, and affordable meals every day. We serve
            a wide variety of snacks, beverages, and full meals prepared with quality
            ingredients in a clean and welcoming environment. Our canteen is committed
            to providing fast service, hygienic food, and a comfortable space where
            everyone can relax, dine, and recharge between classes.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            <div class="w-11 h-11 mx-auto rounded-xl bg-brand-50 flex items-center justify-center text-2xl mb-3">🍽️</div>
            <h3 class="font-bold text-text-primary text-sm">Fresh Meals Daily</h3>
            <p class="text-xs text-text-tertiary mt-1">Prepared fresh every morning with quality ingredients.</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            <div class="w-11 h-11 mx-auto rounded-xl bg-emerald-50 flex items-center justify-center text-2xl mb-3">💸</div>
            <h3 class="font-bold text-text-primary text-sm">Affordable Prices</h3>
            <p class="text-xs text-text-tertiary mt-1">Student-friendly pricing on everything we serve.</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            <div class="w-11 h-11 mx-auto rounded-xl bg-brand-50 flex items-center justify-center text-2xl mb-3">⚡</div>
            <h3 class="font-bold text-text-primary text-sm">Fast Service</h3>
            <p class="text-xs text-text-tertiary mt-1">Quick turnaround so you're back to class on time.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mt-8">
        <h2 class="font-bold text-text-primary mb-4">Visit Us</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 shrink-0 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Academia International College<br>Gwarko Chowk, Lalitpur – 7, Nepal</span>
            </div>
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 mt-0.5 shrink-0 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Mon – Sat: 7:30 AM – 5:30 PM<br>Sunday: Closed</span>
            </div>
        </div>
    </div>

</div>

@endsection