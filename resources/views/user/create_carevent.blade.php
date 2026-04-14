@extends('layouts.modern-app')

@section('title', 'Create Event - Kingsbridge Motors')
@section('description', 'Create a car event and publish it to the community.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Post Car Event</h1>
        <p class="mt-2 text-sm text-slate-300">Share event details, timing, and ticket information.</p>
    </section>

    <form action="{{ route('user.store_carevent') }}" method="POST" enctype="multipart/form-data" class="space-y-6" data-stepper-form>
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

        <div class="flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-wide text-slate-300">
            <span data-step-indicator class="active rounded-full border border-amber-300/40 bg-amber-300/10 px-3 py-1 text-amber-200">Event Info</span>
            <span data-step-indicator class="rounded-full border border-slate-700 px-3 py-1">Poster</span>
        </div>

        <section data-step-panel class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Event Title</label>
                    <input type="text" name="event_title" required value="{{ old('event_title') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none" placeholder="Car event title">
                    @error('event_title')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Date</label>
                    <input type="date" name="event_date" required value="{{ old('event_date') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('event_date')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Time</label>
                    <input type="time" name="event_time" required value="{{ old('event_time') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('event_time')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Event Duration</label>
                    <input type="number" name="event_duration" required value="{{ old('event_duration') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none" placeholder="Days or hours">
                    @error('event_duration')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Ticket Price (Ksh)</label>
                    <input type="number" name="ticket_price" value="{{ old('ticket_price') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none" placeholder="0">
                    @error('ticket_price')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Event Location</label>
                    <input type="text" name="event_location" required value="{{ old('event_location') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none" placeholder="Event venue / city">
                    @error('event_location')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Description</label>
                    <textarea name="event_description" required rows="6" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">{{ old('event_description') }}</textarea>
                    @error('event_description')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Organizer</label>
                    <input type="text" name="organizer" required value="{{ old('organizer', Auth::user()->name) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('organizer')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

            </div>
        </section>

        <section data-step-panel class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <label class="mb-2 block text-sm font-semibold text-slate-200">Poster Image</label>
            <input type="file" name="event_image" accept="image/*" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-200 file:mr-3 file:rounded-md file:border-0 file:bg-amber-300 file:px-3 file:py-1.5 file:font-semibold file:text-slate-900 hover:file:bg-amber-200">
            @error('event_image')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
        </section>

        @include('user.partials.listing-stepper-controls', ['submitText' => 'Post Event'])
        <a href="{{ route('user.userevent') }}" class="inline-flex rounded-xl border border-slate-700 px-5 py-2.5 text-sm font-semibold text-slate-200 hover:border-slate-500">Back to My Events</a>
    </form>
</main>
@include('user.partials.listing-stepper-script')
@endsection
