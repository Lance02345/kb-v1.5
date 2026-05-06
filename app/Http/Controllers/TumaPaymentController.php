<?php

namespace App\Http\Controllers;

use App\Exceptions\TumaPaymentException;
use App\Models\Invoice;
use App\Models\MpesaSTK;
use App\Services\Tuma\TumaClient;
use App\Services\Tuma\TumaPaymentSync;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class TumaPaymentController extends Controller
{
    public function __construct(
        protected TumaClient $tuma,
        protected TumaPaymentSync $sync
    )
    {
    }

    public function store(Request $request, Invoice $invoice)
    {
        try {
            abort_if((int) $invoice->user_id !== (int) auth()->id(), 403);

            if (strtoupper((string) $invoice->status) === 'PAID') {
                return response()->json(['message' => 'Invoice is already paid.'], 409);
            }

            $data = $request->validate([
                'phone' => ['required', 'string'],
            ]);

            try {
                $result = $this->tuma->initiateSale($invoice, $data['phone']);
            } catch (TumaPaymentException $exception) {
                return response()->json(['message' => $exception->getMessage()], 422);
            }

            $normalizedPhone = $this->tuma->normalizePhone($data['phone']);

            MpesaSTK::create([
                'invoice_id' => $invoice->id,
                'order_id' => data_get($result, 'order_id'),
                'payment_id' => data_get($result, 'payment_id'),
                'merchant_request_id' => data_get($result, 'merchant_request_id'),
                'checkout_request_id' => data_get($result, 'checkout_request_id'),
                'amount' => $invoice->total,
                'phonenumber' => $normalizedPhone,
                'status' => 'pending',
                'customer_name' => data_get($result, 'customer_name', $invoice->user?->name),
                'payload' => $result,
            ]);

            return response()->json([
                'message' => 'STK prompt sent. Complete the payment on your phone.',
                'order_id' => data_get($result, 'order_id'),
            ]);
        } catch (ModelNotFoundException $exception) {
            Log::error('Invoice or related model not found during STK initiation.', [
                'exception' => $exception->getMessage(),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
            ]);
            return response()->json(['message' => 'Unable to process payment request. Please refresh and try again.'], 422);
        } catch (Throwable $exception) {
            Log::error('Unexpected error during STK initiation.', [
                'exception' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
            ]);
            return response()->json(['message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }

    public function status(Invoice $invoice)
    {
        try {
            abort_if((int) $invoice->user_id !== (int) auth()->id(), 403);

            $payment = MpesaSTK::where('invoice_id', $invoice->id)->latest()->first();

            if (!$payment) {
                return response()->json([
                    'status' => strtolower((string) $invoice->status),
                    'invoice_status' => strtoupper((string) $invoice->status),
                    'paid' => strtoupper((string) $invoice->status) === 'PAID',
                    'message' => 'No payment request has been initiated for this invoice.',
                ], 404);
            }

            $syncError = null;

            if (!empty($payment->order_id) && strtoupper((string) $invoice->status) !== 'PAID') {
                try {
                    $remote = $this->tuma->paymentStatus($payment->order_id);
                    $payment = $this->sync->sync($payment, $remote);
                    $invoice->refresh();
                } catch (TumaPaymentException $exception) {
                    Log::warning('Tuma payment status sync failed.', [
                        'invoice_id' => $invoice->id,
                        'order_id' => $payment->order_id,
                        'error' => $exception->getMessage(),
                    ]);
                    $syncError = 'Payment request sent. Waiting for confirmation from M-Pesa.';
                    $payment->refresh();
                } catch (ModelNotFoundException $exception) {
                    Log::warning('Related model not found during payment status check.', [
                        'invoice_id' => $invoice->id,
                        'order_id' => $payment->order_id,
                        'error' => $exception->getMessage(),
                    ]);
                    $syncError = 'Payment request sent. Waiting for confirmation from M-Pesa.';
                    $payment->refresh();
                } catch (Throwable $exception) {
                    Log::error('Unexpected error during payment status sync.', [
                        'invoice_id' => $invoice->id,
                        'order_id' => $payment->order_id,
                        'exception' => $exception->getMessage(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                    ]);
                    $syncError = 'Payment request sent. Waiting for confirmation from M-Pesa.';
                    $payment->refresh();
                }
            }

            return response()->json([
                'status' => strtolower((string) ($payment->status ?? $invoice->status)),
                'invoice_status' => strtoupper((string) $invoice->status),
                'paid' => strtoupper((string) $invoice->status) === 'PAID',
                'order_id' => $payment->order_id,
                'payment_id' => $payment->payment_id,
                'checkout_request_id' => $payment->checkout_request_id,
                'mpesa_receipt_number' => $payment->mpesa_receipt_number,
                'message' => strtoupper((string) $invoice->status) === 'PAID'
                    ? 'Payment confirmed.'
                    : ($syncError ?: 'Waiting for payment confirmation.'),
            ]);
        } catch (ModelNotFoundException $exception) {
            Log::error('Invoice or related model not found during status check.', [
                'exception' => $exception->getMessage(),
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'status' => 'pending',
                'invoice_status' => 'PENDING',
                'paid' => false,
                'message' => 'Payment request sent. Waiting for confirmation from M-Pesa.',
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Unexpected error during payment status check.', [
                'exception' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'status' => 'pending',
                'invoice_status' => 'PENDING',
                'paid' => false,
                'message' => 'Payment request sent. Waiting for confirmation from M-Pesa.',
            ], 200);
        }
    }
}
