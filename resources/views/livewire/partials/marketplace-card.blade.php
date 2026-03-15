@php
  $listing = $vehicle->listing;
  $make = optional(optional($vehicle->carmodel)->carmake)->make ?? 'Unknown';
  $model = optional($vehicle->carmodel)->model ?? 'Model';
  $year = $vehicle->year_of_build ?? '';
  $category = optional(optional($listing)->category)->category_name ?? ($vehicle->vehicle_type ?: 'Vehicle');
  $city = optional(optional($listing)->city)->city ?? 'Nairobi';
  $image = $vehicle->front_img ? asset('storage/photos/' . $vehicle->front_img) : 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=900&h=700&fit=crop';
  $href = $listing ? route('vehicle', [$listing->id, $vehicle->id]) : '#';
@endphp

<article class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15 group">
  <div class="relative overflow-hidden">
    <a href="{{ $href }}" class="block">
      <img src="{{ $image }}" alt="{{ $make }} {{ $model }}" loading="lazy" class="h-60 w-full object-cover transition duration-500 group-hover:scale-105">
    </a>
    <span class="absolute left-3 top-3 rounded-full border border-emerald-300/30 bg-emerald-300/15 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-200">
      {{ $badge ?? 'Live' }}
    </span>
    @auth
        <form action="{{ route('addtofavourites') }}" method="POST" class="absolute right-3 top-3">
            @csrf
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
            <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-950/80 text-rose-400 transition hover:bg-rose-400/20" aria-label="Save {{ $make }} {{ $model }} to favorites">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 21s-6-3.4-6-7a4 4 0 0 1 4-4c1.4 0 2.6.9 3 2.2A4 4 0 0 1 16 9a4 4 0 0 1 4 4c0 3.6-6 7-8 7z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
                </svg>
            </button>
        </form>
    @endauth
  </div>

  <div class="space-y-3 p-4">
    <a href="{{ $href }}">
      <h3 class="font-display truncate text-base font-semibold text-white">{{ trim($make . ' ' . $model . ' ' . $year) }}</h3>
    </a>

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
