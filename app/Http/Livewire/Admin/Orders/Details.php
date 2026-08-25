<?php

namespace App\Http\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\{Webhook, Balance};
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Details extends Component
{
    public $val;
    public $user;
    public $settings;

    public function resendWebhook(Webhook $webhook)
    {
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
                return $this->emit('success', __('Webhook Resent'));
            }
        }
        return $this->emit('alert', __('Resending Webhook Failed'));
    }

    public function retryOrder()
    {
        if ($this->val->status == 'pending' && $this->val->failed_order == 1 && $this->val->mode == 'live') {
            try {
                $newUuid = Str::uuid()->toString();

                DB::table('orders')->where('id', $this->val->id)
                    ->update([
                        'id' => $newUuid,
                        'failed_order' => 0,
                    ]);
            } catch (\Exception $e) {
                return $this->emit('alert', __('An error occurred, try again later'));
            }
            return $this->emit('success', __('Order retried'));
        } else {
            return $this->emit('alert', __('Order can\'t be retried'));
        }
    }

    public function markAsFailed()
    {
        if ($this->val->status == 'pending' && $this->val->failed_order == 1 && $this->val->mode == 'live') {
            try {
                DB::transaction(function () {
                    $this->val->update([
                        'status' => 'failed'
                    ]);
                    $balance = Balance::whereId($this->val->transaction->wallet_id)->first();
                    $balance->increment('amount', (($this->val->rev_share + $this->val->profit + $this->val->vendor_share) + ($this->val->amount * $this->val->rate)));
                }, 3);
            } catch (\Exception $e) {
                return $this->emit('alert', __('An error occurred, try again later'));
            }
            return $this->emit('success', __('Order retried'));
        } else {
            return $this->emit('alert', __('Only pending & live can be marked as failed'));
        }
    }

    public function render()
    {
        return view('livewire.admin.orders.details');
    }
}
