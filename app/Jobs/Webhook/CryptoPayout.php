<?php

namespace App\Jobs\Webhook;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookServer\WebhookCall;

class CryptoPayout implements ShouldQueue
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
                'currency' => $this->data->currency,
                'amount' => (float) number_format($this->data->amount, 2, '.', ''),
                'charge' => (float) number_format($this->data->charge, 2, '.', ''),
                'total' => (float) number_format(($this->data->charge + $this->data->amount), 2, '.', ''),
                'status' => $this->data->status,
                'mode' => $this->data->mode,
                'wallet_address' => $this->data->wallet_address,
                'asset_id' => $this->data->crypto_wallet_id,
                'address_id' => $this->data->crypto_account_id,
                'external_reference' => $this->data->external_reference,
                'balance' => [
                    'old_balance' => (float) $this->data->balance_before,
                    'new_balance' => (float) $this->data->balance_after,
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
