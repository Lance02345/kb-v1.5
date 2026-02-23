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

    protected $queryString = [
        'make' => ['except' => ''],
        'model' => ['except' => ''],
        'city' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
    ];

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

    public function clearFilters(): void
    {
        $this->make = '';
        $this->model = '';
        $this->city = '';
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->resetPage();
    }

    public function render()
    {
        $models = Carmodel::query()
            ->when($this->make !== '', fn ($q) => $q->where('make_id', $this->make))
            ->orderBy('model')
            ->get();

        $vehicles = Vehicle::query()
            ->with(['carmodel.carmake', 'listing.category', 'listing.city'])
            ->whereHas('listing', function ($query) {
                $query->whereIn('ads_status', ['Approved', 'Active']);

                if ($this->city !== '') {
                    $query->where('city_id', $this->city);
                }
            })
            ->when($this->make !== '', fn ($q) => $q->whereHas('carmodel', fn ($cq) => $cq->where('make_id', $this->make)))
            ->when($this->model !== '', fn ($q) => $q->where('model_id', $this->model))
            ->when($this->minPrice !== '', fn ($q) => $q->where('price', '>=', (float) $this->minPrice))
            ->when($this->maxPrice !== '', fn ($q) => $q->where('price', '<=', (float) $this->maxPrice))
            ->latest('id')
            ->paginate(9);

        return view('livewire.landing-vehicle-browser', [
            'vehicles' => $vehicles,
            'makes' => Carmake::query()->orderBy('make')->get(),
            'cities' => City::query()->orderBy('city')->get(),
            'models' => $models,
        ]);
    }
}
