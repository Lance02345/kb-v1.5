@extends('layouts.kingsbridge')
@section('content')

<!--==================================
=            User Profile            =
===================================-->
<section class="section-sm">
    <div class="container ">
        <div class="row  m-auto" style="margin: auto;">
            <div class="col-lg-12">
                <div class="heading text-center pb-5">
                    <h2 class="font-weight-bold">Featured Categories</h2>
                </div>
            </div>
           
            <div class="col-lg-3 col-md-6">
                <div class="package-content bg-light border text-center p-5 my-2 my-lg-0">
                    <div class="package-content-heading border-bottom">
                        <i class="fa fa-car"></i>
                        <h2>Car Hire</h2>
                     
                    </div>
                    <ul>
                        <li class="my-4"> <i class="fa fa-check"></i> Click the "choose" to countinue with listing process</li>
                    </ul>
                    <a href="{{ route('user.create_carhire')}}" class="btn btn-primary">Choose</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="package-content bg-light border text-center my-2 my-lg-0 p-5">
                    <div class="package-content-heading border-bottom">
                            <i class="fa fa-car"></i>
                        <h2>Sale Vehicle </h2>
                 
                    </div>
                    <ul>
                        <li class="my-4"> <i class="fa fa-check"></i> Click the "choose" to countinue with listing process</li>
                
                    </ul>
                    <a href="{{ route('user.create_vehiclesale')}}" class="btn btn-primary">Choose</a>
                </div>
            </div>
 
            <div class="col-lg-3 col-md-6">
                <div class="package-content bg-light border text-center my-2 my-lg-0 p-5">
                    <div class="package-content-heading border-bottom">
                            <i class="fa fa-car"></i>
                        <h2> Car Event</h2>
                 
                    </div>
                    <ul>
                        <li class="my-4"> <i class="fa fa-check"></i> Click the "choose" to countinue with listing process</li>
                
                    </ul>
                    <a href="{{ route('user.create_carevent')}}" class="btn btn-primary">Choose</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="package-content bg-light border text-center my-2 my-lg-0 p-5">
                    <div class="package-content-heading border-bottom">
                            <i class="fa fa-car"></i>
                        <h2>Spare Parts</h2>
                 
                    </div>
                    <ul>
                        <li class="my-4"> <i class="fa fa-check"></i> Click the "choose" to countinue with listing process</li>
                
                    </ul>
                    <a href="{{ route('user.sparepartscreate')}}" class="btn btn-primary">Choose</a>
                </div>
            </div>


        </div>
    </div>
</section>
@endsection