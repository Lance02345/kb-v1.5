@extends('layouts.kingsbridge')
@section('title', 'Kingsbridge Motors | Kenya Auto Marketplace')
@section('content')
@php
  $featuredPairs = [];
  foreach ($listings as $listingItem) {
      if ((int) $listingItem->package_id !== 2) {
          continue;
      }
      foreach ($vehicles as $vehicleItem) {
          if ((int) $vehicleItem->listing_id === (int) $listingItem->id) {
              $featuredPairs[] = ['listing' => $listingItem, 'vehicle' => $vehicleItem];
          }
      }
  }
@endphp

<section class="hero-area bg-1 overly landing-hero">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content-block landing-hero-content">
          <p class="landing-kicker">Kenya's automotive marketplace</p>
          <h1>Buy, sell, and scale your automotive business</h1>
          <p class="landing-hero-subtitle">A single platform for verified listings, vehicle parts, and events built for serious buyers and sellers.</p>
          <div id="autotext" class="landing-autotext">
            <div id="text"></div><div id="cursor"></div>
          </div>
          <div class="landing-hero-actions">
            <a class="btn btn-main" href="{{ Auth::check() ? route('user.new_listing') : route('login') }}">Post a Listing</a>
            <a class="btn btn-outline-main" href="{{ route('vehicleslist') }}">Browse Vehicles</a>
          </div>
          <div class="landing-hero-stats">
            <span><b>{{ count($vehicles) }}</b> Vehicles</span>
            <span><b>{{ count($carevents) }}</b> Events</span>
            <span><b>{{ count($listings) }}</b> Listings</span>
          </div>
          <div class="short-popular-category-list">
            <h2>Start with what you need</h2>
            <ul class="list-inline">
              <li class="list-inline-item"><a href="{{ route('vehicleslist') }}">Vehicles</a></li>
              <li class="list-inline-item"><a href="{{ route('spareparts') }}">Vehicle Parts</a></li>
              <li class="list-inline-item"><a href="{{ route('carhire') }}">Car Hire</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="landing-v2-valuebar">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-2 mb-md-0">
        <div class="landing-v2-value-item">
          <h4>Serious Buyers</h4>
          <p>High-intent demand from users actively searching to buy.</p>
        </div>
      </div>
      <div class="col-md-4 mb-2 mb-md-0">
        <div class="landing-v2-value-item">
          <h4>Premium Exposure</h4>
          <p>Promoted inventory options for faster visibility and conversion.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="landing-v2-value-item">
          <h4>All-In-One Flow</h4>
          <p>Vehicles, parts, events, and garages managed from one platform.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="landing-section landing-v2-featured">
  <div class="container">
    <div class="landing-section-head text-center">
      <h2>Featured Inventory</h2>
      <p>Top-tier listings selected for premium visibility across the marketplace.</p>
    </div>

    @if (count($featuredPairs) === 0)
      <div class="landing-empty-state text-center">
        <h4 class="mb-2">No featured inventory yet</h4>
        <p>Featured vehicles will appear here as soon as they are promoted.</p>
      </div>
    @else
      <div id="featuredCarousel" class="carousel slide landing-carousel" data-ride="carousel">
        <div class="carousel-inner">
          @for ($i = 0; $i < count($featuredPairs); $i += 3)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
              <div class="row mt-10">
                @for ($j = $i; $j < min($i + 3, count($featuredPairs)); $j++)
                  <div class="col-sm-6 col-md-4 col-lg-4 mb-3 d-flex">
                    @include('partials.vehicle-card', [
                      'vehicle' => $featuredPairs[$j]['vehicle'],
                      'listing' => $featuredPairs[$j]['listing'],
                      'badge' => 'Featured'
                    ])
                  </div>
                @endfor
              </div>
            </div>
          @endfor
        </div>

        <a class="carousel-control-prev" href="#featuredCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#featuredCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    @endif
  </div>
</section>

<livewire:landing-vehicle-browser />

