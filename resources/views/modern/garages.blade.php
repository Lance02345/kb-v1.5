@extends('layouts.modern-app')

@section('title', 'Garages - Kingsbridge Motors')
@section('description', 'Browse garage listings and services.')

@section('content')
@include('modern._nav')

<section class="border-b border-slate-800 bg-[#0b1020]">
    <div class="w-full px-4 py-14 sm:px-6 lg:px-10">
        <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">Directory</p>
        <h1 class="font-display text-4xl font-bold text-white sm:text-5xl">Garages</h1>
        <p class="mt-3 text-slate-300">Discover trusted workshops and garage services near you.</p>
    </div>
</section>

<main class="w-full space-y-6 px-4 py-10 sm:px-6 lg:px-10">
    @if($garages->count())
        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($garages as $garage)
                <article class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15 transition duration-300 hover:-translate-y-1 hover:border-amber-300/40">
                    <a href="{{ route('garage.show', $garage->id) }}">
                        <img src="{{ !empty($garage->front_img) ? asset('storage/' . ltrim($garage->front_img, '/')) : asset('images/land1.jpg') }}" alt="{{ $garage->garage_title }}" loading="lazy" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                    </a>
                    <div class="space-y-2 p-4">
                        <h3 class="font-display truncate text-base font-semibold text-white">{{ $garage->garage_title }}</h3>
                        <p class="text-xs text-slate-400">{{ $garage->garage_location }}</p>
                        <p class="line-clamp-2 text-xs text-slate-400">{{ \Illuminate\Support\Str::limit(strip_tags($garage->garage_description), 120) }}</p>
                        <a href="{{ route('garage.show', $garage->id) }}" class="inline-flex rounded-lg bg-amber-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">View Garage</a>
                    </div>
                </article>
            @endforeach
        </section>

        <section>
            {{ $garages->links() }}
        </section>
    @else
        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <p class="font-display text-xl font-semibold text-white">No garages found</p>
            <p class="mt-2 text-sm text-slate-400">No garage listings are available yet.</p>
        </section>
    @endif
</main>
@endsection
