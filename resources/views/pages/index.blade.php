@extends('layouts.kingsbridge')
@section('content')


<!--===============================
=            Hero Area            =
================================-->

<section class="hero-area bg-1 text-center overly">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Header Contetnt -->
				<div class="content-block" >
					<h1>Buy & Sell Near You </h1>
					<div id="autotext">
						<div id="text"></div><div id="cursor"></div>
					</div>
					<div class="short-popular-category-list text-center">
						<h2>Popular Category</h2>
					
						    <ul class="list-inline">
								<li class="list-inline-item">
									<a href="{{ route('vehicleslist') }}">Vehicles</a>
								</li>
															<li class="list-inline-item">
									<a href="{{ route('spareparts') }}">Vehicle Parts</a>
								</li>
	                            <li class="list-inline-item">
									<a href="{{ route('carhire') }}">Car Hire</a>
								</li>

						</ul>
					</div>
					
				</div>
				<!-- Advance Search -->
				<div class="advance-search">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 align-content-center sale">
                <form action="{{ route('vehicle_search') }}" method="get" id="vehicleSearchForm">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <select name="make" id="make" class="make form-control">
                                <option value="" data-live-search="true">Choose a Make</option>
                                @foreach($makes as $make)
                                    <option value="{{ $make->id }}">{{ $make->make }}</option>
                                @endforeach
                            </select>
                            <!-- You can leave this error span if needed -->
                            @error('make_id')
                            <span class="invalid" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="carmodel form-group col-md-2">
                            <select name="model_id" id="model_id" class="model form-control">
                                <option value="" disabled="true" selected="true">Choose a model</option>
                            </select>
                        </div>

                        <!-- Other search fields here (city, min_price, max_price) -->
						<div class="form-group col-md-2">
                            <select name="city" id="inputGroupSelect" class="form-control">
                                <option value="">Select City</option>
                                @foreach ($cities as $city )
                                <option value="{{ $city->id }}" {{(old('city')==$city->id)? 'selected':''}}>
                                    {{ $city->city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <input type="text" name="min_price" placeholder="Min Price" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <input type="text" name="max_price" placeholder="Max Price" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary" style="padding: 8px; 30px;">Search Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
				
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>

<section class="home-quick-links section-sm">
	<div class="container">
		<div class="section-title text-center mb-4">
			<h2>Explore Kingsbridge</h2>
			<p>Start where you want: shop, list, discover parts, or join events.</p>
		</div>
		<div class="row">
				<div class="col-6 col-md-3 mb-3">
					<a href="{{ route('vehicleslist') }}" class="quick-link-card">
						<span class="quick-link-title">Buy a Vehicle</span>
						<span class="quick-link-text">Browse verified listings</span>
					</a>
				</div>
				<div class="col-6 col-md-3 mb-3">
					<a href="{{ route('spareparts') }}" class="quick-link-card">
						<span class="quick-link-title">Vehicle Parts</span>
						<span class="quick-link-text">Find trusted spare parts</span>
					</a>
				</div>
				<div class="col-6 col-md-3 mb-3">
					<a href="{{ route('carevent') }}" class="quick-link-card">
						<span class="quick-link-title">Car Events</span>
						<span class="quick-link-text">See upcoming auto events</span>
					</a>
				</div>
				<div class="col-6 col-md-3 mb-3">
					<a href="{{ route('about_us') }}" class="quick-link-card">
						<span class="quick-link-title">About Us</span>
						<span class="quick-link-text">Learn our mission</span>
					</a>
				</div>
		</div>
	</div>
</section>

<style>
					    @media (max-width: 767px) {
        .product-item {
            margin-bottom: 15px; /* Adjust vertical space between items */
        }
        .product-grid-list .row > div[class*="col-"] {
            padding-left: 5px; /* Adjust left padding */
            padding-right: 5px; /* Adjust right padding */
        }
    }
    /* Set a fixed height for the card bodies */
    .card-body {
        height: 150px; /* Adjust this value to your preferred fixed height */
        overflow: hidden; /* Hide content that exceeds the fixed height */
    }

	.styled-list {
        list-style: none;
        padding: 0;
    }

    .styled-list li {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

</style>
<div class="Hdrive text-center my-3">
	<div class = "container">
	<div class="col-md-12">
		<div class="section-title">
			<h2>Trending Ads</h2>
		</div>
	</div>
	<div id="productCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @php $slideNumber = 0; @endphp
        @foreach ($listings as $listing)
		@if ($listing->package_id == 2)
            @foreach ($vehicles as $vehicle)
        @if ($listing->id == $vehicle->listing_id)
                    @if ($slideNumber % 3 == 0)
                        <div class="carousel-item{{ $slideNumber === 0 ? ' active' : '' }}">
                            <div class="row mt-30">
                    @endif
                    <div class="col-sm col-md-4 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
							<div class="product-item bg-light">
								<div class="card">
									<div class="thumb-content">
										<!--<div class="price">{{ $listing->package->package_name}} </div>-->
										<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">
											
											<img class="card-img-top category-img-fluid" src="/storage/photos/{{ $vehicle->front_img }}" alt=""style="max-height: 400px;">
											
										</a>
										<div class="img-count">
											<p class="img-count-text">Featured</p>
											<h2 class="text-white"> {{$listings->count()}}</h2>
										</div>
									</div>
									<div class="card-body">
										<h4 class="card-title"><a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">{{ $vehicle->carmodel->carmake->make}} {{ $vehicle->carmodel->model}} {{ $vehicle->year_of_build}}</a></h4>
											<ul class="list-inline product-meta">
												<li class="list-inline-item">
													<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">{{ $listing->category->category_name}}</a>
												</li>
												<li class="list-inline-item">
													<a href="#">{{ $listing->city->city}} </a>
												</li>
											</ul>
										<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">
											<ul class="styled-list">
												<li ><b>Engine Size:</b><span>{{ $vehicle->engine_size}}</span></li>
												<li ><b>Trans:</b><span >{{ $vehicle->transmission}}</span></li>
												<li ><b>Miles:</b><span>{{ number_format($vehicle->mileage, 0, '.', ',') }} Km</span></li>
												<li ><b>Fuel:</b><span>{{ $vehicle->fuel_type}}</span></li>
				
											</ul>
											</div>
											<div class="property-price">
											<p class="badge-sale">For Sale</p>
											<p class="price">Ksh {{ $vehicle->price}}</p>
											</div>
											
											</div>
										</div>
                                <!-- Your card content here -->
                            </div>
                        </div>
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
    </div>

    <!-- Carousel navigation controls -->
    <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

	
				</div>

</div>
<!--===========================================
--===========================================
=            Popular deals section            =
============================================-->

<section class="product">
	<div class="container">
			<div class="col-md-12">
				<div class="section-title">
					<h2>Find Your Drive</h2>
				</div>
		</div>
	<div id="productCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @php $slideNumber = 0; @endphp
  @foreach ($listings as $listing )
        @foreach ($vehicles as $vehicle)
            @if ($listing->id == $vehicle->listing_id)
                    @if ($slideNumber % 3 == 0)
                        <div class="carousel-item{{ $slideNumber === 0 ? ' active' : '' }}">
                            <div class="row mt-30">
                    @endif
                    <div class="col-sm col-md-4 col-lg-4">
                        <!-- product card -->
                        <div class="product-item bg-light">
                            <div class="card">
							<div class="product-item bg-light">
								<div class="card">
									<div class="thumb-content">
										<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">
											
											<img class="card-img-top category-img-fluid" src="/storage/photos/{{ $vehicle->front_img }}" alt=""style="max-height: 400px;">
											
										</a>
										<div class="img-count">
											<p class="img-count-text">Live</p>
											<h2 class="text-white"> {{$listings->count()}}</h2>
										</div>
									</div>
									<div class="card-body">
										<h4 class="card-title"><a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">{{ $vehicle->carmodel->carmake->make}} {{ $vehicle->carmodel->model}} {{ $vehicle->year_of_build}}</a></h4>
											<ul class="list-inline product-meta">
												<li class="list-inline-item">
													<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">{{ $listing->category->category_name}}</a>
												</li>
												<li class="list-inline-item">
													<a href="#">{{ $listing->city->city}} </a>
												</li>
											</ul>
										<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">
											<ul class="styled-list">
												<li ><b>Engine Size:</b><span>{{ $vehicle->engine_size}}</span></li>
												<li ><b>Trans:</b><span >{{ $vehicle->transmission}}</span></li>
												<li ><b>Miles:</b><span>{{ number_format($vehicle->mileage, 0, '.', ',') }} Km</span></li>
												<li ><b>Fuel:</b><span>{{ $vehicle->fuel_type}}</span></li>
				
											</ul>
											</div>
											<div class="property-price">
											<p class="badge-sale">For Sale</p>
											<p class="price">Ksh {{ $vehicle->price}}</p>
											</div>
											<div>
											
											
												</div>
											</div>
										</div>
                            </div>
                        </div>
                    </div>
                    @php $slideNumber++; @endphp
                    @if ($slideNumber % 3 == 0)
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        @endforeach
    </div>

    <!-- Carousel navigation controls -->
    <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

</section>

<div class="Hdrive text-center my-3">
	<div class = "container">
	<div class="col-md-12">
		<div class="section-title">
			<h2>Events</h2>
		</div>
	</div>
	<div id="eventCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @foreach ($carevents as $index => $carevent)
            <li data-target="#eventCarousel" data-slide-to="{{ $index }}" @if ($index === 0) class="active" @endif></li>
        @endforeach
    </ol>

    <!-- Slides -->
<div id="eventCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @foreach ($carevents as $index => $carevent)
            <li data-target="#eventCarousel" data-slide-to="{{ $index }}" @if ($index === 0) class="active" @endif></li>
        @endforeach
    </ol>

    <!-- Slides -->
    <div class="carousel-inner">
        @for ($i = 0; $i < count($carevents); $i += 3)
            <div class="carousel-item @if ($i === 0) active @endif">
                <div class="row">
                    @for ($j = $i; $j < min($i + 3, count($carevents)); $j++)
                        <div class="col-sm col-md-4 col-lg-4">
                            <!-- event card -->
                            <div class="product-item bg-light" style="margin-right: 10px;"> <!-- Adjust this value as needed -->
                                <div class="card">
                                    <div class="thumb-content">
                                        <div class="price">Event</div>
                                        <a href="{{ route('carevent') }}">
                                            <!-- Display event image -->
                                            <img class="card-img-top category-img-fluid" src="/storage/photos/{{ $carevents[$j]->event_image }}" alt="Event Image" style="max-height: 400px;">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="mdl-card__title">
                                            <!-- Display event title -->
                                            <h2 style="font-weight: 450; font-size: 20px;" class="mdl-card__title-text">{{ $carevents[$j]->event_title }}</h2>
                                        </div>
                                        <div class="mdl-card__supporting-text">
                                            <p class="card-text">
                                                <ul class="list-horizontal">
                                                    <!-- Display event details -->
                                                    <li><b>Location:</b> <span>{{ $carevents[$j]->event_location }}</span></li>
                                                    <li><b>Date:</b> <span>{{ $carevents[$j]->event_date }}</span></li>
                                                    <li><b>Time:</b> <span>{{ $carevents[$j]->event_time }}</span></li>
                                                    <li><b>Organizer:</b> <span>{{ $carevents[$j]->organizer }}</span></li>
                                                    <li><b>Ticket:</b> <span>Kes: {{ $carevents[$j]->ticket_price }}</span></li>
                                                </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>

    <!-- Controls -->
    <a class="carousel-control-prev" href="#eventCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#eventCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
</div>

</div>
</div>
<!--==========================================
=          Why KingsBridge            =
===========================================-->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="section-title section-why-title">
				<h2>Why KingsBridge Motors?</h2>
			</div>
		</div>
		<div class="col-sm-6">
		  <div class="whycard">
			<div class="card-bodyy">
			  <h5 class="why-title">Why us?</h5>
			  <p class="why-text">
				At KingsBridge, we take pride in being more than just an online car selling platform. 
				We are your automotive hub, a comprehensive destination where car enthusiasts and sellers unite.
				Here's why you should choose us:
			  </p>
				<li class="why-btn-alighn"><a class="btn btn-main" href="{{ route('about_us')}}">Learn more</a></li>
			</div>
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="whycard">
			<div class="card-bodyy">
			  <h5 class="why-title">Flexible Options for All</h5>
                <p class="why-text" style="text-align: justify;">
                    At KingsBridge, we offer flexible pricing options to cater to your unique needs.
                    Whether you're a car seller, a garage owner, or a car event organizer, we have a solution tailored just for you. 
                    Explore the possibilities:			  
                    </p>
				<li class="why-btn-alighn"><a class="btn btn-main" href="{{ route('about_us')}}">Learn more</a></li>
			</div>
		  </div>
		</div>
	  </div>
</div>
</div>
</div>

<!--==========================================
=        Join the Largest car community  =
===========================================-->
<section class="section-join">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="grid-flex">
				<div class="block about">
					<h2>Start today to get more exposure and
					grow your business</h2>
					<ul class="list-inline mt-30">
						<li class="list-inline-item"><a class="btn btn-main" href="{{ Auth::check() ? route('user.new_listing') : route('login') }}">Join Today</a></li>
					</ul>
				</div>
			</div>
			<div class="join ">
				<img class="joinimg1" src="../images/call-to-action/Buying.svg" alt="Pineapple" width="230" height="170">
			</div>
		</div>
	</div>
</section>

<!--===================================
=           Our Partners           =
====================================-->

<section class="product">
	<p style="font-weight: 450; font-size:20px; text-align: center;"> <b>Our Partners</b></p>
	<div class="slider ">
		<div><img src="../images/GarageGallery Logo.jpg" alt="" style="max-height: 150px;">
		</div>
	  </div>
</section>

<!--====================================
=            Call to Action            =
=====================================-->
 

<section class="call-to-action overly bg-3 section-sm">
	<!-- Container Start -->
	<div class="container">
		<div class="row justify-content-md-center text-center">
			<div class="col-md-8">
				<div class="content-holder">
					<h2>Join the largest community of vehicle enthusiasts</h2>
					<ul class="list-inline mt-30">
						<li class="list-inline-item"><a class="btn btn-main" href="{{ Auth::check() ? route('user.new_listing') : route('login') }}">Add Listing</a></li>						
						<li class="list-inline-item"><a class="btn btn-secondary" href="{{ route('vehicleslist')}}">Browser Listing</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>


	
	<!-- Container End -->
@push('scripts')
<script>
  $(function () {
    $(document).on('change', '.make', function () {
      var makeId = $(this).val();
      var modelContainer = $('div.carmodel').parent();
      var option = '<option value=\"\" disabled selected>Choose a model</option>';

      $.ajax({
        type: 'get',
        url: '{{ url("carmodel") }}',
        data: { id: makeId },
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            option += '<option value=\"' + data[i].id + '\">' + data[i].model + '</option>';
          }
          modelContainer.find('.model').html(option);
        }
      });
    });

    var content = [
      'Buy and Sell',
      'Advertising a purpose, a car at a time.',
      'With Kingsbridge you get your money\'s worth.',
      'You are in control. Choose the right package to sell your car.'
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
      prevArrow: '<button type=\"button\" class=\"slick-prev\"></button>',
      nextArrow: '<button type=\"button\" class=\"slick-next\"></button>',
      centerMode: true,
      slidesToShow: 3,
      slidesToScroll: 2
    });
  });
</script>
@endpush

	</section>

 @endsection
