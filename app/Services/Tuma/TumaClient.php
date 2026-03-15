<?php

namespace App\Services\Tuma;

use App\Exceptions\TumaPaymentException;
use App\Models\Invoice;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TumaClient
{
    protected string $baseUrl;
    protected ?string $authEmail;
    protected string $apiKey;
    protected string $tokenEndpoint;
    protected string $saleEndpoint;
    protected string $paymentStatusEndpoint;
    protected int $tokenCacheTtl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('tuma.base_url', ''), '/');
        $this->apiKey = config('tuma.api_key') ?? '';
        $this->authEmail = config('tuma.auth_email');
        $this->tokenEndpoint = config('tuma.token_endpoint');
        $this->saleEndpoint = config('tuma.sale_endpoint');
        $this->paymentStatusEndpoint = config('tuma.payment_status_endpoint');
        $this->tokenCacheTtl = config('tuma.token_cache_ttl', 600);
    }

    public function initiateSale(Invoice $invoice, string $phone, ?string $description = null): array
    {
        $payload = [
            'customer_name' => $invoice->user?->name ?? 'Kingsbridge customer',
            'customer_phone' => $this->normalizePhone($phone),
            'payment_method' => 'mpesa',
            'callback_url' => config('tuma.callback_url'),
            'items' => [
                [
                    'product_id' => (string) $invoice->id,
                    'quantity' => 1,
                    'unit_price' => (int) round($invoice->total),
                    'description' => $description ?? 'Invoice #' . $invoice->id,
                ],
            ],
        ];

        $response = Http::withHeaders($this->headers())->post($this->buildUrl($this->saleEndpoint), $payload);

        return $this->handleResponse($response);
    }

    public function paymentStatus(string $orderId): array
    {
        $endpoint = str_replace('{order_id}', urlencode($orderId), $this->paymentStatusEndpoint);
        $response = Http::withHeaders($this->headers())->get($this->buildUrl($endpoint));

        return $this->handleResponse($response);
    }

    public function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (Str::startsWith($digits, '0')) {
            $digits = '254' . ltrim($digits, '0');
        }
        if (Str::startsWith($digits, '254')) {
            return $digits;
        }
        if (Str::startsWith($digits, '7') && strlen($digits) === 9) {
            return '254' . $digits;
        }
        if (Str::startsWith($digits, '1') && strlen($digits) <= 10) {
            return $digits;
        }
        return $digits;
    }

    protected function buildUrl(string $endpoint): string
    {
        $endpoint = ltrim($endpoint, '/');
        return $this->baseUrl . '/' . $endpoint;
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token(),
            'X-API-Key' => $this->apiKey,
            'Accept' => 'application/json',
        ];
    }

    protected function token(): string
    {
        if ($bearer = config('tuma.bearer_token')) {
            return $bearer;
        }

        if (empty($this->authEmail) || empty($this->apiKey)) {
            throw new TumaPaymentException('Tuma credentials are missing.');
        }

        $cacheKey = sprintf('tuma_bearer_%s_%s', md5($this->authEmail), md5($this->apiKey));

        return Cache::remember($cacheKey, $this->tokenCacheTtl, function () {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])->post($this->buildUrl($this->tokenEndpoint), [
                'email' => $this->authEmail,
                'api_key' => $this->apiKey,
            ]);

            if (!$response->successful()) {
                throw new TumaPaymentException('Unable to retrieve Tuma token: ' . $response->body());
            }

            $token = $response->json('token');

            if (empty($token)) {
                throw new TumaPaymentException('Tuma auth response did not include a token.');
            }

            return $token;
        });
    }

    protected function handleResponse(Response $response): array
    {
        if (!$response->successful()) {
            throw new TumaPaymentException('Tuma request failed: ' . $response->body());
        }

        return $response->json();
    }
}
