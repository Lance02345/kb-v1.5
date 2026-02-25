@extends('layouts.kingsbridge')
@section('content')

<link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick/slick.css')}}" >
<link rel="stylesheet" href="{{ asset('plugins/slick-carousel/slick/slick-theme.css')}}" >

<!-- Spare Parts Section -->
<section class="section bg-gray">
    <div class="container">
        <div class="row">
            <!-- Left sidebar -->

            <div class="col-md-8">
                <div class="product-details">
                    <!-- Product Title -->
                    <h1 class="product-title">{{ $sparePart->make }}-{{ $sparePart->item_name }}</h1>

                    <!-- Product Meta Information -->
                    <div class="product-meta">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-money"></i> KSH <a href="">{{ number_format($sparePart->price, 0, '.', ',') }}</a></li>
                            <li class="list-inline-item"><i class="fa fa-folder-open-o"></i> Category<a href="">SpareParts</a></li>
							<li class="list-inline-item"><i class="fa fa-location-arrow"></i> Location<a href="">{{ $sparePart->location }}</a></li>
						</ul>                        
                    </div>

                    <!-- Product Images -->
                    <section>
    <div class="main single-item">
        @if ($sparePart->front_img) <div class="main"><img src="/storage/photos/{{ $sparePart->front_img }}" class="sparePart-img spare-fs-trigger" data-src="/storage/photos/{{ $sparePart->front_img }}"></div> @endif
        @if ($sparePart->back_img) <div class="main"><img src="/storage/photos/{{ $sparePart->back_img }}" class="sparePart-img spare-fs-trigger" data-src="/storage/photos/{{ $sparePart->back_img }}"></div> @endif
        @if ($sparePart->right_img) <div class="main"><img src="/storage/photos/{{ $sparePart->right_img }}" class="sparePart-img spare-fs-trigger" data-src="/storage/photos/{{ $sparePart->right_img }}"></div> @endif
      
    </div>

    <ul class="thumbs mt-3 slider-nav">
        @if ($sparePart->front_img) <div><img class="thumbnail thumb-img" src="/storage/photos/{{ $sparePart->front_img }}"></div> @endif
        @if ($sparePart->back_img) <div><img class="thumbnail thumb-img" src="/storage/photos/{{ $sparePart->back_img }}"></div> @endif
        @if ($sparePart->right_img) <div><img class="thumbnail thumb-img" src="/storage/photos/{{ $sparePart->right_img }}"></div> @endif
        
    </ul>
</section>

<div id="legacy-spare-lightbox" style="position:fixed; inset:0; z-index:9999; display:none; background:rgba(2,6,23,.95); padding:16px;">
    <button type="button" id="legacy-spare-close" style="position:absolute; right:16px; top:16px; border:1px solid #64748b; background:#0f172a; color:#f8fafc; border-radius:8px; padding:8px 12px;">Close</button>
    <button type="button" id="legacy-spare-prev" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); border:1px solid #64748b; background:#0f172a; color:#f8fafc; border-radius:8px; padding:8px 10px;">&larr;</button>
    <img id="legacy-spare-image" src="" alt="Spare part fullscreen" style="max-width:100%; max-height:100%; display:block; margin:0 auto; object-fit:contain;">
    <button type="button" id="legacy-spare-next" style="position:absolute; right:16px; top:50%; transform:translateY(-50%); border:1px solid #64748b; background:#0f172a; color:#f8fafc; border-radius:8px; padding:8px 10px;">&rarr;</button>
</div>
<style>
    /* CSS to set a fixed height and width for the images */
    .sparePart-img {
        max-height: 400px; /* Adjust the height as needed */
        max-width: 100%; /* Keeps the aspect ratio */
    }
</style>

                    <!-- Product Specifications -->
<section class="sparePart specifications">
   
		
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <h3 class="tab-title">Spare Part Description</h3>
                        <p>{{$sparePart->item_description}}</p>
                    </div>
                
           
