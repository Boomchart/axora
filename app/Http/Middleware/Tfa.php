<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class Tfa
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
        $user = auth()->guard('user')->user();
        if($user->id != $user->business->user_id){
            return $next($request);
        }else{
            if($user->business->fa_status == 0){
                return redirect()->route('register');
            }else{
                if ($user->business->fa_status == 1 && $user->business->fa_expiring > Carbon::now()) {
                    return $next($request);
                } elseif ($user->business->fa_status == 1 && $user->business->fa_expiring < Carbon::now()) {
                    return redirect()->route('2fa');
                }
            }
        }
    }
}
