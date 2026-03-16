<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    public function index(Request $request)
    {
        $ids = array_filter(explode(',', (string) $request->query('ids', '')), function ($value) {
            return is_numeric($value);
        });

        $vehicles = Vehicle::query()
            ->select('vehicles.*')
            ->with(['carmodel.carmake', 'listing', 'listing.city'])
            ->whereIn('id', $ids)
            ->orderByRaw('FIELD(id, ' . implode(',', $ids ?: [0]) . ')')
            ->get();

        return view('compare.index', compact('vehicles'));
    }
}
