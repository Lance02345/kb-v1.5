@extends('layouts.kingsbridge')
@section('content')

<section class="section-sm seller-dashboard-page">
  <div class="container">
    @if(session('success'))
      <div class="mt-3 alert {{ session('action_success') ? 'alert-info seller-action-toast' : 'alert-success' }}">
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @php
      $pool = $allListings ?? $listings;
      $total = $pool->count();
      $active = $pool->filter(fn($l) => strtolower((string) $l->ads_status) === 'approved' || strtolower((string) $l->ads_status) === 'active')->count();
      $pending = $pool->filter(fn($l) => strtolower((string) $l->ads_status) === 'pending')->count();
      $sold = $pool->filter(fn($l) => strtolower((string) $l->ads_status) === 'sold')->count();
      $expired = $pool->filter(fn($l) => strtolower((string) $l->ads_status) === 'expired')->count();
    @endphp

    <div class="seller-dashboard-head mb-4">
      <div>
        <h2>{{ $pageTitle ?? 'My Listings Dashboard' }}</h2>
        <p>Manage your listings, track performance, and publish faster.</p>
      </div>
      <div class="seller-dashboard-actions">
        <a href="{{ route('user.new_listing') }}" class="btn btn-main">New Listing</a>
        @if(!empty($statusFilter))
          <a href="{{ route('user.index_vehiclesale') }}" class="btn btn-outline-main">Back to All</a>
        @else
          <a href="{{ route('user.pending_list') }}" class="btn btn-outline-main">Pending Review</a>
        @endif
      </div>
    </div>

    @if(!empty($alerts) && (($alerts['pending'] ?? 0) > 0 || ($alerts['low_views'] ?? 0) > 0 || ($alerts['expiring_soon'] ?? 0) > 0))
      <div class="seller-alerts-wrap mb-4">
        @if(($alerts['pending'] ?? 0) > 0)
          <a href="{{ route('user.pending_list') }}" class="seller-alert-item">
            <span>{{ $alerts['pending'] }} pending listing(s) need review follow-up.</span>
          </a>
        @endif

        @if(($alerts['low_views'] ?? 0) > 0)
          <a href="{{ route('user.index_vehiclesale') }}" class="seller-alert-item">
            <span>{{ $alerts['low_views'] }} listing(s) have low views. Consider better photos or boosting.</span>
          </a>
        @endif

        @if(($alerts['expiring_soon'] ?? 0) > 0)
          <a href="{{ route('user.expired_list') }}" class="seller-alert-item">
            <span>{{ $alerts['expiring_soon'] }} listing(s) are expiring within 7 days.</span>
          </a>
        @endif
      </div>
    @endif

    @if(!empty($analytics))
      <div class="seller-analytics-wrap mb-4">
        <div class="seller-analytics-card">
          <span>Total Views</span>
          <strong>{{ number_format($analytics['total_views'] ?? 0) }}</strong>
        </div>
        <div class="seller-analytics-card">
          <span>Avg Views / Listing</span>
          <strong>{{ $analytics['average_views'] ?? 0 }}</strong>
        </div>
        <div class="seller-analytics-card seller-analytics-card-wide">
          <span>Top Performing Listings</span>
          @if(!empty($analytics['top_listings']) && count($analytics['top_listings']) > 0)
            <ul>
              @foreach($analytics['top_listings'] as $top)
                <li>
                  <a href="{{ route('user.show_vehiclesale', [$top['listing']->id, $top['vehicle']->id]) }}">
                    {{ $top['vehicle']->carmodel->carmake->make ?? '' }} {{ $top['vehicle']->carmodel->model ?? '' }}
                  </a>
                  <small>{{ $top['vehicle']->views }} views</small>
                </li>
              @endforeach
            </ul>
          @else
            <p>No view data yet.</p>
          @endif
        </div>
      </div>
    @endif

    <div class="seller-status-tabs mb-4">
      <a href="{{ route('user.index_vehiclesale') }}" class="seller-status-tab {{ empty($statusFilter) ? 'active' : '' }}">All <span>{{ $total }}</span></a>
      <a href="{{ route('user.active_list') }}" class="seller-status-tab {{ ($statusFilter ?? '') === 'Approved' ? 'active' : '' }}">Active <span>{{ $active }}</span></a>
      <a href="{{ route('user.pending_list') }}" class="seller-status-tab {{ ($statusFilter ?? '') === 'Pending' ? 'active' : '' }}">Pending <span>{{ $pending }}</span></a>
      <a href="{{ route('user.sold_list') }}" class="seller-status-tab {{ ($statusFilter ?? '') === 'Sold' ? 'active' : '' }}">Sold <span>{{ $sold }}</span></a>
      <a href="{{ route('user.expired_list') }}" class="seller-status-tab {{ ($statusFilter ?? '') === 'Expired' ? 'active' : '' }}">Expired <span>{{ $expired }}</span></a>
    </div>

    <form action="{{ url()->current() }}" method="get" class="seller-filter-form mb-4">
      <div class="seller-filter-group">
        <input type="text" name="q" class="form-control" placeholder="Search by make, model, city or listing ID" value="{{ $searchQuery ?? '' }}">
      </div>
      <div class="seller-filter-group">
        <select name="sort" class="form-control">
          <option value="newest" {{ ($sortBy ?? 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
          <option value="oldest" {{ ($sortBy ?? '') === 'oldest' ? 'selected' : '' }}>Oldest</option>
          <option value="price_low" {{ ($sortBy ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
          <option value="price_high" {{ ($sortBy ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
          <option value="views_high" {{ ($sortBy ?? '') === 'views_high' ? 'selected' : '' }}>Most Viewed</option>
        </select>
      </div>
      <div class="seller-filter-group seller-filter-actions">
        <button type="submit" class="btn btn-main btn-sm">Apply</button>
        <a href="{{ url()->current() }}" class="btn btn-outline-main btn-sm">Reset</a>
      </div>
    </form>

    <div class="row seller-stat-row mb-4">
      <div class="col-6 col-md-2 mb-3">
        <div class="seller-stat-card">
          <span>Total</span>
          <strong>{{ $total }}</strong>
        </div>
      </div>
      <div class="col-6 col-md-2 mb-3">
        <div class="seller-stat-card">
          <span>Active</span>
          <strong>{{ $active }}</strong>
        </div>
      </div>
      <div class="col-6 col-md-2 mb-3">
        <div class="seller-stat-card">
          <span>Pending</span>
          <strong>{{ $pending }}</strong>
        </div>
      </div>
      <div class="col-6 col-md-2 mb-3">
        <div class="seller-stat-card">
          <span>Sold</span>
          <strong>{{ $sold }}</strong>
        </div>
      </div>
      <div class="col-6 col-md-2 mb-3">
        <div class="seller-stat-card">
          <span>Expired</span>
          <strong>{{ $expired }}</strong>
        </div>
      </div>
      <div class="col-6 col-md-2 mb-3">
        <div class="seller-stat-card seller-stat-card-link">
          <a href="{{ route('user.new_listing') }}">Add Listing</a>
        </div>
      </div>
    </div>

    @if ($listings->isEmpty())
      <div class="seller-empty-state text-center">
        <h3>No listings in this status</h3>
        <p>Create a new listing or switch status tabs to view other listings.</p>
        <a href="{{ route('user.new_listing') }}" class="btn btn-main">Create Listing</a>
      </div>
    @else
      <div class="seller-listings-grid">
        @foreach($listings as $listing)
          @php
            $vehicle = $vehicles->firstWhere('listing_id', $listing->id);
          @endphp
          @continue(!$vehicle)

          @php
            $status = strtolower((string) $listing->ads_status);
            $statusClass = 'status-pending';
            if ($status === 'approved' || $status === 'active') {
              $statusClass = 'status-active';
            } elseif ($status === 'sold') {
              $statusClass = 'status-sold';
            } elseif ($status === 'expired') {
              $statusClass = 'status-expired';
            }
          @endphp

          <article class="seller-listing-card">
            <a href="{{ route('user.show_vehiclesale', [$listing->id, $vehicle->id]) }}" class="seller-listing-image-wrap">
              <img class="seller-listing-image" src="/storage/photos/{{ $vehicle->front_img }}" alt="{{ $vehicle->title ?? 'Vehicle image' }}">
            </a>
            <div class="seller-listing-body">
              <div class="seller-listing-top">
                <h4>
                  {{ $vehicle->carmodel->carmake->make ?? '' }}
                  {{ $vehicle->carmodel->model ?? '' }}
                  {{ $vehicle->year_of_build }}
                </h4>
                <span class="seller-status-badge {{ $statusClass }}">{{ $listing->ads_status }}</span>
              </div>

              @php
                $listingQuality = $quality[$listing->id] ?? ['score' => 0, 'missing' => []];
              @endphp
              <div class="seller-quality-row">
                <span class="seller-quality-label">Listing Quality</span>
                <span class="seller-quality-score">{{ $listingQuality['score'] }}%</span>
              </div>

              <ul class="seller-meta-list">
                <li><strong>Listing ID:</strong> {{ $listing->id }}</li>
                <li><strong>Price:</strong> Ksh {{ number_format((float) $vehicle->price) }}</li>
                <li><strong>Type:</strong> {{ $vehicle->vehicle_type }}</li>
                <li><strong>Views:</strong> {{ $vehicle->views }}</li>
                <li><strong>City:</strong> {{ optional($listing->city)->city }}</li>
                <li><strong>Created:</strong> {{ optional($listing->created_at)->format('d M Y') }}</li>
              </ul>

              @php
                $tips = $recommendations[$listing->id] ?? [];
              @endphp
              @if(count($tips) > 0)
                <div class="seller-recommendations mb-2">
                  @foreach($tips as $tip)
                    <p>{{ $tip }}</p>
                  @endforeach
                </div>
              @endif

              @if(!empty($listingQuality['missing']))
                <div class="seller-missing-items mb-2">
                  <strong>Missing/Improve:</strong>
                  {{ implode(', ', $listingQuality['missing']) }}
                </div>
              @endif

              <div class="seller-listing-actions">
                <a href="{{ route('user.packages', $listing->id) }}" class="btn btn-sm btn-outline-main">Boost</a>
                <a href="{{ route('user.show_vehiclesale', [$listing->id, $vehicle->id]) }}" class="btn btn-sm btn-outline-main">View</a>
                <a href="{{ route('user.edit_vehiclesale', [$listing->id, $vehicle->id]) }}" class="btn btn-sm btn-outline-main">Edit</a>

                @if($status !== 'sold')
                  <form action="{{ route('user.listing.quick_action', $listing->id) }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="action" value="mark_sold">
                    <button type="submit" class="btn btn-sm btn-outline-main">Mark Sold</button>
                  </form>
                @endif

                @if($status !== 'approved' && $status !== 'active')
                  <form action="{{ route('user.listing.quick_action', $listing->id) }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="action" value="mark_active">
                    <button type="submit" class="btn btn-sm btn-outline-main">Mark Active</button>
                  </form>
                @endif

                <form action="{{ route('user.listing.quick_action', $listing->id) }}" method="post" class="d-inline">
                  @csrf
                  <input type="hidden" name="action" value="renew_30d">
                  <button type="submit" class="btn btn-sm btn-outline-main">Renew 30d</button>
                </form>

                <form action="{{ route('user.delete_vehiclesale', [$listing->id, $vehicle->id]) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this listing?');" class="d-inline">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
