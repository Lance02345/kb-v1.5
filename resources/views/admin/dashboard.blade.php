@extends('layouts.admin')

@section('content')
@php
    $pending = $listings->where('ads_status', 'Pending')->count();
    $approved = $listings->where('ads_status', 'Approved')->count();
    $sold = $listings->where('ads_status', 'Sold')->count();
    $expired = $listings->where('ads_status', 'Expired')->count();
@endphp

@if (session('status'))
    <div class="alert alert-success mb-3">{{ session('status') }}</div>
@endif

<div class="row">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="kb-stat">
            <div class="label">Total Listings</div>
            <div class="value">{{ number_format($listings->count()) }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="kb-stat">
            <div class="label">Registered Users</div>
            <div class="value">{{ number_format($users->count()) }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="kb-stat">
            <div class="label">Pending Review</div>
            <div class="value">{{ number_format($pending) }}</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="kb-stat">
            <div class="label">Active Listings</div>
            <div class="value">{{ number_format($approved) }}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3 text-white">Listing Status Breakdown</h4>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="text-white">Status</th>
                            <th class="text-right text-white">Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-light">Approved</td>
                            <td class="text-right text-light">{{ number_format($approved) }}</td>
                        </tr>
                        <tr>
                            <td class="text-light">Pending</td>
                            <td class="text-right text-light">{{ number_format($pending) }}</td>
                        </tr>
                        <tr>
                            <td class="text-light">Sold</td>
                            <td class="text-right text-light">{{ number_format($sold) }}</td>
                        </tr>
                        <tr>
                            <td class="text-light">Expired</td>
                            <td class="text-right text-light">{{ number_format($expired) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h4 class="card-title mb-3 text-white">Quick Actions</h4>
                <div class="d-flex flex-column" style="gap: 10px;">
                    <a class="btn btn-primary" href="{{ route('admin.listing.index') }}">Review Listings</a>
                    <a class="btn btn-primary" href="{{ route('admin.user.index') }}">Manage Users</a>
                    <a class="btn btn-primary" href="{{ route('admin.invoice.index') }}">Manage Invoices</a>
                    <a class="btn btn-primary" href="{{ route('admin.package.index') }}">Manage Packages</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
