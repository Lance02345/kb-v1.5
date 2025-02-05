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
								<a href="{{ route('vehicleslist') }}"><i class="fa fa-car"></i> Vehicles</a>
							</li>
														<li class="list-inline-item">
								<a href="{{ route('spareparts') }}"><i class="fa fa-car"></i> Vehicle Parts</a>
							</li>
                            <li class="list-inline-item">
								<a href="{{ route('carhire') }}"><i class="fa fa-car"></i> Car Hire</a>
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

    .styled-list li i {
        margin-right: 5px;
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
										<svg style="color:#d4af37;"
										xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
										class="bi bi-camera-fill" viewBox="0 0 16 16">
										<path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" fill="#ffd040">
											</path>
											 <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" fill="#ffd040">
												</path> </svg>
										 <h2 class="text-white"> {{$listings->count()}}</h2>
									</div>
									</div>
									<div class="card-body">
										<h4 class="card-title"><a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">{{ $vehicle->carmodel->carmake->make}} {{ $vehicle->carmodel->model}} {{ $vehicle->year_of_build}}</a></h4>
										<ul class="list-inline product-meta">
											<li class="list-inline-item">
												<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}"><i class="fa fa-folder-open-o"></i>{{ $listing->category->category_name}}</a>
											</li>
											<li class="list-inline-item">
												<a href="#"><i class="fa fa-location-arrow"></i>{{ $listing->city->city}} </a>
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
										<svg style="color:#d4af37;"
										xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
										class="bi bi-camera-fill" viewBox="0 0 16 16">
										<path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" fill="#ffd040">
											</path>
											 <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" fill="#ffd040">
												</path> </svg>
										 <h2 class="text-white"> {{$listings->count()}}</h2>
									</div>
									</div>
									<div class="card-body">
										<h4 class="card-title"><a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">{{ $vehicle->carmodel->carmake->make}} {{ $vehicle->carmodel->model}} {{ $vehicle->year_of_build}}</a></h4>
										<ul class="list-inline product-meta">
											<li class="list-inline-item">
												<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}"><i class="fa fa-folder-open-o"></i>{{ $listing->category->category_name}}</a>
											</li>
											<li class="list-inline-item">
												<a href="#"><i class="fa fa-location-arrow"></i>{{ $listing->city->city}} </a>
											</li>
										</ul>
										<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">
                                            <ul class="">
                                                <div class="row align-items-start">
                                                    <div class="col-6 col-md-6">
                                                        <li><b>Engine Size:</b><span>{{ $vehicle->engine_size}}</span></li>
                                                        <li><b>Trans:</b><span>{{ $vehicle->transmission}}</span></li>
                                                    </div>
                                                    <div class="col-6 col-md-6 align-items-start ml-auto">
                                                        <li><b>Miles:</b><span>{{ $vehicle->mileage}}Km</span></li>
                                                        <li><b>Fuel:</b><span>{{ $vehicle->fuel_type}}</span></li>
                                                    </div>
                                                </div>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
$(document).on('change','.make',function(){
// console.log("hmm its change");
var make_id=$(this).val();
// console.log(cat_id);
var div=$("div.carmodel").parent();
var option=" ";
$.ajax({
	type:'get',
	url:'{!!URL::to('carmodel')!!}',
	data:{'id':make_id},
	success:function(data)
	{
		for(var i=0;i<data.length;i++)
		{
			option+='<option value="'+data[i].id+'">'+data[i].model+'</option>';

		}
			div.find('.model').html(" ");
			div.find('.model').append(option);
	},

	error:function(){    }
});
});
});
$(document).ready(function(){
    new ConditionalField({
          control: ' .select-field',
          visibility: {
            'sale': '.sale',
            'hire': '.hire',
            'parts': '.parts'
          }
        });

});
</script>
	<script type="text/javascript">
    let thumbnails = document.getElementsByClassName('thumbnail')

    let activeImages = document.getElementsByClassName('active')

    for (var i=0; i < thumbnails.length; i++){

        thumbnails[i].addEventListener('click', function(){
            console.log(activeImages)

            if (activeImages.length > 1){
                activeImages[0].classList.remove('active')
            }


            this.classList.add('active')
            document.getElementById('featured').src = this.src
        })
    }


		// List of sentences
var _CONTENT = [
"Buy and Sell",
"Advertising a Purpose, a Car at a Time,",
"With KingsBridge you get your money’s worth!!!.",
"You're in control, choose the right package to sell your car ."
];

// Current sentence being processed
var _PART = 0;

// Character number of the current sentence being processed
var _PART_INDEX = 0;

// Holds the handle returned from setInterval
var _INTERVAL_VAL;

// Element that holds the text
var _ELEMENT = document.querySelector("#text");

// Cursor element
var _CURSOR = document.querySelector("#cursor");

