<section class="max-w-7xl mx-auto px-4 sm:px-6 -mt-8 relative z-20 pb-16 space-y-6">
  <div class="bg-gray-900 rounded-lg shadow border border-gray-800 p-4 sm:p-5">
    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
      <div class="flex items-center gap-3">
        <div class="p-2 rounded-md bg-amber-500/10">
          <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <div>
          <h2 class="font-semibold text-gray-100 text-sm">Search Inventory</h2>
          <p class="text-xs text-gray-500">Filter by make, model, city, and budget.</p>
        </div>
      </div>
      <span class="text-xs font-medium text-gray-500">{{ number_format($vehicles->total()) }} listings</span>
    </div>

    <div class="pt-4 space-y-3">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
        <select wire:model.live="make" class="w-full h-10 px-3 rounded-md bg-gray-800 border border-gray-700 text-sm text-gray-200" aria-label="Choose make">
          <option value="">Choose a Make</option>
          @foreach($makes as $makeOption)
            <option value="{{ $makeOption->id }}">{{ $makeOption->make }}</option>
          @endforeach
        </select>

        <select wire:model.live="model" class="w-full h-10 px-3 rounded-md bg-gray-800 border border-gray-700 text-sm text-gray-200" aria-label="Choose model">
          <option value="">Choose a Model</option>
          @foreach($models as $modelOption)
            <option value="{{ $modelOption->id }}">{{ $modelOption->model }}</option>
          @endforeach
        </select>

        <select wire:model.live="city" class="w-full h-10 px-3 rounded-md bg-gray-800 border border-gray-700 text-sm text-gray-200" aria-label="Choose city">
          <option value="">Select City</option>
          @foreach($cities as $cityOption)
            <option value="{{ $cityOption->id }}">{{ $cityOption->city }}</option>
          @endforeach
        </select>

        <input wire:model.live.debounce.400ms="minPrice" type="number" min="0" placeholder="Min Budget" class="w-full h-10 px-3 rounded-md bg-gray-800 border border-gray-700 text-sm text-gray-200" aria-label="Minimum price" />

        <input wire:model.live.debounce.400ms="maxPrice" type="number" min="0" placeholder="Max Budget" class="w-full h-10 px-3 rounded-md bg-gray-800 border border-gray-700 text-sm text-gray-200" aria-label="Maximum price" />

        <button type="button" wire:click="clearFilters" class="w-full h-10 px-4 bg-amber-500 text-gray-950 rounded-md text-xs font-semibold hover:bg-amber-400 transition">Reset Filters</button>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" wire:loading.remove>
    @forelse($vehicles as $vehicle)
      @include('partials.vehicle-card', ['vehicle' => $vehicle, 'listing' => $vehicle->listing, 'badge' => 'Live'])
    @empty
      <div class="col-span-full flex items-center justify-center py-20">
        <div class="text-center space-y-2">
          <h3 class="font-semibold text-gray-100">No vehicles found</h3>
          <p class="text-sm text-gray-500">Try adjusting your filters to broaden results.</p>
        </div>
      </div>
    @endforelse
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" wire:loading.block>
    @for ($i = 0; $i < 8; $i++)
      <div class="rounded-lg overflow-hidden bg-gray-900 border border-gray-800 animate-pulse">
        <div class="aspect-[4/3] bg-gray-800"></div>
        <div class="p-4 space-y-3">
          <div class="h-4 bg-gray-800 rounded w-5/6"></div>
          <div class="h-3 bg-gray-800 rounded w-2/3"></div>
          <div class="grid grid-cols-2 gap-2">
            <div class="h-3 bg-gray-800 rounded"></div>
            <div class="h-3 bg-gray-800 rounded"></div>
          </div>
        </div>
      </div>
    @endfor
  </div>

  <div class="flex justify-center [&_nav]:text-gray-300 [&_.page-link]:bg-gray-900 [&_.page-link]:border-gray-700 [&_.page-link]:text-gray-200 [&_.active_.page-link]:bg-amber-500 [&_.active_.page-link]:border-amber-500 [&_.active_.page-link]:text-gray-950" wire:loading.remove>
    {{ $vehicles->links() }}
  </div>
</section>
