@extends('layouts.modern-app')

@section('title', 'About Us - Kingsbridge Motors')
@section('description', 'Learn about Kingsbridge Motors mission and vision.')

@section('content')
@include('modern._nav')

<section class="relative overflow-hidden border-b border-slate-800 bg-[#0b1020]">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">About Kingsbridge</p>
        <h1 class="font-display text-4xl font-bold text-white sm:text-5xl">Built for Kenya's automotive community</h1>
        <p class="mt-4 max-w-3xl text-base text-slate-300">We connect buyers, sellers, event organizers, and vehicle service providers on one modern platform.</p>
    </div>
</section>

<main class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:px-8">
    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/60 p-2">
        <img src="{{ asset('images/KINGSBRIDGE.png') }}" alt="Kingsbridge" class="h-full w-full rounded-xl object-cover">
    </div>

    <div class="space-y-6 rounded-2xl border border-slate-800 bg-slate-900/60 p-8">
        <div>
            <h2 class="font-display text-2xl font-semibold text-white">Mission</h2>
            <p class="mt-2 text-slate-300">Deliver a seamless buying and selling experience, while supporting garages and car events with simple digital tools.</p>
        </div>

        <div>
            <h2 class="font-display text-2xl font-semibold text-white">Vision</h2>
            <p class="mt-2 text-slate-300">Create the leading automotive marketplace where everything a driver needs lives in one place.</p>
        </div>

        <div>
            <h2 class="font-display text-2xl font-semibold text-white">What We Believe</h2>
            <p class="mt-2 text-slate-300">Trust, speed, and transparency are non-negotiable. We keep improving the platform so the community can transact with confidence.</p>
        </div>
    </div>
</main>
@endsection
