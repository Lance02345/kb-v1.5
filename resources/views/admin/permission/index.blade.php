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
                  <h4 class="mb-1 text-white">Permissions</h4>
                  <small class="text-muted">Control granular actions that roles can perform.</small>
              </div>
              <a href="{{route('admin.permission.create')}}" class="btn btn-primary">Create Permission</a>
           </div>
     
       
       <div class="row">
           <div class="col-12">
               <div class="card">
                   <div class="card-body">
                       @if( count ($permissions) > 0)
                       <div class="table-responsive">
                           <table class="table table-striped table-bordered align-middle">
                               <thead>
                                   <tr>
                                       <th class="text-nowrap">ID</th> 
                                       <th>Permission</th> 
                                       <th class="text-nowrap">Created</th>  
                                       <th class="text-nowrap">Updated</th>            
                                       <th class="text-nowrap">Actions</th>
                                       
                                   </tr>
                               </thead>
                               <tbody>
                                 @foreach ($permissions as $permission)
                                   <tr>
                                       <td class="text-nowrap">{{$permission->id}}</td>
                                       <td>{{$permission->title}}</td>
                                       <td class="text-nowrap">
                                           @if ($permission->created_at)
                                           {{$permission->created_at->diffForHumans()}}
                                           @else
                                           -
                                           @endif
                                           
                                        </td>
                                       <td class="text-nowrap">
                                        @if ($permission->updated_at)
                                        {{$permission->updated_at->diffForHumans()}}
                                        @else
                                        -
                                        @endif
                                           </td>
                                       <td class="text-nowrap">
                                           <div class="d-inline-flex align-items-center" style="gap: 10px;">
                                               <a href="{{ route('admin.permission.edit',$permission->id)}}" title="Edit Permission"><i class="fa fa-pencil color-muted"></i></a>
                                               <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0" title="Delete Permission"><i class="fa fa-close color-danger"></i></a>
                                           </div>
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
                       <p class="mb-0 text-muted">No permissions found.</p>
                       @endif
                   </div>
               </div>
           </div>
       </div>
   </div>

@endsection
