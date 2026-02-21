@extends('layouts.kingsbridge')
@section('content')

<section class=" section-sm">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="search-result bg-gray">
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
                            <input type="text" name="min_price" id="min_price" placeholder="Min Price" class="form-control">
                        </div>

                        <div class="form-group col-md-2">
                            <input type="text" name="max_price" id="max_price" placeholder="Max Price" class="form-control">
                        </div>


                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary" style="padding: 8px; 30px;">Search Now</button>
                        </div>
                    </div>
                </form>
				<p> {{$listings->count()}} Results on  {{ now()->format('d F Y') }}</p>
            </div>
        </div>
    </div>
		<div class="row">
			<div class="col-md-12">
				<div class="category-search-filter">
					<div class="row">
						<div class="col-md-6">
							<strong>Sort</strong>
							<div class="select-wrapper">
							  <select>
								<option>Most Recent</option>
								<option value="1">Most Popular</option>
								<option value="2">Lowest Price</option>
								<option value="4">Highest Price</option>
							  </select>
							  <ul>
								<li>Most Recent</li>
								<li>Most Popular</li>
								<li>Lowest Price</li>
								<li>Highest Price</li>
							  </ul>
							</div>
						  </div>
						  
						<div class="col-md-6">
							<div class="view">
								<strong>Views</strong>
								<ul class="list-inline view-switcher">
									<li class="list-inline-item">
										<a href="{{ route('vehicleslist')}}" class="text-info"><i class="fa fa-th-large"></i></a>
									</li>
									<li class="list-inline-item">
										<a href="{{ route('vehicles_list')}}"><i class="fa fa-reorder"></i></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				
				<style>
					    @media (max-width: 767px) {
        .product-item {
            margin-bottom: 15px; /* Adjust vertical space between items */
        }
        .product-grid-list .row > div[class*="col-"] {
            padding-left: 2px; /* Adjust left padding */
            padding-right: 2px; /* Adjust right padding */
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
				 <div class="product-grid-list">
					<div class="row mt-30">
  @foreach ($listings as $listing )
  @foreach ($vehicles as $vehicle)
  @if ($listing->id == $vehicle->listing_id)
                    <div class="col-6 col-sm-3 col-md-3 col-lg-3">
							<!-- product card -->
							<div class="product-item bg-light">
								<div class="card">
									<div class="thumb-content">
										<a href="{{ route('vehicle', [$listing->id, $vehicle->id])}}">
											
											<img class="card-img-top category-img-fluid" src="/storage/photos/{{ $vehicle->front_img }}" alt="image description"style="max-height: 200px;">
											
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
											<li >
							                       <a href="#"><i class="fa fa-dot-circle-o"></i><b></b>  {{ $vehicle->engine_size}}    </a>
												</li>
												
												<li >
							                       <a href="#"><i class="fa fa-dot-circle-o"></i>{{ $vehicle->transmission}}</a>
												</li>
												
												<li >
							                       <a href="#"><i class="fa fa-dot-circle-o"></i>{{ number_format($vehicle->mileage, 0, '.', ',') }} <b>Km</b></a>
												</li>
												
												<li >
							                       <a href="#"><i class="fa fa-dot-circle-o"></i><b></b>{{ $vehicle->fuel_type}}</a>
												</li>
				
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
										</a>
									</div>

									@endif
									@endforeach
									@endforeach										
					</div>
				</div>
				
				<div class="pagination justify-content-center">
					
							{{ $listings->appends(Request::all())->links('vendor.pagination.custom') }}
					
				</div>
			</div>
		</div>
	</div>
</section>
@push('scripts')
<script>
  $(function () {
    $('#min_price, #max_price').on('input', function () {
      var value = $(this).val().replace(/[^\d]/g, '');
      $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, ','));
    });

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
  });
</script>
@endpush
@endsection
