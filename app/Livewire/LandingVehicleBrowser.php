<?php

namespace App\Livewire;

use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\City;
use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class LandingVehicleBrowser extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public $make = '';
    public $model = '';
    public $city = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $search = '';
    public int $mobileColumns = 2;

    protected $queryString = [
        'make' => ['except' => ''],
        'model' => ['except' => ''],
        'city' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'search' => ['except' => ''],
        'mobileColumns' => ['except' => 2],
    ];

    public function mount(): void
    {
        $this->mobileColumns = $this->normalizeMobileColumns($this->mobileColumns);
    }

    public function updatedMake(): void
    {
        $this->model = '';
        $this->resetPage();
    }

    public function updatedModel(): void
    {
        $this->resetPage();
    }

    public function updatedCity(): void
    {
        $this->resetPage();
    }

    public function updatedMinPrice(): void
    {
        $this->resetPage();
    }

    public function updatedMaxPrice(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->make = '';
        $this->model = '';
        $this->city = '';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->search = '';
        $this->resetPage();
    }

    public function setMobileColumns(int $columns): void
    {
        $this->mobileColumns = $this->normalizeMobileColumns($columns);
    }

    public function render()
    {
        $models = Carmodel::query()
            ->when($this->make !== '', fn ($q) => $q->where('make_id', $this->make))
            ->orderBy('model')
            ->get();

        $preferredCityId = session('preferred_city_id');

        $vehicles = Vehicle::query()
            ->select('vehicles.*')
            ->with(['carmodel.carmake', 'listing.category', 'listing.city', 'listing.user', 'vehiclephotos'])
            ->join('listings', 'listings.id', '=', 'vehicles.listing_id')
            ->whereIn('listings.ads_status', ['Approved', 'Active'])
            ->when($this->city !== '', fn ($q) => $q->where('listings.city_id', $this->city))
            ->when($this->make !== '', fn ($q) => $q->whereHas('carmodel', fn ($cq) => $cq->where('make_id', $this->make)))
            ->when($this->model !== '', fn ($q) => $q->where('model_id', $this->model))
            ->when($this->minPrice !== '', fn ($q) => $q->where('price', '>=', (float) $this->minPrice))
            ->when($this->maxPrice !== '', fn ($q) => $q->where('price', '<=', (float) $this->maxPrice))
            ->when($this->search !== '', function ($q) {
                $term = '%' . implode('%', preg_split('/\s+/', trim($this->search))) . '%';
                $q->where(function ($inner) use ($term) {
                    $inner->where('vehicles.title', 'like', $term)
                        ->orWhere('vehicles.description', 'like', $term)
                        ->orWhere('vehicles.color', 'like', $term)
                        ->orWhereHas('carmodel', function ($modelQuery) use ($term) {
                            $modelQuery->where('model', 'like', $term)
                                ->orWhereHas('carmake', function ($makeQuery) use ($term) {
                                    $makeQuery->where('make', 'like', $term);
                                });
                        })
                        ->orWhereHas('listing', function ($listingQuery) use ($term) {
                            $listingQuery->whereHas('city', function ($cityQuery) use ($term) {
                                $cityQuery->where('city', 'like', $term);
                            });
                        });
                });
            })
            ->when($preferredCityId, fn ($q) => $q->orderByRaw('CASE WHEN listings.city_id = ? THEN 1 ELSE 0 END DESC', [$preferredCityId]))
            ->orderByRaw('COALESCE(listings.package_id, 0) DESC')
            ->orderByRaw("CASE WHEN listings.ads_featured IN ('1','yes','YES') THEN 1 ELSE 0 END DESC")
            ->orderByDesc('vehicles.id')
            ->paginate(9);

        return view('livewire.landing-vehicle-browser', [
            'vehicles' => $vehicles,
            'makes' => Carmake::query()->orderBy('make')->get(),
            'cities' => City::query()->orderBy('city')->get(),
            'models' => $models,
        ]);
    }

    private function normalizeMobileColumns(int|string $columns): int
    {
        $columns = (int) $columns;

        if (!in_array($columns, [1, 2, 3], true)) {
            return 2;
        }

        return $columns;
    }
}
