@extends('layouts.modern-app')

@section('title', 'Invoice - Kingsbridge Motors')
@section('description', 'View your listing invoice details.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-800 pb-4">
            <div>
                <h1 class="font-display text-2xl font-bold text-white">Invoice #{{ $listing->id }}</h1>
                <p class="mt-1 text-sm text-slate-300">Created {{ $listing->created_at }}</p>
            </div>
            <a href="{{ route('user.my_list') }}" class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back</a>
        </div>

        <div class="mt-5 grid gap-6 sm:grid-cols-2">
            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400">Billed To</h2>
                <p class="mt-2 text-sm text-white">{{ $listing->user->name }}</p>
                <p class="text-sm text-slate-300">{{ $listing->user->phone_number }}</p>
                <p class="text-sm text-slate-300">{{ $listing->user->email }}</p>
            </div>
            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400">Payment Method</h2>
                <p class="mt-2 text-sm text-white">M-Pesa</p>
                <img src="{{ asset('images/M-PESA_LOGO-01.svg') }}" alt="M-Pesa" class="mt-2 h-12 w-auto object-contain">
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-xl border border-slate-800">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-950/40 text-slate-200">
                    <tr>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-slate-800">
                        <td class="px-4 py-3">{{ $listing->package->package_name }} - {{ $vehicle->carmodel?->carmake?->make }} {{ $vehicle->carmodel?->model }} {{ $vehicle->year_of_build }}</td>
                        <td class="px-4 py-3 text-right">Ksh {{ number_format((float) $listing->package->package_amount) }}</td>
                    </tr>
                    <tr class="border-t border-slate-800">
                        <td class="px-4 py-3 font-semibold text-white">Total</td>
                        <td class="px-4 py-3 text-right font-semibold text-white">Ksh {{ number_format((float) $listing->package->package_amount) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
