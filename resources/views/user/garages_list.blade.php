@extends('layouts.modern-app')

@section('title', 'My Garages - Kingsbridge Motors')
@section('description', 'Manage your garage listings.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">My Garages</h1>
                <p class="mt-2 text-sm text-slate-300">Review your garage listings and open public pages.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.my_list') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Dashboard</a>
                <a href="{{ route('user.garage_create') }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Add Garage</a>
            </div>
        </div>
    </section>

    @if(!is_null($garages) && count($garages) > 0)
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach($garages as $garage)
                <article class="group overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/15 transition duration-300 hover:-translate-y-1 hover:border-amber-300/40">
                    <a href="{{ route('garage.show', $garage->id) }}">
                        <img src="{{ !empty($garage->front_img) ? asset('storage/' . ltrim($garage->front_img, '/')) : asset('images/land1.jpg') }}" alt="{{ $garage->garage_title }}" class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                    </a>
                    <div class="space-y-3 p-4">
                        <h2 class="font-display text-xl font-semibold text-white">{{ $garage->garage_title }}</h2>
                        <div class="grid grid-cols-2 gap-2 text-sm text-slate-300">
                            <p>ID: <span class="text-white">{{ $garage->id }}</span></p>
                            <p>Location: <span class="text-white">{{ $garage->garage_location }}</span></p>
                        </div>
                        <p class="line-clamp-2 text-sm text-slate-400">{{ \Illuminate\Support\Str::limit(strip_tags($garage->garage_description), 140) }}</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('garage.show', $garage->id) }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">View Details</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @else
        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-10 text-center">
            <h2 class="font-display text-2xl font-semibold text-white">No garages yet</h2>
            <p class="mt-2 text-sm text-slate-300">Add your first garage listing to get discovered.</p>
            <a href="{{ route('user.garage_create') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Add Garage</a>
        </section>
    @endif
</main>
@endsection
