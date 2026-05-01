<?php

namespace App\Services\Redboxx;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RedboxxGiftcardService
{
    private string $apiKey;
    private string $baseUrl;
    private int $timeout;

    public function __construct(?array $config = null)
    {
        $config = $config ?? config('services.redboxx', []);
        $this->apiKey = (string) ($config['api_key'] ?? '');
        $this->baseUrl = rtrim((string) ($config['base_url'] ?? 'https://redboxx.gifts/api/v1'), '/');
        $this->timeout = (int) ($config['timeout'] ?? 30);
    }

    public function productsByCountry(string $countryCode, array $filters = []): array
    {
        return $this->get('/cards/' . strtoupper($countryCode), $filters);
    }

    public function countries(): array
    {
        return $this->get('/countries');
    }

    public function product(int $productId): array
    {
        return $this->get("/fetch-card/{$productId}");
    }

    public function quote(array $payload): array
    {
        return $this->post('/quote', $payload);
    }

    public function order(array $payload): array
    {
        return $this->post('/order', $payload);
    }

    private function get(string $path, array $query = []): array
    {
        try {
            return $this->handle($this->client()->get($path, $query));
        } catch (\Throwable $e) {
            return $this->failure($e);
        }
    }

    private function post(string $path, array $payload): array
    {
        try {
            return $this->handle($this->client()->post($path, $payload));
        } catch (\Throwable $e) {
            return $this->failure($e);
        }
    }

    private function client(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])
            ->baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ]);
    }

    private function handle(Response $response): array
    {
        $body = $response->json();
        $body = is_array($body) ? $body : null;

        if ($response->failed()) {
            return [
                'success' => false,
                'status' => $response->status(),
                'data' => [],
                'error' => $body['message'] ?? $response->body() ?: 'Redboxx request failed',
            ];
        }

        return [
            'success' => true,
            'status' => $response->status(),
            'data' => $body['data'] ?? $body ?? [],
            'error' => null,
        ];
    }

    private function failure(\Throwable $e): array
    {
        $body = $e instanceof Exception ? $e->errorBody() : null;
        $status = $e->getCode();

        return [
            'success' => false,
            'status' => is_int($status) && $status > 0 ? $status : 0,
            'data' => [],
            'error' => $e->getMessage() ?: 'Reloadly request failed',
        ];
    }
}
