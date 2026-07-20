<?php

namespace App\Services\Reloadly;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReloadlyGiftcardService
{
    private const ACCEPT_HEADER = 'application/com.reloadly.giftcards-v1+json';
    private const ACCEPT_HEADER_V2 = 'application/com.reloadly.giftcards-v2+json';

    private string $clientId;
    private string $clientSecret;
    private string $authUrl;
    private string $baseUrl;
    private string $audience;
    private int $timeout;

    public function __construct(?array $config = null)
    {
        $config = $config ?? config('services.reloadly', []);

        $this->clientId = (string) ($config['client_id'] ?? '');
        $this->clientSecret = (string) ($config['client_secret'] ?? '');
        $this->authUrl = rtrim((string) ($config['auth_url'] ?? 'https://auth.reloadly.com'), '/');
        $this->baseUrl = rtrim((string) ($config['base_url'] ?? 'https://giftcards.reloadly.com'), '/');
        $this->audience = rtrim((string) $this->baseUrl, '/');
        $this->timeout = (int) ($config['timeout'] ?? 30);
    }

    public function countries(): array
    {
        return $this->get('/countries');
    }

    public function products(array $filters = []): array
    {
        return $this->get('/products', $filters);
    }

    public function product(int $productId): array
    {
        return $this->get("/products/{$productId}");
    }

    public function productsByCountry(string $countryCode, array $filters = []): array
    {
        return $this->get('/countries/' . strtoupper($countryCode).'/products', $filters);
    }

    public function discounts(array $filters = []): array
    {
        return $this->get('/discounts', $filters);
    }

    public function productDiscount(int $productId): array
    {
        return $this->get("/products/{$productId}/discounts");
    }

    public function balance(): array
    {
        return $this->get('/accounts/balance');
    }

    public function fxRate(int $productId, float $amount): array
    {
        return $this->get('/fx-rate', [
            'productId' => $productId,
            'amount' => $amount,
        ]);
    }

    /**
     * Place a gift card order.
     *
     * Required keys: productId, countryCode, quantity, unitPrice, customIdentifier, recipientEmail.
     * Optional: senderName, recipientPhoneDetails, preOrder.
     */
    public function order(array $payload): array
    {
        $payload['customIdentifier'] = $payload['customIdentifier'] ?? (string) Str::uuid();

        return $this->post('/orders', $payload);
    }

    public function transactions(array $filters = []): array
    {
        return $this->get('/orders/transactions', $filters);
    }

    public function transaction(int $transactionId): array
    {
        return $this->get("/orders/transactions/{$transactionId}");
    }

    public function redeemCodes(int $transactionId): array
    {
        return $this->get("/orders/transactions/{$transactionId}/cards", [], true);
    }

    public function flushToken(): void
    {
        Cache::forget($this->tokenCacheKey());
    }

    private function get(string $path, array $query = [], bool $redeem = false): array
    {
        try {
            return $this->handle($this->client($redeem)->get($path, $query));
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

    private function client($redeem = false): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->withToken($this->token())
            ->withHeaders([
                'Accept' => $redeem == false ? self::ACCEPT_HEADER : self::ACCEPT_HEADER_V2,
                'Content-Type' => 'application/json',
            ]);
    }

    private function token(): string
    {
        return Cache::remember($this->tokenCacheKey(), now()->addHours(23), function () {
            $response = Http::acceptJson()
                ->asJson()
                ->timeout($this->timeout)
                ->post($this->authUrl . '/oauth/token', [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'client_credentials',
                    'audience' => $this->audience,
                ]);

            if ($response->failed()) {
                throw new Exception(
                    'Reloadly authentication failed: ' . ($response->json('error_description') ?? $response->body()),
                    $response->status(),
                    $response->json(),
                );
            }

            return (string) $response->json('access_token');
        });
    }

    private function tokenCacheKey(): string
    {
        return 'reloadly:giftcards:token:' . md5($this->clientId . '|' . $this->audience);
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
                'error' => $body['message'] ?? $body['errorMessage'] ?? $response->body() ?: 'Request failed',
            ];
        }

        return [
            'success' => true,
            'status' => $response->status(),
            'data' => $body ?? [],
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
            'error' => $e->getMessage() ?: 'Request failed',
        ];
    }
}
