@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="rounded-button">
    <a href="{{ route('admin.carmake.index')}}" class="btn btn-primary">Back</a>
    </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Car Make Create</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.carmake.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label>Car Make</label>
                        <input type="text" name="make" class="form-control  @error('make') is-invalid @enderror" placeholder="Car make">
                            @error('make')
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