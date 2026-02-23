@extends('layouts.kingsbridge')
@section('title', 'Kingsbridge Motors | Kenya Auto Marketplace')

@section('content')
<div class="df-page">
  <section class="df-hero" aria-label="Marketplace hero">
    <img class="df-hero-bg" src="{{ asset('images/land1.jpg') }}" alt="Marketplace vehicles" />
    <div class="df-hero-overlay"></div>
    <div class="df-hero-inner container">
      <div class="df-badge">Marketplace</div>
      <h1>Find Your Drive</h1>
      <p>Fresh marketplace inventory across every budget and style.</p>
    </div>
  </section>

  <livewire:landing-vehicle-browser />
</div>
@endsection
