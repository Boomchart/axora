<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Settings;

class OTP
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
        if (auth()->guard('user')->user()->otp_required == "off") {
            return $next($request);
        } elseif (auth()->guard('user')->user()->otp_required == "on" && Settings::find(1)->otp_login == 0) {
            return $next($request);
        } elseif (auth()->guard('user')->user()->otp_required == "on" && Settings::find(1)->otp_login == 1) {
            return redirect()->route('verify.otp');
        }else {
            return $next($request);
        }
        return $next($request);
    }
}
