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
            <h4 class="card-title">Package Edit</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.package.update',$package->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Package Name</label>
                        <input type="text" name="package_name" class="form-control input-default  @error('package_name') is-invalid @enderror" 
                        placeholder="package name" value="{{$package->package_name}}">
                            @error('package_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Package Amount </label>
                        <input type="number" name="package_amount" class="form-control input-default @error('package_amount') is-invalid @enderror" 
                        placeholder="package amount" value="{{$package->package_amount}}">
                            @error('package_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Package Duration </label>
                        <input type="number" name="package_duration" class="form-control input-default  @error('package_duration') is-invalid @enderror" 
                        placeholder="package_duration" value="{{$package->package_duration}}">
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
                                <input type="checkbox" name="package_featured" class="form-check-input " value="1">Featured</label>
                        </div>   
                        @error('package_featured')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <textarea class="form-control input-default" name="description">
                            {{$package->description}}
                        </textarea>
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