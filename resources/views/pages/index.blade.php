@extends('layouts.kingsbridge')
@section('content')

<section class="hero-area bg-1 overly landing-hero">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content-block landing-hero-content">
          <p class="landing-kicker">Kenya's automotive marketplace</p>
          <h1>Buy, sell, and scale your automotive business</h1>
          <div id="autotext" class="landing-autotext">
            <div id="text"></div><div id="cursor"></div>
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

<section class="landing-section landing-trending">
  <div class="container">
    <div class="landing-section-head text-center">
      <h2>Trending Ads</h2>
      <p>Premium listings getting the most attention right now.</p>
    </div>

    <div id="featuredCarousel" class="carousel slide landing-carousel" data-ride="carousel">
      <div class="carousel-inner">
        @php $slideNumber = 0; @endphp
        @foreach ($listings as $listing)
          @if ($listing->package_id == 2)
            @foreach ($vehicles as $vehicle)
              @if ($listing->id == $vehicle->listing_id)
                @if ($slideNumber % 3 == 0)
                  <div class="carousel-item{{ $slideNumber === 0 ? ' active' : '' }}">
                    <div class="row mt-10">
                @endif

                <div class="col-sm-6 col-md-4 col-lg-4 mb-3">
                  <article class="landing-vehicle-card">
                    <div class="landing-card-shell">
                      <a class="landing-card-media" href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}">
                        <img class="landing-card-image" src="/storage/photos/{{ $vehicle->front_img }}" alt="{{ $vehicle->title ?? 'Vehicle image' }}">
                        <span class="landing-card-badge">Featured</span>
                      </a>
                      <div class="landing-card-body">
                        <h4 class="landing-card-title">
                          <a href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}">{{ $vehicle->carmodel->carmake->make }} {{ $vehicle->carmodel->model }} {{ $vehicle->year_of_build }}</a>
                        </h4>
                        <ul class="landing-meta">
                          <li><a href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}">{{ $listing->category->category_name }}</a></li>
                          <li><a href="#">{{ $listing->city->city }}</a></li>
                        </ul>
                        <ul class="landing-spec-list">
                          <li><b>Engine</b><span>{{ $vehicle->engine_size }}</span></li>
                          <li><b>Trans</b><span>{{ $vehicle->transmission }}</span></li>
                          <li><b>Miles</b><span>{{ number_format($vehicle->mileage, 0, '.', ',') }} Km</span></li>
                          <li><b>Fuel</b><span>{{ $vehicle->fuel_type }}</span></li>
                        </ul>
                        <div class="landing-price-row">
                          <p class="landing-sale-tag">For Sale</p>
                          <p class="landing-price-value">Ksh {{ number_format((float) $vehicle->price) }}</p>
                        </div>
                      </div>
                    </div>
                  </article>
                </div>

                @php $slideNumber++; @endphp
                @if ($slideNumber % 3 == 0)
                    </div>
                  </div>
                @endif
              @endif
            @endforeach
          @endif
        @endforeach

        @if ($slideNumber > 0 && $slideNumber % 3 != 0)
            </div>
          </div>
        @endif
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
  </div>
</section>

<livewire:landing-vehicle-browser />

<section class="landing-section landing-events">
  <div class="container">
    <div class="landing-section-head text-center">
      <h2>Car Events</h2>
      <p>Shows, meetups, and experiences curated for enthusiasts.</p>
    </div>

    @php
      $eventCount = count($carevents);
      $eventSlideCount = $eventCount > 0 ? (int) ceil($eventCount / 3) : 0;
    @endphp

    @if ($eventCount === 0)
      <div class="landing-empty-state text-center">
        <h4>No events yet</h4>
        <p>Check back soon for upcoming car events.</p>
      </div>
    @else
      <div id="eventCarousel" class="carousel slide landing-carousel" data-ride="carousel">
        <ol class="carousel-indicators">
          @for ($slide = 0; $slide < $eventSlideCount; $slide++)
            <li data-target="#eventCarousel" data-slide-to="{{ $slide }}" class="{{ $slide === 0 ? 'active' : '' }}"></li>
          @endfor
        </ol>

        <div class="carousel-inner">
          @for ($i = 0; $i < $eventCount; $i += 3)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
              <div class="row mt-10">
                @for ($j = $i; $j < min($i + 3, $eventCount); $j++)
                  <div class="col-sm-6 col-md-4 col-lg-4 mb-3">
                    <article class="landing-event-card">
                      <div class="landing-card-shell">
                        <a class="landing-card-media" href="{{ route('carevent') }}">
                          <img class="landing-card-image" src="/storage/photos/{{ $carevents[$j]->event_image }}" alt="{{ $carevents[$j]->event_title }}">
                          <span class="landing-card-badge">Event</span>
                        </a>
                        <div class="landing-card-body">
                          <h4 class="landing-card-title">{{ $carevents[$j]->event_title }}</h4>
                          <ul class="landing-event-meta">
                            <li><b>Location:</b> <span>{{ $carevents[$j]->event_location }}</span></li>
                            <li><b>Date:</b> <span>{{ $carevents[$j]->event_date }}</span></li>
                            <li><b>Time:</b> <span>{{ $carevents[$j]->event_time }}</span></li>
                            <li><b>Organizer:</b> <span>{{ $carevents[$j]->organizer }}</span></li>
                            <li><b>Ticket:</b> <span>Kes {{ $carevents[$j]->ticket_price }}</span></li>
                          </ul>
                        </div>
                      </div>
                    </article>
                  </div>
                @endfor
              </div>
            </div>
          @endfor
        </div>

        <a class="carousel-control-prev" href="#eventCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#eventCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    @endif
  </div>
