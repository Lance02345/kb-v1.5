@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="rounded-button">
    <a href="{{ route('admin.user.index')}}" class="btn btn-primary">Back</a>
    </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">user Create</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.user.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control input-default  @error('name') is-invalid @enderror" placeholder="Full name"
                        value="{{ old('name') }}" >
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input id="email" type="email" class="form-control input-default @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="form-group ">
                        <label>Password</label>
                            <input id="password" type="password" class="form-control input-default @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group ">
                        <label>Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control input-default" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label>Phone Number </label>
                        <input type="text" name="phone_number" class="form-control input-default @error('phone_number') is-invalid @enderror" placeholder="+25492947351"
                        value="{{ old('phone_number') }}"  >
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="role">Select Role</label>
                
                        <select class="role form-control" name="role" id="role">
                            <option value="">Select Role...</option>
                            @foreach ($roles as $role)
                            <option  value="{{$role->id}}">{{$role->title}}</option>
                            @endforeach
                        </select>
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

  