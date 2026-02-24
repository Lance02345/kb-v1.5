@extends('layouts.admin')
@section('content')

@if(session('success'))
    <div class="mt-3 alert alert-success">
    <span> {{ session('success') }} </span>
   </div>
   @endif
   <div class="container-fluid">
     
           <div class="rounded-button">
              <a href="{{route('admin.role.create')}}" class="btn btn-primary">Create</a>
           
           </div>
     
       
       <div class="row">
           <div class="col-12">
               <div class="card">
                   <div class="card-body">
                       @if( count ($roles) > 0)
                       <h4 class="card-title">roles</h4>
                       <div class="table-responsive">
                           <table class="table table-striped table-bordered">
                               <thead>
                                   <tr>
                                       <th>ID</th> 
                                       <th>Role</th> 
                                       <th>Permissions</th> 
                                       <th>created_at</th>  
                                       <th>updated_at</th>            
                                       <th>Actions</th>
                                       
                                   </tr>
                               </thead>
                               <tbody>
                                 @foreach ($roles as $role)
                                   <tr>
                                       <td>{{$role->id}}</td>
                                       <td>{{$role->title}}</td>
                                       <td>
                                           
                                        @if ($role->permissions != null)
                                    
                                        @foreach ($role->permissions as $permission)
                                        <span class="badge badge-info">
                                            {{ $permission->title }}                                    
                                        </span>
                                        @endforeach
                                    
                                    @endif
                                        </td>
                                       <td>
                                           @if ($role->created_at)
                                           {{$role->created_at->diffForHumans()}}
                                           @endif
                                           
                                        </td>
                                       <td>
                                        @if ($role->updated_at)
                                        {{$role->updated_at->diffForHumans()}}
                                        @endif
                                           </td>
                                       <td>
                                           <a href="{{ route('admin.role.edit',$role->id)}}" ><i class="fa fa-pencil color-muted m-r-5"></i> </a>
                                    
                                           <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0"><i class="fa fa-close color-danger"></i></a>
                                           <form action="{{ route('admin.role.destroy',$role->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete?');">
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
                       <p> please add roles </p>
                       @endif
                   </div>
               </div>
           </div>
       </div>
   </div>

@endsection