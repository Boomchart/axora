<?php

namespace App\Jobs\Webhook;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Str;

class SimulateCryptoDeposit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;
    public $business;

    public function __construct($data, $business)
    {
        $this->data = $data;
        $this->business = $business;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'event' => 'crypto_deposit',
            'data' => [
                'id' => Str::uuid(),
                'token' => $this->data['token'],
                'network' => $this->data['network'],
                'amount' => expandScientificNotation($this->data['amount']),
                'charge' => expandScientificNotation(0),
                'total' => expandScientificNotation(($this->data['amount'])),
                'status' => $this->data['status'],
                'mode' => 'test',
                'wallet_address' => $this->data['wallet_address'],
                'asset_id' => $this->data['asset_id'],
                'address_id' => $this->data['address_id'],
                'balance' => [
                    'old_balance' => expandScientificNotation(0.00),
                    'new_balance' => expandScientificNotation($this->data['amount']),
                ],
                'created_at' => now(),
            ]
        ];
        WebhookCall::create()
            ->meta([
                'business_id' => $this->business->reference
            ])
            ->maximumTries(3)
            ->url($this->business->webhook_url)
            ->payload($data)
            ->useSecret($this->business->webhook_secret)
            ->dispatch();
    }
}
