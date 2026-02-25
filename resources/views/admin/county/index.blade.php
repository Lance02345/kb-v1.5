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
                <h4 class="mb-1 text-white">Counties</h4>
                <small class="text-muted">Manage county and country mappings.</small>
            </div>
            <a href="{{route('admin.county.create')}}" class="btn btn-primary">Create County</a>
        </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($counties) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>County</th>
                                    <th>Country</th>            
                                    <th class="text-nowrap">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($counties as $county)
                                <tr>
                                    <td>{{$county->county}}</td>
                                    <td>{{$county->country}}</td>
                                    <td class="text-nowrap">
                                        <div class="d-inline-flex align-items-center" style="gap: 10px;">
                                            <a href="{{ route('admin.county.edit',$county->id)}}" title="Edit County"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0" title="Delete County"><i class="fa fa-close color-danger sweet-wrong"></i></a>
                                        </div>
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
                    <p class="mb-0 text-muted">No counties found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
