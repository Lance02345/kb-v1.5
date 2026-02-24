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
                    <h4 class="card-title mb-3">Listings</h4>
                    @if(count($listings) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category / City</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Duration</th>
                                    <th>Package</th>
                                    <th>Owner</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listings as $listing)
                                    <tr>
                                        <td>{{ $listing->id }}</td>
                                        <td>{{ optional($listing->category)->category_name }} - {{ optional($listing->city)->city }}</td>
                                        <td>{{ $listing->ads_status }}</td>
                                        <td>{{ $listing->ads_featured }}</td>
                                        <td>{{ $listing->ads_duration }}</td>
                                        <td>{{ optional($listing->package)->package_name }}</td>
                                        <td>{{ optional($listing->user)->name }}</td>
                                        <td>{{ optional($listing->created_at)->diffForHumans() }}</td>
                                        <td>{{ optional($listing->updated_at)->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('admin.listing.edit', $listing->id) }}"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0">No listings found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
