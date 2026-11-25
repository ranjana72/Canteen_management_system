@extends('layouts.app')

@section('title', 'Feedback')
@section('page-title', 'Feedback')

@section('content')

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div>
                <h2 class="text-[16px] font-bold text-slate-800">Customer Feedback</h2>
                <p class="text-[12px] text-slate-400">All reviews left by students</p>
            </div>
            <a href="{{ route('kitchen.ratings.index') }}"
                class="text-[13px] font-medium text-[#002147] hover:underline shrink-0">
                View Ratings Summary
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($feedbacks as $fb)
                <div class="px-5 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[14px] font-semibold text-slate-800">
                                    {{ $fb->user->name ?? 'Anonymous' }}
                                </span>
                                @if($fb->order)
                                    <span class="text-[12px] text-slate-400">
                                        · Order {{ $fb->order->order_number }}
                                    </span>
                                @endif
                                @if($fb->menuItem)
                                    <span class="text-[12px] text-slate-400">
                                        · {{ $fb->menuItem->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-0.5 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $fb->rating ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                @endfor
                            </div>
                            @if($fb->comment)
                                <p class="text-[13px] text-slate-600">{{ $fb->comment }}</p>
                            @else
                                <p class="text-[13px] text-slate-400 italic">No comment left.</p>
                            @endif
                        </div>
                        <span class="text-[12px] text-slate-400 shrink-0">
                            {{ $fb->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-5 py-16 text-center">
                    <p class="text-[14px] text-slate-400">No feedback has been submitted yet.</p>
                </div>
            @endforelse
        </div>

        @if($feedbacks->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">
                {{ $feedbacks->links() }}
            </div>
        @endif

    </div>

@endsection