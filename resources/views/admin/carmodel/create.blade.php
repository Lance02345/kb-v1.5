@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
        <div>
            <h4 class="mb-1">Create Car Model</h4>
            <small class="text-muted">Attach each model to a make.</small>
        </div>
        <a href="{{ route('admin.carmodel.index')}}" class="btn btn-primary">Back to Car Models</a>
    </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.carmodel.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label>Car Make</label>
                      <select name="make_id" class="form-control input-default  @error('make_id') is-invalid @enderror">
                          <option value="">Choose a Make</option>
                          @foreach ($carmakes as $carmake)
                            <option value="{{$carmake->id}}" {{ (string) old('make_id') === (string) $carmake->id ? 'selected' : '' }}>{{$carmake->make}}</option>
                          @endforeach
                      </select>
                        @error('make_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Car Model</label>
                        <input type="text" name="model" value="{{ old('model') }}" class="form-control input-default  @error('model') is-invalid @enderror" placeholder="Car model">
                            @error('model')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
