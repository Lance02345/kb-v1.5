@extends('layouts.admin')
@section('content')

@if(session('success'))
<div class="mt-3 alert alert-success">
 <span> {{ session('success') }} </span>
</div>
@endif
<div class="container-fluid">
    @can('user-access')
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
            <div>
                <h4 class="mb-1 text-white">Users</h4>
                <small class="text-muted">Manage accounts, roles, and access levels.</small>
            </div>
            <a href="{{route('admin.user.create')}}" class="btn btn-primary">Create User</a>
        </div>
    @endcan
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($users) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Name</th> 
                                    <th>Email</th> 
                                    <th>Phone</th> 
                                    <th>Role</th>
                                    <th>User Type</th>
                                    <th class="text-nowrap">Created</th>
                                    <th class="text-nowrap">Updated</th>            
                                    <th class="text-nowrap">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td class="text-nowrap">{{$user->email}}</td>
                                    <td class="text-nowrap">{{$user->phone_number ?: '-'}}</td>
                                    <td>
                                        @php($hasRole = false)
                                        @foreach($user->roles as $role)
                                            @php($hasRole = true)
                                         <span class="badge badge-info">{{ $role->title }}</span>
                                        @endforeach
                                        @if(!$hasRole)
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{$user->user_type ?: '-'}}</td>
                                    <td class="text-nowrap">
                                        @if ($user->created_at)
                                        {{$user->created_at->diffForHumans()}}
                                        @else
                                        -
                                        @endif
                                   
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($user->updated_at)
                                        {{$user->updated_at->diffForHumans()}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="d-inline-flex align-items-center" style="gap: 10px;">
                                            <a href="{{ route('admin.user.edit',$user->id)}}" title="Edit User"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0" title="Delete User"><i class="fa fa-close color-danger"></i></a>
                                        </div>
                                        <form action="{{ route('admin.user.destroy',$user->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete?');">
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
                    <p class="mb-0 text-muted">No users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
