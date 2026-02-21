@extends('layouts.kingsbridge')
@section('content')

<section class="section-sm seller-create-hub">
  <div class="container">
    <div class="seller-dashboard-head mb-4">
      <div>
        <h2>Start a New Listing</h2>
        <p>Select what you want to list. You can always manage everything from your listings dashboard.</p>
      </div>
      <div class="seller-dashboard-actions">
        <a href="{{ route('user.index_vehiclesale') }}" class="btn btn-outline-main">My Listings</a>
        <a href="{{ route('user.user_profile', Auth::user()->id ) }}" class="btn btn-main">Profile</a>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-lg-3 mb-3">
        <div class="seller-option-card">
          <h4>Vehicle Sale</h4>
          <p>Post a car for sale with photos, specs, and pricing.</p>
          <a href="{{ route('user.create_vehiclesale') }}" class="btn btn-main btn-sm">Choose</a>
        </div>
      </div>

      <div class="col-md-6 col-lg-3 mb-3">
        <div class="seller-option-card">
          <h4>Car Hire</h4>
          <p>List vehicles available for short or long-term hire.</p>
          <a href="{{ route('user.create_carhire') }}" class="btn btn-main btn-sm">Choose</a>
        </div>
      </div>

      <div class="col-md-6 col-lg-3 mb-3">
        <div class="seller-option-card">
          <h4>Car Event</h4>
          <p>Promote your event to enthusiasts across the platform.</p>
          <a href="{{ route('user.create_carevent') }}" class="btn btn-main btn-sm">Choose</a>
        </div>
      </div>

      <div class="col-md-6 col-lg-3 mb-3">
        <div class="seller-option-card">
          <h4>Spare Parts</h4>
          <p>Advertise spare parts and accessories to buyers.</p>
          <a href="{{ route('user.sparepartscreate') }}" class="btn btn-main btn-sm">Choose</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
