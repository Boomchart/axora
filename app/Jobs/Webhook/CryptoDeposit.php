<?php

namespace App\Jobs\Webhook;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookServer\WebhookCall;

class CryptoDeposit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
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
                'id' => $this->data->id,
                'token' => $this->data->token,
                'network' => $this->data->network,
                'amount' => expandScientificNotation($this->data->amount),
                'charge' => expandScientificNotation($this->data->charge),
                'total' => expandScientificNotation(($this->data->charge + $this->data->amount)),
                'status' => $this->data->status,
                'mode' => $this->data->mode,
                'wallet_address' => $this->data->wallet_address,
                'asset_id' => $this->data->crypto_wallet_id,
                'address_id' => $this->data->crypto_account_id,
                'balance' => [
                    'old_balance' => expandScientificNotation($this->data->balance_before),
                    'new_balance' => expandScientificNotation($this->data->balance_after),
                ],
                'created_at' => $this->data->created_at,
            ]
        ];
        WebhookCall::create()
            ->meta([
                'business_id' => $this->data->business_id
            ])
            ->maximumTries(3)
            ->url($this->data->business->webhook_url)
            ->payload($data)
            ->useSecret($this->data->business->webhook_secret)
            ->dispatch();
    }
}
