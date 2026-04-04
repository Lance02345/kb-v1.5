@extends('layouts.kingsbridge')
@section('content')
<section class="hero-area bg-1 text-center overly">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Header Contetnt -->
				<div class="content-block" >
					<h1>Events</h1>
					<div class="short-popular-category-list text-center">
						<h2>Popular Category</h2>
					
						<ul class="list-inline">
							<li class="list-inline-item">
								<a href="{{ route('vehicleslist') }}"><i class="fa fa-car"></i> Vehicles</a>
							</li>
							<li class="list-inline-item">
								<a href="{{ route('spareparts') }}"><i class="fa fa-car"></i> Vehicle Parts</a>
							</li>
						</ul>
					</div>
					
				</div>				
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>

<div class="Hdrive text-center my-3">
	<div class = "container">
	<div class="col-md-12">
		<div class="section-title">
			<h2>Car Events</h2>
		</div>
	</div>
    <div class="row">
    @foreach ($carevents as $j => $carevent)
        <div class="col-sm col-md-4 col-lg-4">
            <!-- event card -->
            <div class="product-item bg-light" style="margin-right: 10px;"> <!-- Adjust this value as needed -->
                <div class="card">
                    <div class="thumb-content">
                        <div class="price">Event</div>
                        <a href="{{ route('events.show', ['id' => $carevent->id]) }}">
                            <!-- Display event image -->
                            <img class="card-img-top category-img-fluid" src="/storage/photos/{{ $carevent->event_image }}" alt="Event Image" style="max-height: 400px;" loading="lazy">
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mdl-card__title">
                            <!-- Display event title -->
                            <h2 style="font-weight: 450; font-size: 20px;" class="mdl-card__title-text">{{ $carevent->event_title }}</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <p class="card-text">
                                <ul class="styled-list">
                                    <!-- Display event details -->
                                    <li><b>Location:</b> <span>{{ $carevent->event_location }}</span></li>
                                    <li><b>Date:</b> <span>{{ $carevent->event_date }}</span></li>
                                    <li><b>Time:</b> <span>{{ $carevent->event_time }}</span></li>
                                    <li><b>Organizer:</b> <span>{{ $carevent->organizer }}</span></li>
                                    </ul>
                                    </p>
                                    </div>
                                    <div class="property-price">
											<p class="badge-sale">Ticket Price</p>
											<p class="price">Ksh {{ $carevent->ticket_price }}</p>
											</div>
                                
                            
                        
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
</div>
</div>
@endsection