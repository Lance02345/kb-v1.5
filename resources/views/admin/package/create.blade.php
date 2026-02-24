@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="rounded-button">
    <a href="{{ route('admin.package.index')}}" class="btn btn-primary">Back</a>
    </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Package Create</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.package.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label>Package Name</label>
                        <input type="text" name="package_name" class="form-control input-default  @error('package_name') is-invalid @enderror" placeholder="package name">
                            @error('package_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Package Amount </label>
                        <input type="number" name="package_amount" class="form-control input-default @error('package_amount') is-invalid @enderror" placeholder="package amount">
                            @error('package_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Package Duration </label>
                        <input type="number" name="package_duration" class="form-control input-default  @error('package_duration') is-invalid @enderror" placeholder="package_duration">
                            @error('package_duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Package Featuring </label>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" name="package_featured" class="form-check-input input-default " value="1">Featured</label>
                        </div>   
                        @error('package_featured')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <textarea class="form-control input-default" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection