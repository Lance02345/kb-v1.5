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

    @if(strtoupper((string) $invoice->status) !== 'PAID')
        <section class="rounded-2xl border border-amber-300/30 bg-amber-500/10 p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="font-display text-2xl font-semibold text-amber-200">Pay with M-Pesa</h2>
                    <p class="text-sm text-amber-100">Secure checkout powered by Nexura Tuma STK.</p>
                </div>
                <span class="rounded-full border border-amber-300/50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-amber-100">Ksh {{ number_format($invoiceAmount) }}</span>
            </div>

            <form id="tuma-payment-form" action="{{ route('user.invoice.pay', $invoice) }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="phone" class="block text-sm font-semibold text-white">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone_number) }}" class="mt-1 w-full rounded-xl border border-amber-300/30 bg-slate-950/30 px-4 py-2 text-white placeholder:text-slate-500 focus:border-amber-300 focus:outline-none" required>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="rounded-lg bg-amber-300 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-200" id="tuma-payment-submit">Send STK</button>
                    <p id="tuma-payment-message" class="text-sm text-amber-100"></p>
                </div>
            </form>
        </section>
    @else
        <section class="rounded-2xl border border-emerald-300/30 bg-emerald-500/10 p-6">
            <p class="text-sm font-semibold text-emerald-100">This invoice is already paid. Thank you!</p>
        </section>
    @endif
</main>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('tuma-payment-form');
                const messageEl = document.getElementById('tuma-payment-message');
                const submit = document.getElementById('tuma-payment-submit');

                if (!form) {
                    return;
                }

                form.addEventListener('submit', async function (event) {
                    event.preventDefault();
                    messageEl.textContent = '';
                    submit.disabled = true;
                    submit.textContent = 'Sending...';

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                phone: form.phone.value,
                            }),
                        });

                        const payload = await response.json();

                        if (!response.ok) {
                            messageEl.textContent = payload.message || 'Unable to send STK request.';
                            messageEl.classList.add('text-rose-200');
                        } else {
                            messageEl.textContent = payload.message || 'STK prompt sent – accept the request on your phone.';
                            messageEl.classList.remove('text-rose-200');
                            messageEl.classList.add('text-amber-100');
                        }
                    } catch (error) {
                        messageEl.textContent = 'Network error. Please try again.';
                        messageEl.classList.add('text-rose-200');
                    } finally {
                        submit.disabled = false;
                        submit.textContent = 'Send STK';
                    }
                });
            });
        </script>
    @endpush
@endonce
@endsection
