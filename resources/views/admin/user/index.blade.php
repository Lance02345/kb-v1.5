@extends('layouts.admin')
@section('content')

@if(session('success'))
<div class="mt-3 alert alert-success">
 <span> {{ session('success') }} </span>
</div>
@endif
<div class="container-fluid">
    @can('user-access')
        <div class="rounded-button">
           <a href="{{route('admin.user.create')}}" class="btn btn-primary">Create</a>
        
        </div>
    @endcan
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($users) > 0)
                    <h4 class="card-title">users</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th> 
                                    <th>Email</th> 
                                    <th>Phone</th> 
                                    <th>Role</th>
                                    <th>User Type</th>
                                    <th>created_at</th>  
                                    <th>updated_at</th>            
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone_number}}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                         <span class="badge badge-info">{{ $role->title }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{$user->user_type}}</td>
                                    <td>
                                        @if ($user->created_at)
                                        {{$user->created_at->diffForHumans()}}
                                        @endif
                                   
                                    </td>
                                    <td>
                                        @if ($user->updated_at)
                                        {{$user->updated_at->diffForHumans()}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.edit',$user->id)}}" ><i class="fa fa-pencil color-muted m-r-5"></i> </a>
                                        <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0"><i class="fa fa-close color-danger"></i></a>
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
                    <p> please add users </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection