<div class="space-y-6">
    @php
        $activeFilterCount = count(array_filter([
            $make ?? '',
            $model ?? '',
            $city ?? '',
            $minPrice ?? '',
            $maxPrice ?? '',
            trim((string) ($search ?? '')),
        ], fn ($value) => $value !== null && $value !== ''));
    @endphp
    <style>
        .kb-mobile-grid {
            grid-template-columns: repeat(var(--kb-mobile-columns, 1), minmax(0, 1fr));
        }

        @media (min-width: 640px) {
            .kb-mobile-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1280px) {
            .kb-mobile-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }
    </style>

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

        <div class="space-y-4 p-4 sm:p-5">
            <div class="space-y-1 relative">
                <input wire:model.live.debounce.400ms="search" id="vehicle-search-input" type="text" placeholder="Type make, model, city, or keyword" autocomplete="off" class="h-11 w-full rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none">
                <div wire:ignore>
                    <div id="vehicle-search-suggestions" class="absolute left-0 right-0 top-full z-20 mt-1 hidden translate-y-1 overflow-hidden rounded-2xl border border-slate-700 bg-slate-900 text-sm shadow-2xl">
                        <ul id="vehicle-search-suggestions-list" class="space-y-1 p-3 text-xs text-slate-300"></ul>
                        <p class="border-t border-slate-800 px-3 py-2 text-[10px] uppercase tracking-wider text-slate-500">Tap a suggestion or keep typing to filter.</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500">Typing will automatically trim the search string and look for the closest matches.</p>
            </div>
            @auth
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <span id="save-search-feedback" class="text-xs font-semibold uppercase tracking-wide text-emerald-300 opacity-0 transition-opacity duration-200">Search saved</span>
                    <button type="button" id="save-search-btn" class="rounded-full border border-emerald-400/40 bg-emerald-400/10 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-200 transition hover:border-emerald-300 hover:text-emerald-100">Save this search & alert me</button>
                </div>
            @endauth
            <div class="md:hidden">
                <button
                    type="button"
                    data-mobile-filter-toggle
                    aria-expanded="false"
                    class="flex w-full items-center justify-between rounded-2xl border border-slate-800 bg-slate-950/60 px-4 py-3 text-left"
                >
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Filters</p>
                        <p class="mt-1 text-sm text-slate-300">{{ $activeFilterCount ? $activeFilterCount . ' active' : 'Tap to refine make, city, and budget' }}</p>
                    </div>
                    <span data-mobile-filter-icon class="text-lg font-semibold text-amber-300">+</span>
                </button>
            </div>

            <div data-mobile-filter-panel class="hidden space-y-4 md:block">
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

            <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-800 bg-slate-950/60 p-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Mobile Layout</p>
                    <p class="mt-1 text-xs text-slate-500">Switch between 1 or 2 cars per row on smaller screens.</p>
                </div>
                <div class="inline-flex rounded-full border border-slate-700 bg-slate-900 p-1">
                    @foreach([1, 2] as $columns)
                        <button
                            type="button"
                            wire:click="setMobileColumns({{ $columns }})"
                            class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ $mobileColumns === $columns ? 'bg-amber-300 text-slate-950' : 'text-slate-300 hover:text-white' }}"
                            aria-pressed="{{ $mobileColumns === $columns ? 'true' : 'false' }}"
                        >
                            {{ $columns }} {{ $columns === 1 ? 'card' : 'cards' }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @include('partials.comparison-drawer')

    <section wire:loading.remove>
        @if($vehicles->count())
            <div class="kb-mobile-grid grid gap-4" style="--kb-mobile-columns: {{ $mobileColumns }};">
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
        <div class="kb-mobile-grid grid gap-4" style="--kb-mobile-columns: {{ $mobileColumns }};">
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
        {{ $vehicles->links('vehicles._pagination') }}
    </section>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const suggestionEndpoint = @json(route('search.suggestions'));
        const input = document.getElementById('vehicle-search-input');
        const panel = document.getElementById('vehicle-search-suggestions');
        const list = document.getElementById('vehicle-search-suggestions-list');
        if (input && panel && list) {
            let debounceTimer;
            let abortController;

            const hidePanel = () => panel.classList.add('hidden');
            const showPanel = () => panel.classList.remove('hidden');

            const renderSuggestions = (suggestions) => {
                list.innerHTML = '';
                if (!suggestions.length) {
                    const empty = document.createElement('li');
                    empty.className = 'px-3 py-2 text-xs text-slate-500';
                    empty.textContent = 'No suggestions';
                    list.appendChild(empty);
                    showPanel();
                    return;
                }

                suggestions.forEach((suggestion) => {
                    const label = suggestion.label || suggestion.value || '';
                    const typeLabel = suggestion.type ? suggestion.type.toUpperCase() : 'RESULT';
                    const item = document.createElement('li');
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'w-full text-left text-xs text-slate-200 hover:text-white focus:text-white focus:outline-none';
                    button.dataset.value = suggestion.value || '';
                    if (suggestion.url) {
                        button.dataset.url = suggestion.url;
                    }

                    const labelSpan = document.createElement('span');
                    labelSpan.className = 'font-semibold text-slate-100';
                    labelSpan.textContent = label;

                    const typeSpan = document.createElement('span');
                    typeSpan.className = 'block text-[11px] text-slate-500';
                    typeSpan.textContent = typeLabel;

                    button.appendChild(labelSpan);
                    button.appendChild(typeSpan);
                    item.appendChild(button);
                    list.appendChild(item);
                });

                showPanel();
            };

            input.addEventListener('input', function () {
                const value = this.value.trim();
                if (value === '') {
                    hidePanel();
                    list.innerHTML = '';
                    return;
                }

                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    if (abortController) {
                        abortController.abort();
                    }
                    abortController = new AbortController();

                    fetch(suggestionEndpoint + '?q=' + encodeURIComponent(value), { signal: abortController.signal })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error('Request failed');
                            }
                            return response.json();
                        })
                        .then((data) => renderSuggestions(data.suggestions || []))
                        .catch((error) => {
                            if (error.name === 'AbortError') {
                                return;
                            }
                            hidePanel();
                        });
                }, 200);
            });

            document.addEventListener('click', (event) => {
                if (!panel.contains(event.target) && event.target !== input) {
                    hidePanel();
                }
            });

            panel.addEventListener('click', (event) => {
                const button = event.target.closest('button[data-value]');
                if (!button) {
                    return;
                }
                const url = button.dataset.url;
                const value = button.dataset.value;
                if (url) {
                    window.location.href = url;
                    return;
                }
                input.value = value;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                hidePanel();
            });
        }

        const syncMobileFilters = () => {
            const toggle = document.querySelector('[data-mobile-filter-toggle]');
            const panel = document.querySelector('[data-mobile-filter-panel]');
            const icon = document.querySelector('[data-mobile-filter-icon]');

            if (!toggle || !panel || window.innerWidth >= 768) {
                if (panel && window.innerWidth >= 768) {
                    panel.classList.remove('hidden');
                }
                return;
            }

            const expanded = toggle.getAttribute('aria-expanded') === 'true';
            panel.classList.toggle('hidden', !expanded);
            if (icon) {
                icon.textContent = expanded ? '−' : '+';
            }
        };

        document.addEventListener('click', (event) => {
            const toggle = event.target.closest('[data-mobile-filter-toggle]');
            if (!toggle) {
                return;
            }

            const expanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            syncMobileFilters();
        });

        window.addEventListener('resize', syncMobileFilters);
        syncMobileFilters();

        const compareRoute = @json(route('compare.index'));
        const drawer = document.getElementById('compare-drawer');
        const drawerList = document.getElementById('compare-drawer-list');
        const drawerCount = document.getElementById('compare-drawer-count');
        const drawerButton = document.getElementById('compare-drawer-button');
        const drawerClose = document.getElementById('compare-drawer-close');
        const drawerClear = document.getElementById('compare-drawer-clear');
        const comparisonKey = 'kb_compare_items';

        const getComparisonItems = () => {
            try {
                return JSON.parse(localStorage.getItem(comparisonKey) || '[]');
            } catch {
                return [];
            }
        };

        const setComparisonItems = (items) => {
            localStorage.setItem(comparisonKey, JSON.stringify(items));
        };

        const refreshCompareButtons = () => {
            const selectedIds = getComparisonItems().map(item => item.id);
            document.querySelectorAll('[data-compare-target]').forEach((button) => {
                const isActive = selectedIds.includes(button.dataset.vehicleId);
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                button.classList.toggle('border-amber-300', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('border-slate-700', !isActive);
            });
        };

        const removeComparisonItem = (vehicleId) => {
            const items = getComparisonItems();
            const index = items.findIndex(item => item.id === vehicleId);
            if (index === -1) {
                return;
            }

            items.splice(index, 1);
            setComparisonItems(items);
            renderComparisonDrawer();
        };

        const clearComparisonItems = () => {
            setComparisonItems([]);
            renderComparisonDrawer();
        };

        const renderComparisonDrawer = () => {
            if (!drawer || !drawerList || !drawerButton || !drawerCount) {
                return;
            }

            const items = getComparisonItems();
            drawerList.innerHTML = '';

            if (!items.length) {
                drawer.classList.add('hidden');
                drawer.classList.add('pointer-events-none');
                drawerCount.textContent = '';
                drawerButton.setAttribute('href', '#');
                refreshCompareButtons();
                if (drawerClear) {
                    drawerClear.disabled = true;
                    drawerClear.classList.add('opacity-40', 'cursor-not-allowed');
                }
                return;
            }

            drawer.classList.remove('hidden');
            drawer.classList.remove('pointer-events-none');
            items.forEach((item) => {
                const listItem = document.createElement('li');
                listItem.className = 'flex items-center gap-2 rounded-full bg-slate-950/70 px-3 py-1 text-slate-200';
                const thumb = document.createElement('img');
                thumb.src = item.image || 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=300&h=200&fit=crop';
                thumb.alt = item.label || 'Vehicle';
                thumb.className = 'h-7 w-9 rounded-md object-cover';
                const label = document.createElement('span');
                label.className = 'flex-1 truncate text-[11px] font-semibold';
                label.textContent = item.label || 'Vehicle';
                listItem.appendChild(thumb);
                listItem.appendChild(label);
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'ml-auto rounded-full border border-rose-400/40 bg-rose-500/10 px-2 py-0.5 text-[11px] font-semibold text-rose-300 transition hover:border-rose-300 hover:text-white';
                removeBtn.textContent = '×';
                removeBtn.setAttribute('aria-label', 'Remove from comparison');
                removeBtn.addEventListener('click', (event) => {
                    event.stopPropagation();
                    removeComparisonItem(item.id);
                });
                listItem.appendChild(removeBtn);
                drawerList.appendChild(listItem);
            });

            drawerCount.textContent = `${items.length} selected`;
            drawerButton.setAttribute('href', `${compareRoute}?ids=${items.map(item => item.id).join(',')}`);
            if (drawerClear) {
                drawerClear.disabled = false;
                drawerClear.classList.remove('opacity-40', 'cursor-not-allowed');
            }
            refreshCompareButtons();
        };

        const toggleComparison = (vehicle) => {
            const items = getComparisonItems();
            const existing = items.findIndex(item => item.id === vehicle.id);
            if (existing > -1) {
                items.splice(existing, 1);
            } else {
                if (items.length >= 4) {
                    alert('You can compare up to 4 vehicles at a time.');
                    return;
                }
                items.push(vehicle);
            }
            setComparisonItems(items);
            renderComparisonDrawer();
        };

        document.body.addEventListener('click', (event) => {
            const button = event.target.closest('[data-compare-target]');
            if (!button) {
                return;
            }
            event.preventDefault();
            toggleComparison({
                id: button.dataset.vehicleId,
                label: button.dataset.vehicleLabel,
                url: button.dataset.vehicleUrl,
                image: button.dataset.vehicleImage,
            });
        });

        if (drawerClose) {
            drawerClose.addEventListener('click', () => {
                drawer?.classList.add('hidden');
                drawer?.classList.add('pointer-events-none');
            });
        }

        if (drawerClear) {
            drawerClear.addEventListener('click', (event) => {
                event.preventDefault();
                clearComparisonItems();
            });
        }

        renderComparisonDrawer();

        @auth
        const saveButton = document.getElementById('save-search-btn');
        const feedback = document.getElementById('save-search-feedback');
        const saveEndpoint = @json(route('user.saved_searches.store'));
        const csrfToken = @json(csrf_token());

        const gatherFilters = () => {
            const filterElements = {
                make: document.querySelector('[wire\\:model\\.live=\"make\"]'),
                model: document.querySelector('[wire\\:model\\.live=\"model\"]'),
                city: document.querySelector('[wire\\:model\\.live=\"city\"]'),
                minPrice: document.querySelector('[wire\\:model\\.live=\"minPrice\"]'),
                maxPrice: document.querySelector('[wire\\:model\\.live=\"maxPrice\"]'),
            };

            const filters = {
                search: input?.value.trim() || '',
            };

            Object.entries(filterElements).forEach(([key, element]) => {
                if (element) {
                    filters[key] = element.value;
                }
            });

            return filters;
        };

        const showFeedback = (message, success = true) => {
            if (!feedback) {
                return;
            }
            feedback.textContent = message;
            feedback.classList.toggle('text-rose-300', !success);
            feedback.classList.toggle('text-emerald-300', success);
            feedback.classList.remove('opacity-0');
            setTimeout(() => feedback.classList.add('opacity-0'), 3000);
        };

        if (saveButton) {
            saveButton.addEventListener('click', () => {
                const filters = gatherFilters();
                const hasAny = Object.values(filters).some(value => value !== null && value !== '');
                if (!hasAny) {
                    showFeedback('Set at least one filter before saving.', false);
                    return;
                }

                const name = prompt('Name this search', 'Saved search ' + new Date().toLocaleTimeString());
                if (name === null) {
                    return;
                }

                fetch(saveEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        name: name.trim() || undefined,
                        filters,
                    }),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Unable to save search');
                        }
                        return response.json();
                    })
                    .then((data) => {
                        showFeedback('Saved "' + (data.name || 'search') + '"');
                    })
                    .catch(() => {
                        showFeedback('Could not save right now', false);
                    });
            });
        }
        @endauth
    });
</script>
@endpush
