@extends('layouts.modern-app')

@section('title', 'Find Your Drive - Kingsbridge Marketplace')
@section('description', 'Browse fresh marketplace inventory across every budget and style.')

@section('content')
@include('modern._nav')

<section class="relative h-[280px] sm:h-[340px] lg:h-[420px] overflow-hidden">
    <img
        src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920&h=700&fit=crop"
        alt="Marketplace hero"
        class="absolute inset-0 h-full w-full object-cover"
    >
    <div class="absolute inset-0 bg-gradient-to-b from-[#020617]/30 via-[#0b1020]/70 to-[#0b1020]"></div>

    <div class="relative z-10 mx-auto flex h-full max-w-7xl items-end px-4 pb-10 sm:px-6 lg:px-8">
        <div>
            <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">
                Livewire + Tailwind Marketplace
            </p>
            <h1 class="font-display text-3xl font-bold leading-tight text-white sm:text-5xl">Find Your Drive</h1>
            <p class="mt-3 max-w-2xl text-sm text-slate-300 sm:text-base">Fresh marketplace inventory across every budget and style.</p>
            <div class="mt-4 flex flex-wrap items-center gap-2 text-xs">
                <a href="{{ route('marketplace.index') }}" class="rounded-full border border-slate-500/60 bg-slate-900/50 px-3 py-1 text-slate-200 hover:border-amber-300 hover:text-amber-200">Vehicles</a>
                <a href="{{ route('spareparts') }}" class="rounded-full border border-slate-500/60 bg-slate-900/50 px-3 py-1 text-slate-200 hover:border-amber-300 hover:text-amber-200">Vehicle Parts</a>
                <a href="{{ route('carhire') }}" class="rounded-full border border-slate-500/60 bg-slate-900/50 px-3 py-1 text-slate-200 hover:border-amber-300 hover:text-amber-200">Car Hire</a>
            </div>
        </div>
    </div>
</section>

<main class="relative z-20 -mt-6 pb-14 sm:-mt-8">
    <div class="mx-auto max-w-7xl space-y-12 px-4 sm:px-6 lg:px-8">
        <livewire:landing-vehicle-browser />

        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-2xl font-semibold text-white">Trending Ads</h2>
                <a href="{{ route('marketplace.index') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">View all</a>
            </div>
            @if(($featuredVehicles ?? collect())->count())
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($featuredVehicles as $vehicle)
                        @include('livewire.partials.marketplace-card', ['vehicle' => $vehicle, 'badge' => 'Featured'])
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-sm text-slate-400">No featured ads yet.</div>
            @endif
        </section>

        <section class="space-y-4">
            <h2 class="font-display text-2xl font-semibold text-white">Find Your Drive</h2>
            @if(($latestVehicles ?? collect())->count())
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($latestVehicles as $vehicle)
                        @include('livewire.partials.marketplace-card', ['vehicle' => $vehicle, 'badge' => 'Live'])
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-sm text-slate-400">No listings found.</div>
            @endif
        </section>

        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-2xl font-semibold text-white">Events</h2>
                <a href="{{ route('carevent') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">See all events</a>
            </div>
            @if(($carevents ?? collect())->count())
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($carevents as $event)
                        <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15">
                            <img src="{{ $event->event_image ? asset('storage/photos/' . $event->event_image) : asset('images/land1.jpg') }}" alt="{{ $event->event_title }}" class="aspect-[16/10] w-full object-cover">
                            <div class="space-y-2 p-4">
                                <h3 class="font-display text-lg font-semibold text-white">{{ $event->event_title }}</h3>
                                <p class="text-xs text-slate-400">{{ $event->event_location }} · {{ $event->event_date }} · {{ $event->event_time }}</p>
                                <span class="inline-flex rounded-full border border-amber-300/30 bg-amber-300/10 px-2.5 py-1 text-xs font-semibold text-amber-200">Ticket Ksh {{ number_format((float) $event->ticket_price) }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-sm text-slate-400">No events yet.</div>
            @endif
        </section>

        <section class="grid gap-4 lg:grid-cols-2">
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <h3 class="font-display text-xl font-semibold text-white">Why KingsBridge Motors?</h3>
                <p class="mt-2 text-sm text-slate-300">We are more than a listings site. KingsBridge connects buyers, sellers, garages, and event organizers in one automotive ecosystem.</p>
                <a href="{{ route('about_us') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Learn more</a>
            </article>
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <h3 class="font-display text-xl font-semibold text-white">Flexible Options for All</h3>
                <p class="mt-2 text-sm text-slate-300">Whether you sell vehicles, post spare parts, or promote events, we provide flexible options that match your goals and budget.</p>
                <a href="{{ route('about_us') }}" class="mt-4 inline-flex rounded-lg border border-slate-700 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500 hover:text-white">Explore options</a>
            </article>
        </section>

        <section class="rounded-2xl border border-slate-800 bg-gradient-to-r from-slate-900 to-slate-800 p-6 sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-display text-2xl font-semibold text-white">Start today to get more exposure</h3>
                    <p class="mt-1 text-sm text-slate-300">Join the largest community of vehicle enthusiasts and grow your business.</p>
                </div>
                <a href="{{ Auth::check() ? route('user.new_listing') : route('login') }}" class="inline-flex w-fit rounded-lg bg-amber-300 px-5 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Join today</a>
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="font-display text-2xl font-semibold text-white">Our Partners</h2>
            <div class="flex items-center justify-center rounded-2xl border border-slate-800 bg-slate-900 p-8">
                <img src="{{ asset('images/GarageGallery Logo.jpg') }}" alt="GarageGallery" class="max-h-24 w-auto rounded-md object-contain">
            </div>
        </section>

        <section class="rounded-2xl border border-amber-300/30 bg-amber-300/10 p-6 sm:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="font-display text-2xl font-semibold text-white">Join the largest community of vehicle enthusiasts</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ Auth::check() ? route('user.new_listing') : route('login') }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Add Listing</a>
                    <a href="{{ route('marketplace.index') }}" class="rounded-lg border border-slate-600 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-100 hover:border-slate-400">Browse Listings</a>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
