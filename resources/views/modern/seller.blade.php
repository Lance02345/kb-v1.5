@extends('layouts.modern-app')

@section('title', ($seller->name ?? 'Seller') . ' | Kingsbridge Motors')
@section('description', 'Browse this seller\'s active listings and spare parts.')

@section('content')
@include('modern._nav')

@php
    $sellerPhone = $seller->phone_number ?? null;
    $sellerWhatsapp = $sellerPhone ? preg_replace('/\D+/', '', $sellerPhone) : null;
@endphp

<section class="border-b border-slate-800 bg-[#0b1020]">
    <div class="w-full px-4 py-12 sm:px-6 lg:px-10">
        <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">Seller Profile</p>
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ $seller->avatar ? asset('storage/photos/' . $seller->avatar) : asset('images/default-avatar.png') }}" alt="{{ $seller->name ?? 'Seller' }}" class="h-16 w-16 rounded-full object-cover ring-2 ring-slate-800">
                <div>
                    <h1 class="font-display text-3xl font-bold text-white sm:text-4xl">{{ $seller->name ?? 'Seller' }}</h1>
                    <p class="mt-1 text-sm text-slate-300">Member since {{ optional($seller->created_at)->format('M Y') ?? 'recently' }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                @if($sellerPhone)
                    <a href="tel:{{ $sellerPhone }}" class="inline-flex rounded-lg bg-amber-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-amber-200">Call Seller</a>
                @endif
                @if($sellerWhatsapp)
                    <a href="https://wa.me/{{ $sellerWhatsapp }}?text={{ rawurlencode('Hi, I am interested in your listings on Kingsbridge Motors.') }}" target="_blank" rel="noopener" class="inline-flex rounded-lg border border-emerald-400/40 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-200 hover:bg-emerald-500/20">WhatsApp Seller</a>
                @endif
            </div>
        </div>

        <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Vehicles</p>
                <p class="mt-2 font-display text-3xl font-bold text-white">{{ $sellerVehicleListings->count() }}</p>
            </article>
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-4">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Spare Parts</p>
                <p class="mt-2 font-display text-3xl font-bold text-white">{{ $sellerSpareParts->count() }}</p>
            </article>
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-4 sm:col-span-2">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Trust</p>
                <div class="mt-2 flex flex-wrap gap-2 text-xs">
                    @if($seller->isVerified)
                        <span class="rounded-full border border-emerald-500/40 bg-emerald-500/10 px-2 py-1 text-emerald-200">Verified seller</span>
                    @endif
                    @if($seller->email_verified_at)
                        <span class="rounded-full border border-sky-500/40 bg-sky-500/10 px-2 py-1 text-sky-200">Email verified</span>
                    @endif
                    @if($seller->phone_verified_at)
                        <span class="rounded-full border border-amber-400/40 bg-amber-400/10 px-2 py-1 text-amber-200">Phone verified</span>
                    @endif
                    @if(!$seller->isVerified && !$seller->email_verified_at && !$seller->phone_verified_at)
                        <span class="rounded-full border border-slate-700 bg-slate-950 px-2 py-1 text-slate-300">Active marketplace member</span>
                    @endif
                </div>
            </article>
        </div>
    </div>
</section>

<main class="w-full space-y-8 px-4 py-8 sm:px-6 lg:px-10">
    <section class="space-y-4">
        <div class="flex items-end justify-between gap-3">
            <div>
                <h2 class="font-display text-2xl font-semibold text-white">Vehicles for Sale</h2>
                <p class="mt-1 text-sm text-slate-400">All active vehicle listings from this seller.</p>
            </div>
            <a href="{{ route('marketplace.index') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">Browse marketplace</a>
        </div>

        @if($sellerVehicleListings->count())
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach($sellerVehicleListings as $vehicle)
                    @php
                        $listing = $vehicle->listing;
                        $title = trim((optional(optional($vehicle->carmodel)->carmake)->make ?? '') . ' ' . (optional($vehicle->carmodel)->model ?? '') . ' ' . ($vehicle->year_of_build ?? ''));
                    @endphp
                    <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/10">
                        <a href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}">
                            <img src="{{ $vehicle->front_img ? asset('storage/photos/' . $vehicle->front_img) : asset('images/land1.jpg') }}" alt="{{ $title }}" loading="lazy" class="aspect-[4/3] w-full object-cover">
                        </a>
                        <div class="space-y-2 p-4">
                            <a href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}" class="block font-display text-base font-semibold text-white hover:text-amber-200">{{ $title }}</a>
                            <p class="text-xs text-slate-400">{{ optional($listing->city)->city ?? 'Kenya' }} · {{ optional($listing->category)->category_name ?? 'Vehicle' }}</p>
                            <div class="grid grid-cols-2 gap-2 text-xs text-slate-400">
                                <div>{{ $vehicle->transmission ?: '-' }}</div>
                                <div>{{ $vehicle->fuel_type ?: '-' }}</div>
                                <div>{{ number_format((float) $vehicle->mileage) }} Km</div>
                                <div>{{ $vehicle->engine_size ?: '-' }}</div>
                            </div>
                            <p class="font-display text-lg font-bold text-amber-300">{{ format_currency($vehicle->price) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6 text-sm text-slate-400">This seller does not have active vehicle listings right now.</div>
        @endif
    </section>

    <section class="space-y-4">
        <div>
            <h2 class="font-display text-2xl font-semibold text-white">Spare Parts</h2>
            <p class="mt-1 text-sm text-slate-400">More listings from the same seller.</p>
        </div>

        @if($sellerSpareParts->count())
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach($sellerSpareParts as $part)
                    <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/10">
                        <a href="{{ route('sparepart', $part->id) }}">
                            <img src="{{ $part->front_img ? asset('storage/photos/' . $part->front_img) : asset('images/land1.jpg') }}" alt="{{ $part->item_name }}" loading="lazy" class="aspect-[4/3] w-full object-cover">
                        </a>
                        <div class="space-y-2 p-4">
                            <a href="{{ route('sparepart', $part->id) }}" class="block font-display text-base font-semibold text-white hover:text-amber-200">{{ $part->make }} - {{ $part->item_name }}</a>
                            <p class="text-xs text-slate-400">{{ $part->location ?: 'Kenya' }} · {{ $part->condition ?: 'N/A' }}</p>
                            @if(!empty($part->category))
                                <p class="text-xs text-amber-200">{{ $part->category }}</p>
                            @endif
                            <p class="font-display text-lg font-bold text-amber-300">{{ format_currency($part->price) }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6 text-sm text-slate-400">No spare parts from this seller yet.</div>
        @endif
    </section>
</main>
@endsection
