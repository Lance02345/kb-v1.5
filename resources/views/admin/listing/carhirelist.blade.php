@extends('layouts.admin')
@section('content')

@if(session('success'))
    <div class="mt-3 alert alert-success">{{ session('success') }}</div>
@endif

<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
        <div>
            <h4 class="mb-1 text-white">Car Hire Listings</h4>
            <small class="text-muted">Review all hire listings with daily pricing and availability dates.</small>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($listings) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">
                                <thead>
                                <tr>
                                    <th class="text-nowrap">Listing ID</th>
                                    <th>Vehicle</th>
                                    <th>Owner</th>
                                    <th class="text-nowrap">Hire Price/Day</th>
                                    <th>Dates</th>
                                    <th class="text-nowrap">Image</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listings as $listing)
                                    @php($vehicle = collect($vehicles)->firstWhere('listing_id', $listing->id))
                                    <tr>
                                        <td class="text-nowrap">{{ $listing->id }}</td>
                                        <td>
                                            @if($vehicle)
                                                {{ $vehicle->title ?: ($vehicle->year_of_build . ' ' . ($vehicle->vehicle_type ?: 'Vehicle')) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ optional($listing->user)->name ?: 'N/A' }}</td>
                                        <td class="text-nowrap">{{ $vehicle && $vehicle->price_per_day ? 'Ksh ' . number_format((float)$vehicle->price_per_day) : 'N/A' }}</td>
                                        <td>
                                            @if($vehicle)
                                                {{ $vehicle->pickup_date ?: '-' }} to {{ $vehicle->return_date ?: '-' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($vehicle && $vehicle->front_img)
                                                <img src="{{ asset('storage/photos/' . $vehicle->front_img) }}" alt="car hire" style="width:72px;height:54px;object-fit:cover;border-radius:8px;border:1px solid #334155;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0 text-muted">No car hire listings found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
