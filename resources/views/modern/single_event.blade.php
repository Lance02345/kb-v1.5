@extends('layouts.modern-app')

@section('title', ($carevent->event_title ?? 'Event') . ' | Kingsbridge Motors')
@section('description', 'Event details, organizer info, ticket pricing, and schedule.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <a href="{{ route('carevent') }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to Events</a>

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="space-y-4 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-4 lg:col-span-2">
            <h1 class="font-display text-2xl font-bold text-white sm:text-3xl">{{ $carevent->event_title }}</h1>

            <img
                src="{{ $carevent->event_image ? asset('storage/photos/' . $carevent->event_image) : asset('images/land1.jpg') }}"
                alt="{{ $carevent->event_title }}"
                class="h-72 w-full rounded-xl border border-slate-800 object-cover sm:h-[26rem]"
            >

            <div class="grid gap-3 rounded-xl border border-slate-800 bg-slate-950/40 p-4 text-sm text-slate-300 sm:grid-cols-2">
                <p>Location: <span class="font-semibold text-white">{{ $carevent->event_location }}</span></p>
                <p>Date: <span class="font-semibold text-white">{{ $carevent->event_date }}</span></p>
                <p>Time: <span class="font-semibold text-white">{{ $carevent->event_time }}</span></p>
                <p>Organizer: <span class="font-semibold text-white">{{ $carevent->organizer }}</span></p>
                <p>Contact: <span class="font-semibold text-white">{{ $carevent->user?->phone_number ?: 'Not provided' }}</span></p>
            </div>

            <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4">
                <h2 class="font-display text-lg font-semibold text-white">Description</h2>
                <p class="mt-2 text-sm text-slate-300">{!! nl2br(e(strip_tags($carevent->event_description))) !!}</p>
            </div>
        </article>

        <aside class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <h2 class="font-display text-lg font-semibold text-white">Ticket</h2>
            <p class="text-sm text-slate-300">Price</p>
            <p class="text-2xl font-bold text-white">Ksh {{ number_format((float) $carevent->ticket_price) }}</p>

            @if($carevent->user?->phone_number)
                <a href="tel:{{ $carevent->user->phone_number }}" class="inline-flex w-full justify-center rounded-lg bg-amber-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-amber-200">Call Organizer</a>
            @endif

            <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4 text-xs text-slate-400">
                Arrive early, verify location details with organizer, and keep your valuables secure.
            </div>
        </aside>
    </section>
</main>
@endsection
