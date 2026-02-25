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
                <h4 class="mb-1 text-white">Cities</h4>
                <small class="text-muted">Manage city records by county.</small>
            </div>
            <a href="{{route('admin.city.create')}}" class="btn btn-primary">Create City</a>
        </div>
  
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($cities) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>City</th>
                                    <th>County</th>            
                                    <th class="text-nowrap">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($cities as $city)
                                <tr>
                                    <td>{{$city->city}}</td>
                                    <td>{{$city->county->county}}</td>
                                    <td class="text-nowrap">
                                        <div class="d-inline-flex align-items-center" style="gap: 10px;">
                                            <a href="{{ route('admin.city.edit',$city->id)}}" title="Edit City"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0" title="Delete City"><i class="fa fa-close color-danger"></i></a>
                                        </div>
                                        <form action="{{ route('admin.city.destroy',$city->id)}}" method="post" onsubmit="return confirm('Are you sure want to delete?');">
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
                    <p class="mb-0 text-muted">No cities found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
