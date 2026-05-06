<?php

namespace App\Http\Controllers;

use App\Models\MpesaSTK;
use App\Services\Tuma\TumaPaymentSync;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TumaWebhookController extends Controller
{
    public function __construct(protected TumaPaymentSync $sync)
    {
    }

    public function __invoke(Request $request)
    {
        if (!$this->isAuthorized($request)) {
            Log::warning('Tuma webhook unauthorized request.', [
                'ip' => $request->ip(),
                'has_api_key' => !empty($request->header('X-API-Key') ?? $request->query('api_key')),
            ]);
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $payload = $request->json()->all();

        if (empty($payload)) {
            Log::warning('Tuma webhook payload missing.', [
                'ip' => $request->ip(),
                'content_type' => $request->header('Content-Type'),
            ]);
            return response()->json(['message' => 'Payload missing'], 400);
        }

        $checkoutRequestId = $this->extract($payload, [
            'checkout_request_id',
            'data.checkout_request_id',
            'response.data.checkout_request_id',
            'CheckoutRequestID',
            'Body.stkCallback.CheckoutRequestID',
        ]);

        $merchantRequestId = $this->extract($payload, [
            'merchant_request_id',
            'data.merchant_request_id',
            'response.data.merchant_request_id',
            'MerchantRequestID',
            'Body.stkCallback.MerchantRequestID',
        ]);

        $orderId = $this->extract($payload, [
            'order_id',
            'data.order_id',
            'response.data.order_id',
            'reference',
        ]);

        if (empty($orderId)) {
            $orderId = $this->callbackMetadataValue($payload, ['AccountReference', 'BillRefNumber']);
        }

        Log::info('Tuma webhook callback received.', [
            'checkout_request_id' => $checkoutRequestId,
            'merchant_request_id' => $merchantRequestId,
            'order_id' => $orderId,
            'status' => $this->extract($payload, ['status', 'data.status', 'response.data.status', 'Body.stkCallback.ResultDesc']),
            'result_code' => $this->extract($payload, ['result_code', 'data.result_code', 'response.data.result_code', 'Body.stkCallback.ResultCode']),
            'payload' => $payload,
        ]);

        $mpesa = MpesaSTK::query()
            ->when(!empty($checkoutRequestId), function ($query) use ($checkoutRequestId) {
                $query->where('checkout_request_id', $checkoutRequestId);
            })
            ->when(!empty($merchantRequestId), function ($query) use ($merchantRequestId) {
                $query->orWhere('merchant_request_id', $merchantRequestId);
            })
            ->when(!empty($orderId), function ($query) use ($orderId) {
                $query->orWhere('order_id', $orderId);
            })
            ->latest()
            ->first();

        if ($mpesa) {
            $this->sync->sync($mpesa, $payload);
            Log::info('Tuma webhook payment synchronized.', [
                'mpesa_stk_id' => $mpesa->id,
                'invoice_id' => $mpesa->invoice_id,
            ]);
        } else {
            Log::warning('Tuma webhook could not match payment record.', [
                'checkout_request_id' => $checkoutRequestId,
                'merchant_request_id' => $merchantRequestId,
                'order_id' => $orderId,
            ]);
        }

        return response()->json(['success' => true]);
    }

    protected function extract(array $payload, array $keys): mixed
    {
        foreach ($keys as $key) {
            $value = data_get($payload, $key);
            if ($value !== null && $value !== '') {
                return $value;
            }
        }

        return null;
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

    protected function isAuthorized(Request $request): bool
    {
        $apiKey = $request->header('X-API-Key') ?? $request->query('api_key');
        return !empty($apiKey) && $apiKey === config('tuma.api_key');
    }
}
