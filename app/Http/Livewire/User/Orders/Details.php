<?php

namespace App\Http\Livewire\User\Orders;

use Livewire\Component;
use App\Models\Webhook;
use Spatie\WebhookServer\WebhookCall;

class Details extends Component
{
    public $val;
    public $user;
    public $settings;

    public function resendWebhook(Webhook $webhook)
    {
        if (now()->setTimezone($this->user->user_timezone) < $webhook->resend_time) {
            return $this->emit('alert', __('You can resend webhook after') . ' ' . $webhook->resend_time->setTimezone($this->user->user_timezone)->toDayDateTimeString());
        }

        if ($webhook->business_id) {
            if ($webhook->business->webhook_url != null) {
                WebhookCall::create()
                    ->meta([
                        'business_id' => $webhook->business->reference
                    ])
                    ->maximumTries(3)
                    ->url($webhook->business->webhook_url)
                    ->payload(json_decode($webhook->payload, true))
                    ->useSecret($webhook->business->webhook_secret)->dispatch();
                $webhook->update([
                    'resend_time' => now()->addHour(1)
                ]);
                return $this->emit('success', __('Webhook Resent'));
            }
        }
        return $this->emit('alert', __('Resending Webhook Failed'));
    }

    public function render()
    {
        return view('livewire.user.orders.details');
    }
}
