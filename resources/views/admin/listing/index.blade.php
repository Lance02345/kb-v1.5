@extends('layouts.admin')
@section('content')

@if(session('success'))
    <div class="mt-3 alert alert-success">{{ session('success') }}</div>
@endif

<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
        <div>
            <h4 class="mb-1 text-white">Listings</h4>
            <small class="text-muted">Moderate ad status, package, and ownership.</small>
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
                                    <th class="text-nowrap">ID</th>
                                    <th>Category / City</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Featured</th>
                                    <th class="text-nowrap">Duration</th>
                                    <th>Package</th>
                                    <th>Owner</th>
                                    <th class="text-nowrap">Created</th>
                                    <th class="text-nowrap">Updated</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listings as $listing)
                                    <tr>
                                        <td class="text-nowrap">{{ $listing->id }}</td>
                                        <td>{{ optional($listing->category)->category_name }} - {{ optional($listing->city)->city }}</td>
                                        <td class="text-nowrap">{{ $listing->ads_status }}</td>
                                        <td class="text-nowrap">{{ $listing->ads_featured }}</td>
                                        <td class="text-nowrap">{{ $listing->ads_duration }}</td>
                                        <td>{{ optional($listing->package)->package_name }}</td>
                                        <td>{{ optional($listing->user)->name }}</td>
                                        <td class="text-nowrap">{{ optional($listing->created_at)->diffForHumans() ?: '-' }}</td>
                                        <td class="text-nowrap">{{ optional($listing->updated_at)->diffForHumans() ?: '-' }}</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('admin.listing.edit', $listing->id) }}" title="Edit Listing"><i class="fa fa-pencil color-muted"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0 text-muted">No listings found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
