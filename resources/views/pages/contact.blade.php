@extends('layouts.guest')

@section('title', 'Contact')

@section('content')

<div class="max-w-3xl mx-auto py-12 px-4">

    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-text-primary tracking-tight">Contact Us</h1>
        <p class="text-sm text-text-tertiary mt-2">Have a question? Reach out to us anytime.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-brand-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-text-primary text-sm">Address</h3>
                <p class="text-sm text-text-tertiary mt-1">Academia International College<br>Gwarko Chowk, Lalitpur – 7, Nepal</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-text-primary text-sm">Opening Hours</h3>
                <p class="text-sm text-text-tertiary mt-1">Mon – Sat: 7:30 AM – 5:30 PM<br>Sunday: Closed</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-brand-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-text-primary text-sm">Email</h3>
                <a href="mailto:mail@academiacollege.edu.np" class="text-sm text-brand-600 hover:underline mt-1 inline-block">mail@academiacollege.edu.np</a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-text-primary text-sm">Phone</h3>
                <p class="text-sm text-text-tertiary mt-1">+977 (1) 5425393<br>+977 (1) 5443037</p>
            </div>
        </div>

    </div>

</div>

@endsection