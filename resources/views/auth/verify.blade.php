@extends('layouts.modern-app')

@section('title', 'Verify Email - Kingsbridge Motors')
@section('description', 'Verify your email address to continue.')

@section('content')
@include('modern._nav')

<main class="mx-auto flex min-h-[calc(100vh-64px)] w-full max-w-7xl items-center px-4 py-10 sm:px-6 lg:px-8">
    <section class="mx-auto w-full max-w-xl rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8">
        <h1 class="font-display text-3xl font-bold text-white">Verify your email address</h1>

        @if (session('resent'))
            <div class="mt-4 rounded-lg border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200">
                A fresh verification link has been sent to your email address.
            </div>
        @endif

        <p class="mt-4 text-sm text-slate-300">Before proceeding, please check your email for a verification link.</p>
        <p class="mt-2 text-sm text-slate-300">If you did not receive the email, request another link below.</p>

        <form class="mt-6" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="w-full rounded-lg bg-amber-300 px-4 py-2.5 text-sm font-semibold text-slate-900 hover:bg-amber-200">Resend verification email</button>
        </form>
    </section>
</main>
@endsection
