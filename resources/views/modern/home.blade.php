@extends('layouts.modern-app')

@section('title', 'Kingsbridge Motors - Home')
@section('description', 'Buy, sell, and discover vehicles across Kenya with a modern automotive marketplace.')

@section('content')
@include('modern._nav')

<section class="relative h-[420px] overflow-hidden sm:h-[500px]">
    <img
        src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920&h=900&fit=crop"
        alt="Luxury cars on a city road"
        class="absolute inset-0 h-full w-full object-cover"
    >
    <div class="absolute inset-0 bg-gradient-to-br from-black/45 via-[#0b1020]/70 to-[#0b1020]"></div>

    <div class="relative z-10 flex h-full w-full items-end px-4 pb-12 sm:px-6 lg:px-10">
        <div class="max-w-3xl">
            <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">Modern automotive hub</p>
            <h1 class="font-display text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">Buy Smarter. Sell Faster. Drive Better.</h1>
            <p class="mt-4 text-sm text-slate-200 sm:text-base">Explore verified listings, discover spare parts, and connect with Kenya's vehicle community in one place.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('marketplace.index') }}" class="rounded-lg bg-amber-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Browse Marketplace</a>
                <a href="{{ Auth::check() ? route('user.new_listing') : route('login') }}" class="rounded-lg border border-slate-500 bg-slate-950/40 px-5 py-2.5 text-sm font-semibold text-white hover:border-slate-300">Create Listing</a>
            </div>
        </div>
    </div>
