@extends('layouts.kingsbridge')
@section('content')
<section class="hero-area bg-1 text-center overly">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Header Contetnt -->
				<div class="content-block" >
					<h1>Vehicle Parts</h1>
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
<section class=" section-sm">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
            <div class="search-result bg-gray">
    <form action="{{ route('spare_parts_search') }}" method="get">
        <div class="form-row">
            <div class="form-group col-md-2">
                <input type="text" name="make" class="form-control" placeholder="Enter Make" value="{{ request('make') }}">
                @error('make')
                    <span class="invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-2">
                <input type="text" name="item_name" class="form-control" placeholder="Enter Item Name" value="{{ request('item_name') }}">
                @error('item_name')
                    <span class="invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-2">
                <input type="text" name="location" class="form-control" placeholder="Enter Location" value="{{ request('location') }}">
            </div>

            <div class="form-group col-md-2">
                <select name="condition" class="form-control">
                    <option value="" {{ (request('condition') == '') ? 'selected' : '' }}>All Conditions</option>
                    <option value="new" {{ (request('condition') == 'new') ? 'selected' : '' }}>New</option>
                    <option value="used" {{ (request('condition') == 'used') ? 'selected' : '' }}>Used</option>
                </select>
            </div>

            <div class="form-group col-md-2">
    <input type="text" name="min_price" class="form-control" placeholder="Min Price" value="{{ request('min_price') }}">
</div>

<div class="form-group col-md-2">
    <input type="text" name="max_price" class="form-control" placeholder="Max Price" value="{{ request('max_price') }}">
</div>

            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-primary" style="padding: 8px; 30px;">Search Now</button>
            </div>
        </div>
    </form>
    <p> {{ $spareParts->count() }} Results on {{ now()->format('d F Y') }}</p>
</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
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
						@foreach($spareParts as $sparePart)
                    <div class="col-6 col-sm-3 col-md-3 col-lg-3">
								<!-- product card -->
								<div class="product-item bg-light">
									<div class="card">
										<div class="thumb-content">
											<a href="{{ route('sparepart', $sparePart->id)}}">
												<img class="card-img-top category-img-fluid" src="/storage/photos/{{ $sparePart->front_img }}" alt="image description" style="max-height: 200px;" loading="lazy">
											</a>
											<div class="img-count">
												<svg style="color:#d4af37;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
													<path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" fill="#ffd040"></path>
													<path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" fill="#ffd040"></path>
												</svg>
												<h2 class="text-white"> {{ $spareParts->count() }}</h2>
											</div>
										</div>
										<div class="card-body">
											<h4 class="card-title"><a href="">{{ $sparePart->make }}-{{ $sparePart->item_name }}</a></h4>
											<ul class="list-inline product-meta">
												<li class="list-inline-item">
													<a href=""><i class="fa fa-folder-open-o"></i>Spare Parts</a>
												</li>
												<li class="list-inline-item">
													<a href="#"><i class="fa fa-location-arrow"></i>{{ $sparePart->location }}</a>
												</li>
											</ul>
											<ul class="styled-list">
												<li><b>Condition:</b><span>{{ $sparePart->condition }}</span></li>
											</ul>

										</div>
                                        <div class="property-price">
											<p class="badge-sale">For Sale</p>
											<p class="price">Ksh {{ $sparePart->price}}</p>
											</div>
</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>

				<div class="pagination justify-content-center">
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function(){
		$("#heart").click(function(){
			if($("#heart").hasClass("liked")){
				$("#heart").html('<i class="fa fa-heart-o" aria-hidden="true"></i>');
				$("#heart").removeClass("liked");
			}else{
				$("#heart").html('<i class="fa fa-heart" aria-hidden="true"></i>');
				$("#heart").addClass("liked");
			}
		});
	});

	$(document).ready(function(){
		$(document).on('change','.make',function(){
			var make_id=$(this).val();
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

<!-- The script for Car Make -->
<script>
	$('input.number').keyup(function(event) {
		if(event.which >= 37 && event.which <= 40) return;
		$(this).val(function(index, value) {
			return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		});
	});

	$(document).ready(function(){
		$(document).on('change','.make',function(){
			var make_id=$(this).val();
			var div=$("div.carmodel").parent();
			var option=" ";
			$.ajax({
				type:'get',
				url:'{!!URL::to('user/model')!!}',
				data:{'id':make_id},
				success:function(data){
					for(var i=0;i<data.length;i++){
						option+='<option value="'+data[i].id+'" >'+data[i].model+'</option>';
					}
					div.find('.model').html(" ");
					div.find('.model').append(option);
				},
				error:function(){    }
			});
		});
	});
</script>
@endsection
