@extends('layouts.admin')
@section('content')

@if(session('success'))
    <div class="mt-3 alert alert-success">{{ session('success') }}</div>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Client Invoices</h4>

                    @if(count($invoices) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Generated</th>
                                    <th>Due</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Package</th>
                                    <th>Listing ID</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>{{ optional($invoice->user)->name }} ({{ optional($invoice->user)->id }})</td>
                                        <td>{{ $invoice->generate_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>Ksh {{ number_format((float)$invoice->total) }}</td>
                                        <td>{{ $invoice->status }}</td>
                                        <td>{{ optional($invoice->package)->package_name }}</td>
                                        <td>{{ $invoice->listing_id }}</td>
                                        <td>
                                            <a href="{{ route('admin.invoice.invoice_edit', $invoice->id) }}"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0">No invoices found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
