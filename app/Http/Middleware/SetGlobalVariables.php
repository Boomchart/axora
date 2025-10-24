<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;
use App\Models\PickupAgent;
use App\Models\Settings;

class SetGlobalVariables
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
        config()->set('recaptchav3.secret', $set->NOCAPTCHA_SECRET);
        config()->set('recaptchav3.sitekey', $set->NOCAPTCHA_SITEKEY);
        $request->attributes->set('set', $set);
        View::share('set', $request->attributes->get('set'));
        View::share('currency', $set->real);

        if (Auth::guard('admin')->check()) {
            $admin = Admin::find(Auth::guard('admin')->user()->id);
            if (!in_array($admin->timezone, timezone_identifiers_list())) {
                $admin->update([
                    'timezone' => 'UTC'
                ]);
            }
            $request->attributes->set('admin', $admin);
            View::share('admin', $request->attributes->get('admin'));
        }

        if (Auth::guard('user')->check()) {
            $user = User::find(Auth::guard('user')->user()->id);
            if (!in_array($user->user_timezone, timezone_identifiers_list())) {
                $user->update([
                    'user_timezone' => 'UTC'
                ]);
            }
            $request->attributes->set('user', $user);
            View::share('user', $request->attributes->get('user'));
        }
        return $next($request);
    }
}
