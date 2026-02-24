@extends('layouts.modern-app')

@section('title', 'Forgot Password - Kingsbridge Motors')
@section('description', 'Request a password reset link.')

@section('content')
@include('modern._nav')

<main class="mx-auto flex min-h-[calc(100vh-64px)] w-full max-w-7xl items-center px-4 py-10 sm:px-6 lg:px-8">
    <section class="mx-auto w-full max-w-xl rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Reset your password</h1>
        <p class="mt-2 text-sm text-slate-300">Enter your email and we will send you a reset link.</p>

        @if (session('status'))
            <div class="mt-4 rounded-lg border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('forget.password.post') }}" class="mt-5 space-y-4">
            @csrf
            <div>
                <label for="email" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-300">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-white focus:border-amber-300 focus:outline-none">
                @error('email')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full rounded-lg bg-amber-300 px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Send Reset Link</button>
        </form>
    </section>
</main>
@endsection
