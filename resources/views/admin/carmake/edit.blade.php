@extends('layouts.admin')
@section('content')
<div class="container-fluid">
<div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
    <div>
        <h4 class="mb-1">Edit Car Make</h4>
        <small class="text-muted">Update manufacturer details used by your model catalog.</small>
    </div>
    <a href="{{ route('admin.carmake.index')}}" class="btn btn-primary">Back to Car Makes</a>
</div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.carmake.update',$carmake->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Car Make</label>
                        <input type="text" name="make" class="form-control  @error('make') is-invalid @enderror" 
                        placeholder="Car make" value="{{ $carmake->make}}">
                            @error('make')
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
