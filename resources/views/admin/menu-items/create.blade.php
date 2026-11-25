@extends('layouts.app')
@section('title', 'Add Menu Item')

@section('content')

@php
    $routePrefix = auth()->user()->role === 'kitchen' ? 'kitchen' : 'admin';
@endphp

<div class="mb-6">
    <a href="{{ route($routePrefix . '.menu-items.index') }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Menu Items</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Add New Menu Item</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-4xl">

    {{-- Form --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <form method="POST" action="{{ route($routePrefix . '.menu-items.store') }}"
              enctype="multipart/form-data" class="space-y-5" id="menu-form">
            @csrf

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Item name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="e.g. Samosa, Momo, Chai"
                    class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400
                           {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Description <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <textarea name="description" rows="3"
                    placeholder="Short description of the item, ingredients, etc..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('description') }}</textarea>
            </div>

            {{-- Price --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Price (Rs.) <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Rs.</span>
                    <input type="number" name="price" value="{{ old('price') }}"
                        step="0.01" min="0" required placeholder="0.00"
                        class="w-full pl-12 pr-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400
                               {{ $errors->has('price') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                </div>
                @error('price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Image upload --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Food photo <span class="text-gray-400 font-normal">(optional)</span>
    </label>

    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-400 transition cursor-pointer"
         onclick="document.getElementById('image-input').click()">

        {{-- Image Preview --}}
        <div id="preview-container" class="hidden mb-3">
            <img
                id="image-preview"
                src=""
                alt="Preview"
                class="h-32 mx-auto rounded-lg object-cover"
            >
        </div>

        {{-- Upload Placeholder --}}
        <div id="upload-placeholder">
            <div class="text-3xl mb-2">📷</div>
            <p class="text-sm text-gray-500">Click to upload photo</p>
            <p class="text-xs text-gray-400 mt-1">
                JPG, PNG, WEBP — max 2MB
            </p>
        </div>

        <input
            type="file"
            name="image"
            id="image-input"
            accept="image/*"
            class="hidden"
            onchange="previewImage(this)"
        >
    </div>

    @error('image')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

            {{-- Availability --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Availability</label>
                <div class="flex gap-3">
                    <label class="flex-1 flex items-center gap-3 p-3 border-2 rounded-xl cursor-pointer transition
                                  {{ old('is_available', '1') === '1' ? 'border-green-400 bg-green-50' : 'border-gray-200' }}"
                           id="label-available">
                        <input type="radio" name="is_available" value="1"
                               {{ old('is_available', '1') === '1' ? 'checked' : '' }}
                               class="text-green-500 focus:ring-green-400"
                               onchange="toggleAvailLabel()">
                        <div>
                            <div class="text-sm font-medium text-gray-800">🟢 Available</div>
                            <div class="text-xs text-gray-400">Visible to students</div>
                        </div>
                    </label>
                    <label class="flex-1 flex items-center gap-3 p-3 border-2 rounded-xl cursor-pointer transition
                                  {{ old('is_available') === '0' ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                           id="label-unavailable">
                        <input type="radio" name="is_available" value="0"
                               {{ old('is_available') === '0' ? 'checked' : '' }}
                               class="text-red-400 focus:ring-red-300"
                               onchange="toggleAvailLabel()">
                        <div>
                            <div class="text-sm font-medium text-gray-800">🔴 Unavailable</div>
                            <div class="text-xs text-gray-400">Hidden from students</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-lg transition">
                    Save Menu Item
                </button>
                <a href="{{ route($routePrefix . '.menu-items.index') }}"
                   class="px-5 py-2.5 text-sm text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg transition">
                    Cancel
                </a>
                
            </div>

        </form>
    </div>

    {{-- Live preview card --}}
    <div class="lg:sticky lg:top-6 h-fit">
        <p class="text-sm font-medium text-gray-500 mb-3">Live Preview</p>
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div id="card-image-preview" class="w-full h-48 bg-gradient-to-br from-orange-50 to-amber-100 flex flex-col items-center justify-center">
                <span class="text-5xl">🍽️</span>
                <span class="text-xs text-gray-400 mt-2">Photo will appear here</span>
            </div>
            <div class="p-4">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <h3 id="preview-name" class="font-bold text-gray-800">Item name</h3>
                    <span id="preview-price" class="text-orange-500 font-bold shrink-0">Rs. 0.00</span>
                </div>
                <p id="preview-desc" class="text-sm text-gray-400 italic">Description will appear here...</p>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span id="preview-badge" class="bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                        ✓ Available
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function previewImage(input) {

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function(e){

            document.getElementById('image-preview').src = e.target.result;

            document.getElementById('preview-container').classList.remove('hidden');

            document.getElementById('upload-placeholder').classList.add('hidden');

            document.getElementById('card-image-preview').innerHTML =
                '<img src="' + e.target.result + '" class="w-full h-48 object-cover">';
        };

        reader.readAsDataURL(input.files[0]);
    }

}
</script>

@endsection