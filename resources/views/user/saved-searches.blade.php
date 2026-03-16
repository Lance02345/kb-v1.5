@extends('layouts.modern-app')

@section('title', 'Saved Searches - Kingsbridge Motors')
@section('description', 'Manage your saved marketplace filters.')

@section('content')
@include('modern._nav')

<main class="w-full space-y-6 px-4 py-8 sm:px-6 lg:px-10">
    <section class="space-y-2">
        <h1 class="font-display text-3xl font-semibold text-white">Saved searches</h1>
        <p class="text-sm text-slate-400">Store filter combinations and return to them instantly.</p>
    </section>

    <section>
        @include('user.partials.saved-search-list', ['searches' => $searches ?? collect()])
    </section>
</main>
@endsection
