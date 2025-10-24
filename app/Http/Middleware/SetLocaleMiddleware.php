<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Settings;

class SetLocaleMiddleware
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
        if ($request->is($set->admin_url.'/*') && auth()->guard('admin')->check()) {
            App::setLocale($set->admin_language);
        } 

        if ($request->is('user/*') && auth()->guard('user')->check()) {
            App::setLocale(auth()->guard('user')->user()->language);
        } 

        return $next($request);
    }
}
