@extends('layouts.modern-app')

@section('title', ($garage->garage_title) . ' | Kingsbridge Motors')
@section('description', 'Garage listing details and contact information.')

@section('content')
@include('modern._nav')

@php
    $images = array_values(array_filter([
        $garage->front_img ?? null,
        $garage->back_img ?? null,
        $garage->right_img ?? null,
        $garage->left_img ?? null,
        $garage->interiorf_img ?? null,
        $garage->interiorb_img ?? null,
        $garage->opt_img1 ?? null,
        $garage->opt_img2 ?? null,
        $garage->opt_img3 ?? null,
    ]));
@endphp

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <a href="{{ route('garages.index') }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to Garages</a>

    <section class="grid gap-6 lg:grid-cols-3">
        <article class="space-y-4 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-4 lg:col-span-2">
            <h1 class="font-display text-2xl font-bold text-white sm:text-3xl">{{ $garage->garage_title }}</h1>
            <p class="text-sm text-slate-300">{!! nl2br(e(strip_tags($garage->garage_description))) !!}</p>

            @if(count($images))
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach($images as $image)
                        <img src="{{ asset('storage/' . ltrim($image, '/')) }}" alt="{{ $garage->garage_title }}" class="h-56 w-full rounded-xl border border-slate-800 object-cover">
                    @endforeach
                </div>
            @endif

            <div class="grid gap-3 rounded-xl border border-slate-800 bg-slate-950/40 p-4 text-sm text-slate-300 sm:grid-cols-2">
                <p>Location: <span class="font-semibold text-white">{{ $garage->garage_location }}</span></p>
                <p>Listed by: <span class="font-semibold text-white">{{ optional($garage->user)->name ?? 'Unknown' }}</span></p>
            </div>
        </article>

        <aside class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900 p-4">
            <h2 class="font-display text-lg font-semibold text-white">Garage Owner</h2>
            <div class="flex items-center gap-3">
                <img src="{{ (optional($garage->user)->avatar) ? asset('storage/photos/' . $garage->user->avatar) : asset('images/default-avatar.png') }}" alt="Owner avatar" class="h-12 w-12 rounded-full object-cover">
                <div>
                    <p class="text-sm font-semibold text-white">{{ optional($garage->user)->name ?? 'Unknown' }}</p>
                    <p class="text-xs text-slate-400">Member since {{ optional(optional($garage->user)->created_at)->diffForHumans() }}</p>
                </div>
            </div>
        </aside>
    </section>
</main>
@endsection
