@extends('layouts.modern-app')

@section('title', ($sparePart->make . ' - ' . $sparePart->item_name) . ' | Kingsbridge Motors')
@section('description', 'Spare part details, photos, seller info, and contact options.')

@section('content')
@include('modern._nav')

@php
    $images = array_values(array_filter([
        $sparePart->front_img ?? null,
        $sparePart->back_img ?? null,
        $sparePart->right_img ?? null,
    ]));
@endphp

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <a href="{{ route('spareparts') }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to Spare Parts</a>

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="space-y-4 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-4 lg:col-span-2">
            <h1 class="font-display text-2xl font-bold text-white sm:text-3xl">{{ $sparePart->make }} - {{ $sparePart->item_name }}</h1>
            <p class="text-sm text-slate-300">{{ $sparePart->item_description }}</p>

            @if(count($images))
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach($images as $image)
                        <img src="{{ asset('storage/photos/' . $image) }}" alt="{{ $sparePart->item_name }}" class="h-56 w-full rounded-xl border border-slate-800 object-cover">
                    @endforeach
                </div>
            @else
                <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-6 text-sm text-slate-400">No images available.</div>
            @endif

            <div class="grid gap-3 rounded-xl border border-slate-800 bg-slate-950/40 p-4 text-sm text-slate-300 sm:grid-cols-2">
                <p>Price: <span class="font-semibold text-white">KSH {{ number_format((float) $sparePart->price) }}</span></p>
                <p>Condition: <span class="font-semibold text-white">{{ $sparePart->condition }}</span></p>
                <p>Location: <span class="font-semibold text-white">{{ $sparePart->location }}</span></p>
                <p>Seller: <span class="font-semibold text-white">{{ $userWhoPosted->name ?? 'Unknown' }}</span></p>
            </div>
        </article>

        <aside class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <h2 class="font-display text-lg font-semibold text-white">Seller</h2>
            <div class="flex items-center gap-3">
                <img src="{{ ($userWhoPosted && $userWhoPosted->avatar) ? asset('storage/photos/' . $userWhoPosted->avatar) : asset('images/default-avatar.png') }}" alt="Seller avatar" class="h-12 w-12 rounded-full object-cover">
                <div>
                    <p class="text-sm font-semibold text-white">{{ $userWhoPosted->name ?? 'Unknown' }}</p>
                    <p class="text-xs text-slate-400">Member since {{ optional($userWhoPosted->created_at)->diffForHumans() }}</p>
                </div>
            </div>

            @if($userWhoPosted && $userWhoPosted->phone_number)
                <a href="tel:{{ $userWhoPosted->phone_number }}" class="inline-flex w-full justify-center rounded-lg bg-amber-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-amber-200">Call Seller</a>
                <a href="https://wa.me/{{ $userWhoPosted->phone_number }}" class="inline-flex w-full justify-center rounded-lg border border-emerald-400/40 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-200 hover:bg-emerald-500/20">WhatsApp</a>
            @endif
        </aside>
    </section>
</main>
@endsection
