@extends('layouts.modern-app')

@section('title', 'My Profile - Kingsbridge Motors')
@section('description', 'Update your personal profile details.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="rounded-xl border border-amber-300/20 bg-amber-300/10 px-4 py-3 text-sm text-amber-100">{{ session('info') }}</div>
    @endif

    <section class="grid gap-6 lg:grid-cols-3">
        <aside class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="flex items-center gap-3">
                <img src="{{ $user->avatar ? asset('storage/photos/' . $user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-white">{{ $user->name }}</p>
                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                </div>
            </div>
            <div class="mt-4 rounded-lg border border-slate-800 bg-slate-950/40 p-3 text-sm text-slate-300">
                Keep your profile updated so buyers can trust your listings.
            </div>
        </aside>

        <section class="rounded-2xl border border-slate-800 bg-slate-900 p-5 lg:col-span-2">
            <h1 class="font-display text-2xl font-semibold text-white">Edit Profile</h1>
            <p class="mt-1 text-sm text-slate-300">Update name, phone number, and avatar.</p>

            <form action="{{ route('user.update_user', $user->id) }}" method="POST" enctype="multipart/form-data" class="mt-5 grid gap-4 sm:grid-cols-2">
                @csrf
                @method('put')

                <div class="sm:col-span-2">
                    <label for="name" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('name')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Email</label>
                    <input type="text" value="{{ $user->email }}" disabled class="w-full rounded-lg border border-slate-800 bg-slate-950/30 px-3 py-2 text-sm text-slate-400">
                </div>

                <div>
                    <label for="phone_number" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Phone Number</label>
                    <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="w-full rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('phone_number')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="avatar" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Profile Photo</label>
                    <input id="avatar" type="file" name="avatar" class="w-full rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2 text-sm text-slate-200 file:mr-3 file:rounded-md file:border-0 file:bg-amber-300 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-slate-900">
                    @error('avatar')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2 flex flex-wrap gap-2">
                    <button type="submit" class="rounded-lg bg-amber-300 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-900 hover:bg-amber-200">Save Changes</button>
                    <a href="{{ route('user.my_list') }}" class="rounded-lg border border-slate-700 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-200 hover:border-slate-500">Back to Dashboard</a>
                </div>
            </form>
        </section>
    </section>
</main>
@endsection
