<?php

namespace App\Services\Tuma;

use App\Models\MpesaSTK;
use App\Support\JourneyMailer;

class TumaPaymentSync
{
    public function sync(MpesaSTK $mpesa, array $payload): MpesaSTK
    {
        $mpesa->fill([
            'status' => data_get($payload, 'status', $mpesa->status),
            'payment_id' => data_get($payload, 'payment_id', $mpesa->payment_id),
            'amount' => data_get($payload, 'amount', $mpesa->amount),
            'mpesa_receipt_number' => data_get($payload, 'mpesa_receipt_number', $mpesa->mpesa_receipt_number),
            'transaction_date' => data_get($payload, 'transaction_date', $mpesa->transaction_date),
            'phonenumber' => data_get($payload, 'phone_number', $mpesa->phonenumber),
            'payload' => $payload ?: $mpesa->payload,
        ]);
        $mpesa->save();

        $this->markInvoiceAsPaid($mpesa);

        return $mpesa->fresh();
    }

    public function markInvoiceAsPaid(MpesaSTK $mpesa): void
    {
        $invoice = $mpesa->invoice;

        if (!$invoice) {
            return;
        }

        $status = strtolower((string) data_get($mpesa->payload, 'status', $mpesa->status));

        if (!in_array($status, ['completed', 'paid', 'success'], true)) {
            return;
        }

        $previousStatus = strtoupper((string) $invoice->status);
        $invoice->status = 'PAID';
        $invoice->paid = max((float) $invoice->paid, (float) ($mpesa->amount ?? $invoice->total));
        $invoice->save();

        if ($previousStatus !== 'PAID') {
            JourneyMailer::sendInvoiceStatusUpdated($invoice, $previousStatus ?: null);
        }

        $listing = $invoice->listing;

        if ($listing && !in_array(strtolower((string) $listing->ads_status), ['approved', 'active', 'sold'], true)) {
            $oldStatus = $listing->ads_status;
            $listing->ads_status = 'Approved';
            $listing->save();
            JourneyMailer::sendListingStatusUpdated($listing, $oldStatus);
        }
    }
}
