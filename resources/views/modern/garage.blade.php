@extends('layouts.modern-app')

@section('title', ($garage->garage_title) . ' | Kingsbridge Motors')
@section('description', 'Garage listing details and contact information.')

@section('content')
@include('modern._nav')

@php
    $images = array_values(array_filter([
        $garage->front_img ?? null,
        $garage->back_img ?? null,
        $garage->right_img ?? null,
        $garage->left_img ?? null,
        $garage->interiorf_img ?? null,
        $garage->interiorb_img ?? null,
        $garage->opt_img1 ?? null,
        $garage->opt_img2 ?? null,
        $garage->opt_img3 ?? null,
    ]));
    $ownerPhone = optional($garage->user)->phone_number;
    $ownerWhatsapp = $ownerPhone ? preg_replace('/\D+/', '', $ownerPhone) : null;
@endphp

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('garages.index') }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to Garages</a>
        @auth
            <a href="{{ route('user.my_list') }}" class="inline-flex rounded-lg border border-amber-300/40 bg-amber-300/10 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-amber-200 hover:bg-amber-300/20">Return to Dashboard</a>
        @endauth
    </div>

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="space-y-4 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-4 lg:col-span-2">
            <h1 class="font-display text-2xl font-bold text-white sm:text-3xl">{{ $garage->garage_title }}</h1>
            <p class="text-sm text-slate-300">{!! nl2br(e(strip_tags($garage->garage_description))) !!}</p>

            @if(count($images))
                <div class="space-y-3">
                    <button type="button" id="garage-main-photo-trigger" class="block w-full rounded-xl border-0 bg-transparent p-0 text-left" aria-label="Open garage photo fullscreen">
                        <img id="garage-main-photo" src="{{ asset('storage/' . ltrim($images[0], '/')) }}" alt="{{ $garage->garage_title }}" class="h-72 w-full rounded-xl object-cover sm:h-[28rem]">
                    </button>
                    <p class="text-xs text-slate-400">Click image to view fullscreen.</p>
                    <div class="grid grid-cols-3 gap-2 sm:grid-cols-5">
                        @foreach($images as $index => $image)
                            <button type="button" class="garage-thumb overflow-hidden rounded-lg border border-slate-700 transition hover:border-amber-300" data-src="{{ asset('storage/' . ltrim($image, '/')) }}" data-index="{{ $index }}">
                                <img src="{{ asset('storage/' . ltrim($image, '/')) }}" alt="{{ $garage->garage_title }}" class="h-20 w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid gap-3 rounded-xl border border-slate-800 bg-slate-950/40 p-4 text-sm text-slate-300 sm:grid-cols-2">
                <p>Location: <span class="font-semibold text-white">{{ $garage->garage_location }}</span></p>
                <p>Listed by: <span class="font-semibold text-white">{{ optional($garage->user)->name ?? 'Unknown' }}</span></p>
            </div>
        </article>

        <aside class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <h2 class="font-display text-lg font-semibold text-white">Garage Owner</h2>
            <div class="flex items-center gap-3">
                <img src="{{ (optional($garage->user)->avatar) ? asset('storage/photos/' . $garage->user->avatar) : asset('images/default-avatar.png') }}" alt="Owner avatar" class="h-12 w-12 rounded-full object-cover">
                <div>
                    <p class="text-sm font-semibold text-white">{{ optional($garage->user)->name ?? 'Unknown' }}</p>
                    <p class="text-xs text-slate-400">Member since {{ optional(optional($garage->user)->created_at)->diffForHumans() }}</p>
                </div>
            </div>

            @if($ownerPhone)
                <a href="tel:{{ $ownerPhone }}" class="inline-flex w-full justify-center rounded-lg bg-amber-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-amber-200">Call Garage Owner</a>
                @if($ownerWhatsapp)
                    <a href="https://wa.me/{{ $ownerWhatsapp }}" class="inline-flex w-full justify-center rounded-lg border border-emerald-400/40 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-200 hover:bg-emerald-500/20">WhatsApp Owner</a>
                @endif
            @endif
        </aside>
    </section>
</main>

<div id="garage-lightbox" class="fixed inset-0 z-[90] hidden bg-slate-950/95 p-3 sm:p-6" aria-hidden="true">
    <div class="relative mx-auto flex h-full w-full max-w-7xl items-center justify-center">
        <button type="button" id="garage-lightbox-close" class="absolute right-0 top-0 rounded-lg border border-slate-600 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-100 hover:border-slate-300">Close</button>
        <button type="button" id="garage-lightbox-prev" class="absolute left-1 top-1/2 -translate-y-1/2 rounded-lg border border-slate-600 bg-slate-900/70 px-3 py-2 text-slate-100 hover:border-slate-300" aria-label="Previous image">&larr;</button>
        <img id="garage-lightbox-image" src="" alt="Garage image fullscreen" class="max-h-full max-w-full rounded-lg object-contain">
        <button type="button" id="garage-lightbox-next" class="absolute right-1 top-1/2 -translate-y-1/2 rounded-lg border border-slate-600 bg-slate-900/70 px-3 py-2 text-slate-100 hover:border-slate-300" aria-label="Next image">&rarr;</button>
    </div>
</div>

<script>
    (function () {
        var main = document.getElementById('garage-main-photo');
        var mainTrigger = document.getElementById('garage-main-photo-trigger');
        var thumbs = Array.prototype.slice.call(document.querySelectorAll('.garage-thumb'));
        if (!main || thumbs.length === 0) return;

        var lightbox = document.getElementById('garage-lightbox');
        var image = document.getElementById('garage-lightbox-image');
        var closeBtn = document.getElementById('garage-lightbox-close');
        var prevBtn = document.getElementById('garage-lightbox-prev');
        var nextBtn = document.getElementById('garage-lightbox-next');
        var images = thumbs.map(function (thumb) { return thumb.dataset.src; });
        var currentIndex = 0;

        function setActiveThumb(index) {
            thumbs.forEach(function (item, itemIndex) {
                item.classList.toggle('border-amber-300', itemIndex === index);
            });
        }

        function showImage(index) {
            currentIndex = (index + images.length) % images.length;
            main.src = images[currentIndex];
            if (image) {
                image.src = images[currentIndex];
            }
            setActiveThumb(currentIndex);
        }

        function openLightbox(index) {
            if (!lightbox) return;
            showImage(index);
            lightbox.classList.remove('hidden');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            if (!lightbox) return;
            lightbox.classList.add('hidden');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        thumbs.forEach(function (thumb, index) {
            thumb.addEventListener('click', function () {
                showImage(index);
            });
        });

        if (mainTrigger) {
            mainTrigger.addEventListener('click', function () {
                openLightbox(currentIndex);
            });
        }
        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (prevBtn) prevBtn.addEventListener('click', function () { showImage(currentIndex - 1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { showImage(currentIndex + 1); });
        if (lightbox) {
            lightbox.addEventListener('click', function (event) {
                if (event.target === lightbox) closeLightbox();
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
