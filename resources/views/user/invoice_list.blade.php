@extends('layouts.modern-app')

@section('title', 'Invoices - Kingsbridge Motors')
@section('description', 'View and download your invoices.')

@section('content')
@include('modern._nav')

<main class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5 sm:p-6">
        <h1 class="font-display text-3xl font-bold text-white">My Invoices</h1>
        <p class="mt-2 text-sm text-slate-300">Track your invoice status and download receipts.</p>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-950/40 text-xs uppercase tracking-wide text-slate-400">
                    <tr>
                        <th class="px-4 py-3">Invoice #</th>
                        <th class="px-4 py-3">Invoice Date</th>
                        <th class="px-4 py-3">Due Date</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        @continue(auth()->id() != $invoice->user_id)
                        <tr class="border-t border-slate-800">
                            <td class="px-4 py-3 text-white">{{ $invoice->id }}</td>
                            <td class="px-4 py-3">{{ $invoice->generate_date }}</td>
                            <td class="px-4 py-3">{{ $invoice->due_date }}</td>
                            <td class="px-4 py-3">Ksh {{ number_format((float) $invoice->total) }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full border border-amber-300/30 bg-amber-300/10 px-2.5 py-1 text-xs font-semibold text-amber-200">{{ $invoice->status }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('user.invoice.show', $invoice->id) }}" class="rounded-lg border border-slate-700 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">View</a>
                                    <a href="{{ route('user.generatePDF', $invoice->id) }}" class="rounded-lg bg-amber-300 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Download</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-sm text-slate-400">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