</section>

<section class="landing-section landing-why">
  <div class="container">
    <div class="landing-section-head text-center">
      <h2>Why KingsBridge Motors?</h2>
      <p>Built for buyers, sellers, garages, and event organizers.</p>
    </div>
    <div class="row">
      <div class="col-md-6 mb-3">
        <article class="landing-info-card">
          <h5>More Than Listings</h5>
          <p>
            KingsBridge is an automotive hub where buyers, sellers, garages, and enthusiasts connect in one trusted platform.
            From discovery to deal closure, the experience is designed to move faster.
          </p>
          <a class="btn btn-main" href="{{ route('about_us') }}">Learn more</a>
        </article>
      </div>
      <div class="col-md-6 mb-3">
        <article class="landing-info-card">
          <h5>Flexible Growth Options</h5>
          <p>
            Choose listing and promotion options that match your goals.
            Whether you are moving one vehicle or scaling a full inventory, KingsBridge gives you room to grow.
          </p>
          <a class="btn btn-main" href="{{ route('about_us') }}">Learn more</a>
        </article>
      </div>
    </div>
  </div>
</section>

<section class="section-join landing-join">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-7">
        <div class="block about landing-join-copy">
          <h2>Start today, get more exposure, and grow your business</h2>
          <p>Launch your next listing in minutes and reach high-intent buyers.</p>
          <ul class="list-inline mt-20">
            <li class="list-inline-item"><a class="btn btn-main" href="{{ Auth::check() ? route('user.new_listing') : route('login') }}">Join Today</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-5 text-center">
        <img class="joinimg1" src="../images/call-to-action/Buying.svg" alt="Join KingsBridge" width="260" height="190">
      </div>
    </div>
  </div>
</section>

<section class="product landing-partners">
  <div class="container">
    <div class="landing-section-head text-center">
      <h2>Our Partners</h2>
      <p>Trusted collaborators helping us serve the automotive ecosystem.</p>
    </div>
    <div class="slider">
      <div><img src="../images/GarageGallery Logo.jpg" alt="Garage Gallery" style="max-height: 150px;"></div>
    </div>
  </div>
</section>

<section class="call-to-action overly bg-3 section-sm landing-cta">
  <div class="container">
    <div class="row justify-content-md-center text-center">
      <div class="col-md-8">
        <div class="content-holder">
          <h2>Join the largest community of vehicle enthusiasts</h2>
          <ul class="list-inline mt-30">
            <li class="list-inline-item"><a class="btn btn-main" href="{{ Auth::check() ? route('user.new_listing') : route('login') }}">Add Listing</a></li>
            <li class="list-inline-item"><a class="btn btn-secondary" href="{{ route('vehicleslist') }}">Browse Listings</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  $(function () {
    var content = [
      'Buy and sell smarter.',
      'Move inventory faster with better visibility.',
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
          intervalVal = setInterval(remove, 50);
        }, 1000);
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
          intervalVal = setInterval(type, 100);
        }, 200);
      }
    }

    intervalVal = setInterval(type, 100);

    $('.slider').slick({
      autoplay: true,
      autoplaySpeed: 1500,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev"></button>',
      nextArrow: '<button type="button" class="slick-next"></button>',
      centerMode: true,
      slidesToShow: 3,
      slidesToScroll: 2,
      responsive: [
        { breakpoint: 992, settings: { slidesToShow: 2 } },
        { breakpoint: 640, settings: { slidesToShow: 1, centerMode: false } }
      ]
    });
  });
</script>
@endpush

@endsection
