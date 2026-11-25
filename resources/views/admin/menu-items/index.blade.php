@extends('layouts.app')

@section('title', 'Menu Items')

@section('content')

@php
    $routePrefix = auth()->user()->role === 'kitchen' ? 'kitchen' : 'admin';
@endphp

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Menu Items</h1>
        <p class="text-sm text-gray-500 mt-1">
            {{ $menuItems->total() }} {{ Str::plural('item', $menuItems->total()) }} on the menu
        </p>
    </div>

    <a href="{{ route($routePrefix.'.menu-items.create') }}"
       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 active:scale-95 transition-all duration-150 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm shadow-orange-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Add Menu Item
    </a>
</div>

{{-- ===================== ALL MENU ITEMS ===================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($menuItems as $item)
        @include('partials.menu-item-card', ['item' => $item, 'routePrefix' => $routePrefix])
    @empty
        <div class="col-span-full">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                <div class="text-5xl mb-3">🍽️</div>
                <h2 class="text-lg font-bold text-gray-900">No Menu Items Found</h2>
                <p class="text-gray-500 mt-1 text-sm">Click "Add Menu Item" to create your first menu item.</p>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $menuItems->links() }}
</div>

@endsection