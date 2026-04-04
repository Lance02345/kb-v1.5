@extends('layouts.kingsbridge')
@section('content')
  <section class="hero-area bg-1 text-center overly">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Header Contetnt -->
				<div class="content-block" >
					<h1>Garages</h1>
					<div class="short-popular-category-list text-center">
						<h2>Popular Category</h2>
					
						<ul class="list-inline">
							<li class="list-inline-item">
								<a href="{{ route('vehicleslist') }}"><i class="fa fa-car"></i> Vehicles</a>
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
			<h2>Garages</h2>
		</div>
	</div>
    <div class="row">
    @foreach ($garages as $j => $garage)
        <div class="col-sm col-md-4 col-lg-4">
            <!-- event card -->
            <div class="product-item bg-light" style="margin-right: 10px;"> <!-- Adjust this value as needed -->
            <div class="card">
                    <div class="thumb-content">
                        <div class="price">Garage</div>
                        <a href="">
                            <!-- Display event image -->
                            <img class="card-img-top category-img-fluid" src="/storage/app/{{ $garage->front_img }}" alt="Garage Image" style="max-height: 400px;" loading="lazy">
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mdl-card__title">
                            <!-- Display event title -->
                            <h2 style="font-weight: 450; font-size: 20px;" class="mdl-card__title-text">{{ $garage->garage_title }}</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <p class="card-text">
                                <ul class="styled-list">
                                    <!-- Display event details -->
                                    <li><b>Location:</b> <span>{{ $garage->garage_location }}</span></li>
                                    <li><b>Description:</b> <span>{!! strip_tags($garage->garage_description) !!}</span></li>
                                    </ul>
                                    </p>
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
