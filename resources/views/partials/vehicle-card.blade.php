@php
  $listing = $listing ?? $vehicle->listing ?? null;
  $cardHref = $listing ? route('vehicle', [$listing->id, $vehicle->id]) : '#';
  $badge = $badge ?? 'Live';
  $make = optional(optional($vehicle->carmodel)->carmake)->make;
  $model = optional($vehicle->carmodel)->model;
  $image = $vehicle->image_url ?? ($vehicle->front_img ? '/storage/photos/' . $vehicle->front_img : asset('images/car3.jpg'));
@endphp

<a href="{{ $cardHref }}" class="df-card">
  <div class="df-card-media">
    <img src="{{ $image }}" alt="{{ trim($make . ' ' . $model) ?: 'Vehicle image' }}" loading="lazy" />
    <span class="df-card-badge">{{ $badge }}</span>
  </div>

  <div class="df-card-body">
    <h3>{{ $make }} {{ $model }} {{ $vehicle->year_of_build }}</h3>

    <div class="df-card-meta">
      <span class="df-meta-pill">{{ optional(optional($listing)->category)->category_name ?? 'N/A' }}</span>
      <span class="df-meta-city">{{ optional(optional($listing)->city)->city ?? '' }}</span>
    </div>

    <div class="df-card-specs">
      <span>{{ $vehicle->engine_size }}</span>
      <span>{{ $vehicle->transmission }}</span>
      <span>{{ number_format((float) $vehicle->mileage, 0, '.', ',') }} Km</span>
      <span>{{ $vehicle->fuel_type }}</span>
    </div>

    <div class="df-card-price">
      <span>For Sale</span>
      <strong>Ksh {{ number_format((float) $vehicle->price, 0, '.', ',') }}</strong>
    </div>
  </div>
</a>
