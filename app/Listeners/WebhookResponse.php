<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Webhook;

class WebhookResponse
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $payload = json_encode($event->payload);

        $reference = json_decode($payload, true);

        Webhook::create([
            'uuid' => $event->uuid,
            'business_id' => $event->meta['business_id'],
            'url' => $event->webhookUrl,
            'payload' => $payload,
            'reference' => $reference['data']['id'],
            'mode' => $reference['data']['mode'],
            'response' => json_encode($event->response),
            'headers' => json_encode($event->headers),
            'response_status_code' => $event->response->getStatusCode(),
            'attempts' => $event->attempt,
            'resend_time' => now()->addHour(1)
        ]);
    }
}