</section>	 
                     <div class="content ">
						<ul class="nav nav-pills  justify-content-center" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile"
								 aria-selected="false">Specifications</a>
							</li>
							<!--<li class="nav-item">-->
							<!--	<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact"-->
							<!--	 aria-selected="false">Reviews</a>-->
							<!--</li>-->
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
								<h3 class="tab-title">Car Specifications</h3>
								<table class="table table-bordered product-table">
									<tbody>
										
										<tr>	
											<td>Make</td>
											<td>{{ $sparePart->make}}</td>
										</tr>

										<tr>
											<td>Spare Part Name</td>
											<td>{{ $sparePart->item_name}}</td>
										</tr>
										
										<tr>
											<td>Condition</td>
											<td>{{ $sparePart->condition}}</td>
										</tr>
										<tr>
											<td>Location</td>
											<td>{{ $sparePart->location}}</td>
										</tr>
										
									</tbody>
								</table>
							</div>

						</div>
					</div>
</div>

</div>

            <!-- Sidebar for Spare Parts -->
            <div class="col-md-4">
                <div class="sidebar">
                    <!-- Price Widget -->
                    <div class="widget price mt-4 text-center">
                        <h4>Price</h4>
                        <p>KSH {{ $sparePart->price }}</p>
                    </div>

                    <!-- Seller Information Widget -->
                    <div class="widget user text-center">
                        <!-- Seller Avatar -->
                        <div class="image d-flex justify-content-center">
                        <img src="/storage/photos/{{ $userWhoPosted->avatar}}" alt="" class="">
                        </div>
                        <h4><a href=""> {{ $userWhoPosted->name }}  </a></h4>
                        <!-- Member Since Information -->
                        <p class="member-time">Member Since {{ $userWhoPosted->created_at->diffForHumans() }} </p>
                        <a href="">See all spare parts</a>
                        <!-- Phone Number Information (if authenticated) -->
                        @if(Auth::check())
                            <p>{{ $userWhoPosted->phone_number }}</p>
                        @else
                            <a href="{{ route('user.login') }}"></a>
                        @endif

                        <!-- Contact and Make Offer Buttons -->
                        <ul class="list-inline mt-20">
                            <li class="list-inline-item">
                                <!-- Contact Button -->
                                @if(Auth::check())
                                    <a href="tel:{{ $userWhoPosted->phone_number }}" class="btn btn-contact d-inline-block btn-primary px-lg-5 my-1 px-md-3">Contact</a>
                                @else
                                    <a href="{{ route('user.login') }}" class="btn btn-contact d-inline-block btn-primary px-lg-5 my-1 px-md-3">Contact</a>
                                @endif
                            </li>
                            <!--<li class="list-inline-item">-->
                                <!-- Make an Offer Button -->
                            <!--    <a href="" class="btn btn-offer d-inline-block btn-primary ml-n1 my-1 px-lg-4 px-md-3">Make an offer</a>-->
                            <!--</li>-->
                        </ul>

                        <!-- WhatsApp Chat Button -->
                        <div>
                            @if(Auth::check())
                                <a aria-label="Chat on WhatsApp" href="https://wa.me/{{ $userWhoPosted->phone_number }}">
                                    <img class="w-75" alt="Chat on WhatsApp" src="{{ asset('images/WhatsAppButtonGreenSmall.png')}}" />
                                </a>
                            @else
                                <a aria-label="Chat on WhatsApp" href="{{ route('user.login') }}">
                                    <img class="w-75" alt="Chat on WhatsApp" src="{{ asset('images/WhatsAppButtonGreenSmall.png')}}" />
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Safety Tips Widget -->
                    <div class="widget disclaimer">
                        <h5 class="widget-header">Safety Tips</h5>
                        <ul>
                            <li>Meet seller at a public place</li>
                            <li>Check the item before you buy</li>
                            <li>Pay only after collecting the item</li>
                            <li>Pay only after collecting the item</li>
                        </ul>
                    </div>
                    <div class="widget coupon text-center">
						<!-- Coupon description -->
						<p>Have a great product to post ? Share it with
							your fellow users.
						</p>
						<!-- Submit button -->						
						<a href="{{ Auth::check() ? route('user.sparepartscreate') : route('user.login') }}" class="btn btn-transparent-white">Submit Listing</a>
					</div>
                </div>
            </div>
