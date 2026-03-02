@extends('layouts.modern-app')

@section('title', 'Invoice Details - Kingsbridge Motors')
@section('description', 'View invoice details and payment status.')

@section('content')
@include('modern._nav')

@php($invoiceStatus = strtoupper((string) $invoice->status))
@php($invoicePackageName = optional($invoice->package)->package_name ?: 'Free Plan')
@php($invoiceAmount = (float) ($invoice->total ?? optional($invoice->package)->package_amount ?? 0))

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-800 pb-4">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">Invoice #{{ $invoice->id }}</h1>
                <p class="mt-1 text-sm text-slate-300">Generated: {{ $invoice->generate_date }}</p>
            </div>
            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $invoiceStatus === 'PAID' ? 'border border-emerald-300/30 bg-emerald-300/10 text-emerald-200' : 'border border-rose-300/30 bg-rose-300/10 text-rose-200' }}">{{ $invoiceStatus }}</span>
        </div>

        <div class="mt-5 grid gap-6 sm:grid-cols-2">
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-400">Invoiced To</h2>
                <p class="mt-2 text-sm text-white">{{ $invoice->user->name }}</p>
                <p class="text-sm text-slate-300">{{ $invoice->user->address }}</p>
            </div>
            <div class="sm:text-right">
                <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-400">Pay To</h2>
                <p class="mt-2 text-sm text-white">Kingsbridge Motors</p>
                <p class="text-sm text-slate-300">P.O Box 60278-00200, Nairobi - Kenya</p>
                <p class="text-sm text-slate-300">info@kingsbridge.com</p>
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
                        <td class="px-4 py-3">
                            {{ $invoicePackageName }}<br>
                            Payment ID: {{ $invoice->id }}<br>
                            Listing ID: {{ $invoice->listing_id }}
                        </td>
                        <td class="px-4 py-3 text-right">Ksh {{ number_format($invoiceAmount) }}</td>
                    </tr>
                    <tr class="border-t border-slate-800">
                        <td class="px-4 py-3">Subtotal</td>
                        <td class="px-4 py-3 text-right">Ksh {{ number_format($invoiceAmount) }}</td>
                    </tr>
                    <tr class="border-t border-slate-800">
                        <td class="px-4 py-3">VAT</td>
                        <td class="px-4 py-3 text-right">{{ $invoice->tax }}</td>
                    </tr>
                    <tr class="border-t border-slate-800">
                        <td class="px-4 py-3 font-semibold text-white">Total</td>
                        <td class="px-4 py-3 text-right font-semibold text-white">Ksh {{ number_format($invoiceAmount) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <a href="{{ route('user.invoice.index') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to Invoices</a>
            <a href="{{ route('user.generatePDF', $invoice->id) }}" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Download PDF</a>
        </div>
    </section>
</main>
@endsection
