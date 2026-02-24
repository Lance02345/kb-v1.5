@extends('layouts.modern-app')

@section('title', 'Marketplace - Kingsbridge Motors')
@section('description', 'Browse all available cars with filters for make, model, city, and budget.')

@section('content')
@include('modern._nav')

<section class="relative overflow-hidden border-b border-slate-800 bg-[#0b1020]">
    <div class="absolute -left-16 top-8 h-44 w-44 rounded-full bg-amber-300/20 blur-3xl"></div>
    <div class="absolute right-0 top-0 h-56 w-56 rounded-full bg-cyan-300/10 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">Marketplace</p>
        <h1 class="font-display text-4xl font-bold text-white sm:text-5xl">Cars Marketplace</h1>
        <p class="mt-3 max-w-2xl text-sm text-slate-300 sm:text-base">Search and filter cars only. Click any card to open full vehicle details.</p>
    </div>
</section>

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <livewire:landing-vehicle-browser />
</main>
@endsection
