<?php

namespace App\Console\Commands;

use App\Models\SavedSearch;
use App\Models\Vehicle;
use App\Notifications\SavedSearchAlert;
use Illuminate\Console\Command;

class CheckSavedSearches extends Command
{
    protected $signature = 'saved-searches:check';
    protected $description = 'Scan saved searches for new matching vehicles.';

    public function handle(): int
    {
        $this->info('Checking saved searches...');

        $now = now();
        $searches = SavedSearch::with('user')->get();

        foreach ($searches as $search) {
            $filters = $search->filters ?? [];
            $query = Vehicle::query()
                ->select('vehicles.*')
                ->with(['listing', 'listing.city'])
                ->join('listings', 'listings.vehicle_id', '=', 'vehicles.id')
                ->whereIn('listings.ads_status', ['Approved', 'Active']);

            if (!empty($filters['city'])) {
                $query->where('listings.city_id', $filters['city']);
            }
            if (!empty($filters['make'])) {
                $query->whereHas('carmodel', fn ($q) => $q->where('make_id', $filters['make']));
            }
            if (!empty($filters['model'])) {
                $query->where('model_id', $filters['model']);
            }
            if (!empty($filters['minPrice'])) {
                $query->where('price', '>=', (float) $filters['minPrice']);
            }
            if (!empty($filters['maxPrice'])) {
                $query->where('price', '<=', (float) $filters['maxPrice']);
            }
            if (!empty($filters['search'])) {
                $term = '%' . implode('%', preg_split('/\s+/', trim($filters['search']))) . '%';
                $query->where(function ($inner) use ($term) {
                    $inner->where('vehicles.title', 'like', $term)
                        ->orWhere('vehicles.description', 'like', $term);
                });
            }

            $threshold = $search->last_notified_at ?: $search->last_run_at ?: $search->created_at;
            if ($threshold) {
                $query->where('vehicles.created_at', '>', $threshold);
            }

            $match = $query->orderByDesc('vehicles.created_at')->first();

            $search->last_run_at = $now;

            if ($match) {
                $search->user->notify(new SavedSearchAlert($search, $match));
                $search->last_notified_at = $now;
                $this->info('Notified ' . $search->user->email . ' about search ' . $search->name);
            }

            $search->save();
        }

        return Command::SUCCESS;
    }
}
