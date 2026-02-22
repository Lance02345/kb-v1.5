<section class="landing-section landing-drive">
  <div class="container">
    <div class="landing-search-shell landing-livewire-search mb-4 landing-search-lift" role="region" aria-label="Vehicle filters">
      <div class="landing-search-head d-flex flex-wrap justify-content-between align-items-center mb-2">
        <div>
          <h3>Search Inventory</h3>
          <p>Filter by make, model, city, and budget.</p>
        </div>
        <span class="landing-search-count">{{ number_format($vehicles->total()) }} listings</span>
      </div>
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
          <button type="button" wire:click="clearFilters" class="btn btn-outline-main w-100">Reset Filters</button>
        </div>
      </div>
    </div>

    <div class="landing-section-head text-center">
      <h2>Find Your Drive</h2>
      <p>Fresh marketplace inventory across every budget and style.</p>
    </div>

    <div wire:loading.block>
      <div class="row">
        @for ($i = 0; $i < 6; $i++)
          <div class="col-sm-6 col-md-4 col-lg-4 mb-3 d-flex">
            <div class="landing-skeleton-card w-100">
              <div class="landing-skeleton-media"></div>
              <div class="landing-skeleton-body">
                <div class="landing-skeleton-line w-85"></div>
                <div class="landing-skeleton-line w-65"></div>
                <div class="landing-skeleton-line w-100"></div>
                <div class="landing-skeleton-line w-55"></div>
              </div>
            </div>
          </div>
        @endfor
      </div>
    </div>

    <div class="row" wire:loading.remove>
      @forelse($vehicles as $vehicle)
        @php
          $listing = $vehicle->listing;
        @endphp
        <div class="col-sm-6 col-md-4 col-lg-4 mb-3 d-flex">
          @include('partials.vehicle-card', ['vehicle' => $vehicle, 'listing' => $listing, 'badge' => 'Live'])
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
