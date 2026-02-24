@extends('layouts.modern-app')

@section('title', 'Car Hire Listings - Kingsbridge Motors')
@section('description', 'Manage your car hire listings.')

@section('content')
@include('modern._nav')

<main class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5 sm:p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">My Car Hire Listings</h1>
                <p class="mt-1 text-sm text-slate-300">Manage your rental listings and pricing details.</p>
            </div>
            <a href="{{ route('user.create_carhire') }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Add Car Hire</a>
        </div>
    </section>

    @if(($listings ?? collect())->count() > 0)
        <section class="space-y-4">
            @foreach($listings as $listing)
                @php $vehicle = ($vehicles ?? collect())->firstWhere('listing_id', $listing->id); @endphp
                @continue(!$vehicle)

                <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
                    <div class="grid lg:grid-cols-12">
                        <img src="{{ $vehicle->front_img ? asset('storage/photos/' . $vehicle->front_img) : asset('images/land1.jpg') }}" alt="Car hire" class="h-64 w-full object-cover lg:col-span-4 lg:h-full">
                        <div class="space-y-4 p-5 lg:col-span-8">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <h2 class="font-display text-xl font-semibold text-white">{{ $vehicle->carmodel?->carmake?->make }} {{ $vehicle->carmodel?->model }} {{ $vehicle->year_of_build }}</h2>
                                    <p class="mt-1 text-xs text-slate-400">Listing #{{ $listing->id }} · {{ $listing->category?->category_name }} · {{ $listing->ads_status }}</p>
                                </div>
                                <span class="rounded-full border border-cyan-300/30 bg-cyan-300/10 px-3 py-1 text-xs font-semibold text-cyan-200">Ksh {{ number_format((float) $vehicle->price_per_day) }}/day</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-sm text-slate-300 md:grid-cols-4">
                                <p>Pick Up: <span class="text-white">{{ $vehicle->pickup_date }}</span></p>
                                <p>Return: <span class="text-white">{{ $vehicle->return_date }}</span></p>
                                <p>Days: <span class="text-white">{{ $vehicle->rent_days }}</span></p>
                                <p>Mileage: <span class="text-white">{{ number_format((int)$vehicle->mileage) }} km</span></p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('user.show_carhire', [$listing->id, $vehicle->id]) }}" class="rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">View</a>
                                <a href="{{ route('user.edit_carhire', [$listing->id, $vehicle->id]) }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Edit</a>
                                <a href="{{ route('user.invoice', [$listing->id, $vehicle->id]) }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Invoice</a>
                                <form action="{{ route('user.delete_carhire', [$listing->id, $vehicle->id]) }}" method="post" onsubmit="return confirm('Are you sure want to delete this listing?');">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="rounded-lg border border-rose-400/40 bg-rose-400/10 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-rose-200 hover:bg-rose-400/20">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @else
        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <h2 class="font-display text-2xl font-semibold text-white">No car hire listings yet</h2>
            <p class="mt-2 text-sm text-slate-300">Create your first car hire listing now.</p>
            <a href="{{ route('user.create_carhire') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Create Listing</a>
        </section>
    @endif
</main>
@endsection
