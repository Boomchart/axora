<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;
use Illuminate\Support\Str;

class Index extends Component
{
    public $user;
    public $type;
    public $timezone;
    public $webhook_url;
    public $webhook_secret;
    public $api_key;
    public $test_api_key;
    public $ip_whitelisting;
    public $ipv6_whitelisting;
    public $settings;
    public $hide_live = 1;
    public $hide_test = 1;

    protected $listeners = ['saved' => '$refresh'];

    public function testStatus()
    {
        if ($this->hide_test == 1) {
            $this->hide_test = 0;
        } else {
            $this->hide_test = 1;
        }
    }

    public function liveStatus()
    {
        if ($this->hide_live == 1) {
            $this->hide_live = 0;
        } else {
            $this->hide_live = 1;
        }
    }

    public function mount()
    {
        $this->timezone = $this->user->user_timezone;
        if ($this->type == 'api') {
            $this->webhook_url = $this->user->business->webhook_url;
            $this->webhook_secret = $this->user->business->webhook_secret;
            $this->api_key = $this->user->business->api_key;
            $this->test_api_key = $this->user->business->test_api_key;
            $this->ip_whitelisting = $this->user->business->ip_whitelisting;
            $this->ipv6_whitelisting = $this->user->business->ipv6_whitelisting;
        }
    }

    public function profile()
    {
        $this->user->update([
            'user_timezone' => $this->timezone
        ]);
        $this->emit('success', __('Account updated'));
    }

    public function webhookUpdate()
    {
        $this->validate([
            'webhook_url' => ['nullable', 'url'],
            'webhook_secret' => [($this->webhook_url == null) ? 'nullable' : 'required', 'string', 'max:255'],
            'ip_whitelisting' => ['nullable'],
            'ipv6_whitelisting' => ['nullable'],
        ]);

        if ($this->ip_whitelisting) {
            foreach (explode(',', formatTag($this->ip_whitelisting)) as $ip) {
                if (isValidIPv4(trim($ip)) == false) {
                    return $this->addError('ip_whitelisting', $ip . ' ' . __('is not a valid ipv4 address'));
                }
            }
        }
        if ($this->ipv6_whitelisting) {
            foreach (explode(',', formatTag($this->ipv6_whitelisting)) as $ip) {
                if (isValidIPv6(trim($ip)) == false) {
                    return $this->addError('ipv6_whitelisting', $ip . ' ' . __('is not a valid ipv6 address'));
                }
            }
        }

        $this->user->business->update([
            'webhook_url' => $this->webhook_url,
            'webhook_secret' => $this->webhook_secret,
            'ip_whitelisting' => $this->ip_whitelisting,
            'ipv6_whitelisting' => $this->ipv6_whitelisting,
        ]);
        $this->emit('saved');
        $this->emit('success', __('Account updated'));
    }

    public function generate()
    {
        $this->user->business->update([
            'api_key' => encryptRSA(Str::random(30)),
            'test_api_key' => Str::random(30)
        ]);
        $this->api_key = $this->user->business->api_key;
        $this->test_api_key = $this->user->business->test_api_key;
        $this->emit('saved');
        $this->emit('success', __('Keys updated'));
    }

    public function generateWebhookSecret()
    {
        $result = '';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 10;

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, strlen($characters) - 1)];
        }
        $this->webhook_secret = $result;

        $this->user->business->update([
            'webhook_secret' => $result,
        ]);
    }

    public function render()
    {
        return view('livewire.user.settings.index');
    }
}
