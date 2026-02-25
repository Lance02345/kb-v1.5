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
            <h4 class="mb-1 text-white">Car Models</h4>
            <small class="text-muted">Manage model names and make relationships.</small>
        </div>
        <a href="{{route('admin.carmodel.create')}}" class="btn btn-primary">Add Car Model</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($carmodels) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Model</th>
                                    <th class="text-nowrap">Year</th>
                                    <th>Make</th>            
                                    <th class="text-nowrap">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($carmodels as $carmodel)
                                <tr>
                                    <td>{{$carmodel->model}}</td>
                                    <td class="text-nowrap">{{$carmodel->model_year ?: '-'}}</td>
                                    <td>{{ optional($carmodel->carmake)->make ?? '-' }}</td>
                                    <td class="text-nowrap">
                                        <div class="d-inline-flex align-items-center" style="gap: 10px;">
                                            <a href="{{ route('admin.carmodel.edit',$carmodel->id)}}" title="Edit Car Model"><i class="fa fa-pencil color-muted"></i></a>
                                            <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0" title="Delete Car Model"><i class="fa fa-close color-danger"></i></a>
                                        </div>
                                        <form action="{{ route('admin.carmodel.destroy',$carmodel->id)}}" method="post" onsubmit="return confirm('Are you sure you want to delete this car model?');">
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
                    <div class="text-center py-4">
                        <p class="mb-3">No car models yet.</p>
                        <a href="{{ route('admin.carmodel.create') }}" class="btn btn-primary">Create First Car Model</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
