<?php

namespace App\Jobs\Webhook;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookServer\WebhookCall;

class Redemption implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;
    public $issue;

    public function __construct($data, $issue)
    {
        $this->data = $data;
        $this->issue = $issue;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'event' => 'redemption',
            'data' => [
                'id' => $this->data['id'],
                'card_id' => $this->data['card_id'],
                'name' => $this->data['name'],
                'processed_amount' => $this->data['processed_amount'],
                'balance' => $this->data['balance'],
                'card_code' => $this->data['card_code'],
                'card_url' => $this->data['card_url'],
                'expires' => $this->data['expires'],
                'mode' => $this->data['mode']
            ]
        ];
        WebhookCall::create()
            ->meta([
                'business_id' => $this->issue->business_id
            ])
            ->maximumTries(3)
            ->url($this->issue->business->webhook_url)
            ->payload($data)
            ->useSecret($this->issue->business->webhook_secret)
            ->dispatch();
    }
}
