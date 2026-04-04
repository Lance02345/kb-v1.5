@extends('layouts.modern-app')

@section('title', 'Vehicle Listing Preview - Kingsbridge Motors')
@section('description', 'Preview your vehicle listing details.')

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

    $title = trim(($vehicle->title ? $vehicle->title . ' ' : '') . ($vehicle->carmodel?->carmake?->make ?? '') . ' ' . ($vehicle->carmodel?->model ?? '') . ' ' . ($vehicle->year_of_build ?? ''));
@endphp

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('user.index_vehiclesale') }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back</a>
        <a href="{{ route('user.edit_vehiclesale', [$listing->id, $vehicle->id]) }}" class="rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Edit Listing</a>
        <a href="{{ route('user.invoice', [$listing->id, $vehicle->id]) }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Invoice</a>
    </div>

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="space-y-5 rounded-2xl border border-slate-800 bg-slate-900 p-5 lg:col-span-2">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-amber-300">Vehicle Listing</p>
                    <h1 class="font-display text-2xl font-bold text-white sm:text-3xl">{{ $title }}</h1>
                    <p class="mt-2 text-sm text-slate-300">{{ $listing->city?->city }} · {{ $listing->category?->category_name }} · Status: {{ $listing->ads_status }}</p>
                </div>
                <p class="rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-lg font-semibold text-white">KSH {{ number_format((float) $vehicle->price) }}</p>
            </div>

            @if(count($images))
                <div class="space-y-3">
                    <button type="button" id="main-photo-trigger" class="block w-full rounded-xl border-0 bg-transparent p-0 text-left" aria-label="Open photo fullscreen">
                        <img id="main-photo" src="{{ asset('storage/photos/' . $images[0]) }}" alt="{{ $title }}" class="h-72 w-full rounded-xl object-cover sm:h-[28rem]">
                    </button>
                    <p class="text-xs text-slate-400">Click image to view fullscreen.</p>
                    <div class="grid grid-cols-3 gap-2 sm:grid-cols-5">
                        @foreach($images as $image)
                            <button type="button" class="photo-thumb overflow-hidden rounded-lg border border-slate-700 transition hover:border-amber-300" data-src="{{ asset('storage/photos/' . $image) }}">
                                <img src="{{ asset('storage/photos/' . $image) }}" alt="Vehicle photo" loading="lazy" class="h-20 w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-white">Quick Specs</h2>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Mileage: <span class="font-semibold text-white">{{ number_format((int) $vehicle->mileage) }} km</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Fuel: <span class="font-semibold text-white">{{ $vehicle->fuel_type ?: 'N/A' }}</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Transmission: <span class="font-semibold text-white">{{ $vehicle->transmission ?: 'N/A' }}</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Body: <span class="font-semibold text-white">{{ $vehicle->body_type ?: 'N/A' }}</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Engine: <span class="font-semibold text-white">{{ $vehicle->engine_size ?: 'N/A' }}</span></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">Interior: <span class="font-semibold text-white">{{ $vehicle->interior_type ?: 'N/A' }}</span></div>
                </div>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-white">Car Description</h2>
                <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-4 text-sm leading-relaxed text-slate-200">
                    {!! $vehicle->description !!}
                </div>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-white">Car Specifications</h2>
                <div class="overflow-hidden rounded-xl border border-slate-800">
                    <table class="w-full text-left text-sm text-slate-300">
                        <tbody>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Title</th><td class="px-4 py-3">{{ $vehicle->title ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Model</th><td class="px-4 py-3">{{ $vehicle->carmodel?->model ?: '-' }} - {{ $vehicle->carmodel?->carmake?->make ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Year of Build</th><td class="px-4 py-3">{{ $vehicle->year_of_build ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Condition</th><td class="px-4 py-3">{{ $vehicle->condition ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Duty Type</th><td class="px-4 py-3">{{ $vehicle->duty_type ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Vehicle Type</th><td class="px-4 py-3">{{ $vehicle->vehicle_type ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Body Type</th><td class="px-4 py-3">{{ $vehicle->body_type ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Fuel Type</th><td class="px-4 py-3">{{ $vehicle->fuel_type ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Transmission</th><td class="px-4 py-3">{{ $vehicle->transmission ?: '-' }}</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Mileage</th><td class="px-4 py-3">{{ number_format((int) $vehicle->mileage) }} km</td></tr>
                            <tr class="border-b border-slate-800"><th class="bg-slate-950/50 px-4 py-3 font-medium">Color</th><td class="px-4 py-3">{{ $vehicle->color ?: '-' }}</td></tr>
                            <tr><th class="bg-slate-950/50 px-4 py-3 font-medium">Views</th><td class="px-4 py-3">{{ number_format((int) $vehicle->views) }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </article>

        <aside class="space-y-4">
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <h3 class="font-display text-lg font-semibold text-white">Listing Summary</h3>
                <div class="mt-3 space-y-2 text-sm text-slate-300">
                    <p>ID: <span class="text-white">{{ $listing->id }}</span></p>
                    <p>Status: <span class="text-white">{{ $listing->ads_status }}</span></p>
                    <p>Package: <span class="text-white">{{ $listing->package?->package_name ?: 'N/A' }}</span></p>
                    <p>Created: <span class="text-white">{{ optional($listing->created_at)->format('d M Y') }}</span></p>
                </div>
            </article>

            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <h3 class="font-display text-lg font-semibold text-white">Seller Info</h3>
                <div class="mt-3 text-sm text-slate-300">
                    <p class="text-white">{{ $listing->user?->name }}</p>
                    <p>{{ $listing->user?->phone_number }}</p>
                    <p>{{ $listing->user?->email }}</p>
                </div>
            </article>

            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5 text-sm text-slate-300">
                <h3 class="font-display text-lg font-semibold text-white">Safety Tips</h3>
                <ul class="mt-3 space-y-2">
                    <li>Meet in a safe public location.</li>
                    <li>Verify ownership and service records.</li>
                    <li>Do not send payment before inspection.</li>
                </ul>
            </article>
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
