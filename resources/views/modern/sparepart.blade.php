@extends('layouts.modern-app')

@section('title', ($sparePart->make . ' - ' . $sparePart->item_name) . ' | Kingsbridge Motors')
@section('description', 'Spare part details, photos, seller info, and contact options.')

@section('content')
@include('modern._nav')

@php
    $images = array_values(array_filter([
        $sparePart->front_img ?? null,
        $sparePart->back_img ?? null,
        $sparePart->right_img ?? null,
        $sparePart->left_img ?? null,
        $sparePart->interiorf_img ?? null,
        $sparePart->interiorb_img ?? null,
        $sparePart->opt_img1 ?? null,
        $sparePart->opt_img2 ?? null,
        $sparePart->opt_img3 ?? null,
    ]));
@endphp

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('spareparts') }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to Spare Parts</a>
        @auth
            <a href="{{ route('user.my_list') }}" class="inline-flex rounded-lg border border-amber-300/40 bg-amber-300/10 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-amber-200 hover:bg-amber-300/20">Return to Dashboard</a>
        @endauth
    </div>
    @auth
        @if((int) auth()->id() === (int) $sparePart->user_id)
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.sparepartsedit', $sparePart->id) }}" class="inline-flex rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Edit Listing</a>
                <form action="{{ route('user.sparepartsdestroy', $sparePart->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this spare part?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex rounded-lg border border-rose-300/30 bg-rose-400/10 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-rose-200 hover:bg-rose-400/20">Delete Listing</button>
                </form>
            </div>
        @endif
    @endauth

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="space-y-4 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-4 lg:col-span-2">
            <h1 class="font-display text-2xl font-bold text-white sm:text-3xl">{{ $sparePart->make }} - {{ $sparePart->item_name }}</h1>
            <p class="text-sm text-slate-300">{{ $sparePart->item_description }}</p>

            @if(count($images))
                <div class="space-y-3">
                    <button type="button" id="spare-main-photo-trigger" class="block w-full rounded-xl border-0 bg-transparent p-0 text-left" aria-label="Open spare part photo fullscreen">
                        <img id="spare-main-photo" src="{{ asset('storage/photos/' . $images[0]) }}" alt="{{ $sparePart->item_name }}" class="h-72 w-full rounded-xl object-cover sm:h-[28rem]">
                    </button>
                    <p class="text-xs text-slate-400">Click image to view fullscreen.</p>
                    <div class="grid grid-cols-3 gap-2 sm:grid-cols-5">
                        @foreach($images as $index => $image)
                            <button type="button" class="spare-thumb overflow-hidden rounded-lg border border-slate-700 transition hover:border-amber-300" data-src="{{ asset('storage/photos/' . $image) }}" data-index="{{ $index }}">
                                <img src="{{ asset('storage/photos/' . $image) }}" alt="{{ $sparePart->item_name }}" class="h-20 w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-6 text-sm text-slate-400">No images available.</div>
            @endif

            <div class="grid gap-3 rounded-xl border border-slate-800 bg-slate-950/40 p-4 text-sm text-slate-300 sm:grid-cols-2">
                <p>Price: <span class="font-semibold text-white">KSH {{ number_format((float) $sparePart->price) }}</span></p>
                <p>Category: <span class="font-semibold text-white">{{ $sparePart->category ?: 'Other' }}</span></p>
                <p>Condition: <span class="font-semibold text-white">{{ $sparePart->condition }}</span></p>
                <p>Location: <span class="font-semibold text-white">{{ $sparePart->location }}</span></p>
                <p>Seller: <span class="font-semibold text-white">{{ $userWhoPosted->name ?? 'Unknown' }}</span></p>
            </div>
        </article>

        <aside class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <h2 class="font-display text-lg font-semibold text-white">Seller</h2>
            <div class="flex items-center gap-3">
                <img src="{{ ($userWhoPosted && $userWhoPosted->avatar) ? asset('storage/photos/' . $userWhoPosted->avatar) : asset('images/default-avatar.png') }}" alt="Seller avatar" class="h-12 w-12 rounded-full object-cover">
                <div>
                    <p class="text-sm font-semibold text-white">{{ $userWhoPosted->name ?? 'Unknown' }}</p>
                    <p class="text-xs text-slate-400">Member since {{ optional($userWhoPosted->created_at)->diffForHumans() }}</p>
                </div>
            </div>

            @if($userWhoPosted && $userWhoPosted->phone_number)
                <a href="tel:{{ $userWhoPosted->phone_number }}" class="inline-flex w-full justify-center rounded-lg bg-amber-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-amber-200">Call Seller</a>
                <a href="https://wa.me/{{ $userWhoPosted->phone_number }}" class="inline-flex w-full justify-center rounded-lg border border-emerald-400/40 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-200 hover:bg-emerald-500/20">WhatsApp</a>
            @endif
        </aside>
    </section>
</main>

<div id="spare-lightbox" class="fixed inset-0 z-[90] hidden bg-slate-950/95 p-3 sm:p-6" aria-hidden="true">
    <div class="relative mx-auto flex h-full w-full max-w-7xl items-center justify-center">
        <button type="button" id="spare-lightbox-close" class="absolute right-0 top-0 rounded-lg border border-slate-600 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-100 hover:border-slate-300">Close</button>
        <button type="button" id="spare-lightbox-prev" class="absolute left-1 top-1/2 -translate-y-1/2 rounded-lg border border-slate-600 bg-slate-900/70 px-3 py-2 text-slate-100 hover:border-slate-300" aria-label="Previous image">&larr;</button>
        <img id="spare-lightbox-image" src="" alt="Spare part image fullscreen" class="max-h-full max-w-full rounded-lg object-contain">
        <button type="button" id="spare-lightbox-next" class="absolute right-1 top-1/2 -translate-y-1/2 rounded-lg border border-slate-600 bg-slate-900/70 px-3 py-2 text-slate-100 hover:border-slate-300" aria-label="Next image">&rarr;</button>
    </div>
</div>

<script>
    (function () {
        var main = document.getElementById('spare-main-photo');
        var mainTrigger = document.getElementById('spare-main-photo-trigger');
        var thumbs = Array.prototype.slice.call(document.querySelectorAll('.spare-thumb'));
        if (thumbs.length === 0) return;

        var lightbox = document.getElementById('spare-lightbox');
        var image = document.getElementById('spare-lightbox-image');
        var closeBtn = document.getElementById('spare-lightbox-close');
        var prevBtn = document.getElementById('spare-lightbox-prev');
        var nextBtn = document.getElementById('spare-lightbox-next');
        var images = thumbs.map(function (thumb) { return thumb.dataset.src; });
        var currentIndex = 0;

        function setActiveThumb(index) {
            thumbs.forEach(function (item, itemIndex) {
                item.classList.toggle('border-amber-300', itemIndex === index);
            });
        }

        function showImage(index) {
            currentIndex = (index + images.length) % images.length;
            if (main) {
                main.src = images[currentIndex];
            }
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
