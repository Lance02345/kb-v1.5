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
                    <h4 class="card-title mb-3">Vehicle Listings</h4>
                    @if($vehicles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Listing ID</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Primary Image</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->id }}</td>
                                        <td>{{ $vehicle->listing_id }}</td>
                                        <td>{{ $vehicle->title ?: 'N/A' }}</td>
                                        <td>{{ isset($vehicle->price) ? 'Ksh ' . number_format((float)$vehicle->price) : 'N/A' }}</td>
                                        <td>{{ $vehicle->vehicle_type ?: 'N/A' }}</td>
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
                        <p class="mb-0">No vehicle records found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
