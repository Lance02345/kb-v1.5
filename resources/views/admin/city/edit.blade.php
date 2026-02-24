@extends('layouts.admin')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">City Update</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.city.update',$city->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>County</label>
                      <select name="county_id" class="form-control input-default  @error('county_id') is-invalid @enderror">
                          <option value=" ">Choose a County</option>
                          @foreach ($counties as $county)
                            <option value="{{$county->id}}"
                                @if ($county->id==$city->county_id)
                                    selected
                                @endif
                                >{{$county->county}}</option>
                          @endforeach
                      </select>
                            @error('county_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control  @error('city') is-invalid @enderror" 
                        placeholder="city" value="{{$city->city}}">
                            @error('city')
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