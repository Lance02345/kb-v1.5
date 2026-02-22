<section class="landing-section landing-drive">
  <div class="container">
    <div class="landing-search-shell landing-livewire-search mb-4" role="region" aria-label="Vehicle filters">
      <div class="row">
        <div class="col-md-2 mb-2">
          <select wire:model.live="make" class="form-control" aria-label="Choose make">
            <option value="">Choose a Make</option>
            @foreach($makes as $makeOption)
              <option value="{{ $makeOption->id }}">{{ $makeOption->make }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 mb-2">
          <select wire:model.live="model" class="form-control" aria-label="Choose model">
            <option value="">Choose a model</option>
            @foreach($models as $modelOption)
              <option value="{{ $modelOption->id }}">{{ $modelOption->model }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 mb-2">
          <select wire:model.live="city" class="form-control" aria-label="Choose city">
            <option value="">Select City</option>
            @foreach($cities as $cityOption)
              <option value="{{ $cityOption->id }}">{{ $cityOption->city }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 mb-2">
          <input wire:model.live.debounce.400ms="minPrice" type="number" min="0" class="form-control" placeholder="Min Price" aria-label="Minimum price">
        </div>
        <div class="col-md-2 mb-2">
          <input wire:model.live.debounce.400ms="maxPrice" type="number" min="0" class="form-control" placeholder="Max Price" aria-label="Maximum price">
        </div>
        <div class="col-md-2 mb-2 d-flex">
          <button type="button" wire:click="clearFilters" class="btn btn-outline-main w-100">Reset</button>
        </div>
      </div>
    </div>

    <div class="landing-section-head text-center">
      <h2>Find Your Drive</h2>
      <p>Fresh marketplace inventory across every budget and style.</p>
    </div>

    <div wire:loading.flex class="landing-loading">Updating listings...</div>

    <div class="row" wire:loading.remove>
      @forelse($vehicles as $vehicle)
        @php
          $listing = $vehicle->listing;
        @endphp
        <div class="col-sm-6 col-md-4 col-lg-4 mb-3 d-flex">
          <article class="landing-vehicle-card">
            <div class="landing-card-shell">
              <a class="landing-card-media" href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}">
                <img class="landing-card-image" src="/storage/photos/{{ $vehicle->front_img }}" alt="{{ $vehicle->title ?? 'Vehicle image' }}">
                <span class="landing-card-badge">Live</span>
              </a>
              <div class="landing-card-body">
                <h4 class="landing-card-title">
                  <a href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}">{{ $vehicle->carmodel->carmake->make ?? '' }} {{ $vehicle->carmodel->model ?? '' }} {{ $vehicle->year_of_build }}</a>
                </h4>
                <ul class="landing-meta">
                  <li><a href="{{ route('vehicle', [$listing->id, $vehicle->id]) }}">{{ optional($listing->category)->category_name }}</a></li>
                  <li><a href="#">{{ optional($listing->city)->city }}</a></li>
                </ul>
                <ul class="landing-spec-list">
                  <li><b>Engine</b><span>{{ $vehicle->engine_size }}</span></li>
                  <li><b>Trans</b><span>{{ $vehicle->transmission }}</span></li>
                  <li><b>Miles</b><span>{{ number_format((float) $vehicle->mileage, 0, '.', ',') }} Km</span></li>
                  <li><b>Fuel</b><span>{{ $vehicle->fuel_type }}</span></li>
                </ul>
                <div class="landing-price-row">
                  <p class="landing-sale-tag">For Sale</p>
                  <p class="landing-price-value">Ksh {{ number_format((float) $vehicle->price) }}</p>
                </div>
              </div>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12">
          <div class="landing-empty-state text-center">
            <h4 class="mb-2">No vehicles found</h4>
            <p>Try adjusting your filters to broaden results.</p>
          </div>
        </div>
      @endforelse
    </div>

    <div class="landing-pagination mt-3" wire:loading.remove>
      {{ $vehicles->links() }}
    </div>
  </div>
</section>
