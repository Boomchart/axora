<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        if($role != null){
            $type = [
                'profile' => auth()->guard('admin')->user()->profile,
                'promo' => auth()->guard('admin')->user()->promo,
                'support' => auth()->guard('admin')->user()->support,
                'news' => auth()->guard('admin')->user()->news,
                'message' => auth()->guard('admin')->user()->message,
                'knowledge_base' => auth()->guard('admin')->user()->knowledge_base,
                'email_configuration' => auth()->guard('admin')->user()->email_configuration,
                'general_settings' => auth()->guard('admin')->user()->general_settings,
                'firewall' => auth()->guard('admin')->user()->firewall,
                'deposit' => auth()->guard('admin')->user()->deposit,
                'payout' => auth()->guard('admin')->user()->payout,
                'giftcard' => auth()->guard('admin')->user()->giftcard,
            ];
            if (auth()->guard('admin')->user()->role == "super") {
                return $next($request);
            } elseif ($type[$role] == 1) {
                return $next($request);
            } else {
                abort(403);
            }
        }else{
            if (auth()->guard('admin')->user()->role == "super") {
                return $next($request);
            } else {
                abort(403);
            }
        }
    }
}
