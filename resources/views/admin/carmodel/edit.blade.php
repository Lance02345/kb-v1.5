@extends('layouts.admin')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Car Model Update</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.carmodel.update',$carmodel->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Car Make</label>
                      <select name="make_id" class="form-control input-default  @error('make_id') is-invalid @enderror">
                          <option value=" ">Choose a Make</option>
                          @foreach ($carmakes as $carmake)
                            <option value="{{$carmake->id}}"
                                @if($carmake->id == $carmodel->make_id)
                                    selected
                                @endif
                                >{{$carmake->make}}</option>
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
                        <input type="text" name="model" class="form-control input-default  @error('model') is-invalid @enderror" 
                        value="{{$carmodel->model}}">
                            @error('model')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Car Model Year</label>
                        <input type="number" name="model_year" class="form-control input-default  @error('model_year') is-invalid @enderror" 
                        value="{{$carmodel->model_year}}" >
                            @error('model_year')
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