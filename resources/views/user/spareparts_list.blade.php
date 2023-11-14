@extends('layouts.kingsbridge')
@section('content')

<!--==================================
=            User Profile            =
===================================-->
@if(session('success'))
<div class="mt-3 alert alert-success">
    <span> {{ session('success') }} </span>
</div>
@endif
<section class="section-sm">
    <!-- Container Start -->
    <div class="container">
        <!-- Row Start -->
        <div class="row">
            <div class="col-md-10 offset-md-1 col-lg-4 offset-lg-0">
                <!-- Sidebar -->
				<div class="sidebar">
					<!-- User Widget -->
					<div class="widget user-dashboard-profile user">
						<!-- User Image -->
						<div class="image d-flex justify-content-center">
							<img src="/storage/photos/{{ auth()->user()->avatar}}" alt="" class="">
						</div>
						<!-- User Name -->
						<h5 class="text-center">{{ auth()->user()->name }}</h5>
						<p>Joined {{ auth()->user()->created_at->diffForHumans() }}</p>
						<a href="{{ route('user.user_profile', Auth::user()->id )}}" class="btn btn-main-sm">Edit Profile</a>
					</div>
					<!-- Dashboard Links -->
					<div class="widget user-dashboard-menu">
						<h3>My list</h3>
						<ul>
							<li> <a href="{{ route('user.index_vehiclesale')}}"><i class="fa fa-car"></i>Vehicles for Sale <span>{{$listings->where('category_id','2')->count()}}</a> </li>
						<!--	<li> <a href="{{ route('user.index_carhire')}}"><i class="fa fa-car"></i>Vehicles for Hire <span>{{$listings->where('category_id','1')->count()}}</a> </li> -->

						</ul>
					</div>
					<div class="widget user-dashboard-menu">
						<ul>
							<li> <a href="{{ route('favourite_list')}}"><i class="fa fa-heart"></i>Favourite</a> </li>
	
						</ul>
					</div>
					<div class="widget user-dashboard-menu">
						<h3>Listing Status</h3>
						<ul>
							<li> <a href="{{ route('user.active_list')}}"><i class="fa fa-circle"></i>Active <span>{{$listings->where('ads_status','Approved')->count()}}</span></a> </li>
							<li> <a href="{{ route('user.pending_list')}}"><i class="fa fa-file-archive-o"></i>Pending <span>{{$listings->where('ads_status','Pending')->count()}}</span></a></a> </li>
							<li> <a href="{{ route('user.expired_list')}}"><i class="fa fa-flag"></i>Expired <span>{{$listings->where('ads_status','Expired')->count()}}</span></a></a> </li>
							<li> <a href="{{ route('user.sold_list')}}"><i class="fa fa-money"></i>Sold <span>{{$listings->where('ads_status','Sold')->count()}}</span></a></a> </li>
						
						</ul>
					</div>
					<!-- delete-account modal -->
											  <!-- delete account popup modal start-->
                <!-- Modal -->
                <div class="modal fade" id="deleteaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header border-bottom-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body text-center">
                        <img src="images/account/Account1.png" class="img-fluid mb-2" alt="">
                        <h6 class="py-2">Are you sure you want to delete your account?</h6>
                        <p>Do you really want to delete these records? This process cannot be undone.</p>
                        <textarea name="message" id="" cols="40" rows="4" class="w-100 rounded"></textarea>
                      </div>
                      <div class="modal-footer border-top-0 mb-3 mx-5 justify-content-lg-between justify-content-center">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger">Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- delete account popup modal end-->
					<!-- delete-account modal -->

				</div>            </div>

            @if ( !is_null($spareParts) && count($spareParts) > 0)
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
                <!-- My Listings -->
                <div class="Hdrive text-center my-3">
                    <div class="container">
                        <div class="col-md-12">
                            <div class="section-title">
                                <h2>My Spare Parts</h2>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($spareParts as $sparePart)
                <div class="dashboard-container my-list">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 mt-3">                               
                                <div class="listing-container">
                                <a href="{{ route('sparepart', $sparePart->id)}}">
				<div class="listing-image">
				  <img class="img-square-wrapper" src="/storage/photos/{{ $sparePart->front_img }}" alt="image description">
				</div>
                                    <!-- Spare Part Info -->
                                    <div class="listing-info">
                                        <div class="mdl-card__title">
                                            <h2 style="font-weight: 450; font-size:20px;" class="mdl-card__title-text">
                                                {{ $sparePart->make }} - {{ $sparePart->item_name }} <small><span style="color: red;"> </span></small>
                                            </h2>
                                        </div>
                                        <div class="mdl-card__supporting-text">
                                            <p class="card-text">
                                                <ul class="list-horizontal">
                                                    <li><b>Listing ID:</b> <span>{{ $sparePart->id }}</span></li>
                                                    <li><b>Price:</b> <span>{{ $sparePart->price }}</span></li>
                                                    <li><b>Condition:</b> <span>{{ $sparePart->condition }}</span></li>
                                                    <li><b>Location:</b> <span>{{ $sparePart->location }}</span></li>
                                                    <!-- Add other spare part details as needed -->
                                                </ul>
                                                <a href="" class="invoice-link">Invoice</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-list-footer">
                                    <!-- Action Icons -->
                                    <small class="text-muted">
                                        <div class="change-icons">
                                            <td class="action" data-title="Action">
                                                <div class="change-icons">
                                                    <ul class="list-inline justify-content-center">
                                                        <li class="list-inline-item">
                                                            <a data-toggle="tooltip" data-placement="top" title="View" class="view" href="#">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a data-toggle="tooltip" data-placement="top" title="Edit" class="edit"
                                                                href="">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0)"
                                                                onclick="$(this).parent().find('form').submit()" data-toggle="tooltip"
                                                                data-placement="top" title="Delete" class="delete">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                            <form action="" method="post"
                                                                onsubmit="return confirm('Are you sure want to delete?');">
                                                                @method('DELETE')
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </div>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <h1> No Spare Parts Found... Please Add your first Spare Part </h1>
            @endif
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
</section>
@endsection
