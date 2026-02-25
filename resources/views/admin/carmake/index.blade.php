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
            <h4 class="mb-1">Car Makes</h4>
            <small class="text-muted">Manage manufacturers used when creating vehicle models.</small>
        </div>
        <a href="{{route('admin.carmake.create')}}" class="btn btn-primary">Add Car Make</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if( count ($carmakes) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Car Make</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($carmakes as $carmake)
                                <tr>
                                    <td>{{$carmake->make}}</td>
                                    <td>
                                        <a href="{{ route('admin.carmake.edit',$carmake->id)}}" ><i class="fa fa-pencil color-muted m-r-5"></i> </a>
                                        <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()" class="btn btn-link p-0"><i class="fa fa-close color-danger"></i></a>
                                        <form action="{{ route('admin.carmake.destroy',$carmake->id)}}" method="post" onsubmit="return confirm('Are you sure you want to delete this car make?');">
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
                        <p class="mb-3">No car makes yet.</p>
                        <a href="{{ route('admin.carmake.create') }}" class="btn btn-primary">Create First Car Make</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
