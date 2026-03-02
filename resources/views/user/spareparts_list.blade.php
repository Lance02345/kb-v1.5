@extends('layouts.modern-app')

@section('title', 'My Spare Parts - Kingsbridge Motors')
@section('description', 'Manage your spare parts listings.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">My Spare Parts</h1>
                <p class="mt-2 text-sm text-slate-300">Review and manage all your spare part listings.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.my_list') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Dashboard</a>
                <a href="{{ route('user.sparepartscreate') }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Add Spare Part</a>
            </div>
        </div>
    </section>

    @if(!is_null($spareParts) && count($spareParts) > 0)
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($spareParts as $sparePart)
                <article class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15 transition duration-300 hover:-translate-y-1 hover:border-amber-300/40">
                    <a href="{{ route('sparepart', $sparePart->id) }}">
                        <img src="{{ $sparePart->front_img ? asset('storage/photos/' . $sparePart->front_img) : asset('images/land1.jpg') }}" alt="{{ $sparePart->item_name }}" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                    </a>
                    <div class="space-y-3 p-4">
                        <h2 class="font-display text-xl font-semibold text-white">{{ $sparePart->make }} - {{ $sparePart->item_name }}</h2>
                        <div class="grid grid-cols-2 gap-2 text-sm text-slate-300">
                            <p>ID: <span class="text-white">{{ $sparePart->id }}</span></p>
                            <p>Category: <span class="text-white">{{ $sparePart->category ?: 'Other' }}</span></p>
                            <p>Price: <span class="text-white">Ksh {{ number_format((float) $sparePart->price) }}</span></p>
                            <p>Condition: <span class="text-white">{{ $sparePart->condition }}</span></p>
                            <p>Location: <span class="text-white">{{ $sparePart->location }}</span></p>
                        </div>
                        <p class="line-clamp-2 text-sm text-slate-400">{{ $sparePart->item_description }}</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('sparepart', $sparePart->id) }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">View Details</a>
                            <a href="{{ route('user.sparepartsedit', $sparePart->id) }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Edit</a>
                            <form action="{{ route('user.sparepartsdestroy', $sparePart->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this spare part?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex rounded-lg border border-rose-300/30 bg-rose-400/10 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-rose-200 hover:bg-rose-400/20">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @else
        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <h2 class="font-display text-2xl font-semibold text-white">No spare parts yet</h2>
            <p class="mt-2 text-sm text-slate-300">Add your first spare part to start getting buyer inquiries.</p>
            <a href="{{ route('user.sparepartscreate') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Add Spare Part</a>
        </section>
    @endif
</main>
@endsection
