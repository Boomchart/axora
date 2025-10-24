<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;

class Phone
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
        if ($set->phone_verify == 1) {
            if (auth()->guard('user')->user()->phone_verify == 1) {
                return $next($request);
            } else {
                return redirect()->route('user.add-phone');
            }
        }else {
            return $next($request);
        }
    }
}