// Implements typing effect
function Type() {
// Get substring with 1 characater added
var text =  _CONTENT[_PART].substring(0, _PART_INDEX + 1);
_ELEMENT.innerHTML = text;
_PART_INDEX++;

// If full sentence has been displayed then start to delete the sentence after some time
if(text === _CONTENT[_PART]) {
// Hide the cursor
_CURSOR.style.display = 'none';

clearInterval(_INTERVAL_VAL);
setTimeout(function() {
	_INTERVAL_VAL = setInterval(Delete, 50);
}, 1000);
}
}

// Implements deleting effect
function Delete() {
// Get substring with 1 characater deleted
var text =  _CONTENT[_PART].substring(0, _PART_INDEX - 1);
_ELEMENT.innerHTML = text;
_PART_INDEX--;

// If sentence has been deleted then start to display the next sentence
if(text === '') {
clearInterval(_INTERVAL_VAL);

// If current sentence was last then display the first one, else move to the next
if(_PART == (_CONTENT.length - 1))
	_PART = 0;
else
	_PART++;

_PART_INDEX = 0;

// Start to display the next sentence after some time
setTimeout(function() {
	_CURSOR.style.display = 'inline-block';
	_INTERVAL_VAL = setInterval(Type, 100);
}, 200);
}
}

/// Start the typing effect on load
_INTERVAL_VAL = setInterval(Type, 100);

window.onload=function(){
  $('.slider').slick({
  autoplay:true,
  autoplaySpeed:1500,
  arrows:true,
  prevArrow:'<button type="button" class="slick-prev"></button>',
  nextArrow:'<button type="button" class="slick-next"></button>',
  centerMode:true,
  slidesToShow:3,
  slidesToScroll:2

  });

};


</script>
<script type="text/javascript">
let thumbnails = document.getElementsByClassName('thumbnail')

let activeImages = document.getElementsByClassName('active')

for (var i=0; i < thumbnails.length; i++){

	thumbnails[i].addEventListener('click', function(){
		console.log(activeImages)

		if (activeImages.length > 1){
			activeImages[0].classList.remove('active')
		}


		this.classList.add('active')
		document.getElementById('featured').src = this.src
	})
}


	// List of sentences
var _CONTENT = [
"The largest community of car enthusiasts.",
"From Car hiring services,,",
"selling of vehicles and selling of vehicles parts. ",
"All under one roof."
];

// Current sentence being processed
var _PART = 0;

// Character number of the current sentence being processed
var _PART_INDEX = 0;

// Holds the handle returned from setInterval
var _INTERVAL_VAL;

// Element that holds the text
var _ELEMENT = document.querySelector("#text");

// Cursor element
var _CURSOR = document.querySelector("#cursor");

// Implements typing effect
function Type() {
// Get substring with 1 characater added
var text =  _CONTENT[_PART].substring(0, _PART_INDEX + 1);
_ELEMENT.innerHTML = text;
_PART_INDEX++;

// If full sentence has been displayed then start to delete the sentence after some time
if(text === _CONTENT[_PART]) {
// Hide the cursor
_CURSOR.style.display = 'none';

clearInterval(_INTERVAL_VAL);
setTimeout(function() {
_INTERVAL_VAL = setInterval(Delete, 50);
}, 1000);
}
}

// Implements deleting effect
function Delete() {
// Get substring with 1 characater deleted
var text =  _CONTENT[_PART].substring(0, _PART_INDEX - 1);
_ELEMENT.innerHTML = text;
_PART_INDEX--;

// If sentence has been deleted then start to display the next sentence
if(text === '') {
clearInterval(_INTERVAL_VAL);

// If current sentence was last then display the first one, else move to the next
if(_PART == (_CONTENT.length - 1))
_PART = 0;
else
_PART++;

_PART_INDEX = 0;

// Start to display the next sentence after some time
setTimeout(function() {
_CURSOR.style.display = 'inline-block';
_INTERVAL_VAL = setInterval(Type, 100);
}, 200);
}
}

// Start the typing effect on load
_INTERVAL_VAL = setInterval(Type, 100);



window.onload=function(){
$('.slider').slick({
autoplay:true,
autoplaySpeed:1500,
arrows:true,
prevArrow:'<button type="button" class="slick-prev"></button>',
nextArrow:'<button type="button" class="slick-next"></button>',
centerMode:true,
slidesToShow:3,
slidesToScroll:2

});

};

$('#recipeCarousel').carousel({
interval: 10000
})

$('.carousel .carousel-item').each(function(){
var minPerSlide = 3;
var next = $(this).next();
if (!next.length) {
next = $(this).siblings(':first');
}
next.children(':first-child').clone().appendTo($(this));

for (var i=0;i<minPerSlide;i++) {
	next=next.next();
	if (!next.length) {
		next = $(this).siblings(':first');
	  }

	next.children(':first-child').clone().appendTo($(this));
  }
});


</script>

<script src="node_modules/@glidejs/glide/dist/glide.min.js"></script>

<script>
  new Glide('.glide').mount()
</script>


</section>

 @endsection
