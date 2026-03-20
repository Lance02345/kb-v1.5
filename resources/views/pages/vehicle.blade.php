@extends('layouts.modern-app')

@section('title', (($vehicle->carmodel?->carmake?->make ?? 'Vehicle') . ' ' . ($vehicle->carmodel?->model ?? '') . ' - Kingsbridge Motors'))
@section('description', 'View listing details, specs, photos, and seller contact information.')

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

    $title = trim(($vehicle->carmodel?->carmake?->make ?? '') . ' ' . ($vehicle->carmodel?->model ?? '') . ' ' . ($vehicle->year_of_build ?? ''));
    $seller = $listing->user;
    $sellerPhone = $seller->phone_number ?? null;
    $sellerWhatsapp = $sellerPhone ? preg_replace('/\D+/', '', $sellerPhone) : null;
    $sellerProfileUrl = $seller ? route('seller.show', $seller->id) : null;
@endphp

<main class="w-full space-y-8 px-4 py-8 sm:px-6 lg:px-10">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('vehicleslist') }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to Listings</a>
        @auth
            <a href="{{ route('user.my_list') }}" class="inline-flex rounded-lg border border-amber-300/40 bg-amber-300/10 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-amber-200 hover:bg-amber-300/20">Return to Dashboard</a>
        @endauth
    </div>

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="space-y-5 rounded-2xl border border-slate-800 bg-slate-900 p-5 lg:col-span-2">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-300">Vehicle Listing</p>
                        <h1 class="font-display text-2xl font-bold text-white sm:text-3xl">{{ $title }}</h1>
                        <p class="mt-2 text-sm text-slate-300">{{ $listing->city->city ?? 'Unknown city' }} · {{ $listing->category->category_name ?? 'Vehicle' }}</p>
                    </div>
                    <p class="rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-lg font-semibold text-white">{{ format_currency($vehicle->price) }}</p>
                </div>

            @if(count($images))
                <div class="space-y-3">
                    <div class="relative">
                        <button type="button" id="main-photo-trigger" class="block w-full rounded-xl border-0 bg-transparent p-0 text-left" aria-label="Open photo fullscreen">
                            <img id="main-photo" src="{{ asset('storage/photos/' . $images[0]) }}" alt="{{ $title }}" loading="lazy" class="h-72 w-full rounded-xl object-cover sm:h-[28rem]">
                        </button>
                        @if(count($images) > 1)
                            <button type="button" id="gallery-nav-prev" class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full border border-slate-600 bg-slate-900/70 px-3 py-2 text-2xl font-semibold text-slate-100 shadow-lg" aria-label="Previous photo">&larr;</button>
                            <button type="button" id="gallery-nav-next" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full border border-slate-600 bg-slate-900/70 px-3 py-2 text-2xl font-semibold text-slate-100 shadow-lg" aria-label="Next photo">&rarr;</button>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400">Click image to view fullscreen.</p>
                    <div class="grid grid-cols-3 gap-2 sm:grid-cols-5">
                        @foreach($images as $image)
                            <button type="button" class="photo-thumb overflow-hidden rounded-lg border border-slate-700 transition hover:border-amber-300" data-src="{{ asset('storage/photos/' . $image) }}">
                                <img src="{{ asset('storage/photos/' . $image) }}" alt="Vehicle photo" loading="lazy" class="h-20 w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-6 text-sm text-slate-400">No photos uploaded yet.</div>
            @endif

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-white">Quick Specs</h2>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Mileage: <span class="font-semibold text-white">{{ number_format((float) $vehicle->mileage, 0, '.', ',') }} km</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Fuel: <span class="font-semibold text-white">{{ $vehicle->fuel_type ?? 'N/A' }}</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Transmission: <span class="font-semibold text-white">{{ $vehicle->transmission ?? 'N/A' }}</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Body: <span class="font-semibold text-white">{{ $vehicle->body_type ?? 'N/A' }}</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Engine: <span class="font-semibold text-white">{{ $vehicle->engine_size ?? 'N/A' }}</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Interior: <span class="font-semibold text-white">{{ $vehicle->interior_type ?? 'N/A' }}</span></div>
                </div>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-white">Description</h2>
                <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-4 text-sm leading-relaxed text-slate-200">
                    {!! $vehicle->description !!}
                </div>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-white">Full Specifications</h2>
                <div class="overflow-hidden rounded-xl border border-slate-800">
                    <table class="w-full text-left text-sm text-slate-300">
                        <tbody>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Model</th><td class="px-4 py-3">{{ $vehicle->carmodel?->model ?? '-' }} - {{ $vehicle->carmodel?->carmake?->make ?? '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Year of Build</th><td class="px-4 py-3">{{ $vehicle->year_of_build ?? '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Duty Type</th><td class="px-4 py-3">{{ $vehicle->duty_type ?? '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Condition</th><td class="px-4 py-3">{{ $vehicle->condition ?? '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Mileage</th><td class="px-4 py-3">{{ number_format((float) $vehicle->mileage, 0, '.', ',') }} km</td></tr>
                            <tr><th class="bg-slate-950/50 px-4 py-3 font-medium">Views</th><td class="px-4 py-3">{{ $vehicle->views }} total views</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-end justify-between gap-3">
                    <h2 class="font-display text-xl font-semibold text-white">Similar vehicles</h2>
                    <a href="{{ route('marketplace.index') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">Browse marketplace</a>
                </div>
                @if(($similarVehicles ?? collect())->count())
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach($similarVehicles as $suggested)
                            @php
                                $suggestedListing = $suggested->listing;
                                $makeName = optional(optional($suggested->carmodel)->carmake)->make;
                                $suggestedTitle = trim((string) ($makeName ?? '') . ' ' . (optional($suggested->carmodel)->model ?? '') . ' ' . ($suggested->year_of_build ?? ''));
                                $listRoute = $suggestedListing ? route('vehicle', [$suggestedListing->id, $suggested->id]) : '#';
                            @endphp
                            <article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
                                <a href="{{ $listRoute }}">
                                    <img src="{{ $suggested->front_img ? asset('storage/photos/' . $suggested->front_img) : asset('images/land1.jpg') }}" alt="{{ $suggestedTitle }}" loading="lazy" class="h-44 w-full object-cover">
                                </a>
                                <div class="space-y-1 p-3">
                                    <a href="{{ $listRoute }}" class="font-display text-sm font-semibold text-white hover:text-amber-200">{{ $suggestedTitle }}</a>
                                    <p class="text-xs text-slate-400">{{ optional($suggestedListing->city)->city ?? 'Kenya' }} · {{ $suggestedListing->ads_status ?? 'Unknown' }}</p>
                                    <span class="text-sm font-semibold text-amber-300">{{ format_currency($suggested->price) }}</span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4 text-sm text-slate-400">No similar vehicles caught our radar yet.</div>
                @endif
            </section>
        </article>

        <aside class="space-y-4">
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <h2 class="font-display text-xl font-semibold text-white">Seller Info</h2>
                <div class="mt-4 flex items-center gap-3">
                    <img src="{{ $seller && $seller->avatar ? asset('storage/photos/' . $seller->avatar) : asset('images/default-avatar.png') }}" alt="Seller avatar" class="h-12 w-12 rounded-full object-cover">
                    <div>
                        <p class="text-sm font-semibold text-white">{{ $seller->name ?? 'Seller' }}</p>
                        <p class="text-xs text-slate-400">Member {{ optional($seller->created_at)->diffForHumans() }}</p>
                    </div>
                </div>

                @if($sellerProfileUrl)
                    <a href="{{ $sellerProfileUrl }}" class="mt-4 inline-flex w-full justify-center rounded-lg border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-200 hover:border-slate-500 hover:text-white">
                        View Seller Profile
                    </a>
                @endif

                <div class="mt-4 space-y-2">
                    @auth
                        @if($sellerPhone)
                            <a href="tel:{{ $sellerPhone }}" class="inline-flex w-full justify-center rounded-lg bg-amber-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-amber-200">Call Seller</a>
                        @endif
                        @if($sellerWhatsapp)
                            <a href="https://wa.me/{{ $sellerWhatsapp }}?text={{ rawurlencode('Hi, I am interested in ' . $title . ' ' . route('vehicle', [$listing->id, $vehicle->id])) }}" target="_blank" rel="noopener" class="inline-flex w-full justify-center rounded-lg border border-slate-600 px-4 py-2 text-sm font-semibold text-white hover:border-slate-400">WhatsApp Seller</a>
                        @endif
                        @if(!$sellerPhone)
                            <p class="rounded-lg border border-slate-800 bg-slate-950/60 px-4 py-3 text-center text-xs text-slate-400">Seller contact details have not been added yet.</p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex w-full justify-center rounded-lg bg-amber-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-amber-200">Login to Contact</a>
                    @endauth

                    @auth
                        <form method="POST" action="{{ route('addtofavourites') }}">
                            @csrf
                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <button type="submit" class="inline-flex w-full justify-center rounded-lg border border-amber-300/40 bg-amber-300/10 px-4 py-2 text-sm font-semibold text-amber-200 hover:bg-amber-300/20">Save to Favourites</button>
                        </form>
                    @endauth
                </div>
            </article>

            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5 text-sm text-slate-300">
                <h3 class="font-display text-lg font-semibold text-white">Safety Tips</h3>
                <ul class="mt-3 space-y-2">
                    <li>Meet the seller in a safe public place.</li>
                    <li>Inspect the vehicle before sending payment.</li>
                    <li>Verify documents before finalizing the purchase.</li>
                </ul>
            </article>

            <a href="{{ Auth::check() ? route('user.create_vehiclesale') : route('login') }}" class="block rounded-2xl border border-slate-800 bg-gradient-to-r from-slate-900 to-slate-800 p-5 text-center text-sm font-semibold text-white hover:border-slate-600">
                Have a vehicle to sell? Create listing
            </a>
        </aside>
    </section>
</main>

<div id="photo-lightbox" class="fixed inset-0 z-[90] hidden bg-slate-950/95 p-3 sm:p-6" aria-hidden="true">
    <div class="relative mx-auto flex h-full w-full max-w-7xl items-center justify-center">
        <button type="button" id="lightbox-close" class="absolute right-0 top-0 rounded-lg border border-slate-600 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-100 hover:border-slate-300">Close</button>
        <button type="button" id="lightbox-prev" class="absolute left-1 top-1/2 -translate-y-1/2 rounded-lg border border-slate-600 bg-slate-900/70 px-3 py-2 text-slate-100 hover:border-slate-300" aria-label="Previous photo">&larr;</button>
        <img id="lightbox-image" src="" alt="Vehicle image fullscreen" class="max-h-full max-w-full rounded-lg object-contain">
        <button type="button" id="lightbox-next" class="absolute right-1 top-1/2 -translate-y-1/2 rounded-lg border border-slate-600 bg-slate-900/70 px-3 py-2 text-slate-100 hover:border-slate-300" aria-label="Next photo">&rarr;</button>
    </div>
</div>

<script>
    (function () {
        var main = document.getElementById('main-photo');
        var mainTrigger = document.getElementById('main-photo-trigger');
        var thumbs = Array.prototype.slice.call(document.querySelectorAll('.photo-thumb'));
        if (!main || thumbs.length === 0) {
            return;
        }

        var lightbox = document.getElementById('photo-lightbox');
        var lightboxImage = document.getElementById('lightbox-image');
        var closeBtn = document.getElementById('lightbox-close');
        var prevBtn = document.getElementById('lightbox-prev');
        var nextBtn = document.getElementById('lightbox-next');
        var images = thumbs.map(function (thumb) { return thumb.dataset.src; });
        var currentIndex = 0;

        function setActiveThumb(index) {
            thumbs.forEach(function (item, itemIndex) {
                item.classList.toggle('border-amber-300', itemIndex === index);
            });
        }

        function showImage(index) {
            currentIndex = (index + images.length) % images.length;
            var src = images[currentIndex];
            main.src = src;
            if (lightboxImage) {
                lightboxImage.src = src;
            }
            setActiveThumb(currentIndex);
        }

        function openLightbox() {
            if (!lightbox || !lightboxImage) return;
            lightbox.classList.remove('hidden');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            lightboxImage.src = images[currentIndex];
        }

        function closeLightbox() {
            if (!lightbox) return;
            lightbox.classList.add('hidden');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        thumbs.forEach(function (button, index) {
            button.addEventListener('click', function () {
                showImage(index);
            });
        });

        if (mainTrigger) {
            mainTrigger.addEventListener('click', openLightbox);
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', closeLightbox);
        }
        if (prevBtn) {
            prevBtn.addEventListener('click', function () { showImage(currentIndex - 1); });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function () { showImage(currentIndex + 1); });
        }
        var galleryPrev = document.getElementById('gallery-nav-prev');
        var galleryNext = document.getElementById('gallery-nav-next');
        if (galleryPrev) {
            galleryPrev.addEventListener('click', function () { showImage(currentIndex - 1); });
        }
        if (galleryNext) {
            galleryNext.addEventListener('click', function () { showImage(currentIndex + 1); });
        }
        if (lightbox) {
            lightbox.addEventListener('click', function (event) {
                if (event.target === lightbox) {
                    closeLightbox();
                }
            });
        }

        document.addEventListener('keydown', function (event) {
            if (!lightbox || lightbox.classList.contains('hidden')) return;
            if (event.key === 'Escape') closeLightbox();
            if (event.key === 'ArrowLeft') showImage(currentIndex - 1);
            if (event.key === 'ArrowRight') showImage(currentIndex + 1);
        });

        showImage(0);
    })();
</script>
@endsection
