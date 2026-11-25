@extends('layouts.app')
@section('title', 'Menu')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Menu</h1>
        <p class="text-[13px] text-slate-400 mt-1">{{ now()->format('l, F j') }} &middot; {{ $menuItems->where('is_available', true)->count() }} {{ Str::plural('item', $menuItems->where('is_available', true)->count()) }} available</p>
    </div>

    <a href="{{ route('student.orders.create') }}"
       class="inline-flex items-center gap-2 bg-[#002147] hover:bg-[#003a75] text-white font-semibold text-[13px] px-4 py-2 rounded-md transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4z"/>
        </svg>
        Place Order
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($menuItems as $item)
        @include('partials.menu-item-card-readonly', ['item' => $item])
    @empty
        <div class="col-span-full">
            <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
                <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h2 class="text-[15px] font-semibold text-slate-800">No menu items available right now</h2>
                <p class="text-slate-400 mt-1 text-[13px]">Check back later!</p>
            </div>
        </div>
    @endforelse
</div>

@endsection