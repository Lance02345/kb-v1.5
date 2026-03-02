@extends('layouts.modern-app')

@section('title', 'Vehicle Parts - Kingsbridge Motors')
@section('description', 'Browse verified vehicle spare parts listings.')

@section('content')
@include('modern._nav')

<section class="border-b border-slate-800 bg-[#0b1020]">
    <div class="w-full px-4 py-14 sm:px-6 lg:px-10">
        <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">Marketplace</p>
        <h1 class="font-display text-4xl font-bold text-white sm:text-5xl">Vehicle Parts</h1>
        <p class="mt-3 text-slate-300">Find genuine and aftermarket parts from trusted sellers.</p>
    </div>
</section>

<main class="w-full space-y-6 px-4 py-10 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4 sm:p-5">
        <form method="GET" action="{{ route('spare_parts_search') }}" class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-7">
            <input type="text" name="make" value="{{ request('make') }}" placeholder="Make" class="h-11 rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none">
            <input type="text" name="item_name" value="{{ request('item_name') }}" placeholder="Item Name" class="h-11 rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none">
            <select name="category" class="h-11 rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 focus:border-amber-400 focus:outline-none">
                <option value="">All Categories</option>
                @foreach(($categories ?? []) as $category)
                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <input type="text" name="location" value="{{ request('location') }}" placeholder="Location" class="h-11 rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none">
            <select name="condition" class="h-11 rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 focus:border-amber-400 focus:outline-none">
                <option value="">All Conditions</option>
                <option value="New" {{ request('condition') === 'New' ? 'selected' : '' }}>New</option>
                <option value="Used" {{ request('condition') === 'Used' ? 'selected' : '' }}>Used</option>
            </select>
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price" class="h-11 rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none">
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" class="h-11 rounded-xl border border-slate-700 bg-slate-950 px-3 text-sm text-slate-100 placeholder:text-slate-500 focus:border-amber-400 focus:outline-none">

            <div class="md:col-span-2 xl:col-span-7 flex items-center justify-between">
                <p class="text-xs uppercase tracking-wide text-slate-400">{{ $spareParts->total() }} results</p>
                <button type="submit" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Search</button>
            </div>
        </form>

        @if(!empty($categoryCounts) && count($categoryCounts))
            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('spareparts') }}" class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-medium {{ request('category') ? 'border-slate-700 text-slate-300 hover:border-slate-500' : 'border-amber-300/40 bg-amber-300/10 text-amber-200' }}">
                    All Categories
                </a>
                @foreach($categoryCounts as $name => $total)
                    <a href="{{ route('spare_parts_search', array_merge(request()->except('page', 'category'), ['category' => $name])) }}" class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-medium {{ request('category') === $name ? 'border-amber-300/40 bg-amber-300/10 text-amber-200' : 'border-slate-700 text-slate-300 hover:border-slate-500' }}">
                        <span>{{ $name }}</span>
                        <span class="rounded-full bg-slate-800 px-1.5 py-0.5 text-[10px]">{{ $total }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    @if($spareParts->count())
        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($spareParts as $sparePart)
                <article class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15 transition duration-300 hover:-translate-y-1 hover:border-amber-300/40">
                    <a href="{{ route('sparepart', $sparePart->id) }}">
                        <img src="{{ $sparePart->front_img ? asset('storage/photos/' . $sparePart->front_img) : asset('images/land1.jpg') }}" alt="{{ $sparePart->item_name }}" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                    </a>
                    <div class="space-y-2 p-4">
                        <h3 class="font-display truncate text-base font-semibold text-white">{{ $sparePart->make }} - {{ $sparePart->item_name }}</h3>
                        @if(!empty($sparePart->category))
                            <p class="text-xs text-amber-200">{{ $sparePart->category }}</p>
                        @endif
                        <p class="text-xs text-slate-400">{{ $sparePart->location }}</p>
                        <p class="text-xs text-slate-400">Condition: {{ $sparePart->condition }}</p>
                        <div class="pt-1">
                            <span class="font-display text-lg font-bold text-amber-300">Ksh {{ number_format((float) $sparePart->price) }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <section>
            {{ $spareParts->links() }}
        </section>
    @else
        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <p class="font-display text-xl font-semibold text-white">No parts found</p>
            <p class="mt-2 text-sm text-slate-400">Try adjusting your filters.</p>
        </section>
    @endif
</main>
@endsection
