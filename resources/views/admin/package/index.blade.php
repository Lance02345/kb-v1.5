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
                <h4 class="mb-1 text-white">Packages</h4>
                <small class="text-muted">Configure listing plans and feature limits.</small>
            </div>
            <a href="{{route('admin.package.create')}}" class="btn btn-primary">Create Package</a>
        </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($packages) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                
                                <tr>
                                    <th class="text-nowrap">Package ID</th> 
                                    <th>Package Name</th> 
                                    <th class="text-nowrap">Amount</th> 
                                    <th class="text-nowrap">Duration</th> 
                                    <th class="text-nowrap">Featuring</th>        
                                    <th class="text-nowrap">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($packages as $package)
                                <tr>
                                    <td class="text-nowrap">{{$package->id}}</td>
                                    <td>{{$package->package_name}}</td>
                                    <td class="text-nowrap">{{$package->package_amount}}</td>
                                    <td class="text-nowrap">{{$package->package_duration}}</td>
                                    <td class="text-nowrap">{{$package->package_featured}}</td>
                                    
                                   
                                    <td class="text-nowrap">
                                        <div class="d-inline-flex align-items-center" style="gap: 10px;">
                                            <a href="{{ route('admin.package.edit',$package->id)}}" title="Edit Package"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0" title="Delete Package"><i class="fa fa-close color-danger"></i></a>
                                        </div>
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
                    <p class="mb-0 text-muted">No packages found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
