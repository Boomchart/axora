<?php

namespace App\Services\Hasapay;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class HasapayService
{
    private string $apiKey;
    private string $secretKey;
    private string $webhook_hash;
    private string $baseUrl;
    private string $mode;
    private int $timeout;

    public function __construct($mode = 'live', ?array $config = null)
    {
        $config = $config ?? config('services.hasapay', []);
        $this->apiKey = (string) decryptRSA(($config['api_key'] ?? ''));
        $this->secretKey = (string) decryptRSA(($config['secret_key'] ?? ''));
        $this->webhook_hash = (string) decryptRSA(($config['webhook_hash'] ?? ''));
        $this->baseUrl = rtrim((string) ($config['base_url'] ?? 'https://apitest.hasapay.com/api/v1'), '/');
        $this->timeout = (int) ($config['timeout'] ?? 30);
        $this->mode = $mode;
    }

    public function walletData(): array
    {
        if ($this->mode == 'live') {
            $data = [
                [
                    'network' => 'ETH',
                    'token' => 'ETH',
                    'network_name' => 'mainnet',
                    'chain' => 'ethereum',
                    'wallet_id' => 'a75e390f-7e0c-42f6-9d87-0c87b4e4e13c',
                    'asset_id' => '09b86ad3-c84a-4683-a528-08a1e3fd03d3'
                ],
                [
                    'network' => 'ETH',
                    'token' => 'USDC',
                    'network_name' => 'mainnet',
                    'chain' => 'ethereum',
                    'wallet_id' => 'a75e390f-7e0c-42f6-9d87-0c87b4e4e13c',
                    'asset_id' => 'e6582a24-a893-4de4-823f-1695f9fbea96'
                ],
                [
                    'network' => 'ETH',
                    'token' => 'USDT',
                    'network_name' => 'mainnet',
                    'chain' => 'ethereum',
                    'wallet_id' => 'a75e390f-7e0c-42f6-9d87-0c87b4e4e13c',
                    'asset_id' => '26e59d8e-c5e9-4e46-b586-3aa2d8285b7b'
                ],
                [
                    'network' => 'TRX',
                    'token' => 'TRX',
                    'network_name' => 'mainnet',
                    'chain' => 'tron',
                    'wallet_id' => '9e9668ab-143a-4b90-b60e-8fa0757f3929',
                    'asset_id' => '7f384a5b-8496-4d5e-abdd-80cc7d82054f'
                ],
                [
                    'network' => 'TRX',
                    'token' => 'USDT',
                    'network_name' => 'mainnet',
                    'chain' => 'tron',
                    'wallet_id' => '9e9668ab-143a-4b90-b60e-8fa0757f3929',
                    'asset_id' => 'b8f91684-401b-456c-8cc3-df3283f160a2'
                ],
                [
                    'network' => 'TRX',
                    'token' => 'USDC',
                    'network_name' => 'mainnet',
                    'chain' => 'tron',
                    'wallet_id' => '9e9668ab-143a-4b90-b60e-8fa0757f3929',
                    'asset_id' => '0f8f5cab-1dbe-4065-b0ec-ba047b51e8b4'
                ],
                [
                    'network' => 'SOL',
                    'token' => 'SOL',
                    'network_name' => 'mainnet',
                    'chain' => 'solana',
                    'wallet_id' => '53e2656b-d3d0-477f-a8d7-985b8e3d9eab',
                    'asset_id' => 'b4ff2503-c4c4-41c9-8f91-efc80124026b'
                ],
                [
                    'network' => 'SOL',
                    'token' => 'USDT',
                    'network_name' => 'mainnet',
                    'chain' => 'solana',
                    'wallet_id' => '53e2656b-d3d0-477f-a8d7-985b8e3d9eab',
                    'asset_id' => '4844732a-001c-46cd-aecd-3c86a760ac6d'
                ],
                [
                    'network' => 'SOL',
                    'token' => 'USDC',
                    'network_name' => 'mainnet',
                    'chain' => 'solana',
                    'wallet_id' => '53e2656b-d3d0-477f-a8d7-985b8e3d9eab',
                    'asset_id' => '362ea2ac-bf99-4fdd-a3ad-fd017fb43950'
                ],
                [
                    'network' => 'BTC',
                    'token' => 'BTC',
                    'network_name' => 'mainnet',
                    'chain' => 'bitcoin',
                    'wallet_id' => '01437e3a-8088-4939-8d9b-0bf929a3739a',
                    'asset_id' => '2ec4a0f0-b0a4-410a-b6ab-ebec9397826c'
                ]
            ];
        } else {
            $data = [
                [
                    'network' => 'ETH',
                    'token' => 'ETH',
                    'network_name' => 'sepolia',
                    'chain' => 'ethereum',
                    'wallet_id' => '91f0d5f6-fdbc-4d7b-b97f-7764eb127b48',
                    'asset_id' => 'fa54d9c3-1ec9-4a8c-93a8-9d5faf3f51e6'
                ],
                [
                    'network' => 'ETH',
                    'token' => 'USDC',
                    'network_name' => 'sepolia',
                    'chain' => 'ethereum',
                    'wallet_id' => '91f0d5f6-fdbc-4d7b-b97f-7764eb127b48',
                    'asset_id' => 'ea6fce42-6969-4826-93cf-b3b0943315b8'
                ],
                [
                    'network' => 'TRX',
                    'token' => 'TRX',
                    'network_name' => 'shasta',
                    'chain' => 'tron',
                    'wallet_id' => 'aa1922f6-aea5-4c45-b093-c07bc516678a',
                    'asset_id' => '9f2d61cf-e431-4578-97c1-1501e5a699d1'
                ],
                [
                    'network' => 'TRX',
                    'token' => 'USDT',
                    'network_name' => 'shasta',
                    'chain' => 'tron',
                    'wallet_id' => 'aa1922f6-aea5-4c45-b093-c07bc516678a',
                    'asset_id' => '25c9e965-93e7-4abe-b010-b8c88e3cb67b'
                ],
                [
                    'network' => 'SOL',
                    'token' => 'SOL',
                    'network_name' => 'devnet',
                    'chain' => 'solana',
                    'wallet_id' => '43538012-bf78-420e-8e2f-35b7aa450253',
                    'asset_id' => '202b1812-5eae-4348-a223-fe735312e182'
                ],
                [
                    'network' => 'SOL',
                    'token' => 'USDC',
                    'network_name' => 'devnet',
                    'chain' => 'solana',
                    'wallet_id' => '43538012-bf78-420e-8e2f-35b7aa450253',
                    'asset_id' => 'd33ab677-7b67-418a-9d23-3ee32ce0eee6'
                ],
                [
                    'network' => 'BTC',
                    'token' => 'BTC',
                    'network_name' => 'testnet4',
                    'chain' => 'bitcoin',
                    'wallet_id' => '668c4fa6-975e-4d58-b7e5-49551821a384',
                    'asset_id' => '1398c500-7bef-4685-b482-01249e820300'
                ]
            ];
        }
        return $data;
    }

    public function fetchWalletId(string $token, string $network): array
    {
        return collect($this->walletData())->where('token', $token)->where('network', $network)->first();
    }

    public function generateAddress(string $walletId, string $label): array
    {
        return $this->post("/wallets/{$walletId}/address", [
            'label' => $label,
            'auto_sweep_enabled' => true
        ]);
    }

    public function payout(string $walletId, string $assetId, string $toAddress, float $amount, string $reference): array
    {
        return $this->post("/wallets/{$walletId}/send", [
            'to_address' => $toAddress,
            'asset_id' => $assetId,
            'amount' => $amount,
            'idempotency_key' => $reference
        ]);
    }

    public function estimateGasFee(string $token, string $chain, string $network_name, float $amount): array
    {
        return $this->get("/fees/estimate", [
            'token' => $token,
            'chain' => $chain,
            'network' => $network_name,
            'amount' => $amount,
        ]);
    }

    public function verifyWebhookSignature(string $rawBody, string $signatureHeader): bool
    {
        // Parse "t=<unix>,v1=<hex>"
        $parts = [];
        foreach (explode(',', $signatureHeader) as $segment) {
            [$k, $v] = array_pad(explode('=', $segment, 2), 2, null);
            $parts[trim($k)] = $v;
        }

        $timestamp = $parts['t'] ?? null;
        $provided  = $parts['v1'] ?? null;
        if (!$timestamp || !$provided) {
            return false;
        }

        // Replay protection — reject signatures older than 5 min
        if (abs(time() - (int) $timestamp) > 300) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $rawBody, $this->webhook_hash);

        return hash_equals($expected, $provided);
    }

    private function generateHMACAuth(array $body)
    {
        $timestamp = (string) time();
        $requestId = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
        $bodyString = $body ? json_encode($body) : '';

        $payload = "{$timestamp}:{$requestId}:{$bodyString}";
        $signature = hash_hmac('sha256', $payload, $this->secretKey);

        return [
            'X-API-Key' => $this->apiKey,
            'X-Timestamp' => $timestamp,
            'X-Request-ID' => $requestId,
            'X-Signature' => $signature
        ];
    }

    private function get(string $path, array $query = []): array
    {
        try {
            $request = $this->client([]);
            return $this->handle(empty($query) ? $request->get($path) : $request->get($path, $query));
        } catch (\Throwable $e) {
            return $this->failure($e);
        }
    }

    private function post(string $path, array $payload): array
    {
        try {
            return $this->handle($this->client($payload ?? [])->post($path, $payload));
        } catch (\Throwable $e) {
            return $this->failure($e);
        }
    }

    private function client(array $payload): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->asJson()
            ->acceptJson()
            ->withHeaders($this->generateHMACAuth($payload));
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
                'error' => $body['message'] ?? $response->body() ?: 'Request failed',
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
