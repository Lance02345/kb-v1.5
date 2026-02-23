<section class="df-main container">
  <div class="df-filter-shell" role="region" aria-label="Vehicle filters">
    <div class="df-filter-head">
      <div class="df-filter-title-wrap">
        <span class="df-filter-icon" aria-hidden="true"><i class="fa fa-search"></i></span>
        <div>
          <h2>Search Inventory</h2>
          <p>Filter by make, model, city, and budget.</p>
        </div>
      </div>
      <span class="df-count">{{ number_format($vehicles->total()) }} listings</span>
    </div>

    <div class="df-filter-grid">
      <select wire:model.live="make" class="df-control" aria-label="Choose make">
        <option value="">Choose a Make</option>
        @foreach($makes as $makeOption)
          <option value="{{ $makeOption->id }}">{{ $makeOption->make }}</option>
        @endforeach
      </select>

      <select wire:model.live="model" class="df-control" aria-label="Choose model">
        <option value="">Choose a Model</option>
        @foreach($models as $modelOption)
          <option value="{{ $modelOption->id }}">{{ $modelOption->model }}</option>
        @endforeach
      </select>

      <select wire:model.live="city" class="df-control" aria-label="Choose city">
        <option value="">Select City</option>
        @foreach($cities as $cityOption)
          <option value="{{ $cityOption->id }}">{{ $cityOption->city }}</option>
        @endforeach
      </select>

      <input wire:model.live.debounce.400ms="minPrice" type="number" min="0" placeholder="Min Budget" class="df-control" aria-label="Minimum price" />

      <input wire:model.live.debounce.400ms="maxPrice" type="number" min="0" placeholder="Max Budget" class="df-control" aria-label="Maximum price" />

      <button type="button" wire:click="clearFilters" class="df-reset-btn">Reset Filters</button>
    </div>
  </div>

  <div class="df-grid" wire:loading.remove>
    @forelse($vehicles as $vehicle)
      @include('partials.vehicle-card', ['vehicle' => $vehicle, 'listing' => $vehicle->listing, 'badge' => 'Live'])
    @empty
      <div class="df-empty">
        <h3>No vehicles found</h3>
        <p>Try adjusting your filters to broaden results.</p>
      </div>
    @endforelse
  </div>

  <div class="df-grid" wire:loading.block>
    @for ($i = 0; $i < 8; $i++)
      <div class="df-card-skeleton">
        <div class="df-card-skeleton-media"></div>
        <div class="df-card-skeleton-body">
          <div class="df-skeleton-line w-80"></div>
          <div class="df-skeleton-line w-60"></div>
          <div class="df-skeleton-line w-90"></div>
        </div>
      </div>
    @endfor
  </div>

  <div class="df-pagination" wire:loading.remove>
    {{ $vehicles->links() }}
  </div>
</section>
