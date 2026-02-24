@extends('layouts.modern-app')

@section('title', ($pageTitle ?? 'My Listings') . ' - Kingsbridge Motors')
@section('description', 'Manage your vehicle listings, status, and performance.')

@section('content')
@include('modern._nav')

@php
    $pool = $allListings ?? $listings;
    $total = $pool->count();
    $active = $pool->filter(fn($l) => in_array(strtolower((string) $l->ads_status), ['approved', 'active']))->count();
    $pending = $pool->filter(fn($l) => strtolower((string) $l->ads_status) === 'pending')->count();
    $sold = $pool->filter(fn($l) => strtolower((string) $l->ads_status) === 'sold')->count();
    $expired = $pool->filter(fn($l) => strtolower((string) $l->ads_status) === 'expired')->count();
@endphp

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">{{ $pageTitle ?? 'My Listings' }}</h1>
                <p class="mt-2 text-sm text-slate-300">Track performance, update status, and optimize your ads.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.new_listing') }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">New Listing</a>
                @if(!empty($statusFilter))
                    <a href="{{ route('user.index_vehiclesale') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to All</a>
                @endif
            </div>
        </div>
    </section>

    <section class="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
        <article class="rounded-xl border border-slate-800 bg-slate-900 p-4"><p class="text-xs text-slate-400">Total</p><p class="mt-1 text-2xl font-bold text-white">{{ $total }}</p></article>
        <article class="rounded-xl border border-slate-800 bg-slate-900 p-4"><p class="text-xs text-slate-400">Active</p><p class="mt-1 text-2xl font-bold text-emerald-300">{{ $active }}</p></article>
        <article class="rounded-xl border border-slate-800 bg-slate-900 p-4"><p class="text-xs text-slate-400">Pending</p><p class="mt-1 text-2xl font-bold text-amber-300">{{ $pending }}</p></article>
        <article class="rounded-xl border border-slate-800 bg-slate-900 p-4"><p class="text-xs text-slate-400">Sold</p><p class="mt-1 text-2xl font-bold text-cyan-300">{{ $sold }}</p></article>
        <article class="rounded-xl border border-slate-800 bg-slate-900 p-4"><p class="text-xs text-slate-400">Expired</p><p class="mt-1 text-2xl font-bold text-rose-300">{{ $expired }}</p></article>
    </section>

    <section class="flex flex-wrap gap-2">
      <a href="{{ route('user.index_vehiclesale') }}" class="rounded-full border px-3 py-1.5 text-xs {{ empty($statusFilter) ? 'border-amber-300 bg-amber-300/10 text-amber-200' : 'border-slate-700 text-slate-300' }}">All {{ $total }}</a>
      <a href="{{ route('user.active_list') }}" class="rounded-full border px-3 py-1.5 text-xs {{ ($statusFilter ?? '') === 'Approved' ? 'border-emerald-300 bg-emerald-300/10 text-emerald-200' : 'border-slate-700 text-slate-300' }}">Active {{ $active }}</a>
      <a href="{{ route('user.pending_list') }}" class="rounded-full border px-3 py-1.5 text-xs {{ ($statusFilter ?? '') === 'Pending' ? 'border-amber-300 bg-amber-300/10 text-amber-200' : 'border-slate-700 text-slate-300' }}">Pending {{ $pending }}</a>
      <a href="{{ route('user.sold_list') }}" class="rounded-full border px-3 py-1.5 text-xs {{ ($statusFilter ?? '') === 'Sold' ? 'border-cyan-300 bg-cyan-300/10 text-cyan-200' : 'border-slate-700 text-slate-300' }}">Sold {{ $sold }}</a>
      <a href="{{ route('user.expired_list') }}" class="rounded-full border px-3 py-1.5 text-xs {{ ($statusFilter ?? '') === 'Expired' ? 'border-rose-300 bg-rose-300/10 text-rose-200' : 'border-slate-700 text-slate-300' }}">Expired {{ $expired }}</a>
    </section>

    <form action="{{ url()->current() }}" method="get" class="grid gap-2 rounded-xl border border-slate-800 bg-slate-900 p-4 md:grid-cols-4">
        <input type="text" name="q" value="{{ $searchQuery ?? '' }}" placeholder="Search make, model, city, listing #" class="md:col-span-2 rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
        <select name="sort" class="rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
            <option value="newest" {{ ($sortBy ?? 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ ($sortBy ?? '') === 'oldest' ? 'selected' : '' }}>Oldest</option>
            <option value="price_low" {{ ($sortBy ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_high" {{ ($sortBy ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="views_high" {{ ($sortBy ?? '') === 'views_high' ? 'selected' : '' }}>Most Viewed</option>
        </select>
        <div class="flex gap-2">
            <button type="submit" class="w-full rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Apply</button>
            <a href="{{ url()->current() }}" class="w-full rounded-lg border border-slate-700 px-4 py-2 text-center text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Reset</a>
        </div>
    </form>

    @if($listings->isEmpty())
        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <h2 class="font-display text-2xl font-semibold text-white">No listings found</h2>
            <p class="mt-2 text-sm text-slate-300">Create a new listing or switch status tabs to view others.</p>
            <a href="{{ route('user.new_listing') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Create Listing</a>
        </section>
    @else
        <section class="space-y-4">
            @foreach($listings as $listing)
                @php
                    $vehicle = $vehicles->firstWhere('listing_id', $listing->id);
                @endphp
                @continue(!$vehicle)

                @php
                    $status = strtolower((string) $listing->ads_status);
                    $badgeClass = 'border-amber-300/40 bg-amber-300/10 text-amber-200';
                    if (in_array($status, ['approved', 'active'])) $badgeClass = 'border-emerald-300/40 bg-emerald-300/10 text-emerald-200';
                    if ($status === 'sold') $badgeClass = 'border-cyan-300/40 bg-cyan-300/10 text-cyan-200';
                    if ($status === 'expired') $badgeClass = 'border-rose-300/40 bg-rose-300/10 text-rose-200';
                    $listingQuality = $quality[$listing->id] ?? ['score' => 0, 'missing' => []];
                    $score = max(0, min(100, (int) ($listingQuality['score'] ?? 0)));
                @endphp

                <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
                    <div class="grid gap-0 lg:grid-cols-12">
                        <a href="{{ route('user.show_vehiclesale', [$listing->id, $vehicle->id]) }}" class="block lg:col-span-4">
                            <img src="{{ $vehicle->front_img ? asset('storage/photos/' . $vehicle->front_img) : asset('images/land1.jpg') }}" alt="{{ $vehicle->title ?? 'Vehicle photo' }}" class="h-64 w-full object-cover lg:h-full">
                        </a>

                        <div class="space-y-4 p-5 lg:col-span-8">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <h3 class="font-display text-xl font-semibold text-white">{{ $vehicle->carmodel?->carmake?->make }} {{ $vehicle->carmodel?->model }} {{ $vehicle->year_of_build }}</h3>
                                    <p class="mt-1 text-xs text-slate-400">Listing #{{ $listing->id }} · {{ optional($listing->city)->city ?: 'No city' }} · {{ optional($listing->created_at)->format('d M Y') }}</p>
                                </div>
                                <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $badgeClass }}">{{ $listing->ads_status }}</span>
                            </div>

                            <div class="grid gap-2 text-sm text-slate-300 sm:grid-cols-2 xl:grid-cols-4">
                                <p class="rounded-lg border border-slate-800 bg-slate-950/40 px-3 py-2">Price: <span class="font-semibold text-white">Ksh {{ number_format((float) $vehicle->price) }}</span></p>
                                <p class="rounded-lg border border-slate-800 bg-slate-950/40 px-3 py-2">Views: <span class="font-semibold text-white">{{ number_format((int) $vehicle->views) }}</span></p>
                                <p class="rounded-lg border border-slate-800 bg-slate-950/40 px-3 py-2">Fuel: <span class="font-semibold text-white">{{ $vehicle->fuel_type ?: 'N/A' }}</span></p>
                                <p class="rounded-lg border border-slate-800 bg-slate-950/40 px-3 py-2">Mileage: <span class="font-semibold text-white">{{ number_format((int) $vehicle->mileage) }} km</span></p>
                            </div>

                            <div>
                                <div class="mb-1 flex items-center justify-between text-xs text-slate-300">
                                    <span>Listing Quality</span>
                                    <span>{{ $score }}%</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-slate-800">
                                    <div class="h-full rounded-full bg-amber-300" style="width: {{ $score }}%"></div>
                                </div>
                                @if(!empty($listingQuality['missing']))
                                    <p class="mt-2 text-xs text-slate-400">Missing/Improve: {{ implode(', ', $listingQuality['missing']) }}</p>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('user.show_vehiclesale', [$listing->id, $vehicle->id]) }}" class="rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">View</a>
                                <a href="{{ route('user.edit_vehiclesale', [$listing->id, $vehicle->id]) }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Edit</a>
                                <a href="{{ route('user.packages', $listing->id) }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Boost</a>

                                @if($status !== 'sold')
                                    <form action="{{ route('user.listing.quick_action', $listing->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="mark_sold">
                                        <button type="submit" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Mark Sold</button>
                                    </form>
                                @endif

                                @if(!in_array($status, ['approved', 'active']))
                                    <form action="{{ route('user.listing.quick_action', $listing->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="action" value="mark_active">
                                        <button type="submit" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Mark Active</button>
                                    </form>
                                @endif

                                <form action="{{ route('user.listing.quick_action', $listing->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="action" value="renew_30d">
                                    <button type="submit" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Renew 30d</button>
                                </form>

                                <form action="{{ route('user.delete_vehiclesale', [$listing->id, $vehicle->id]) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this listing?');">
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
    @endif
</main>
@endsection
