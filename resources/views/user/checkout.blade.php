@extends('layouts.modern-app')

@section('title', 'Checkout - Kingsbridge Motors')
@section('description', 'Complete listing package checkout.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Your Order Summary</h1>
        <p class="mt-2 text-sm text-slate-300">Confirm your package and proceed to payment.</p>
    </section>

    <section class="grid gap-6 lg:grid-cols-2">
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            @foreach ($packages as $package)
                @if ($package->id == $packageid)
                    <h2 class="font-display text-2xl font-semibold text-white">{{ $package->package_name }}</h2>
                    <p class="mt-2 text-3xl font-bold text-amber-300">{{ format_currency($package->package_amount) }}</p>
                    <p class="mt-1 text-sm text-slate-300">Featured for {{ $package->package_featured }} days</p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-300">
                        <li>Featured ad placement</li>
                        <li>Higher visibility in listings</li>
                        <li>Secure checkout</li>
                    </ul>
                @endif
            @endforeach

            <div class="mt-5 rounded-lg border border-slate-800 bg-slate-950/40 p-4 text-sm text-slate-300">
                Payment Method: <span class="font-semibold text-white">M-Pesa</span>
            </div>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <form action="{{ route('user.post_invoice') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="listing_id" value="{{ $listing }}">
                <input type="hidden" name="package_id" value="{{ $packageid }}">

                @foreach ($packages as $package)
                    @if ($package->id == $packageid)
                        <input type="hidden" name="total" value="{{ $package->package_amount }}">
                        <input type="hidden" name="package_duration" value="{{ $package->package_duration }}">
                        <div class="rounded-lg border border-slate-800 bg-slate-950/40 p-4 text-sm text-slate-300">
                            <div class="flex justify-between"><span>Subtotal</span><span class="text-white">{{ format_currency($package->package_amount) }}</span></div>
                            <div class="mt-2 flex justify-between"><span>VAT</span><span class="text-white">0%</span></div>
                            <div class="mt-2 border-t border-slate-800 pt-2 flex justify-between text-base font-semibold"><span class="text-white">Total</span><span class="text-amber-300">{{ format_currency($package->package_amount) }}</span></div>
                        </div>
                    @endif
                @endforeach

                <button type="submit" class="w-full rounded-lg bg-amber-300 px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Checkout and Pay</button>
            </form>
        </article>
    </section>
</main>
@endsection
