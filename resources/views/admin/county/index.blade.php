@extends('layouts.admin')
@section('content')

@if(session('success'))
<div class="mt-3 alert alert-success">
 <span> {{ session('success') }} </span>
</div>
@endif
<div class="container-fluid">
  
        <div class="rounded-button">
           <a href="{{route('admin.county.create')}}" class="btn btn-primary">Create</a>
        
        </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($counties) > 0)
                    <h4 class="card-title">Counties</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>county</th>
                                    <th>country</th>            
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($counties as $county)
                                <tr>
                                    <td>{{$county->county}}</td>
                                    <td>{{$county->country}}</td>
                                    <td>
                                        <a href="{{ route('admin.county.edit',$county->id)}}" ><i class="fa fa-pencil color-muted m-r-5"></i> </a>
                                        <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0"><i class="fa fa-close color-danger sweet-wrong"></i></a>
                                        <form action="{{ route('admin.county.destroy',$county->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete?');">
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
                    <p> please add Counties </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection