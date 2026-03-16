<?php

namespace App\Http\Controllers;

use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\City;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SearchSuggestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        if ($term === '') {
            return response()->json(['suggestions' => []]);
        }

        $wildcard = '%' . implode('%', preg_split('/\s+/', $term)) . '%';

        $vehicles = Vehicle::query()
            ->select('vehicles.*')
            ->with(['carmodel.carmake', 'listing.city'])
            ->join('listings', 'listings.id', '=', 'vehicles.listing_id')
            ->whereIn('listings.ads_status', ['Approved', 'Active'])
            ->where(function ($query) use ($wildcard) {
                $query->where('vehicles.title', 'like', $wildcard)
                    ->orWhere('vehicles.description', 'like', $wildcard)
                    ->orWhere('vehicles.color', 'like', $wildcard)
                    ->orWhereHas('carmodel', function ($modelQuery) use ($wildcard) {
                        $modelQuery->where('model', 'like', $wildcard)
                            ->orWhereHas('carmake', function ($makeQuery) use ($wildcard) {
                                $makeQuery->where('make', 'like', $wildcard);
                            });
                    })
                    ->orWhereHas('listing', function ($listingQuery) use ($wildcard) {
                        $listingQuery->whereHas('city', function ($cityQuery) use ($wildcard) {
                            $cityQuery->where('city', 'like', $wildcard);
                        });
                    });
            })
            ->orderByRaw('COALESCE(listings.package_id, 0) DESC')
            ->orderByRaw("CASE WHEN listings.ads_featured IN ('1','yes','YES') THEN 1 ELSE 0 END DESC")
            ->orderByDesc('vehicles.id')
            ->limit(4)
            ->get();

        $suggestions = [];
        foreach ($vehicles as $vehicle) {
            $labelParts = [];
            $labelParts[] = $vehicle->carmodel?->carmake?->make ?: 'Vehicle';
            if ($vehicle->carmodel?->model) {
                $labelParts[] = $vehicle->carmodel->model;
            }
            if ($vehicle->listing?->city?->city) {
                $labelParts[] = $vehicle->listing->city->city;
            }

            $suggestions[] = [
                'type' => 'vehicle',
                'label' => implode(' · ', $labelParts),
                'value' => $vehicle->title ?? implode(' ', $labelParts),
                'url' => $vehicle->listing ? route('vehicle', [$vehicle->listing->id, $vehicle->id]) : null,
            ];
        }

        $makes = Carmake::query()
            ->where('make', 'like', $wildcard)
            ->orderBy('make')
            ->limit(3)
            ->pluck('make');

        foreach ($makes as $make) {
            $suggestions[] = [
                'type' => 'make',
                'label' => 'Make: ' . $make,
                'value' => $make,
                'url' => null,
            ];
        }

        $models = Carmodel::query()
            ->where('model', 'like', $wildcard)
            ->orderBy('model')
            ->limit(3)
            ->pluck('model');

        foreach ($models as $model) {
            $suggestions[] = [
                'type' => 'model',
                'label' => 'Model: ' . $model,
                'value' => $model,
                'url' => null,
            ];
        }

        $cities = City::query()
            ->where('city', 'like', $wildcard)
            ->orderBy('city')
            ->limit(3)
            ->pluck('city');

        foreach ($cities as $city) {
            $suggestions[] = [
                'type' => 'city',
                'label' => 'City: ' . $city,
                'value' => $city,
                'url' => null,
            ];
        }

        return response()->json(['suggestions' => $suggestions]);
    }
}
