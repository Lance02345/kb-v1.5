@extends('layouts.admin')
@section('content')

@if(session('success'))
<div class="mt-3 alert alert-success">
 <span> {{ session('success') }} </span>
</div>
@endif
<div class="container-fluid">
  
        <div class="rounded-button">
           <a href="{{route('admin.package.create')}}" class="btn btn-primary">Create</a>
        
        </div>
  
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($packages) > 0)
                    <h4 class="card-title">packages</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                
                                <tr>
                                    <th>package ID</th> 
                                    <th>package Name</th> 
                                    <th>package Amount</th> 
                                    <th>package Duration</th> 
                                    <th>package Featuring</th>        
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($packages as $package)
                                <tr>
                                    <td>{{$package->id}}</td>
                                    <td>{{$package->package_name}}</td>
                                    <td>{{$package->package_amount}}</td>
                                    <td>{{$package->package_duration}}</td>
                                    <td>{{$package->package_featured}}</td>
                                    
                                   
                                    <td>
                                        <a href="{{ route('admin.package.edit',$package->id)}}" ><i class="fa fa-pencil color-muted m-r-5"></i> </a>
                                        <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0"><i class="fa fa-close color-danger"></i></a>
                                        <form action="{{ route('admin.package.destroy',$package->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete?');">
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
                    <p> please add packages </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection