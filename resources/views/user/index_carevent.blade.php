@extends('layouts.modern-app')

@section('title', 'My Events - Kingsbridge Motors')
@section('description', 'Manage your car events.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">My Events</h1>
                <p class="mt-2 text-sm text-slate-300">Create, edit, and remove your published car events.</p>
            </div>
            <a href="{{ route('user.create_carevent') }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Create Event</a>
        </div>
    </section>

    @if($carevents->count() > 0)
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($carevents as $carevent)
                <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
                    <a href="{{ route('events.show', ['id' => $carevent->id]) }}" class="block">
                        <img src="{{ $carevent->event_image ? asset('storage/photos/' . $carevent->event_image) : asset('images/land1.jpg') }}" alt="{{ $carevent->event_title }}" loading="lazy" class="h-52 w-full object-cover">
                    </a>
                    <div class="space-y-3 p-4">
                        <h2 class="font-display text-xl font-semibold text-white"><a href="{{ route('events.show', ['id' => $carevent->id]) }}" class="hover:text-amber-200">{{ $carevent->event_title }}</a></h2>
                        <div class="space-y-1 text-sm text-slate-300">
                            <p>Location: <span class="text-white">{{ $carevent->event_location }}</span></p>
                            <p>Date: <span class="text-white">{{ $carevent->event_date }}</span></p>
                            <p>Time: <span class="text-white">{{ $carevent->event_time }}</span></p>
                            <p>Organizer: <span class="text-white">{{ $carevent->organizer }}</span></p>
                            <p>Ticket: <span class="text-white">Ksh {{ number_format((float) $carevent->ticket_price) }}</span></p>
                            <p>Package: <span class="text-white">{{ optional(optional($carevent->listing)->package)->package_name ?: 'Free Plan' }}</span></p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('user.edit_carevent', $carevent->id) }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Edit</a>
                            @if($carevent->invoice_id)
                                <a href="{{ route('user.invoice.show', $carevent->invoice_id) }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Invoice</a>
                            @endif
                            <form action="{{ route('user.delete_carevent', $carevent->id) }}" method="post" onsubmit="return confirm('Are you sure want to delete this event?');">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="rounded-lg border border-rose-400/40 bg-rose-400/10 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-rose-200 hover:bg-rose-400/20">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @else
        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <h2 class="font-display text-2xl font-semibold text-white">No events yet</h2>
            <p class="mt-2 text-sm text-slate-300">Create your first event and start reaching enthusiasts.</p>
            <a href="{{ route('user.create_carevent') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Create Event</a>
        </section>
    @endif
</main>
@endsection
