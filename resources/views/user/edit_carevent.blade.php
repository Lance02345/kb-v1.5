@extends('layouts.modern-app')

@section('title', 'Edit Event - Kingsbridge Motors')
@section('description', 'Update your car event information.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Edit Car Event</h1>
        <p class="mt-2 text-sm text-slate-300">Update event details and re-upload the poster if needed.</p>
    </section>

    <form action="{{ route('user.update_carevent', $carevent->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('put')
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Event Title</label>
                    <input type="text" name="event_title" value="{{ old('event_title', $carevent->event_title) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('event_title')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Date</label>
                    <input type="date" name="event_date" value="{{ old('event_date', $carevent->event_date) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('event_date')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Time</label>
                    <input type="time" name="event_time" value="{{ old('event_time', $carevent->event_time) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('event_time')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Event Duration</label>
                    <input type="number" name="event_duration" value="{{ old('event_duration', $carevent->event_duration) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('event_duration')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Ticket Price (Ksh)</label>
                    <input type="number" name="ticket_price" value="{{ old('ticket_price', $carevent->ticket_price) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('ticket_price')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Event Location</label>
                    <input type="text" name="event_location" value="{{ old('event_location', $carevent->event_location) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('event_location')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Description</label>
                    <textarea name="event_description" rows="6" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">{{ old('event_description', $carevent->event_description) }}</textarea>
                    @error('event_description')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Organizer</label>
                    <input type="text" name="organizer" value="{{ old('organizer', $carevent->organizer ?? Auth::user()->name) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('organizer')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Poster Image</label>
                    <input type="file" name="event_image" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-200 file:mr-3 file:rounded-md file:border-0 file:bg-amber-300 file:px-3 file:py-1.5 file:font-semibold file:text-slate-900 hover:file:bg-amber-200">
                    @error('event_image')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                @if($carevent->event_image)
                    <div class="sm:col-span-2">
                        <p class="mb-2 text-xs uppercase tracking-wide text-slate-400">Current Poster</p>
                        <img src="{{ asset('storage/photos/' . $carevent->event_image) }}" alt="{{ $carevent->event_title }}" class="h-52 w-full max-w-xl rounded-xl border border-slate-700 object-cover">
                    </div>
                @endif
            </div>
        </section>

        <div class="flex flex-wrap gap-2">
            <button type="submit" class="rounded-xl bg-amber-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Update Event</button>
            <a href="{{ route('user.userevent') }}" class="rounded-xl border border-slate-700 px-5 py-2.5 text-sm font-semibold text-slate-200 hover:border-slate-500">Back to My Events</a>
        </div>
    </form>
</main>
@endsection
