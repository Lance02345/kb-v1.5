@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="rounded-button">
        <a href="{{ route('admin.listing.index')}}" class="btn btn-primary">Back</a>
        </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Listing Update</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.listing.update',$listing->id) }}" >
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Ad Status</label>
                        <select name="ads_status" class="form-control  @error('ads_status') is-invalid @enderror" >
                            <option selected>{{$listing->ads_status}}</option>
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Active</option>
                            <option>Sold</option>
                            <option>Expired</option>
                            <option>Archived</option>
                        </select>
                        
                            @error('ads_status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Ad Duration</label>
                        <select name="ads_duration" class="form-control  @error('ads_duration') is-invalid @enderror" >
                            <option selected>{{$listing->ads_duration}}</option>
                            <option>3</option>
                            <option>15</option>
                            <option>30</option>
                            <option>60</option>
                        </select>
                        
                            @error('ads_duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Ad Featured</label>
                        <select name="ads_featured" class="form-control  @error('ads_featured') is-invalid @enderror" >
                            <option selected>{{$listing->ads_featured}}</option>
                            <option>Featured</option>
                            <option>Not-Featured</option>
                        </select>
                        
                            @error('ads_featured')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Status Note (optional, emailed to seller)</label>
                        <textarea name="status_reason" rows="3" class="form-control @error('status_reason') is-invalid @enderror" placeholder="Optional note to seller, e.g. why listing was rejected or what to fix.">{{ old('status_reason') }}</textarea>
                        @error('status_reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
               
               
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
