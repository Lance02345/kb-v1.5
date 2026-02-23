@extends('layouts.kingsbridge')
@section('title', 'Kingsbridge Motors | Kenya Auto Marketplace')

@section('content')
<div class="min-h-screen bg-gray-950">
  <section class="relative h-[340px] md:h-[420px] overflow-hidden">
    <img src="{{ asset('images/hero-bg.jpg') }}" alt="Car marketplace" class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-950/50 to-gray-950/20"></div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
      <div class="inline-flex items-center gap-2 mb-4 px-4 py-1.5 rounded-full bg-amber-500/15 border border-amber-500/30">
        <span class="text-sm font-medium text-amber-400">Marketplace</span>
      </div>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-3">Find Your Drive</h1>
      <p class="text-gray-400 text-base md:text-lg max-w-xl">Fresh marketplace inventory across every budget and style.</p>
    </div>
  </section>

  <livewire:landing-vehicle-browser />
</div>
@endsection
