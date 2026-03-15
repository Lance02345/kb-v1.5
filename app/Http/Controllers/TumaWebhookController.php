<?php

namespace App\Http\Controllers;

use App\Models\MpesaSTK;
use App\Support\JourneyMailer;
use Illuminate\Http\Request;

class TumaWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$this->isAuthorized($request)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $payload = $request->json()->all();

        if (empty($payload)) {
            return response()->json(['message' => 'Payload missing'], 400);
        }

        $mpesa = MpesaSTK::where('checkout_request_id', data_get($payload, 'checkout_request_id'))
            ->orWhere('merchant_request_id', data_get($payload, 'merchant_request_id'))
            ->orWhere('order_id', data_get($payload, 'order_id'))
            ->latest()
            ->first();

        if ($mpesa) {
            $mpesa->fill([
                'status' => data_get($payload, 'status', $mpesa->status),
                'payment_id' => data_get($payload, 'payment_id', $mpesa->payment_id),
                'amount' => data_get($payload, 'amount', $mpesa->amount),
                'mpesa_receipt_number' => data_get($payload, 'mpesa_receipt_number', $mpesa->mpesa_receipt_number),
                'transaction_date' => data_get($payload, 'transaction_date', $mpesa->transaction_date),
                'phonenumber' => data_get($payload, 'phone_number', $mpesa->phonenumber),
                'payload' => $payload,
            ]);
            $mpesa->save();

            $this->markInvoiceAsPaid($mpesa);
        }

        return response()->json(['success' => true]);
    }

    protected function isAuthorized(Request $request): bool
    {
        $apiKey = $request->header('X-API-Key') ?? $request->query('api_key');
        return !empty($apiKey) && $apiKey === config('tuma.api_key');
    }

    protected function markInvoiceAsPaid(MpesaSTK $mpesa): void
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
