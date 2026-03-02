@extends('layouts.modern-app')

@section('title', 'Create Listing - Kingsbridge Motors')
@section('description', 'Choose the listing type you want to publish.')

@section('content')
@include('modern._nav')

<main class="w-full px-4 py-10 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">Start a New Listing</h1>
                <p class="mt-2 text-sm text-slate-300">Choose what you want to list. You can manage and edit everything from your dashboard.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.index_vehiclesale') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">My Listings</a>
                <a href="{{ route('user.user_profile', Auth::user()->id ) }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Profile</a>
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <h2 class="font-display text-xl font-semibold text-white">Vehicle Sale</h2>
            <p class="mt-2 text-sm text-slate-300">Post a car for sale with photos, specs, and pricing.</p>
            <a href="{{ route('user.create_vehiclesale') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Choose</a>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <h2 class="font-display text-xl font-semibold text-white">Car Hire</h2>
            <p class="mt-2 text-sm text-slate-300">List vehicles available for short-term or long-term hire.</p>
            <a href="{{ route('user.create_carhire') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Choose</a>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <h2 class="font-display text-xl font-semibold text-white">Car Event</h2>
            <p class="mt-2 text-sm text-slate-300">Promote your event to enthusiasts on the marketplace.</p>
            <a href="{{ route('user.create_carevent') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Choose</a>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <h2 class="font-display text-xl font-semibold text-white">Spare Parts</h2>
            <p class="mt-2 text-sm text-slate-300">Advertise spare parts and accessories to active buyers.</p>
            <a href="{{ route('user.sparepartscreate') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Choose</a>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <h2 class="font-display text-xl font-semibold text-white">Garage</h2>
            <p class="mt-2 text-sm text-slate-300">Showcase your garage services and workspace to potential clients.</p>
            <a href="{{ route('user.garage_create') }}" class="mt-4 inline-flex rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Choose</a>
        </article>
    </section>
</main>
@endsection
