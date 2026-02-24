@extends('layouts.modern-app')

@section('title', 'Favourites - Kingsbridge Motors')
@section('description', 'Your saved favorite vehicles.')

@section('content')
@include('modern._nav')

@php
    $allListings = $listings ?? collect();
@endphp

<main class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5 sm:p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">Favorite Cars</h1>
                <p class="mt-1 text-sm text-slate-300">Vehicles you saved for quick access.</p>
            </div>
            <a href="{{ route('marketplace.index') }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Browse More</a>
        </div>
    </section>

    @if(($favoriteVehicles ?? collect())->count())
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($favoriteVehicles as $favorite)
                @php
                    $vehicle = $favorite->vehicle;
                    $listing = $vehicle?->listing;
                @endphp
                @continue(!$vehicle || !$listing)

                <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
                    <a href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}">
                        <img src="{{ $vehicle->front_img ? asset('storage/photos/' . $vehicle->front_img) : asset('images/land1.jpg') }}" alt="{{ $vehicle->title ?? 'Vehicle' }}" class="h-52 w-full object-cover">
                    </a>
                    <div class="space-y-3 p-4">
                        <h2 class="font-display text-lg font-semibold text-white">{{ $vehicle->carmodel?->carmake?->make }} {{ $vehicle->carmodel?->model }} {{ $vehicle->year_of_build }}</h2>
                        <div class="grid grid-cols-2 gap-2 text-sm text-slate-300">
                            <p>Fuel: <span class="text-white">{{ $vehicle->fuel_type }}</span></p>
                            <p>Trans: <span class="text-white">{{ $vehicle->transmission }}</span></p>
                            <p>Miles: <span class="text-white">{{ number_format((int) $vehicle->mileage) }} km</span></p>
                            <p>Engine: <span class="text-white">{{ $vehicle->engine_size }}</span></p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="rounded-full border border-amber-300/30 bg-amber-300/10 px-2.5 py-1 text-xs font-semibold text-amber-200">{{ $listing->category?->category_name ?? 'Vehicle' }}</span>
                            <span class="text-sm font-semibold text-white">Ksh {{ number_format((float) $vehicle->price) }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @else
        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <h2 class="font-display text-2xl font-semibold text-white">No favorites yet</h2>
            <p class="mt-2 text-sm text-slate-300">Save vehicles from marketplace to see them here.</p>
        </section>
    @endif
</main>
@endsection
