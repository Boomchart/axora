<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MonitorUsers;
use App\Models\User;
use App\Models\Settings;

class BlockIPs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $set = Settings::find(1);
        if ($set->firewall == 1) {
            $blockedIps = [];
            if (!empty(cache()->get('blockedIps'))) {
                $blockedIps = cache()->get('blockedIps');
            } else {
                $value = cache()->rememberForever('blockedIps', function () use ($blockedIps) {
                    foreach (MonitorUsers::whereWhitelist(0)->select('ip_address')->get() as $dd) {
                        $blockedIps[] = $dd->ip_address;
                    }
                    return $blockedIps;
                });
                $blockedIps = $value;
            }

            $bannedEmails = [];

            if (!empty(cache()->get('bannedEmails'))) {
                $bannedEmails = cache()->get('bannedEmails');
            } else {
                $value = cache()->rememberForever('bannedEmails', function () use ($bannedEmails) {
                    foreach (User::whereBan(1)->select('email')->withTrashed()->get() as $dd) {
                        if (MonitorUsers::whereEmail($dd->email)->whereWhitelist(0)->exists() == true) {
                            $bannedEmails[] = str_replace('@deleted', '', $dd->email);
                        }
                    }
                    return $bannedEmails;
                });
                $bannedEmails = $value;
            }

            $bannedPhones = [];
            if (!empty(cache()->get('bannedPhones'))) {
                $bannedPhones = cache()->get('bannedPhones');
            } else {
                $value = cache()->rememberForever('bannedPhones', function () use ($bannedPhones) {
                    foreach (User::whereBan(1)->select('phone')->withTrashed()->get() as $dd) {
                        if (MonitorUsers::whereEmail($dd->phone)->whereWhitelist(0)->exists() == true) {
                            $bannedPhones[] = str_replace('@deleted', '', $dd->phone);
                        }
                    }
                    return $bannedPhones;
                });
                $bannedPhones = $value;
            }

            while (($index = array_search('::1', $blockedIps)) !== false) {
                unset($blockedIps[$index]);
            }

            if (!in_array(user_ip(), $blockedIps)) {
                return $next($request);
            } else {
                return redirect()->route('firewall');
            }

            if (!in_array($request->email, $bannedEmails)) {
                return $next($request);
            } else {
                return redirect()->route('firewall');
            }            

        }else{
            return $next($request);
        }
    }
}
