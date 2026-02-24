@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="rounded-button">
    <a href="{{ route('admin.invoice.index')}}" class="btn btn-primary">Back</a>
    </div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Invoice Edit</h4>
            <div class="basic-form">
                <form method="POST" action="{{ route('admin.invoice.invoice_update',$invoice->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Invoice Status</label>
                    <select name="invoice_status" class="form-control @error('invoice_paid') is-invalid @enderror">
                        <option>{{$invoice->status}}</option>
                        <option>PAID</option>
                        <option>UNPAID</option>
                        <option>CANCELLED</option>
                    </select>
                            @error('invoice_paid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Update</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
