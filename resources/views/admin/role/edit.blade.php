@extends('layouts.admin')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Role Update</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.role.update',$role->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="title" class="form-control  @error('title') is-invalid @enderror" 
                        placeholder="role name" value="{{$role->title}}" >
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label class="required" for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple required>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}" {{ ( $role->permissions->contains($permission)) ? 'selected' : '' }}>{{ $permission->title }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('permissions'))
                            <div class="invalid-feedback">
                                {{ $errors->first('permissions') }}
                            </div>
                        @endif
                      
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