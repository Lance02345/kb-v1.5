@extends('layouts.modern-app')

@section('title', 'Choose Package - Kingsbridge Motors')
@section('description', 'Select a package to boost your listing visibility.')

@section('content')
@include('modern._nav')

<main class="mx-auto max-w-6xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Choose Your Boosting Plan</h1>
        <p class="mt-2 text-sm text-slate-300">Select one package then continue to checkout.</p>
    </section>

    <form action="{{ route('user.packageupdate', $listing->id) }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <input type="hidden" name="listing_id" value="{{ $listing->id }}">
        <input type="hidden" name="package_duration" id="selectedPackageDuration" value="">

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($packages as $package)
                <label class="group block cursor-pointer rounded-2xl border border-slate-800 bg-slate-900 p-5 transition hover:border-amber-300/60">
                    <input
                        type="radio"
                        name="package_id"
                        value="{{ $package->id }}"
                        data-duration="{{ $package->package_duration }}"
                        class="peer sr-only"
                        {{ (old('package_id') == $package->id) ? 'checked' : '' }}
                    >

                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-4 peer-checked:border-amber-300/70 peer-checked:bg-amber-300/10">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Package</p>
                        <h2 class="mt-1 font-display text-2xl font-semibold text-white">{{ $package->package_name }}</h2>
                        <p class="mt-2 text-2xl font-bold text-amber-300">Ksh {{ number_format((float) $package->package_amount) }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ $package->package_duration }} day duration</p>
                        <p class="mt-4 text-sm text-slate-300">{{ $package->description }}</p>
                    </div>
                </label>
            @endforeach
        </section>

        @error('package_id')
            <p class="text-sm font-medium text-rose-300">{{ $message }}</p>
        @enderror

        <div class="flex justify-end">
            <button type="submit" class="rounded-xl bg-amber-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Continue to Checkout</button>
        </div>
    </form>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const durationInput = document.getElementById('selectedPackageDuration');
        const radios = document.querySelectorAll('input[name=\"package_id\"]');

        const syncDuration = function (radio) {
            durationInput.value = radio ? (radio.dataset.duration || '') : '';
        };

        const checked = document.querySelector('input[name=\"package_id\"]:checked');
        syncDuration(checked);

        radios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                syncDuration(radio);
            });
        });
    });
</script>
@endsection
