@extends('layouts.modern-app')

@section('title', 'My List - Kingsbridge Motors')
@section('description', 'Quick access to your active listings dashboard.')

@section('content')
@include('modern._nav')

<main class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-8 text-center">
        <h1 class="font-display text-3xl font-bold text-white">My Listings</h1>
        <p class="mt-2 text-sm text-slate-300">You are using the updated listings dashboard.</p>
        <a href="{{ route('user.index_vehiclesale') }}" class="mt-5 inline-flex rounded-lg bg-amber-300 px-5 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Open Dashboard</a>
    </section>
</main>
@endsection
