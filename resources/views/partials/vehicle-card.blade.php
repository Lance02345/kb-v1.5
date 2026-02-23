@php
  $cardListing = $listing ?? $vehicle->listing ?? null;
  $cardHref = $cardListing ? route('vehicle', [$cardListing->id, $vehicle->id]) : '#';
  $badge = $badge ?? 'Live';
  $make = optional(optional($vehicle->carmodel)->carmake)->make;
  $model = optional($vehicle->carmodel)->model;
  $city = optional($cardListing->city)->city;
  $category = optional($cardListing->category)->category_name;
@endphp

<article class="landing-vehicle-card landing-neo-card h-100 w-100">
  <a class="landing-neo-card-media" href="{{ $cardHref }}">
    <img class="landing-neo-card-image" src="/storage/photos/{{ $vehicle->front_img }}" alt="{{ trim($make . ' ' . $model) ?: 'Vehicle image' }}">
    <span class="landing-neo-card-badge">{{ $badge }}</span>
  </a>

  <div class="landing-neo-card-body d-flex flex-column">
    <h4 class="landing-neo-card-title">
      <a href="{{ $cardHref }}">{{ $make }} {{ $model }} {{ $vehicle->year_of_build }}</a>
    </h4>

    <div class="landing-neo-meta">
      @if($category)
        <span class="landing-neo-pill">{{ $category }}</span>
      @endif
      @if($city)
        <span class="landing-neo-city">{{ $city }}</span>
      @endif
    </div>

    <ul class="landing-neo-specs">
      <li>{{ $vehicle->engine_size }}</li>
      <li>{{ $vehicle->transmission }}</li>
      <li>{{ number_format((float) $vehicle->mileage, 0, '.', ',') }} Km</li>
      <li>{{ $vehicle->fuel_type }}</li>
    </ul>

    <div class="landing-neo-price mt-auto">
      <span>For Sale</span>
      <strong>Ksh {{ number_format((float) $vehicle->price, 0, '.', ',') }}</strong>
    </div>
  </div>
</article>
