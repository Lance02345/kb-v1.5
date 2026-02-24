@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="rounded-button">
    <a href="{{ route('admin.role.index')}}" class="btn btn-primary">Back</a>
    </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Role Create</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.role.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="title" class="form-control  @error('title') is-invalid @enderror" placeholder="role name">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Add Permissions</label>
                      
                          <select type="select" name="permissions[]" class="form-control @error('permissions') is-invalid @enderror" multiple> 
                            <option value="0">
                            </option>
                            @foreach ($permissions as $permission)
                                <option value="{{$permission->id}}">{{$permission->title}}</option>
                            @endforeach
                
                        </select>
                        @error('permissions')
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