</div>

</section>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>	
<script type="text/javascript">
	let thumbnails = document.getElementsByClassName('thumbnail')
	
	let activeImages = document.getElementsByClassName('active')
	
	for (var i=0; i < thumbnails.length; i++){
	
	  thumbnails[i].addEventListener('click', function(){
		  console.log(activeImages)
		  
		  if (activeImages.length > 0){
			  activeImages[0].classList.remove('active')
		  }
		  
	
		  this.classList.add('active')
		  document.getElementById('featured').src = this.src
	  })
	}        


	$(function() {
  // Get references to the main image container and thumbnails
  var $mainImages = $('.main > img');
  var $thumbnails = $('.thumb-img');
  
  // Listen for click events on the left and right arrows
  $('.slider-prev, .slider-next').on('click', function() {
    // Find the index of the currently active main image
    var activeIndex = $mainImages.index($('.main > img.active'));
    
    // Calculate the index of the next main image based on the clicked arrow
    var nextIndex = activeIndex + ($(this).hasClass('slider-next') ? 1 : -1);
    
    // Make sure the index is within the bounds of the main images array
    if (nextIndex < 0) {
      nextIndex = $mainImages.length - 1;
    } else if (nextIndex >= $mainImages.length) {
      nextIndex = 0;
    }
    
    // Update the active class on the main image and its corresponding thumbnail
    $mainImages.removeClass('active').eq(nextIndex).addClass('active');
    $thumbnails.removeClass('active').eq(nextIndex).addClass('active');
  });
});
	</script> 
 <script type="text/javascript">
  $(document).ready(function() {
    $('.single-item').slick({
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev">&#8592;</button>',
      nextArrow: '<button type="button" class="slick-next">&#8594;</button>'
    });

    $('.slider-nav').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: '.single-item',
      dots: false,
      centerMode: false,
      focusOnSelect: true
    });
  });
	

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

(function () {
  var triggers = Array.prototype.slice.call(document.querySelectorAll('.spare-fs-trigger'));
  if (!triggers.length) return;

  var lightbox = document.getElementById('legacy-spare-lightbox');
  var image = document.getElementById('legacy-spare-image');
  var closeBtn = document.getElementById('legacy-spare-close');
  var prevBtn = document.getElementById('legacy-spare-prev');
  var nextBtn = document.getElementById('legacy-spare-next');
  var images = triggers.map(function (trigger) { return trigger.getAttribute('data-src'); });
  var currentIndex = 0;

  function show(index) {
    currentIndex = (index + images.length) % images.length;
    image.src = images[currentIndex];
  }

  function open(index) {
    show(index);
    lightbox.style.display = 'block';
    document.body.style.overflow = 'hidden';
  }

  function close() {
    lightbox.style.display = 'none';
    document.body.style.overflow = '';
  }

  triggers.forEach(function (trigger, index) {
    trigger.addEventListener('click', function () {
      open(index);
    });
  });

  closeBtn.addEventListener('click', close);
  prevBtn.addEventListener('click', function () { show(currentIndex - 1); });
  nextBtn.addEventListener('click', function () { show(currentIndex + 1); });

  document.addEventListener('keydown', function (event) {
    if (lightbox.style.display !== 'block') return;
    if (event.key === 'Escape') close();
    if (event.key === 'ArrowLeft') show(currentIndex - 1);
    if (event.key === 'ArrowRight') show(currentIndex + 1);
  });
})();
  </script>
@endsection
