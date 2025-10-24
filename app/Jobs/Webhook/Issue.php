<?php

namespace App\Jobs\Webhook;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookServer\WebhookCall;
use App\Models\Webhook;

class Issue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $issue;
    public $resend;

    public function __construct($issue, $resend = false)
    {
        $this->issue = $issue;
        $this->resend = $resend;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'event' => 'issued',
            'data' => [
                'id' => $this->issue->id,
                'card_id' => $this->issue->card_id,
                'name' => $this->issue->name,
                'amount' => $this->issue->amount,
                'currency' => $this->issue->currency,
                'rate' => (float)number_format($this->issue->rate, 5, '.', ''),
                'value' => (float)number_format($this->issue->amount * $this->issue->rate, 2, '.', ''),
                'status' => $this->issue->status,
                'card_code' => $this->issue->card_code,
                'card_url' => $this->issue->card_url,
                'expires' => $this->issue->expires,
                'mode' => $this->issue->mode
            ]
        ];

        if (Webhook::whereReference($this->issue->id)->whereStatus($this->issue?->status)->whereMode($this->issue?->mode)->exists() == false || $this->resend == true) {
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
}
