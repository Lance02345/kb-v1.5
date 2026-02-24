@extends('layouts.modern-app')

@section('title', 'Sign Up - Kingsbridge Motors')
@section('description', 'Create your Kingsbridge account and start listing today.')

@section('content')
@include('modern._nav')

<main class="flex min-h-[calc(100vh-64px)] w-full items-center px-4 py-10 sm:px-6 lg:px-10">
    <section class="mx-auto w-full max-w-2xl rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <p class="text-xs uppercase tracking-[0.2em] text-amber-300">Join Kingsbridge</p>
        <h1 class="mt-2 font-display text-3xl font-bold text-white">Create your account</h1>
        <p class="mt-2 text-sm text-slate-300">Start selling vehicles, posting events, and managing your marketplace profile.</p>

        <form method="POST" action="{{ route('register') }}" class="mt-6 grid gap-4 sm:grid-cols-2">
            @csrf
            <div class="sm:col-span-2">
                <label for="name" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                @error('name')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label for="email" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                @error('email')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                @error('password')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password-confirm" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Confirm password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
            </div>

            <div class="sm:col-span-2">
                <button type="submit" class="w-full rounded-lg bg-amber-300 px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Create account</button>
            </div>
        </form>

        <p class="mt-5 text-center text-sm text-slate-300">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-amber-300 hover:text-amber-200">Login</a></p>
    </section>
</main>
@endsection
