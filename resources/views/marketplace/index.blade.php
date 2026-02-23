@extends('layouts.modern-app')

@section('title', 'Find Your Drive - Kingsbridge Marketplace')
@section('description', 'Browse fresh marketplace inventory across every budget and style.')

@section('content')
<section class="relative h-[280px] sm:h-[340px] lg:h-[420px] overflow-hidden">
    <img
        src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920&h=700&fit=crop"
        alt="Marketplace hero"
        class="absolute inset-0 h-full w-full object-cover"
    >
    <div class="absolute inset-0 bg-gradient-to-b from-[#020617]/30 via-[#0b1020]/70 to-[#0b1020]"></div>

    <div class="relative z-10 mx-auto flex h-full max-w-7xl items-end px-4 pb-10 sm:px-6 lg:px-8">
        <div>
            <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1 text-xs font-medium text-amber-200">
                Livewire + Tailwind Marketplace
            </p>
            <h1 class="font-display text-3xl font-bold leading-tight text-white sm:text-5xl">Find Your Drive</h1>
            <p class="mt-3 max-w-2xl text-sm text-slate-300 sm:text-base">Fresh marketplace inventory across every budget and style.</p>
        </div>
    </div>
</section>

<main class="relative z-20 -mt-6 pb-14 sm:-mt-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <livewire:landing-vehicle-browser />
    </div>
</main>
@endsection
