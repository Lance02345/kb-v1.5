@extends('layouts.modern-app')

@section('title', 'Create Garage Listing - Kingsbridge Motors')
@section('description', 'Post your garage details and photos.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Post Garage Listing</h1>
        <p class="mt-2 text-sm text-slate-300">Add your garage profile and photos so customers can discover your services.</p>
    </section>

    <form action="{{ route('user.garages') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <h2 class="font-display text-xl font-semibold text-white">Garage Details</h2>
            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Garage Title</label>
                    <input type="text" name="garage_title" required value="{{ old('garage_title') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('garage_title')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Location</label>
                    <input type="text" name="garage_location" required value="{{ old('garage_location') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('garage_location')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Latitude (optional)</label>
                    <input type="text" name="latitude" id="garage-latitude" value="{{ old('latitude') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none" placeholder="Latitude">
                    @error('latitude')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Longitude (optional)</label>
                    <input type="text" name="longitude" id="garage-longitude" value="{{ old('longitude') }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none" placeholder="Longitude">
                    @error('longitude')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Description</label>
                    <textarea name="garage_description" required rows="6" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">{{ old('garage_description') }}</textarea>
                    @error('garage_description')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <h2 class="font-display text-xl font-semibold text-white">Upload Photos</h2>
            <p class="mt-1 text-sm text-slate-400">First image is required. Add up to 9 images.</p>
            <p class="text-xs text-slate-400">Supported formats: JPEG, PNG, WEBP, GIF, SVG, HEIC, HEIF. Each file must be under 20MB.</p>

            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach ([
                    'front_img' => 'First Image (Required)',
                    'back_img' => 'Second Image',
                    'right_img' => 'Third Image',
                    'left_img' => 'Optional 1',
                    'interiorf_img' => 'Optional 2',
                    'interiorb_img' => 'Optional 3',
                    'opt_img1' => 'Optional 4',
                    'opt_img2' => 'Optional 5',
                    'opt_img3' => 'Optional 6',
                ] as $field => $label)
                    <label class="rounded-xl border border-slate-700 bg-slate-950 p-4 text-sm text-slate-200">
                        <span class="mb-2 block font-semibold text-white">{{ $label }}</span>
                        <input type="file" name="{{ $field }}" {{ $field === 'front_img' ? 'required' : '' }} class="w-full rounded-lg border border-slate-700 bg-slate-900 px-3 py-2 text-xs text-slate-200 file:mr-3 file:rounded-md file:border-0 file:bg-amber-300 file:px-3 file:py-1.5 file:font-semibold file:text-slate-900 hover:file:bg-amber-200">
                        @error($field)<span class="mt-2 block text-xs font-medium text-rose-300">{{ $message }}</span>@enderror
                    </label>
                @endforeach
            </div>
        </section>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-amber-300 px-4 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Post Garage</button>
            <a href="{{ route('user.mygarages') }}" class="rounded-lg border border-slate-700 px-4 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">My Garages</a>
        </div>
    </form>
</main>
<script>
    (function () {
        var latInput = document.getElementById('garage-latitude');
        var lngInput = document.getElementById('garage-longitude');
        if (!latInput || !lngInput || latInput.value || lngInput.value || !('geolocation' in navigator)) {
            return;
        }

        navigator.geolocation.getCurrentPosition(function (position) {
            if (!position?.coords) {
                return;
            }

            latInput.value = position.coords.latitude.toFixed(6);
            lngInput.value = position.coords.longitude.toFixed(6);
        }, function () {}, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 600000,
        });
    })();
</script>
@endsection
