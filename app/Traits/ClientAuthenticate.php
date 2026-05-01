<?php

namespace App\Traits;

use App\Models\ApiLogs;
use App\Models\Business;
use Illuminate\Support\Facades\App;

trait ClientAuthenticate
{
    public $client;
    public $mode;
    public $bearer_token;
    public $access = false;
    public $ip_pass = 0;
    public $log = null;
    public $security_check;
    public $idempotency_key;

    private function verifyToken($token): void
    {
        try {
            if (Business::where('api_key', '=', $token->bearerToken())->whereNotNull('api_key')->whereRelation('user', 'status', '=', 0)->exists()) {
                $business = Business::where('api_key', '=', $token->bearerToken())->first();
                $this->bearer_token = $token->bearerToken();
                $this->idempotency_key = $token->header('Idempotency-Key');
                $this->access = ($business?->kyc_status == 'APPROVED') ? true : false;
                $this->mode = 'live';
                $this->client = $business;
                if ($business->ip_whitelisting == null && $business->ipv6_whitelisting == null) {
                    $this->ip_pass = 1;
                }
                if ($business->ip_whitelisting) {
                    $this->ip_pass = (in_array(request()->ip(), explode(',', formatTag($business->ip_whitelisting)))) ? 1 : 0;
                }
                if ($business->ipv6_whitelisting) {
                    $this->ip_pass = (in_array(request()->ip(), explode(',', formatTag($business->ipv6_whitelisting)))) ? 1 : 0;
                }
            } elseif (Business::where('test_api_key', '=', $token->bearerToken())->whereNotNull('test_api_key')->whereRelation('user', 'status', '=', 0)->exists()) {
                $business = Business::where('test_api_key', '=', $token->bearerToken())->first();
                $this->bearer_token = $token->bearerToken();
                $this->idempotency_key = $token->header('Idempotency-Key');
                $this->access = true;
                $this->mode = 'test';
                $this->client = $business;
                if ($business->ip_whitelisting == null && $business->ipv6_whitelisting == null) {
                    $this->ip_pass = 1;
                }
                if ($business->ip_whitelisting) {
                    $this->ip_pass = (in_array(request()->ip(), explode(',', formatTag($business->ip_whitelisting)))) ? 1 : 0;
                }
                if ($business->ipv6_whitelisting) {
                    $this->ip_pass = (in_array(request()->ip(), explode(',', formatTag($business->ipv6_whitelisting)))) ? 1 : 0;
                }
                App::setLocale($business->user->language);
            }
        } catch (\Exception $exception) {
        }
    }

    private function ipCheck()
    {
        if ($this->ip_pass === 0) {
            $this->logError(403, ['message' => __('Invalid IP Address'), 'status' => 'failed', 'data' => null]);
            $this->security_check = __('Invalid IP Address');
            return;
        }
        if ($this->idempotency_key == null) {
            $this->logError(403, ['message' => __('Idempotency-Key is required in Header'), 'status' => 'failed', 'data' => null]);
            $this->security_check = __('Idempotency-Key is required in Header');
            return;
        } elseif (strlen($this->idempotency_key) > 50) {
            $this->logError(403, ['message' => __('Idempotency-Key must not exceed 50 characters'), 'status' => 'failed', 'data' => null]);
            $this->security_check = __('Idempotency-Key must not exceed 50 characters');
            return;
        } elseif (ApiLogs::whereIdempotencyKey($this->idempotency_key)->exists()) {
            $this->logError(403, ['message' => __('Idempotency-Key is already used'), 'status' => 'failed', 'data' => null]);
            $this->security_check = __('Idempotency-Key is already used');
        }
    }

    private function logError($status, $message = null)
    {
        $this->log = ApiLogs::create([
            'business_id' => $this->client->reference,
            'url' => request()->fullUrl(),
            'mode' => $this->mode,
            'method' => request()->method(),
            'ip_address' => request()->header('cf-connecting-ip') ?? request()->ip(),
            'origin_host' => request()->headers->get('origin', 'unknown'),
            'payload' => request()->getContent(),
            'idempotency_key' => $this->idempotency_key
        ]);

        $this->log?->update([
            'status_code' => $status,
            'message' => (is_array($message) == false) ? $message : json_encode($message ?? [])
        ]);

        if ($status == 500) {
            $data = "Error: " . $message;
            $data .= "</br>";
            $data .= "URL: " . $this->log->url;
            $data .= "</br>";
            $data .= "Method: " . $this->log->method;
            $data .= "</br>";
            $data .= "Mode: " . $this->log->mode;

            foreach (\App\Models\Admin::whereStatus(0)->whereApiError(1)->get() as $admin) {
                dispatch(new \App\Jobs\SendEmail(
                    (($admin->role == 'super') ? $this->settings->support_email : $admin->email),
                    (($admin->role == 'super') ? $this->settings->site_name : $admin->username),
                    __('Error on Azora API'),
                    $data,
                    null,
                    null,
                    0
                ));
            }
        }
    }
}
