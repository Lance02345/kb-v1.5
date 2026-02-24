@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="rounded-button">
    <a href="{{ route('admin.carmodel.index')}}" class="btn btn-primary">Back</a>
    </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Car Make Create</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.carmodel.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label>Car Make</label>
                      <select name="make_id" class="form-control input-default  @error('make_id') is-invalid @enderror">
                          <option value=" ">Choose a Make</option>
                          @foreach ($carmakes as $carmake)
                            <option value="{{$carmake->id}}">{{$carmake->make}}</option>
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
                        <input type="text" name="model" class="form-control input-default  @error('model') is-invalid @enderror" placeholder="Car model">
                            @error('model')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Car Model Year</label>
                        <input type="number" name="model_year" class="form-control input-default  @error('model_year') is-invalid @enderror" placeholder="Car model_year">
                            @error('model_year')
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