@extends('layouts.admin')
@section('content')

@if(session('success'))
    <div class="mt-3 alert alert-success">{{ session('success') }}</div>
@endif

<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
        <div>
            <h4 class="mb-1 text-white">Vehicle Listings</h4>
            <small class="text-muted">Browse vehicle records linked to listing entries.</small>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($vehicles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">
                                <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th class="text-nowrap">Listing ID</th>
                                    <th>Title</th>
                                    <th class="text-nowrap">Price</th>
                                    <th class="text-nowrap">Type</th>
                                    <th class="text-nowrap">Primary Image</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td class="text-nowrap">{{ $vehicle->id }}</td>
                                        <td class="text-nowrap">{{ $vehicle->listing_id }}</td>
                                        <td>{{ $vehicle->title ?: 'N/A' }}</td>
                                        <td class="text-nowrap">{{ isset($vehicle->price) ? 'Ksh ' . number_format((float)$vehicle->price) : 'N/A' }}</td>
                                        <td class="text-nowrap">{{ $vehicle->vehicle_type ?: 'N/A' }}</td>
                                        <td>
                                            @if(!empty($vehicle->front_img))
                                                <img src="{{ asset('storage/photos/' . $vehicle->front_img) }}" alt="vehicle" style="width:72px;height:54px;object-fit:cover;border-radius:8px;border:1px solid #334155;">
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
                        <p class="mb-0 text-muted">No vehicle records found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
