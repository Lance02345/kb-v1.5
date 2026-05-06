<?php

namespace App\Services\Tuma;

use App\Models\MpesaSTK;
use App\Support\JourneyMailer;

class TumaPaymentSync
{
    public function sync(MpesaSTK $mpesa, array $payload): MpesaSTK
    {
        $status = $this->extract($payload, [
            'status',
            'data.status',
            'response.data.status',
            'Body.stkCallback.ResultDesc',
        ], $mpesa->status);

        $mpesa->fill([
            'status' => $status,
            'payment_id' => $this->extract($payload, ['payment_id', 'data.payment_id', 'response.data.payment_id'], $mpesa->payment_id),
            'amount' => $this->extract($payload, ['amount', 'data.amount', 'response.data.amount'], $this->callbackMetadataValue($payload, ['Amount']) ?? $mpesa->amount),
            'mpesa_receipt_number' => $this->extract($payload, ['mpesa_receipt_number', 'data.mpesa_receipt_number', 'response.data.mpesa_receipt_number'], $this->callbackMetadataValue($payload, ['MpesaReceiptNumber']) ?? $mpesa->mpesa_receipt_number),
            'transaction_date' => $this->extract($payload, ['transaction_date', 'data.transaction_date', 'response.data.transaction_date'], $this->callbackMetadataValue($payload, ['TransactionDate']) ?? $mpesa->transaction_date),
            'phonenumber' => $this->extract($payload, ['phone_number', 'data.phone_number', 'response.data.phone_number'], $this->callbackMetadataValue($payload, ['PhoneNumber']) ?? $mpesa->phonenumber),
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

        if (!$this->isSuccessfulPayment($mpesa->payload, $mpesa->status)) {
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

    protected function isSuccessfulPayment(array $payload, mixed $fallbackStatus = null): bool
    {
        $status = strtolower((string) $this->extract($payload, [
            'status',
            'data.status',
            'response.data.status',
            'Body.stkCallback.ResultDesc',
        ], $fallbackStatus));

        if (in_array($status, ['completed', 'paid', 'success', 'successful', 'succeeded'], true)) {
            return true;
        }

        $resultCode = (int) $this->extract($payload, [
            'result_code',
            'data.result_code',
            'response.data.result_code',
            'Body.stkCallback.ResultCode',
        ], -1);

        return $resultCode === 0;
    }

    protected function extract(array $payload, array $keys, mixed $default = null): mixed
    {
        foreach ($keys as $key) {
            $value = data_get($payload, $key);
            if ($value !== null && $value !== '') {
                return $value;
            }
        }

        return $default;
    }

    protected function callbackMetadataValue(array $payload, array $names): mixed
    {
        $items = data_get($payload, 'Body.stkCallback.CallbackMetadata.Item', []);

        if (!is_array($items)) {
            return null;
        }

        foreach ($items as $item) {
            $name = (string) data_get($item, 'Name');
            if (in_array($name, $names, true)) {
                $value = data_get($item, 'Value');
                if ($value !== null && $value !== '') {
                    return $value;
                }
            }
        }

        return null;
    }
}
