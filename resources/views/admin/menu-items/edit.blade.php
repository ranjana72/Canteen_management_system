@extends('layouts.app')
@section('title', 'Edit Menu Item')

@section('content')

@php
    $routePrefix = auth()->user()->role === 'kitchen' ? 'kitchen' : 'admin';
@endphp

<div class="mb-6">
    <a href="{{ route($routePrefix.'.menu-items.index') }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Menu Items</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit: {{ $menuItem->name }}</h1>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6 max-w-lg">
    <form method="POST" action="{{ route($routePrefix.'.menu-items.update', $menuItem) }}"
          enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Item name</label>
            <input type="text" name="name" value="{{ old('name', $menuItem->name) }}" required
                class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400
                       {{ $errors->has('name') ? 'border-red-400' : 'border-gray-300' }}">
            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('description', $menuItem->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rs.)</label>
            <input type="number" name="price" value="{{ old('price', $menuItem->price) }}" step="0.01" min="0" required
                class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400
                       {{ $errors->has('price') ? 'border-red-400' : 'border-gray-300' }}">
            @error('price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
            @if($menuItem->image)
                <img id="image-preview" src="{{ asset('storage/' . $menuItem->image) }}" alt="Current photo"
                     class="h-32 mx-auto rounded-lg object-cover mb-2">
                <p class="text-xs text-gray-400 mb-2 text-center">Upload a new photo to replace the current one.</p>
            @endif
            <input type="file" name="image" accept="image/*"
                onchange="const f=this.files[0]; if(f){document.getElementById('image-preview').src = URL.createObjectURL(f);}"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                       file:text-sm file:font-medium file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Availability</label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="radio" name="is_available" value="1"
                           {{ old('is_available', $menuItem->is_available ? '1' : '0') === '1' ? 'checked' : '' }}
                           class="text-orange-500 focus:ring-orange-400">
                    Available
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="radio" name="is_available" value="0"
                           {{ old('is_available', $menuItem->is_available ? '1' : '0') === '0' ? 'checked' : '' }}
                           class="text-orange-500 focus:ring-orange-400">
                    Unavailable
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                Save Changes
            </button>
            <a href="{{ route($routePrefix.'.menu-items.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 px-4 py-2.5">Cancel</a>
        </div>
    </form>
</div>

@endsection