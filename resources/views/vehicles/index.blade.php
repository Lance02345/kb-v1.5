@extends('layouts.marketplace')

@section('title', 'Find Your Drive - Vehicle Marketplace')
@section('description', 'Browse fresh marketplace inventory across every budget and style.')

@section('content')
<section class="relative h-[340px] md:h-[420px] overflow-hidden">
    <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920&h=600&fit=crop"
         alt="Car marketplace hero" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-[#0c0f14]/90 via-[#0c0f14]/50 to-[#0c0f14]/20"></div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
        <div class="inline-flex items-center gap-2 mb-4 px-4 py-1.5 rounded-full bg-amber-500/15 border border-amber-500/30">
            <svg class="w-4 h-4 mk-icon text-amber-400" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10"/></svg>
            <span class="text-sm font-medium text-amber-400">Marketplace</span>
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-3" style="font-family: 'Space Grotesk', sans-serif;">Find Your Drive</h1>
        <p class="text-gray-400 text-base md:text-lg max-w-xl">Fresh marketplace inventory across every budget and style.</p>
    </div>
</section>

<main class="max-w-7xl mx-auto px-4 sm:px-6 -mt-8 relative z-20 pb-16 space-y-6">
    <div class="bg-[#161a22] rounded-lg shadow-lg border border-gray-800">
        <div class="flex items-center justify-between p-4 border-b border-gray-800">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-md bg-amber-500/10">
                    <svg class="w-4 h-4 mk-icon text-amber-400" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-100 text-sm" style="font-family: 'Space Grotesk', sans-serif;">Search Inventory</h2>
                    <p class="text-xs text-gray-500">Filter by make, model, city, and budget.</p>
                </div>
            </div>
            <span class="text-xs font-medium text-gray-500">{{ $vehicles->total() }} listings</span>
        </div>
        <form method="GET" action="{{ route('marketplace.index') }}" class="p-4 space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <select name="make" onchange="this.form.submit()"
                    class="w-full h-10 px-3 rounded-md bg-[#161a22] border border-gray-700 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 appearance-none cursor-pointer">
                    <option value="">Choose a Make</option>
                    @foreach($makes as $m)
                        <option value="{{ $m }}" {{ request('make') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>

                <select name="model" onchange="this.form.submit()"
                    class="w-full h-10 px-3 rounded-md bg-[#161a22] border border-gray-700 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 appearance-none cursor-pointer"
                    {{ !request('make') ? 'disabled' : '' }}>
                    <option value="">Choose a Model</option>
                    @foreach($models as $mod)
                        <option value="{{ $mod }}" {{ request('model') == $mod ? 'selected' : '' }}>{{ $mod }}</option>
                    @endforeach
                </select>

                <select name="city" onchange="this.form.submit()"
                    class="w-full h-10 px-3 rounded-md bg-[#161a22] border border-gray-700 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500 appearance-none cursor-pointer">
                    <option value="">Select City</option>
                    @foreach($cities as $c)
                        <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>

                <input type="number" name="min_price" placeholder="Min Budget" value="{{ request('min_price') }}"
                    class="w-full h-10 px-3 rounded-md bg-[#161a22] border border-gray-700 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">

                <input type="number" name="max_price" placeholder="Max Budget" value="{{ request('max_price') }}"
                    class="w-full h-10 px-3 rounded-md bg-[#161a22] border border-gray-700 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="text-xs text-amber-400 hover:text-amber-300 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 mk-icon-sm" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                <a href="{{ route('marketplace.index') }}" class="text-xs text-gray-500 hover:text-gray-300 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 mk-icon-sm" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if($vehicles->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($vehicles as $vehicle)
                @include('vehicles._card', ['vehicle' => $vehicle])
            @endforeach
        </div>
    @else
        <div class="flex items-center justify-center py-20">
            <div class="text-center space-y-2">
                <svg class="w-12 h-12 mk-icon-lg text-gray-700 mx-auto" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <h3 class="font-semibold text-gray-100" style="font-family: 'Space Grotesk', sans-serif;">No vehicles found</h3>
                <p class="text-sm text-gray-500">Try adjusting your filters to broaden results.</p>
            </div>
        </div>
    @endif

    @if($vehicles->hasPages())
        <div class="flex items-center justify-center gap-2 pt-4">
            {{ $vehicles->links('vehicles._pagination') }}
        </div>
    @endif
</main>
@endsection
