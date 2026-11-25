@extends('layouts.app')

@section('title', 'Ratings')
@section('page-title', 'Ratings')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6 items-start">

        {{-- ---------------- Summary Card ---------------- --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="text-[15px] font-bold text-slate-800 mb-4">Overall Rating</h2>

            <p class="text-[40px] font-bold text-slate-800 leading-none">
                {{ number_format($average, 1) }}
                <span class="text-[16px] font-medium text-slate-400">/ 5</span>
            </p>

            <div class="flex items-center gap-0.5 mt-2 mb-1">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= round($average) ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                @endfor
            </div>

            <p class="text-[13px] text-slate-400 mb-6">Based on {{ $total }} reviews</p>

            {{-- Star breakdown bars --}}
            <div class="flex flex-col gap-2">
                @for($star = 5; $star >= 1; $star--)
                    @php
                        $count = $breakdown[$star] ?? 0;
                        $pct   = $total > 0 ? round(($count / $total) * 100) : 0;
                    @endphp
                    <div class="flex items-center gap-2">
                        <span class="text-[12px] text-slate-500 w-10 shrink-0">{{ $star }} star</span>
                        <div class="flex-1 h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="text-[12px] text-slate-400 w-8 text-right shrink-0">{{ $count }}</span>
                    </div>
                @endfor
            </div>
        </div>

        {{-- ---------------- Recent Feedback ---------------- --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <div>
                    <h2 class="text-[16px] font-bold text-slate-800">Recent Reviews</h2>
                    <p class="text-[12px] text-slate-400">Latest 10 feedback entries</p>
                </div>
                <a href="{{ route('kitchen.feedback.index') }}"
                    class="text-[13px] font-medium text-[#002147] hover:underline shrink-0">
                    View all
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentFeedback as $fb)
                    <div class="px-5 py-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[14px] font-semibold text-slate-800">
                                        {{ $fb->user->name ?? 'Anonymous' }}
                                    </span>
                                    @if($fb->menuItem)
                                        <span class="text-[12px] text-slate-400">· {{ $fb->menuItem->name }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-0.5 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $fb->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    @endfor
                                </div>
                                @if($fb->comment)
                                    <p class="text-[13px] text-slate-600">{{ $fb->comment }}</p>
                                @endif
                            </div>
                            <span class="text-[12px] text-slate-400 shrink-0">
                                {{ $fb->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-16 text-center">
                        <p class="text-[14px] text-slate-400">No reviews yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

@endsection