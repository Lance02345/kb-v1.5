@extends('layouts.admin')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">County Update</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.county.update',$county->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>County</label>
                        <input type="text" name="county" class="form-control  @error('county') is-invalid @enderror" 
                        placeholder="county" value="{{$county->county}}">
                            @error('county')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" name="country" class="form-control  @error('country') is-invalid @enderror"
                        placeholder="Kenya" value="{{$county->country}}">
                            @error('country')
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