@php
  $listing = $listing ?? $vehicle->listing ?? null;
  $cardHref = $listing ? route('vehicle', [$listing->id, $vehicle->id]) : '#';
  $badge = $badge ?? 'Live';
  $make = optional(optional($vehicle->carmodel)->carmake)->make;
  $model = optional($vehicle->carmodel)->model;
  $image = $vehicle->image_url ?? ($vehicle->front_img ? '/storage/photos/' . $vehicle->front_img : asset('images/no-image.png'));
@endphp

<a href="{{ $cardHref }}" class="group rounded-lg overflow-hidden bg-gray-900 border border-gray-800 shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-1 block">
  <div class="relative overflow-hidden aspect-[4/3]">
    <img src="{{ $image }}" alt="{{ trim($make . ' ' . $model) }}"
      class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400">
      {{ $badge }}
    </span>
  </div>

  <div class="p-4 space-y-3">
    <h3 class="font-semibold text-gray-100 text-base leading-tight truncate">
      {{ $make }} {{ $model }} {{ $vehicle->year_of_build }}
    </h3>

    <div class="flex items-center gap-2 text-xs">
      <span class="px-2 py-0.5 rounded-full bg-gray-800 text-gray-400">
        {{ optional(optional($listing)->category)->category_name ?? 'N/A' }}
      </span>
      <span class="text-gray-500">{{ optional(optional($listing)->city)->city ?? '' }}</span>
    </div>

    <div class="grid grid-cols-2 gap-2 text-xs text-gray-500">
      <span>{{ $vehicle->engine_size }}</span>
      <span>{{ $vehicle->transmission }}</span>
      <span>{{ number_format((float) $vehicle->mileage, 0, '.', ',') }} Km</span>
      <span>{{ $vehicle->fuel_type }}</span>
    </div>

    <div class="flex items-center justify-between pt-2 border-t border-gray-800">
      <span class="text-xs text-gray-500">For Sale</span>
      <span class="font-bold text-amber-400 text-lg">Ksh {{ number_format((float) $vehicle->price, 0, '.', ',') }}</span>
    </div>
  </div>
</a>
