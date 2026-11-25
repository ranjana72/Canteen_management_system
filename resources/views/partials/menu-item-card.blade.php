{{-- Menu Item Card — full variant with toggle + edit/delete (kitchen/admin) --}}
{{-- Usage: @include('partials.menu-item-card', ['item' => $item, 'routePrefix' => $routePrefix]) --}}

<div class="group bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md hover:border-slate-300 transition-all duration-200">

    {{-- Image --}}
    <div class="relative h-40 bg-slate-100 overflow-hidden">
        @if($item->image)
            <img
                src="{{ asset('storage/' . $item->image) }}"
                alt="{{ $item->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
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
            <span class="inline-block whitespace-nowrap bg-white px-2.5 py-1 rounded-md text-[13px] font-bold text-[#002147] shadow-sm border border-white/50">
                Rs. {{ number_format($item->price, 2) }}
            </span>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-4">
        <div class="flex items-start justify-between gap-2 mb-1">
            <h3 class="font-semibold text-slate-800 text-[15px] leading-snug truncate">
                {{ $item->name }}
            </h3>
            @if($item->is_available)
                <span class="shrink-0 inline-flex items-center gap-1 text-[11px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Available
                </span>
            @else
                <span class="shrink-0 inline-flex items-center gap-1 text-[11px] font-medium text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                    Out of stock
                </span>
            @endif
        </div>

        <p class="text-[13px] text-slate-500 line-clamp-2 min-h-[2.25rem]">
            {{ $item->description ?? 'No description available.' }}
        </p>

        {{-- Actions: only for kitchen/admin managing the menu --}}
        @if(isset($routePrefix))
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-2">

                {{-- Toggle stock --}}
                <form action="{{ route($routePrefix.'.menu-items.toggle-stock', $item) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    @if($item->is_available)
                        <button type="submit"
                            class="w-full text-[13px] font-medium px-3 py-1.5 rounded-md border border-slate-200 text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors">
                            Mark out of stock
                        </button>
                    @else
                        <button type="submit"
                            class="w-full text-[13px] font-medium px-3 py-1.5 rounded-md border border-slate-200 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 transition-colors">
                            Mark available
                        </button>
                    @endif
                </form>

                {{-- Edit --}}
                <a href="{{ route($routePrefix.'.menu-items.edit', $item) }}"
                   class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 text-slate-500 hover:bg-[#eef2ff] hover:text-[#002147] hover:border-[#c7d5ee] transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>

                {{-- Delete --}}
                <form action="{{ route($routePrefix.'.menu-items.destroy', $item) }}" method="POST"
                      onsubmit="return confirm('Delete {{ $item->name }}?');" class="shrink-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-slate-200 text-slate-500 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>