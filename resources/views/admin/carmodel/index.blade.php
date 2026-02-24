@extends('layouts.admin')
@section('content')

@if(session('success'))
<div class="mt-3 alert alert-success">
 <span> {{ session('success') }} </span>
</div>
@endif
<div class="container-fluid">
  
        <div class="rounded-button">
           <a href="{{route('admin.carmodel.create')}}" class="btn btn-primary">Create</a>
        
        </div>
  
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($carmodels) > 0)
                    <h4 class="card-title">Car Makes</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>carmodel</th>  
                                    <th>year</th>    
                                    <th>Make</th>            
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($carmodels as $carmodel)
                                <tr>
                                    <td>{{$carmodel->model}}</td>
                                    <td>{{$carmodel->model_year}}</td>
                                    <td>{{$carmodel->carmake->make}}</td>
                                    <td>
                                        <a href="{{ route('admin.carmodel.edit',$carmodel->id)}}" ><i class="fa fa-pencil color-muted m-r-5"></i> </a>
                                        <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0"><i class="fa fa-close color-danger"></i></a>
                                        <form action="{{ route('admin.carmodel.destroy',$carmodel->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete?');">
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
                    <p> please add car Models </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection