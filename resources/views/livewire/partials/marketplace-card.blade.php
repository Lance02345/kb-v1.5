@php
    $listing = $vehicle->listing;
    $make = optional(optional($vehicle->carmodel)->carmake)->make ?? 'Unknown';
    $model = optional($vehicle->carmodel)->model ?? 'Model';
    $year = $vehicle->year_of_build ?? '';
    $category = optional(optional($listing)->category)->category_name ?? ($vehicle->vehicle_type ?: 'Vehicle');
    $city = optional(optional($listing)->city)->city ?? 'Nairobi';
    $image = $vehicle->front_img ? asset('storage/photos/' . $vehicle->front_img) : 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=900&h=700&fit=crop';
    $href = $listing ? route('vehicle', [$listing->id, $vehicle->id]) : '#';
    $seller = optional($listing)->user;
    $sellerProfileUrl = $seller ? route('seller.show', $seller->id) : null;
    $trustBadges = [];
    if ($seller?->isVerified) {
        $trustBadges[] = 'Verified seller';
    }
    if ($seller?->email_verified_at) {
        $trustBadges[] = 'Email verified';
    }
    if ($seller?->phone_verified_at) {
        $trustBadges[] = 'Phone verified';
    }
    $thumbnails = $vehicle->vehiclephotos->take(3);
    $compareLabel = trim($make . ' ' . $model . ' ' . $year);
@endphp

<article class="relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15 group">
    <a href="{{ $href }}" class="absolute inset-0 z-10 rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-300" aria-label="Open {{ $compareLabel }} listing"></a>

    <div class="relative overflow-hidden">
        <img src="{{ $image }}" alt="{{ $make }} {{ $model }}" loading="lazy" class="h-60 w-full object-cover transition duration-500 group-hover:scale-105">
        <span class="absolute left-3 top-3 rounded-full border border-emerald-300/30 bg-emerald-300/15 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-200">
            {{ $badge ?? 'Live' }}
        </span>
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute right-3 top-3 flex gap-2">
                @auth
                    <form action="{{ route('addtofavourites') }}" method="POST" class="pointer-events-auto relative z-20">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-950/80 text-rose-400 transition hover:bg-rose-400/20" aria-label="Save {{ $make }} {{ $model }} to favorites">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 21s-6-3.4-6-7a4 4 0 0 1 4-4c1.4 0 2.6.9 3 2.2A4 4 0 0 1 16 9a4 4 0 0 1 4 4c0 3.6-6 7-8 7z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
                            </svg>
                        </button>
                    </form>
                @endauth
                <button type="button" data-compare-target
                        data-vehicle-id="{{ $vehicle->id }}"
                        data-vehicle-label="{{ e($compareLabel) }}"
                        data-vehicle-url="{{ $href }}"
                        data-vehicle-image="{{ $image }}"
                        class="pointer-events-auto relative z-20 rounded-full border border-slate-700 bg-slate-950/80 px-3 py-1.5 text-[11px] font-semibold text-slate-200 transition hover:border-amber-300 hover:text-white" aria-pressed="false">
                    Compare
                </button>
            </div>
        </div>
    </div>

    @if($thumbnails->count())
        <div class="grid grid-cols-3 gap-1 bg-slate-950/60 px-4 pb-3 pt-2">
            @foreach($thumbnails as $thumb)
                <img src="{{ asset('storage/photos/' . $thumb->photo) }}" alt="Additional photo" loading="lazy" class="h-14 w-full rounded-xl object-cover">
            @endforeach
        </div>
    @endif

    <div class="relative z-20 space-y-3 p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1">
                <h3 class="font-display truncate text-base font-semibold text-white">{{ trim($make . ' ' . $model . ' ' . $year) }}</h3>
            </div>
        </div>

        <div class="flex items-center gap-2 text-xs">
            <span class="rounded-full bg-slate-800 px-2 py-1 text-slate-300">{{ $category }}</span>
            <span class="inline-flex items-center gap-1 text-slate-400">
                <svg class="h-3.5 w-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z"></path>
                    <circle cx="12" cy="10" r="2.5"></circle>
                </svg>
                {{ $city }}
            </span>
        </div>

        @if(count($trustBadges))
            <div class="flex flex-wrap gap-2 text-[11px]">
                @foreach($trustBadges as $trust)
                    <span class="rounded-full border border-emerald-500/40 bg-emerald-500/10 px-2 py-1 text-emerald-200">{{ $trust }}</span>
                @endforeach
            </div>
        @endif

        @if($sellerProfileUrl)
            <div class="text-xs text-slate-400">
                Seller:
                <a href="{{ $sellerProfileUrl }}" class="font-medium text-slate-200 hover:text-amber-200">
                    {{ $seller->name ?? 'Seller' }}
                </a>
            </div>
        @endif

        <dl class="grid grid-cols-2 gap-2 text-xs text-slate-400">
            <div>{{ $vehicle->engine_size ?: '-' }}</div>
            <div>{{ $vehicle->transmission ?: '-' }}</div>
            <div>{{ number_format((float) $vehicle->mileage) }} Km</div>
            <div>{{ $vehicle->fuel_type ?: '-' }}</div>
        </dl>

        <div class="flex items-center justify-between border-t border-slate-800 pt-3">
            <span class="text-xs text-slate-500">For Sale</span>
            <span class="font-display text-lg font-bold text-amber-300">{{ format_currency($vehicle->price) }}</span>
        </div>
    </div>
</article>
