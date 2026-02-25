@extends('layouts.modern-app')

@section('title', 'Car Events - Kingsbridge Motors')
@section('description', 'Discover upcoming car events and meetups.')

@section('content')
@include('modern._nav')

<section class="border-b border-slate-800 bg-[#0b1020]">
    <div class="w-full px-4 py-14 sm:px-6 lg:px-10">
        <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">Community</p>
        <h1 class="font-display text-4xl font-bold text-white sm:text-5xl">Car Events</h1>
        <p class="mt-3 text-slate-300">Track meets, launches, cruises, and other community events.</p>
    </div>
</section>

<main class="w-full px-4 py-10 sm:px-6 lg:px-10">
    @if($carevents->count())
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($carevents as $carevent)
                <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15">
                    <a href="{{ route('events.show', ['id' => $carevent->id]) }}" class="block">
                        <img src="{{ $carevent->event_image ? asset('storage/photos/' . $carevent->event_image) : asset('images/land1.jpg') }}" alt="{{ $carevent->event_title }}" class="aspect-[16/10] w-full object-cover">
                    </a>
                    <div class="space-y-3 p-4">
                        <h2 class="font-display text-xl font-semibold text-white">
                            <a href="{{ route('events.show', ['id' => $carevent->id]) }}" class="hover:text-amber-200">{{ $carevent->event_title }}</a>
                        </h2>
                        <div class="space-y-1 text-sm text-slate-300">
                            <p><span class="text-slate-500">Location:</span> {{ $carevent->event_location }}</p>
                            <p><span class="text-slate-500">Date:</span> {{ $carevent->event_date }}</p>
                            <p><span class="text-slate-500">Time:</span> {{ $carevent->event_time }}</p>
                            <p><span class="text-slate-500">Organizer:</span> {{ $carevent->organizer }}</p>
                            <p><span class="text-slate-500">Contact:</span> {{ $carevent->user?->phone_number ?: 'Not provided' }}</p>
                        </div>
                        <div class="pt-2">
                            <span class="rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-semibold text-amber-200">Ticket: Ksh {{ number_format((float) $carevent->ticket_price) }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <p class="font-display text-xl font-semibold text-white">No events available</p>
            <p class="mt-2 text-sm text-slate-400">Check back soon for upcoming events.</p>
        </div>
    @endif
</main>
@endsection
