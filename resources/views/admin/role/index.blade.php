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
                  <h4 class="mb-1 text-white">Roles</h4>
                  <small class="text-muted">Manage role definitions and attached permissions.</small>
              </div>
              <a href="{{route('admin.role.create')}}" class="btn btn-primary">Create Role</a>
           </div>
     
       
       <div class="row">
           <div class="col-12">
               <div class="card">
                   <div class="card-body">
                       @if( count ($roles) > 0)
                       <div class="table-responsive">
                           <table class="table table-striped table-bordered align-middle">
                               <thead>
                                   <tr>
                                       <th class="text-nowrap">ID</th> 
                                       <th>Role</th> 
                                       <th>Permissions</th> 
                                       <th class="text-nowrap">Created</th>  
                                       <th class="text-nowrap">Updated</th>            
                                       <th class="text-nowrap">Actions</th>
                                       
                                   </tr>
                               </thead>
                               <tbody>
                                 @foreach ($roles as $role)
                                   <tr>
                                       <td class="text-nowrap">{{$role->id}}</td>
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
                                       <td class="text-nowrap">
                                           @if ($role->created_at)
                                           {{$role->created_at->diffForHumans()}}
                                           @else
                                           -
                                           @endif
                                           
                                        </td>
                                       <td class="text-nowrap">
                                        @if ($role->updated_at)
                                        {{$role->updated_at->diffForHumans()}}
                                        @else
                                        -
                                        @endif
                                           </td>
                                       <td class="text-nowrap">
                                           <div class="d-inline-flex align-items-center" style="gap: 10px;">
                                               <a href="{{ route('admin.role.edit',$role->id)}}" title="Edit Role"><i class="fa fa-pencil color-muted"></i></a>
                                               <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0" title="Delete Role"><i class="fa fa-close color-danger"></i></a>
                                           </div>
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
                       <p class="mb-0 text-muted">No roles found.</p>
                       @endif
                   </div>
               </div>
           </div>
       </div>
   </div>

@endsection