<section class="landing-section landing-v2-events">
  <div class="container">
    <div class="d-flex flex-wrap align-items-end justify-content-between landing-v2-section-inline-head">
      <div>
        <h2>Upcoming Car Events</h2>
        <p>Connect with communities, clubs, and automotive brands near you.</p>
      </div>
      <a class="btn btn-outline-main mt-2 mt-md-0" href="{{ route('carevent') }}">See all events</a>
    </div>
    <div class="row">
      @forelse($carevents as $carevent)
        <div class="col-md-6 col-lg-4 mb-3 d-flex">
          <article class="landing-v2-event-tile">
            <img src="/storage/photos/{{ $carevent->event_image }}" alt="{{ $carevent->event_title }}">
            <div class="landing-v2-event-body">
              <h4>{{ $carevent->event_title }}</h4>
              <ul>
                <li><b>Location:</b> {{ $carevent->event_location }}</li>
                <li><b>Date:</b> {{ $carevent->event_date }}</li>
                <li><b>Time:</b> {{ $carevent->event_time }}</li>
                <li><b>Organizer:</b> {{ $carevent->organizer }}</li>
              </ul>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12">
          <div class="landing-empty-state text-center">
            <h4 class="mb-2">No events yet</h4>
            <p>Check back soon for upcoming meets and shows.</p>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>

<section class="landing-section landing-v2-why">
  <div class="container">
    <div class="landing-section-head text-center">
      <h2>Why Sellers And Buyers Choose Kingsbridge</h2>
      <p>A platform designed to help you discover, list, promote, and close better.</p>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-3 mb-3">
        <article class="landing-v2-point-card">
          <h4>Verified Visibility</h4>
          <p>Get your inventory in front of buyers actively ready to transact.</p>
        </article>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <article class="landing-v2-point-card">
          <h4>Flexible Packages</h4>
          <p>Choose listing and promotion levels that match your business goals.</p>
        </article>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <article class="landing-v2-point-card">
          <h4>Faster Lead Flow</h4>
          <p>Clean listings, structured details, and clear actions increase response rates.</p>
        </article>
      </div>
      <div class="col-md-6 col-lg-3 mb-3">
        <article class="landing-v2-point-card">
          <h4>Ecosystem Reach</h4>
          <p>Sell vehicles, offer parts, promote events, and support garage services together.</p>
        </article>
      </div>
    </div>
  </div>
</section>

<section class="landing-v2-final-cta">
  <div class="container">
    <div class="landing-v2-final-shell">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h2>Ready To Move More Inventory?</h2>
          <p>Launch your next listing in minutes and reach motivated buyers across Kenya.</p>
        </div>
        <div class="col-lg-4 text-lg-right mt-3 mt-lg-0">
          <a class="btn btn-main" href="{{ Auth::check() ? route('user.new_listing') : route('login') }}">Start Selling</a>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  $(function () {
    var content = [
      'Sell smarter with premium listing tools.',
      'Reach serious buyers across Kenya.',
      'Promote vehicles, parts, and events in one place.'
    ];

    var part = 0;
    var partIndex = 0;
    var intervalVal;
    var element = document.querySelector('#text');
    var cursor = document.querySelector('#cursor');

    function type() {
      if (!element || !cursor) {
        return;
      }

      var text = content[part].substring(0, partIndex + 1);
      element.innerHTML = text;
      partIndex += 1;

      if (text === content[part]) {
        cursor.style.display = 'none';
        clearInterval(intervalVal);
        setTimeout(function () {
          intervalVal = setInterval(remove, 55);
        }, 900);
      }
    }

    function remove() {
      var text = content[part].substring(0, partIndex - 1);
      element.innerHTML = text;
      partIndex -= 1;

      if (text === '') {
        clearInterval(intervalVal);
        part = part === content.length - 1 ? 0 : part + 1;
        partIndex = 0;
        setTimeout(function () {
          cursor.style.display = 'inline-block';
          intervalVal = setInterval(type, 95);
        }, 200);
      }
    }

    intervalVal = setInterval(type, 95);
  });
</script>
@endpush

@endsection