</section>

	<main class="w-full space-y-12 px-4 py-10 sm:px-6 lg:px-10">
    <section class="space-y-4">
        <h2 class="font-display text-2xl font-semibold text-white">Our Services</h2>
        <div class="grid gap-3 sm:grid-cols-4">
            <a href="{{ route('marketplace.index') }}" class="rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-center text-sm font-semibold text-white hover:border-amber-300 hover:text-amber-200">Cars on Sale</a>
            <a href="{{ route('spareparts') }}" class="rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-center text-sm font-semibold text-white hover:border-amber-300 hover:text-amber-200">Spare Parts</a>
            <a href="{{ route('carevent') }}" class="rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-center text-sm font-semibold text-white hover:border-amber-300 hover:text-amber-200">Events</a>
            <a href="{{ route('garages.index') }}" class="rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-center text-sm font-semibold text-white hover:border-amber-300 hover:text-amber-200">Garages</a>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-3">
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Live Listings</p><p class="mt-2 font-display text-3xl font-bold text-white">{{ ($latestVehicles ?? collect())->count() }}</p></article>
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Featured Cars</p><p class="mt-2 font-display text-3xl font-bold text-white">{{ ($featuredVehicles ?? collect())->count() }}</p></article>
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5"><p class="text-xs uppercase tracking-[0.2em] text-slate-400">Upcoming Events</p><p class="mt-2 font-display text-3xl font-bold text-white">{{ ($carevents ?? collect())->count() }}</p></article>
    </section>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-2xl font-semibold text-white">Trending Ads</h2>
            <a href="{{ route('marketplace.index') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">View all</a>
        </div>
        @if(($featuredVehicles ?? collect())->count())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($featuredVehicles->take(6) as $vehicle)
                    @include('livewire.partials.marketplace-card', ['vehicle' => $vehicle, 'badge' => 'Featured'])
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-sm text-slate-400">No featured listings yet.</div>
        @endif
    </section>

    <section class="space-y-4">
        <h2 class="font-display text-2xl font-semibold text-white">Latest Arrivals</h2>
        @if(($latestVehicles ?? collect())->count())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($latestVehicles->take(6) as $vehicle)
                    @include('livewire.partials.marketplace-card', ['vehicle' => $vehicle, 'badge' => 'Live'])
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-sm text-slate-400">No listings found.</div>
        @endif
    </section>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-2xl font-semibold text-white">Spare Parts</h2>
            <a href="{{ route('spareparts') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">See all parts</a>
        </div>
        @if(($latestSpareParts ?? collect())->count())
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach($latestSpareParts as $sparePart)
                    <article class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15 transition duration-300 hover:-translate-y-1 hover:border-amber-300/40">
                        <a href="{{ route('sparepart', $sparePart->id) }}">
                            <img src="{{ $sparePart->front_img ? asset('storage/photos/' . $sparePart->front_img) : asset('images/land1.jpg') }}" alt="{{ $sparePart->item_name }}" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                        </a>
                        <div class="space-y-2 p-4">
                            <h3 class="font-display text-lg font-semibold text-white">
                                <a href="{{ route('sparepart', $sparePart->id) }}" class="hover:text-amber-200">{{ $sparePart->make }} - {{ $sparePart->item_name }}</a>
                            </h3>
                            <p class="text-xs text-slate-400">{{ $sparePart->condition }} · {{ $sparePart->location }}</p>
                            <span class="inline-flex rounded-full border border-amber-300/30 bg-amber-300/10 px-2.5 py-1 text-xs font-semibold text-amber-200">Ksh {{ number_format((float) $sparePart->price) }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-sm text-slate-400">No spare parts yet.</div>
        @endif
    </section>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-2xl font-semibold text-white">Top Garages</h2>
            <a href="{{ route('garages.index') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">See all garages</a>
        </div>
        @if(($latestGarages ?? collect())->count())
            <div class="relative">
                <button type="button" data-garage-carousel-prev class="absolute left-0 top-1/2 z-10 hidden -translate-y-1/2 rounded-full border border-slate-600 bg-slate-950/80 px-3 py-2 text-xs font-semibold text-white shadow-lg backdrop-blur md:block">&larr;</button>
                <div id="home-garage-carousel" class="flex snap-x snap-mandatory gap-4 overflow-x-auto pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    @foreach($latestGarages as $garage)
                        <article class="group min-w-[280px] snap-start overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15 transition duration-300 hover:-translate-y-1 hover:border-amber-300/40 sm:min-w-[320px]">
                            <a href="{{ route('garage.show', $garage->id) }}" class="block">
                                <img src="{{ !empty($garage->front_img) ? asset('storage/' . ltrim($garage->front_img, '/')) : asset('images/land1.jpg') }}" alt="{{ $garage->garage_title }}" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                            </a>
                            <div class="space-y-2 p-4">
                                <h3 class="font-display text-lg font-semibold text-white">
                                    <a href="{{ route('garage.show', $garage->id) }}" class="hover:text-amber-200">{{ $garage->garage_title }}</a>
                                </h3>
                                <p class="text-xs text-slate-400">{{ $garage->garage_location }}</p>
                                <p class="line-clamp-2 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags($garage->garage_description), 120) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
                <button type="button" data-garage-carousel-next class="absolute right-0 top-1/2 z-10 hidden -translate-y-1/2 rounded-full border border-slate-600 bg-slate-950/80 px-3 py-2 text-xs font-semibold text-white shadow-lg backdrop-blur md:block">&rarr;</button>
            </div>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-sm text-slate-400">No garages yet.</div>
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
                        <a href="{{ route('events.show', ['id' => $event->id]) }}" class="block">
                            <img src="{{ $event->event_image ? asset('storage/photos/' . $event->event_image) : asset('images/land1.jpg') }}" alt="{{ $event->event_title }}" class="aspect-[16/10] w-full object-cover">
                        </a>
                        <div class="space-y-2 p-4">
                            <h3 class="font-display text-lg font-semibold text-white"><a href="{{ route('events.show', ['id' => $event->id]) }}" class="hover:text-amber-200">{{ $event->event_title }}</a></h3>
                            <p class="text-xs text-slate-400">{{ $event->event_location }} · {{ $event->event_date }} · {{ $event->event_time }}</p>
                            <p class="text-xs text-slate-500">Contact: {{ $event->user?->phone_number ?: 'Not provided' }}</p>
                            <span class="inline-flex rounded-full border border-amber-300/30 bg-amber-300/10 px-2.5 py-1 text-xs font-semibold text-amber-200">Ticket Ksh {{ number_format((float) $event->ticket_price) }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-sm text-slate-400">No events yet.</div>
        @endif
    </section>

    <section class="space-y-4">
        <h2 class="font-display text-2xl font-semibold text-white">Why Us</h2>
        <div class="grid gap-4 md:grid-cols-3">
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <h3 class="font-display text-lg font-semibold text-white">Verified Listings</h3>
                <p class="mt-2 text-sm text-slate-300">Every listing goes through moderation so buyers browse with confidence.</p>
            </article>
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <h3 class="font-display text-lg font-semibold text-white">Trusted Seller Tools</h3>
                <p class="mt-2 text-sm text-slate-300">Simple ad creation, package boosts, and invoice tracking in one dashboard.</p>
            </article>
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <h3 class="font-display text-lg font-semibold text-white">Local Market Reach</h3>
                <p class="mt-2 text-sm text-slate-300">Connect with active buyers, sellers, and event communities across Kenya.</p>
            </article>
        </div>
    </section>

    <section class="space-y-4">
        <h2 class="font-display text-2xl font-semibold text-white">Our Partners</h2>
        <div class="grid gap-4 rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:grid-cols-2">
            <div class="flex items-center justify-center rounded-xl border border-slate-700/70 bg-slate-950/40 p-5">
                <img src="{{ asset('images/GarageGallery Logo.jpg') }}" alt="GarageGallery" class="max-h-24 w-auto rounded-md object-contain">
            </div>
            <div class="flex items-center justify-center rounded-xl border border-slate-700/70 bg-slate-950/40 p-5">
                <img src="{{ asset('images/nexraAfrica.jpg') }}" alt="NexraAfrica" class="max-h-24 w-auto rounded-md object-contain" onerror="this.onerror=null;this.src='{{ asset('images/nexuraAfrica.jpg') }}';">
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-amber-300/30 bg-amber-300/10 p-6 sm:p-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="font-display text-2xl font-semibold text-white">Ready to post your first ad?</h3>
                <p class="mt-1 text-sm text-slate-200">Create a listing in minutes and reach buyers across the country.</p>
            </div>
            <a href="{{ Auth::check() ? route('user.new_listing') : route('register') }}" class="rounded-lg bg-amber-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Get started</a>
        </div>
    </section>
</main>
<script>
    (function () {
        var track = document.getElementById('home-garage-carousel');
        if (!track) return;

        var prevBtn = document.querySelector('[data-garage-carousel-prev]');
        var nextBtn = document.querySelector('[data-garage-carousel-next]');
        var step = 340;

        function move(direction) {
            track.scrollBy({ left: direction * step, behavior: 'smooth' });
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { move(-1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { move(1); });
    })();
</script>
@endsection
