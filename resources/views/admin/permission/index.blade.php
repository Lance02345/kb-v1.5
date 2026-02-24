@extends('layouts.admin')
@section('content')

@if(session('success'))
<div class="mt-3 alert alert-success">
    <span> {{ session('success') }} </span>
   </div>
   @endif
   <div class="container-fluid">
     
           <div class="rounded-button">
              <a href="{{route('admin.permission.create')}}" class="btn btn-primary">Create</a>
           
           </div>
     
       
       <div class="row">
           <div class="col-12">
               <div class="card">
                   <div class="card-body">
                       @if( count ($permissions) > 0)
                       <h4 class="card-title">permissions</h4>
                       <div class="table-responsive">
                           <table class="table table-striped table-bordered">
                               <thead>
                                   <tr>
                                       <th>ID</th> 
                                       <th>permission</th> 
                                       <th>created_at</th>  
                                       <th>updated_at</th>            
                                       <th>Actions</th>
                                       
                                   </tr>
                               </thead>
                               <tbody>
                                 @foreach ($permissions as $permission)
                                   <tr>
                                       <td>{{$permission->id}}</td>
                                       <td>{{$permission->title}}</td>
                                       <td>
                                           @if ($permission->created_at)
                                           {{$permission->created_at->diffForHumans()}}
                                           @endif
                                           
                                        </td>
                                       <td>
                                        @if ($permission->updated_at)
                                        {{$permission->updated_at->diffForHumans()}}
                                        @endif
                                           </td>
                                       <td>
                                           <a href="{{ route('admin.permission.edit',$permission->id)}}" ><i class="fa fa-pencil color-muted m-r-5"></i> </a>
                                           <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0"><i class="fa fa-close color-danger"></i></a>
                                           <form action="{{ route('admin.permission.destroy',$permission->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete?');">
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
                       <p> please add permissions </p>
                       @endif
                   </div>
               </div>
           </div>
       </div>
   </div>

@endsection