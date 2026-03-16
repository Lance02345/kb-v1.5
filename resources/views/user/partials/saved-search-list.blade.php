@php
use App\Models\City;
use Illuminate\Support\Str;
@endphp

<section class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-display text-xl font-semibold text-white">Saved searches</h2>
            <p class="text-xs text-slate-400">Use these filters instantly on the marketplace.</p>
        </div>
        <a href="{{ route('user.saved_searches.index') }}" class="text-xs font-semibold uppercase tracking-wide text-amber-300 hover:text-amber-200">Manage</a>
    </div>

    <div class="mt-4 overflow-x-auto">
        <table class="w-full text-left text-[13px] text-slate-300">
            <thead>
                <tr class="text-slate-400">
                    <th class="pb-2 text-xs uppercase tracking-[0.3em]">Name</th>
                    <th class="pb-2 text-xs uppercase tracking-[0.3em]">Filters</th>
                    <th class="pb-2 text-xs uppercase tracking-[0.3em]">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($searches as $search)
                    <tr class="border-t border-slate-800">
                        <td class="py-2 font-semibold text-white">{{ $search->name }}</td>
                        <td class="py-2 text-slate-400">
                            @php
                                $labels = [];
                                $filters = $search->filters ?? [];
                                if (!empty($filters['make'])) {
                                    $labels[] = 'Make: ' . $filters['make'];
                                }
                                if (!empty($filters['model'])) {
                                    $labels[] = 'Model: ' . $filters['model'];
                                }
                                if (!empty($filters['city'])) {
                                    $labels[] = 'City: ' . (App\Models\City::find($filters['city'])?->city ?? $filters['city']);
                                }
                                if (!empty($filters['search'])) {
                                    $labels[] = 'Keyword: ' . Str::limit($filters['search'], 25);
                                }
                                if (!empty($filters['minPrice']) || !empty($filters['maxPrice'])) {
                                    $labels[] = 'Budget: ' . ($filters['minPrice'] ?? '0') . ' - ' . ($filters['maxPrice'] ?? 'Any');
                                }
                            @endphp
                            {{ implode(' · ', array_filter($labels)) ?: 'No filters' }}
                        </td>
                        <td class="py-2 space-x-2">
                            @php
                                $query = $filters ?: [];
                                $url = route('marketplace.index', $query);
                            @endphp
                            <a href="{{ $url }}" class="text-xs font-semibold text-emerald-300 hover:text-emerald-200">Apply</a>
                            <form action="{{ route('user.saved_searches.destroy', $search) }}" method="POST" class="inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-xs font-semibold text-rose-400 hover:text-rose-300">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 text-xs text-slate-500">You have no saved searches yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
