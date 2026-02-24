@extends('layouts.admin')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Category Update</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.category.update',$category->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="category_name" class="form-control  @error('category_name') is-invalid @enderror" 
                        placeholder="Category name" value="{{$category->category_name}}">
                            @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Slug </label>
                        <input type="text" name="slug" class="form-control  @error('slug') is-invalid @enderror" 
                        placeholder="Category-name" value="{{$category->slug}}">
                            @error('slug')
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