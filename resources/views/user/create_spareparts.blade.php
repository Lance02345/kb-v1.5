@extends('layouts.modern-app')

@section('title', 'Create Spare Part Listing - Kingsbridge Motors')
@section('description', 'Post your spare part with photos and details.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Post Spare Parts Ad</h1>
        <p class="mt-2 text-sm text-slate-300">Add clear details and photos so buyers can identify the exact part quickly.</p>
    </section>

    <form action="{{ route('user.sparepartsstore') }}" method="POST" enctype="multipart/form-data" class="space-y-6" data-stepper-form>
        @csrf

        <div class="flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-wide text-slate-300">
            <span data-step-indicator class="active rounded-full border border-amber-300/40 bg-amber-300/10 px-3 py-1 text-amber-200">Details</span>
            <span data-step-indicator class="rounded-full border border-slate-700 px-3 py-1">Photos</span>
        </div>

        <section data-step-panel class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <h2 class="font-display text-xl font-semibold text-white">Part Details</h2>
            <p class="mt-1 text-sm text-slate-400">Example format: Toyota Mark X 2019 Front Bumper.</p>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Category</label>
                    <select name="category" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select category</option>
                        @foreach(($categories ?? []) as $category)
                            <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Make</label>
                    <input type="text" name="make" required value="{{ old('make') }}" placeholder="Spare part make" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-amber-300 focus:outline-none">
                    @error('make')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Item Name</label>
                    <input type="text" name="item_name" required value="{{ old('item_name') }}" placeholder="Item name" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-amber-300 focus:outline-none">
                    @error('item_name')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Condition</label>
                    <select name="condition" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                        <option value="Used" {{ old('condition') === 'Used' ? 'selected' : '' }}>Used</option>
                        <option value="New" {{ old('condition') === 'New' ? 'selected' : '' }}>New</option>
                    </select>
                    @error('condition')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Price (Ksh)</label>
                    <input type="number" name="price" required value="{{ old('price') }}" placeholder="0" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-amber-300 focus:outline-none">
                    @error('price')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Location</label>
                    <input type="text" name="location" required value="{{ old('location') }}" placeholder="City / area" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-amber-300 focus:outline-none">
                    @error('location')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Latitude (optional)</label>
                    <input type="text" name="latitude" id="spare-latitude" value="{{ old('latitude') }}" placeholder="Latitude" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-amber-300 focus:outline-none">
                    @error('latitude')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Longitude (optional)</label>
                    <input type="text" name="longitude" id="spare-longitude" value="{{ old('longitude') }}" placeholder="Longitude" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-amber-300 focus:outline-none">
                    @error('longitude')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Item Description</label>
                    <textarea name="item_description" required rows="6" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-amber-300 focus:outline-none">{{ old('item_description') }}</textarea>
                    @error('item_description')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section data-step-panel class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <h2 class="font-display text-xl font-semibold text-white">Upload Photos</h2>
            <p class="mt-1 text-sm text-slate-400">First image is required. Add up to 9 photos.</p>
            <p class="text-xs text-slate-400">Upload high-resolution JPEG, PNG, WEBP, GIF, SVG, HEIC, or HEIF files (max 20MB each).</p>

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

        @include('user.partials.listing-stepper-controls', ['submitText' => 'Post Spare Parts Ad'])
    </form>
</main>
@include('user.partials.listing-stepper-script')
<script>
    (function () {
        var latInput = document.getElementById('spare-latitude');
        var lngInput = document.getElementById('spare-longitude');
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
