<?php

namespace App\Http\Controllers;

use App\Exceptions\TumaPaymentException;
use App\Models\Invoice;
use App\Models\MpesaSTK;
use App\Services\Tuma\TumaClient;
use Illuminate\Http\Request;

class TumaPaymentController extends Controller
{
    public function __construct(protected TumaClient $tuma)
    {
    }

    public function store(Request $request, Invoice $invoice)
    {
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
    }
}
