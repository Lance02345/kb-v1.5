@extends('layouts.modern-app')

@section('title', 'Packages - Kingsbridge Motors')
@section('description', 'Compare listing packages and choose the best fit for your ad goals.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-8 px-4 py-8 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Best Price Guaranteed</h1>
        <p class="mt-2 text-sm text-slate-300">Flexible plans for casual sellers, dealers, and power users.</p>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <p class="text-xs uppercase tracking-wide text-slate-400">Starter</p>
            <h2 class="mt-1 font-display text-2xl font-semibold text-white">Basic Package</h2>
            <p class="mt-3 text-2xl font-bold text-amber-300">$10<span class="text-sm font-medium text-slate-400">/month</span></p>
            <ul class="mt-5 space-y-2 text-sm text-slate-300">
                <li>Free ad posting</li>
                <li>Featured visibility</li>
                <li>15-day campaign</li>
                <li>Secure payments</li>
            </ul>
        </article>

        <article class="rounded-2xl border border-amber-300/50 bg-amber-300/10 p-6">
            <p class="text-xs uppercase tracking-wide text-amber-200">Popular</p>
            <h2 class="mt-1 font-display text-2xl font-semibold text-white">Standard Package</h2>
            <p class="mt-3 text-2xl font-bold text-amber-300">$30<span class="text-sm font-medium text-slate-300">/month</span></p>
            <ul class="mt-5 space-y-2 text-sm text-slate-200">
                <li>Priority placement</li>
                <li>More featured slots</li>
                <li>Longer campaign window</li>
                <li>Secure payments</li>
            </ul>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
            <p class="text-xs uppercase tracking-wide text-slate-400">Pro</p>
            <h2 class="mt-1 font-display text-2xl font-semibold text-white">Premium Package</h2>
            <p class="mt-3 text-2xl font-bold text-amber-300">$50<span class="text-sm font-medium text-slate-400">/month</span></p>
            <ul class="mt-5 space-y-2 text-sm text-slate-300">
                <li>Maximum visibility</li>
                <li>Top search priority</li>
                <li>Extended campaign duration</li>
                <li>Secure payments</li>
            </ul>
        </article>
    </section>
</main>
@endsection
