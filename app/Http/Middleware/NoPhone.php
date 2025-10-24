<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoPhone
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
        if (auth()->guard('user')->user()->phone != null) {
            return $next($request);
        } else {
            return redirect()->route('user.no-phone');
        }
    }
}
