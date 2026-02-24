@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="rounded-button">
    <a href="{{ route('admin.category.index')}}" class="btn btn-primary">Back</a>
    </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Category Create</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.category.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="category_name" class="form-control  @error('category_name') is-invalid @enderror" placeholder="Category name">
                            @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Slug </label>
                        <input type="text" name="slug" class="form-control  @error('slug') is-invalid @enderror" placeholder="Category-name">
                            @error('slug')
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