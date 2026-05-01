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

class Airtime implements ShouldQueue
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
            'event' => 'airtime',
            'data' => [
                'id' => $this->issue->id,
                'external_reference' => $this->issue->external_reference,
                'operator' => [
                    'id' => $this->issue->operator_id,
                    'name' => $this->issue->operator_name,
                    'amount' => $this->issue->amount,
                ],
                'payment' => [
                    'currency' => $this->issue->currency,
                    'rate' => $this->issue->rate,
                    'amount' => (float) number_format($this->issue->amount * $this->issue->rate, 2, '.', ''),
                    'charge' => (float) number_format($this->issue->rev_share + $this->issue->profit + $this->issue->vendor_share, 2, '.', ''),
                    'total' => (float) number_format(($this->issue->rev_share + $this->issue->profit + $this->issue->vendor_share) + ($this->issue->amount * $this->issue->rate), 2, '.', '')
                ],
                'status' => $this->issue->status,
                'customer' => [
                    'phone' => $this->issue->phone,
                    'phone_code' => $this->issue->phone_code,
                ],
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
