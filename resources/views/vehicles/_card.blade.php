@php
    $make = optional(optional($vehicle->carmodel)->carmake)->make ?? 'Unknown';
    $model = optional($vehicle->carmodel)->model ?? 'Model';
    $year = $vehicle->year_of_build;
    $city = optional(optional($vehicle->listing)->city)->city ?? 'N/A';
    $category = optional(optional($vehicle->listing)->category)->category_name ?? ($vehicle->vehicle_type ?: 'Vehicle');
    $badge = optional($vehicle->listing)->ads_featured ? 'Featured' : 'Live';
    $image = $vehicle->front_img ? asset('storage/photos/' . $vehicle->front_img) : 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&h=600&fit=crop';
    $href = $vehicle->listing ? route('vehicle', [$vehicle->listing->id, $vehicle->id]) : '#';
@endphp

<div class="group relative rounded-lg overflow-hidden bg-[#161a22] shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-800">
    <a href="{{ $href }}" class="absolute inset-0 z-10 rounded-lg" aria-label="Open {{ $make }} {{ $model }} {{ $year }} listing"></a>
    <div class="relative overflow-hidden aspect-[4/3]">
        <img src="{{ $image }}" alt="{{ $make }} {{ $model }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400">
            {{ $badge }}
        </span>
    </div>
    <div class="relative z-20 p-4 space-y-3">
        <h3 class="font-semibold text-gray-100 text-base leading-tight truncate" style="font-family: 'Space Grotesk', sans-serif;">
            {{ $make }} {{ $model }} {{ $year }}
        </h3>
        <div class="flex items-center gap-2 text-xs">
            <span class="px-2 py-0.5 rounded-full bg-gray-800 text-gray-300">{{ $category }}</span>
            <span class="flex items-center gap-1 text-gray-500">
                <svg class="w-3 h-3 mk-icon-sm" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $city }}
            </span>
        </div>
        <div class="grid grid-cols-2 gap-2 text-xs text-gray-500">
            <span class="flex items-center gap-1.5">{{ $vehicle->engine_size ?: '-' }}</span>
            <span class="flex items-center gap-1.5">{{ $vehicle->transmission ?: '-' }}</span>
            <span class="flex items-center gap-1.5">{{ number_format((float) $vehicle->mileage) }} Km</span>
            <span class="flex items-center gap-1.5">{{ $vehicle->fuel_type ?: '-' }}</span>
        </div>
        <div class="flex items-center justify-between pt-2 border-t border-gray-800">
            <span class="text-xs text-gray-500">For Sale</span>
            <span class="font-bold text-amber-400 text-lg" style="font-family: 'Space Grotesk', sans-serif;">Ksh {{ number_format((float) $vehicle->price) }}</span>
        </div>
    </div>
</div>
