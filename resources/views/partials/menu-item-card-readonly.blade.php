{{-- Menu Item Card — read-only variant (no Edit/Delete) --}}
{{-- Usage: @include('partials.menu-item-card-readonly', ['item' => $item]) --}}

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-slate-300 hover:shadow-sm transition-all duration-200">

    {{-- Image --}}
    <div class="relative h-40 bg-slate-100 overflow-hidden">
        @if($item->image)
            <img
                src="{{ asset('storage/' . $item->image) }}"
                alt="{{ $item->name }}"
                class="w-full h-full object-cover"
            >
        @else
            <div class="w-full h-full flex items-center justify-center bg-slate-50">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        @endif

        {{-- Price badge --}}
        <div class="absolute top-2.5 right-2.5 z-10">
            <span class="inline-block whitespace-nowrap bg-white px-2.5 py-1 rounded-md text-[13px] font-bold text-[#002147] shadow-sm">
                Rs. {{ number_format($item->price, 2) }}
            </span>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-4">
        <h3 class="font-semibold text-slate-800 text-[15px] leading-snug truncate mb-1">
            {{ $item->name }}
        </h3>

        <p class="text-[13px] text-slate-500 line-clamp-2 min-h-[2.25rem]">
            {{ $item->description ?? 'No description available.' }}
        </p>

        <div class="mt-3 pt-3 border-t border-slate-100">
            @if($item->is_available)
                <span class="inline-flex items-center gap-1.5 text-[12px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Available
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 text-[12px] font-medium text-red-600 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                    Out of stock
                </span>
            @endif
        </div>
        
    </div>
</div>