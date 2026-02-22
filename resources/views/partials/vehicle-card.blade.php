@php
  $cardListing = $listing ?? $vehicle->listing ?? null;
  $cardHref = $cardListing ? route('vehicle', [$cardListing->id, $vehicle->id]) : '#';
  $badge = $badge ?? 'Live';
@endphp

<article class="landing-vehicle-card h-100">
  <div class="product-item bg-light landing-product-item h-100">
    <div class="card h-100">
      <div class="thumb-content">
        <a class="landing-card-media" href="{{ $cardHref }}">
          <img class="card-img-top category-img-fluid landing-card-image" src="/storage/photos/{{ $vehicle->front_img }}" alt="{{ $vehicle->title ?? 'Vehicle image' }}">
          <span class="landing-card-badge">{{ $badge }}</span>
        </a>
      </div>
      <div class="card-body d-flex flex-column">
        <h4 class="card-title landing-card-title">
          <a href="{{ $cardHref }}">{{ optional(optional($vehicle->carmodel)->carmake)->make }} {{ optional($vehicle->carmodel)->model }} {{ $vehicle->year_of_build }}</a>
        </h4>
        <ul class="list-inline product-meta landing-meta">
          <li class="list-inline-item">
            <a href="{{ $cardHref }}"><i class="fa fa-folder-open-o"></i>{{ optional($cardListing->category)->category_name }}</a>
          </li>
          <li class="list-inline-item">
            <a href="{{ $cardHref }}"><i class="fa fa-location-arrow"></i>{{ optional($cardListing->city)->city }}</a>
          </li>
        </ul>
        <ul class="styled-list landing-spec-list">
          <li><a href="{{ $cardHref }}"><i class="fa fa-dot-circle-o"></i>{{ $vehicle->engine_size }}</a></li>
          <li><a href="{{ $cardHref }}"><i class="fa fa-dot-circle-o"></i>{{ $vehicle->transmission }}</a></li>
          <li><a href="{{ $cardHref }}"><i class="fa fa-dot-circle-o"></i>{{ number_format((float) $vehicle->mileage, 0, '.', ',') }} Km</a></li>
          <li><a href="{{ $cardHref }}"><i class="fa fa-dot-circle-o"></i>{{ $vehicle->fuel_type }}</a></li>
        </ul>
        <div class="property-price landing-property-price mt-auto">
          <p class="badge-sale">For Sale</p>
          <p class="price">Ksh {{ number_format((float) $vehicle->price, 0, '.', ',') }}</p>
        </div>
      </div>
    </div>
  </div>
</article>
