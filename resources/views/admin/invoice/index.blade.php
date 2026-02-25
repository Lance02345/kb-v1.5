@extends('layouts.admin')
@section('content')

@if(session('success'))
    <div class="mt-3 alert alert-success">{{ session('success') }}</div>
@endif

<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 12px;">
        <div>
            <h4 class="mb-1 text-white">Invoices</h4>
            <small class="text-muted">Track billing status and package charges.</small>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($invoices) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">
                                <thead>
                                <tr>
                                    <th class="text-nowrap">ID</th>
                                    <th>Client</th>
                                    <th class="text-nowrap">Generated</th>
                                    <th class="text-nowrap">Due</th>
                                    <th class="text-nowrap">Total</th>
                                    <th class="text-nowrap">Status</th>
                                    <th>Package</th>
                                    <th class="text-nowrap">Listing ID</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td class="text-nowrap">{{ $invoice->id }}</td>
                                        <td>{{ optional($invoice->user)->name }} ({{ optional($invoice->user)->id }})</td>
                                        <td class="text-nowrap">{{ $invoice->generate_date }}</td>
                                        <td class="text-nowrap">{{ $invoice->due_date }}</td>
                                        <td class="text-nowrap">Ksh {{ number_format((float)$invoice->total) }}</td>
                                        <td class="text-nowrap">{{ $invoice->status }}</td>
                                        <td>{{ optional($invoice->package)->package_name }}</td>
                                        <td class="text-nowrap">{{ $invoice->listing_id }}</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('admin.invoice.invoice_edit', $invoice->id) }}" title="Edit Invoice"><i class="fa fa-pencil color-muted"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0 text-muted">No invoices found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
