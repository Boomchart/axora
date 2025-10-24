<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Carbon\Carbon;

class AdminTfa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = auth()->guard('admin')->user();
        if ($admin->fa_status == 1 && $admin->fa_expiring > Carbon::now()) {
            return $next($request);
        } elseif ($admin->fa_status == 1 && $admin->fa_expiring < Carbon::now()) {
            return redirect()->route('admin.2fa');
        } else {
            return $next($request);
        }
    }
}
