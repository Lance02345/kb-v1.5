<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 12px; }
        .wrap { max-width: 760px; margin: 0 auto; }
        .row { width: 100%; margin-bottom: 18px; }
        .title { font-size: 24px; font-weight: 700; margin-bottom: 4px; }
        .muted { color: #6b7280; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 999px; font-size: 10px; font-weight: 700; }
        .paid { background: #dcfce7; color: #166534; }
        .unpaid { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 10px; text-align: left; }
        th { background: #f9fafb; }
        .right { text-align: right; }
    </style>
</head>
<body>
<div class="wrap">
    @php($invoiceStatus = strtoupper((string) $invoice->status))
    @php($invoicePackageName = optional($invoice->package)->package_name ?: 'Free Plan')
    @php($invoiceAmount = (float) ($invoice->total ?? optional($invoice->package)->package_amount ?? 0))

    <div class="row">
        <div class="title">Invoice #{{ $invoice->id }}</div>
        <div class="muted">Generated: {{ $invoice->generate_date }} | Due: {{ $invoice->due_date }}</div>
        <div style="margin-top:8px;">
            <span class="badge {{ $invoiceStatus === 'PAID' ? 'paid' : 'unpaid' }}">{{ $invoiceStatus }}</span>
        </div>
    </div>

    <div class="row">
        <table>
            <tr>
                <td style="width:50%; vertical-align: top;">
                    <strong>Invoiced To</strong><br>
                    {{ $invoice->user->name }}<br>
                    {{ $invoice->user->address }}
                </td>
                <td style="width:50%; vertical-align: top;">
                    <strong>Pay To</strong><br>
                    Kingsbridge Motors<br>
                    P.O Box 60278-00200, Nairobi - Kenya<br>
                    info@kingsbridge.com
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table>
            <thead>
            <tr>
                <th>Description</th>
                <th class="right">Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    {{ $invoicePackageName }}<br>
                    Payment ID: {{ $invoice->id }}<br>
                    Listing ID: {{ $invoice->listing_id }}
                </td>
                <td class="right">Ksh {{ number_format($invoiceAmount) }}</td>
            </tr>
            <tr>
                <td>Subtotal</td>
                <td class="right">Ksh {{ number_format($invoiceAmount) }}</td>
            </tr>
            <tr>
                <td>VAT</td>
                <td class="right">{{ $invoice->tax }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td class="right"><strong>Ksh {{ number_format($invoiceAmount) }}</strong></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
