@extends('layouts.modern-app')

@section('title', 'Reset Password - Kingsbridge Motors')
@section('description', 'Set your new account password.')

@section('content')
@include('modern._nav')

<main class="mx-auto flex min-h-[calc(100vh-64px)] w-full max-w-7xl items-center px-4 py-10 sm:px-6 lg:px-8">
    <section class="mx-auto w-full max-w-xl rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Choose a new password</h1>
        <p class="mt-2 text-sm text-slate-300">Enter your account email and a strong password.</p>

        <form method="POST" action="{{ route('password.update') }}" class="mt-5 space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Email</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                @error('email')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">New password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                @error('password')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password-confirm" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Confirm password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
            </div>

            <button type="submit" class="w-full rounded-lg bg-amber-300 px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Reset Password</button>
        </form>
    </section>
</main>
@endsection
