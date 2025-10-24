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

    private function verifyToken($token): void
    {
        try {
            if (Business::where('api_key', '=', $token->bearerToken())->whereNotNull('api_key')->whereRelation('user', 'status', '=', 0)->exists()) {
                $business = Business::where('api_key', '=', $token->bearerToken())->first();
                $this->bearer_token = $token->bearerToken();
                $this->access = ($business?->kyc_status == 'APPROVED') ? true : false;
                $this->mode = 'live';
                $this->client = $business;
                if ($business->ip_whitelisting == null && $business->ipv6_whitelisting == null) {
                    $this->ip_pass == 1;
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
                $this->access = true;
                $this->mode = 'test';
                $this->client = $business;
                if ($business->ip_whitelisting == null && $business->ipv6_whitelisting == null) {
                    $this->ip_pass == 1;
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
            return response()->json(['message' => __('Invalid IP Address'), 'status' => 'failed', 'data' => null], 403);
        }
    }

    private function logError($status, $message = null)
    {
        $this->log = ApiLogs::create([
            'business_id' => $this->client->reference,
            'url' => request()->fullUrl(),
            'mode' => $this->mode,
            'method' => request()->method(),
            'ip_address' => request()->ip(),
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
                    __('Error on Axora API'),
                    $data,
                    null,
                    null,
                    0
                ));
            }
        }
    }
}
