@extends('layouts.modern-app')

@section('title', 'Compare vehicles - Kingsbridge Motors')
@section('description', 'Side-by-side comparison of selected vehicles.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-10 px-4 py-10 sm:px-6 lg:px-10">
    <section class="space-y-3">
        <h1 class="font-display text-3xl font-semibold text-white">Compare vehicles</h1>
        <p class="text-sm text-slate-400">Select up to four listings and view them side-by-side.</p>
    </section>

    @if($vehicles->count())
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-{{ min(4, $vehicles->count()) }}">
            @foreach($vehicles as $vehicle)
                @php
                    $listing = $vehicle->listing;
                    $make = optional(optional($vehicle->carmodel)->carmake)->make ?? 'Unknown';
                    $model = optional($vehicle->carmodel)->model ?? 'Model';
                    $city = optional(optional($listing)->city)->city ?? 'Nairobi';
                @endphp
                <article class="space-y-3 rounded-2xl border border-slate-800 bg-slate-900 p-5">
                    <h2 class="font-display text-lg font-semibold text-white">{{ $make }} {{ $model }} {{ $vehicle->year_of_build }}</h2>
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-500">{{ $city }}</p>
                    <p class="text-sm text-slate-300">{{ $vehicle->description }}</p>
                    <dl class="grid text-xs text-slate-400">
                        <div class="flex justify-between"><dt>Price</dt><dd>{{ format_currency($vehicle->price) }}</dd></div>
                        <div class="flex justify-between"><dt>Mileage</dt><dd>{{ number_format((float) $vehicle->mileage) }} Km</dd></div>
                        <div class="flex justify-between"><dt>Transmission</dt><dd>{{ $vehicle->transmission ?: '-' }}</dd></div>
                        <div class="flex justify-between"><dt>Fuel</dt><dd>{{ $vehicle->fuel_type ?: '-' }}</dd></div>
                    </dl>
                    <a href="{{ $listing ? route('vehicle', [$listing->id, $vehicle->id]) : '#' }}" class="text-xs font-semibold text-amber-300 hover:text-amber-200">View listing →</a>
                </article>
            @endforeach
        </div>
    @else
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-8 text-center text-sm text-slate-400">
            Select at least one vehicle to compare.
        </div>
    @endif
</main>
@endsection
