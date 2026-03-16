<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\SavedSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedSearchController extends Controller
{
    public function index()
    {
        $searches = Auth::user()->savedSearches()->latest('id')->get();
        return view('user.saved-searches', compact('searches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:120',
            'filters' => 'required|array',
        ]);

        $filters = array_filter($request->input('filters', []), function ($value) {
            return $value !== null && $value !== '';
        });

        if (empty($filters)) {
            return response()->json(['errors' => ['filters' => 'Provide at least one parameter']], 422);
        }

        $name = $request->input('name');
        if (!$name) {
            $name = 'Saved search ' . now()->format('d M H:i');
        }

        $savedSearch = Auth::user()->savedSearches()->create([
            'name' => $name,
            'filters' => $filters,
        ]);

        if (!empty($filters['city'])) {
            session([
                'preferred_city_id' => (int) $filters['city'],
                'preferred_city_label' => City::find($filters['city'])?->city,
            ]);
        }

        return response()->json(['saved' => true, 'name' => $savedSearch->name]);
    }

    public function destroy(SavedSearch $savedSearch)
    {
        if ($savedSearch->user_id !== Auth::id()) {
            abort(403);
        }

        $savedSearch->delete();

        return back()->with('success', 'Saved search removed.');
    }
}
