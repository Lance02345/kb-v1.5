@extends('layouts.modern-app')

@section('title', 'Marketplace - Kingsbridge Motors')
@section('description', 'Browse fresh marketplace inventory across every budget and style.')

@section('content')
@include('modern._nav')

<section class="relative overflow-hidden border-b border-slate-800 bg-[#0b1020]">
    <div class="absolute -left-16 top-8 h-44 w-44 rounded-full bg-amber-300/20 blur-3xl"></div>
    <div class="absolute right-0 top-0 h-56 w-56 rounded-full bg-cyan-300/10 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">Marketplace</p>
        <h1 class="font-display text-4xl font-bold text-white sm:text-5xl">Find Your Next Vehicle</h1>
        <p class="mt-3 max-w-2xl text-sm text-slate-300 sm:text-base">Filter by city, make, and price to discover cars that match your budget and style.</p>
    </div>
</section>

<main class="mx-auto max-w-7xl space-y-10 px-4 py-8 sm:px-6 lg:px-8">
    <livewire:landing-vehicle-browser />

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-2xl font-semibold text-white">Trending Ads</h2>
            <a href="{{ route('marketplace.index') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">Refresh</a>
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
        <h2 class="font-display text-2xl font-semibold text-white">Latest Arrivals</h2>
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
</main>
@endsection
