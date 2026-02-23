<?php

namespace App\Http\Controllers;

use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\City;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleMarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $selectedMake = $request->string('make')->toString();

        $makes = Carmake::query()
            ->whereNotNull('make')
            ->orderBy('make')
            ->pluck('make');

        $modelsQuery = Carmodel::query()
            ->whereNotNull('model')
            ->orderBy('model');

        if ($selectedMake !== '') {
            $modelsQuery->whereHas('carmake', function ($query) use ($selectedMake) {
                $query->where('make', $selectedMake);
            });
        } else {
            $modelsQuery->whereRaw('1 = 0');
        }

        $models = $modelsQuery->pluck('model');

        $cities = City::query()
            ->whereNotNull('city')
            ->orderBy('city')
            ->pluck('city');

        $vehicles = Vehicle::query()
            ->with(['carmodel.carmake', 'listing.city', 'listing.category'])
            ->whereHas('listing', function ($query) {
                $query->where('category_id', 2);
            })
            ->when($request->filled('make'), function ($query) use ($request) {
                $query->whereHas('carmodel.carmake', function ($sub) use ($request) {
                    $sub->where('make', $request->input('make'));
                });
            })
            ->when($request->filled('model'), function ($query) use ($request) {
                $query->whereHas('carmodel', function ($sub) use ($request) {
                    $sub->where('model', $request->input('model'));
                });
            })
            ->when($request->filled('city'), function ($query) use ($request) {
                $query->whereHas('listing.city', function ($sub) use ($request) {
                    $sub->where('city', $request->input('city'));
                });
            })
            ->when($request->filled('min_price'), function ($query) use ($request) {
                $query->where('price', '>=', (float) $request->input('min_price'));
            })
            ->when($request->filled('max_price'), function ($query) use ($request) {
                $query->where('price', '<=', (float) $request->input('max_price'));
            })
            ->latest('id')
            ->paginate(16)
            ->withQueryString();

        return view('vehicles.index', compact('vehicles', 'makes', 'models', 'cities'));
    }
}
