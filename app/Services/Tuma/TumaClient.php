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
    protected ?string $productId;
    protected int $tokenCacheTtl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('tuma.base_url', ''), '/');
        $this->apiKey = config('tuma.api_key') ?? '';
        $this->authEmail = config('tuma.auth_email');
        $this->tokenEndpoint = config('tuma.token_endpoint');
        $this->saleEndpoint = config('tuma.sale_endpoint');
        $this->paymentStatusEndpoint = config('tuma.payment_status_endpoint');
        $this->productId = config('tuma.product_id');
        $this->tokenCacheTtl = config('tuma.token_cache_ttl', 600);
    }

    public function initiateSale(Invoice $invoice, string $phone, ?string $description = null): array
    {
        $item = array_filter([
            'product_id' => $this->productId ? (string) $this->productId : null,
            'quantity' => 1,
            'unit_price' => (int) round((float) $invoice->total),
            'description' => $description ?? 'Invoice #' . $invoice->id,
        ]);

        $payload = [
            'customer_name' => $invoice->user?->name ?? 'Kingsbridge customer',
            'customer_phone' => $this->normalizePhone($phone),
            'payment_method' => 'mpesa',
            'callback_url' => $this->callbackUrl(),
            'items' => [$item],
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

    public function callbackUrl(): string
    {
        $callbackUrl = config('tuma.callback_url') ?: url('/webhook/tuma');

        if (empty($this->apiKey)) {
            return $callbackUrl;
        }

        $parts = parse_url($callbackUrl);
        $query = [];

        if (!empty($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        $query['api_key'] = $query['api_key'] ?? $this->apiKey;

        $scheme = isset($parts['scheme']) ? $parts['scheme'] . '://' : '';
        $host = $parts['host'] ?? '';
        $port = isset($parts['port']) ? ':' . $parts['port'] : '';
        $user = $parts['user'] ?? '';
        $pass = isset($parts['pass']) ? ':' . $parts['pass'] : '';
        $auth = $user !== '' ? $user . $pass . '@' : '';
        $path = $parts['path'] ?? '';
        $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';

        return $scheme . $auth . $host . $port . $path . '?' . http_build_query($query) . $fragment;
    }

    protected function buildUrl(string $endpoint): string
    {
        $endpoint = ltrim($endpoint, '/');
        return $this->baseUrl . '/' . $endpoint;
    }

    protected function headers(): array
    {
        $headers = [
            'X-API-Key' => $this->apiKey,
            'Accept' => 'application/json',
        ];

        if ($token = $this->token()) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }

    protected function token(): ?string
    {
        if ($bearer = config('tuma.bearer_token')) {
            return $bearer;
        }

        if (empty($this->authEmail)) {
            return null;
        }

        if (empty($this->apiKey)) {
            throw new TumaPaymentException('Tuma API key is missing.');
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
