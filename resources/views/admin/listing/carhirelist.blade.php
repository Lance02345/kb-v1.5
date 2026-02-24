@extends('layouts.admin')
@section('content')

@if(session('success'))
    <div class="mt-3 alert alert-success">{{ session('success') }}</div>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Car Hire Listings</h4>
                    @if(count($listings) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Listing ID</th>
                                    <th>Vehicle</th>
                                    <th>Owner</th>
                                    <th>Hire Price/Day</th>
                                    <th>Dates</th>
                                    <th>Image</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listings as $listing)
                                    @php($vehicle = collect($vehicles)->firstWhere('listing_id', $listing->id))
                                    <tr>
                                        <td>{{ $listing->id }}</td>
                                        <td>
                                            @if($vehicle)
                                                {{ $vehicle->title ?: ($vehicle->year_of_build . ' ' . ($vehicle->vehicle_type ?: 'Vehicle')) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ optional($listing->user)->name ?: 'N/A' }}</td>
                                        <td>{{ $vehicle && $vehicle->price_per_day ? 'Ksh ' . number_format((float)$vehicle->price_per_day) : 'N/A' }}</td>
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
                        <p class="mb-0">No car hire listings found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
