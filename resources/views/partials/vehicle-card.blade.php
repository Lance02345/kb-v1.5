@php
  $cardListing = $listing ?? $vehicle->listing ?? null;
  $cardHref = $cardListing ? route('vehicle', [$cardListing->id, $vehicle->id]) : '#';
  $badge = $badge ?? 'Live';
@endphp

<article class="landing-vehicle-card h-100">
  <div class="landing-card-shell h-100">
    <a class="landing-card-media" href="{{ $cardHref }}">
      <img class="landing-card-image" src="/storage/photos/{{ $vehicle->front_img }}" alt="{{ $vehicle->title ?? 'Vehicle image' }}">
      <span class="landing-card-badge">{{ $badge }}</span>
    </a>
    <div class="landing-card-body">
      <h4 class="landing-card-title">
        <a href="{{ $cardHref }}">{{ optional(optional($vehicle->carmodel)->carmake)->make }} {{ optional($vehicle->carmodel)->model }} {{ $vehicle->year_of_build }}</a>
      </h4>
      <ul class="landing-meta">
        <li><a href="{{ $cardHref }}">{{ optional($cardListing->category)->category_name }}</a></li>
        <li><a href="{{ $cardHref }}">{{ optional($cardListing->city)->city }}</a></li>
      </ul>
      <ul class="landing-spec-list">
        <li><b>Engine</b><span>{{ $vehicle->engine_size }}</span></li>
        <li><b>Trans</b><span>{{ $vehicle->transmission }}</span></li>
        <li><b>Miles</b><span>{{ number_format((float) $vehicle->mileage, 0, '.', ',') }} Km</span></li>
        <li><b>Fuel</b><span>{{ $vehicle->fuel_type }}</span></li>
      </ul>
      <div class="property-price landing-property-price">
        <p class="badge-sale">For Sale</p>
        <p class="price">Ksh {{ number_format((float) $vehicle->price, 0, '.', ',') }}</p>
      </div>
    </div>
  </div>
</article>
