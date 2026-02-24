@extends('layouts.modern-app')

@section('title', 'Login - Kingsbridge Motors')
@section('description', 'Login to your Kingsbridge account.')

@section('content')
@include('modern._nav')

<main class="flex min-h-[calc(100vh-64px)] w-full items-center px-4 py-10 sm:px-6 lg:px-10">
    <section class="grid w-full gap-6 lg:grid-cols-2">
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-8">
            <p class="text-xs uppercase tracking-[0.2em] text-amber-300">Welcome back</p>
            <h1 class="mt-2 font-display text-3xl font-bold text-white">Sign in to your account</h1>
            <p class="mt-2 text-sm text-slate-300">Manage listings, favourites, invoices, and profile settings.</p>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('email')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <div>
                    <div class="mb-1 flex items-center justify-between">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-slate-300">Password</label>
                        <a href="{{ route('forget.password.get') }}" class="text-xs text-amber-300 hover:text-amber-200">Forgot password?</a>
                    </div>
                    <input id="password" type="password" name="password" required class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                    @error('password')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-300">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="rounded border-slate-600 bg-slate-900 text-amber-300 focus:ring-amber-300">
                    Remember me
                </label>

                <button type="submit" class="w-full rounded-lg bg-amber-300 px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Continue</button>
            </form>

            <div class="mt-5 space-y-2">
                <a href="{{ route('login.google') }}" class="flex w-full items-center justify-center gap-2 rounded-lg border border-slate-700 px-4 py-2 text-sm font-medium text-slate-100 hover:border-slate-500">
                    <img src="{{ asset('images/gp.png') }}" alt="Google" class="h-5 w-5 object-contain">
                    Continue with Google
                </a>
                <a href="{{ route('login.facebook') }}" class="flex w-full items-center justify-center gap-2 rounded-lg border border-slate-700 px-4 py-2 text-sm font-medium text-slate-100 hover:border-slate-500">
                    <img src="{{ asset('images/fb.png') }}" alt="Facebook" class="h-5 w-5 object-contain">
                    Continue with Facebook
                </a>
            </div>

            <p class="mt-5 text-center text-sm text-slate-300">No account yet? <a href="{{ route('register') }}" class="font-semibold text-amber-300 hover:text-amber-200">Create one</a></p>
        </article>
    </section>
</main>
@endsection
