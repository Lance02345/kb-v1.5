@extends('layouts.admin')
@section('content')

@if(session('success'))
<div class="mt-3 alert alert-success">
 <span> {{ session('success') }} </span>
</div>
@endif
<div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
            <div>
                <h4 class="mb-1 text-white">Categories</h4>
                <small class="text-muted">Organize listings by vehicle and service category.</small>
            </div>
            <a href="{{route('admin.category.create')}}" class="btn btn-primary">Create Category</a>
        </div>

    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($categories) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th> 
                                    <th>Category</th>          
                                    <th class="text-nowrap">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($categories as $category)
                                <tr>
                                    <td class="text-nowrap">{{$category->id}}</td>
                                    <td>{{$category->category_name}}</td>
                                    <td class="text-nowrap">
                                        <div class="d-inline-flex align-items-center" style="gap: 10px;">
                                            <a href="{{ route('admin.category.edit',$category->id)}}" title="Edit Category"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0" title="Delete Category"><i class="fa fa-close color-danger"></i></a>
                                        </div>
                                        <form action="{{ route('admin.category.destroy',$category->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete?');">
                                            @method('DELETE')
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </form>
                                      
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
            
                        </table>
                    </div>
                    @else
                    <p class="mb-0 text-muted">No categories found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
