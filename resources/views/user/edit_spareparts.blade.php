@extends('layouts.modern-app')

@section('title', 'Edit Spare Part Listing - Kingsbridge Motors')
@section('description', 'Update your spare part listing details and photos.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-white">Edit Spare Part</h1>
                <p class="mt-2 text-sm text-slate-300">Update details, pricing, and photos for this listing.</p>
            </div>
            <a href="{{ route('user.myspareparts') }}" class="inline-flex rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to My Spare Parts</a>
        </div>
    </section>

    <form action="{{ route('user.sparepartsupdate', $sparePart->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <h2 class="font-display text-xl font-semibold text-white">Part Details</h2>
            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Category</label>
                    <select name="category" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                        <option value="" disabled>Select category</option>
                        @foreach(($categories ?? []) as $category)
                            <option value="{{ $category }}" {{ old('category', $sparePart->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Make</label>
                    <input type="text" name="make" required value="{{ old('make', $sparePart->make) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('make')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Item Name</label>
                    <input type="text" name="item_name" required value="{{ old('item_name', $sparePart->item_name) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('item_name')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Condition</label>
                    <select name="condition" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                        <option value="Used" {{ old('condition', $sparePart->condition) === 'Used' ? 'selected' : '' }}>Used</option>
                        <option value="New" {{ old('condition', $sparePart->condition) === 'New' ? 'selected' : '' }}>New</option>
                    </select>
                    @error('condition')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Price (Ksh)</label>
                    <input type="number" name="price" required value="{{ old('price', $sparePart->price) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('price')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Location</label>
                    <input type="text" name="location" required value="{{ old('location', $sparePart->location) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('location')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-slate-200">Item Description</label>
                    <textarea name="item_description" required rows="6" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-white focus:border-amber-300 focus:outline-none">{{ old('item_description', $sparePart->item_description) }}</textarea>
                    @error('item_description')<p class="mt-2 text-xs font-medium text-rose-300">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <h2 class="font-display text-xl font-semibold text-white">Photos</h2>
            <p class="mt-1 text-sm text-slate-400">Upload new images only for the slots you want to replace.</p>

            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach (['front_img' => 'First Image', 'back_img' => 'Second Image', 'right_img' => 'Third Image'] as $field => $label)
                    <label class="rounded-xl border border-slate-700 bg-slate-950 p-4 text-sm text-slate-200">
                        <span class="mb-2 block font-semibold text-white">{{ $label }}</span>
                        <input type="file" name="{{ $field }}" class="w-full rounded-lg border border-slate-700 bg-slate-900 px-3 py-2 text-xs text-slate-200 file:mr-3 file:rounded-md file:border-0 file:bg-amber-300 file:px-3 file:py-1.5 file:font-semibold file:text-slate-900 hover:file:bg-amber-200">
                        @if(!empty($sparePart->{$field}))
                            <img src="{{ asset('storage/photos/' . $sparePart->{$field}) }}" alt="{{ $label }}" class="mt-3 h-28 w-full rounded-lg object-cover">
                        @endif
                        @error($field)<span class="mt-2 block text-xs font-medium text-rose-300">{{ $message }}</span>@enderror
                    </label>
                @endforeach
            </div>
        </section>

        <div class="flex flex-wrap items-center gap-3">
            <button type="submit" class="rounded-lg bg-amber-300 px-4 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Update Spare Part</button>
            <a href="{{ route('sparepart', $sparePart->id) }}" class="rounded-lg border border-slate-700 px-4 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">View Public Page</a>
        </div>
    </form>
</main>
@endsection
