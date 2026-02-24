@extends('layouts.modern-app')

@section('title', 'Car Hire Listing Preview - Kingsbridge Motors')
@section('description', 'Preview your car hire listing details.')

@section('content')
@include('modern._nav')

@php
    $images = array_values(array_filter([
        $vehicle->front_img ?? null,
        $vehicle->back_img ?? null,
        $vehicle->right_img ?? null,
        $vehicle->left_img ?? null,
        $vehicle->interiorf_img ?? null,
        $vehicle->interiorb_img ?? null,
        $vehicle->engine_img ?? null,
        $vehicle->opt_img1 ?? null,
        $vehicle->opt_img2 ?? null,
        $vehicle->opt_img3 ?? null,
    ]));
@endphp

<main class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('user.index_carhire') }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back</a>
        <a href="{{ route('user.edit_carhire', [$listing->id, $vehicle->id]) }}" class="rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Edit Listing</a>
    </div>

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900 p-5 lg:col-span-2">
            <h1 class="font-display text-2xl font-bold text-white">{{ $vehicle->carmodel?->carmake?->make }} {{ $vehicle->carmodel?->model }} {{ $vehicle->year_of_build }}</h1>
            <p class="text-sm text-slate-300">{{ $listing->city?->city }} · {{ $listing->category?->category_name }} · {{ $listing->ads_status }}</p>

            @if(count($images))
                <img id="main-photo" src="{{ asset('storage/photos/' . $images[0]) }}" class="h-80 w-full rounded-xl object-cover" alt="vehicle">
                <div class="grid grid-cols-3 gap-2 sm:grid-cols-5">
                    @foreach($images as $image)
                        <button type="button" class="photo-thumb overflow-hidden rounded-lg border border-slate-700 hover:border-amber-300" data-src="{{ asset('storage/photos/' . $image) }}">
                            <img src="{{ asset('storage/photos/' . $image) }}" class="h-20 w-full object-cover" alt="thumb">
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="grid gap-2 text-sm text-slate-300 sm:grid-cols-2 lg:grid-cols-3">
                <p class="rounded-lg border border-slate-800 bg-slate-950/40 p-2">Price/Day: <span class="text-white">Ksh {{ number_format((float) $vehicle->price_per_day) }}</span></p>
                <p class="rounded-lg border border-slate-800 bg-slate-950/40 p-2">Pick Up: <span class="text-white">{{ $vehicle->pickup_date }}</span></p>
                <p class="rounded-lg border border-slate-800 bg-slate-950/40 p-2">Return: <span class="text-white">{{ $vehicle->return_date }}</span></p>
                <p class="rounded-lg border border-slate-800 bg-slate-950/40 p-2">Days: <span class="text-white">{{ $vehicle->rent_days }}</span></p>
                <p class="rounded-lg border border-slate-800 bg-slate-950/40 p-2">Transmission: <span class="text-white">{{ $vehicle->transmission }}</span></p>
                <p class="rounded-lg border border-slate-800 bg-slate-950/40 p-2">Fuel: <span class="text-white">{{ $vehicle->fuel_type }}</span></p>
            </div>

            <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4 text-sm text-slate-200">{!! $vehicle->description !!}</div>
        </article>

        <aside class="space-y-4">
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <h3 class="font-display text-lg font-semibold text-white">Owner Info</h3>
                <p class="mt-2 text-sm text-slate-300">{{ $listing->user?->name }}</p>
                <p class="text-sm text-slate-400">{{ $listing->user?->phone_number }}</p>
            </article>
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5 text-sm text-slate-300">
                <h3 class="font-display text-lg font-semibold text-white">Safety Tips</h3>
                <ul class="mt-2 space-y-1">
                    <li>Confirm pricing and included terms.</li>
                    <li>Inspect vehicle before handover.</li>
                    <li>Use secure payment methods.</li>
                </ul>
            </article>
        </aside>
    </section>
</main>

<script>
    document.querySelectorAll('.photo-thumb').forEach(function(button) {
        button.addEventListener('click', function() {
            var main = document.getElementById('main-photo');
            if (main) main.src = this.dataset.src;
        });
    });
</script>
@endsection
