<div class="space-y-6">
    <section class="rounded-2xl border border-slate-800/80 bg-slate-900/80 shadow-2xl shadow-black/20 backdrop-blur">
        <div class="flex flex-col gap-4 border-b border-slate-800 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
            <div class="flex items-start gap-3">
                <div class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-2 text-amber-300">
                    <svg class="h-5 w-5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="m20 20-3.5-3.5"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-display text-lg font-semibold text-white">Search Inventory</h2>
                    <p class="text-sm text-slate-400">Filter by make, model, city, and budget.</p>
                </div>
            </div>
            <span class="text-xs font-medium uppercase tracking-wide text-slate-400">{{ number_format($vehicles->total()) }} listings</span>
        </div>

        <div class="space-y-3 p-4 sm:p-5">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-5">
                <select wire:model.live="make" class="h-11 w-full rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 focus:border-amber-400 focus:outline-none">
                    <option value="">Choose a Make</option>
                    @foreach($makes as $makeOption)
                        <option value="{{ $makeOption->id }}">{{ $makeOption->make }}</option>
                    @endforeach
                </select>

                <select wire:model.live="model" class="h-11 w-full rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 focus:border-amber-400 focus:outline-none" {{ $make === '' ? 'disabled' : '' }}>
                    <option value="">Choose a Model</option>
                    @foreach($models as $modelOption)
                        <option value="{{ $modelOption->id }}">{{ $modelOption->model }}</option>
                    @endforeach
                </select>

                <select wire:model.live="city" class="h-11 w-full rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 focus:border-amber-400 focus:outline-none">
                    <option value="">Select City</option>
                    @foreach($cities as $cityOption)
                        <option value="{{ $cityOption->id }}">{{ $cityOption->city }}</option>
                    @endforeach
                </select>

                <input wire:model.live.debounce.400ms="minPrice" type="number" min="0" placeholder="Min Budget" class="h-11 w-full rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none">
                <input wire:model.live.debounce.400ms="maxPrice" type="number" min="0" placeholder="Max Budget" class="h-11 w-full rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none">
            </div>

            <div class="flex items-center gap-4">
                <button type="button" wire:click="clearFilters" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">
                    Reset filters
                </button>
                <span wire:loading.inline-flex class="text-xs text-slate-400">Updating results...</span>
            </div>
        </div>
    </section>

    <section wire:loading.remove>
        @if($vehicles->count())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($vehicles as $vehicle)
                    @include('livewire.partials.marketplace-card', ['vehicle' => $vehicle, 'badge' => 'Live'])
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
                <p class="font-display text-xl font-semibold text-white">No vehicles found</p>
                <p class="mt-2 text-sm text-slate-400">Try adjusting your filters to broaden results.</p>
            </div>
        @endif
    </section>

    <section wire:loading>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @for($i = 0; $i < 6; $i++)
                <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
                    <div class="aspect-[4/3] animate-pulse bg-slate-800"></div>
                    <div class="space-y-3 p-4">
                        <div class="h-4 w-3/4 animate-pulse rounded bg-slate-800"></div>
                        <div class="h-3 w-1/2 animate-pulse rounded bg-slate-800"></div>
                        <div class="h-3 w-2/3 animate-pulse rounded bg-slate-800"></div>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <section wire:loading.remove class="pt-2">
        {{ $vehicles->links() }}
    </section>
</div>
