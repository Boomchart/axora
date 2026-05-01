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

class Giftcard implements ShouldQueue
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
            'event' => 'giftcard',
            'data' => [
                'id' => $this->issue->id,
                'external_reference' => $this->issue->external_reference,
                'card' => [
                    'id' => $this->issue->card_id,
                    'name' => $this->issue->card_name,
                    'amount' => $this->issue->amount,
                ],
                'payment' => [
                    'currency' => $this->issue->currency,
                    'rate' => $this->issue->rate,
                    'amount' => (float) number_format($this->issue->amount * $this->issue->rate, 2, '.', ''),
                    'charge' => (float) number_format($this->issue->rev_share + $this->issue->profit + $this->issue->vendor_share, 2, '.', ''),
                    'total' => (float) number_format(($this->issue->rev_share + $this->issue->profit + $this->issue->vendor_share) + ($this->issue->amount * $this->issue->rate), 2, '.', '')
                ],
                'customer' => [
                    'name' => $this->issue->name,
                    'email' => $this->issue->email,
                    'phone' => $this->issue->phone,
                    'phone_code' => $this->issue->phone_code,
                ],
                'status' => $this->issue->status,
                'redeem_code' => [
                    'url' => !empty(decryptRSA($this->issue->card_url)) ? decryptRSA($this->issue->card_url) : null,
                    'card_code' => !empty(decryptRSA($this->issue->card_code)) ? decryptRSA($this->issue->card_code) : null,
                    'pin' => !empty(decryptRSA($this->issue->pin_code)) ? decryptRSA($this->issue->pin_code) : null,
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
