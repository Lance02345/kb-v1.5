<?php

namespace App\Http\Controllers;

use App\Models\MpesaSTK;
use App\Services\Tuma\TumaPaymentSync;
use Illuminate\Http\Request;

class TumaWebhookController extends Controller
{
    public function __construct(protected TumaPaymentSync $sync)
    {
    }

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
            $this->sync->sync($mpesa, $payload);
        }

        return response()->json(['success' => true]);
    }

    protected function isAuthorized(Request $request): bool
    {
        $apiKey = $request->header('X-API-Key') ?? $request->query('api_key');
        return !empty($apiKey) && $apiKey === config('tuma.api_key');
    }
}
