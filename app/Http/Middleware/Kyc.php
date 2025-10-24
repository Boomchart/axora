<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Settings;
use App\Models\Compliance;

use Auth;
class Kyc
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
        $user = User::find(auth()->guard('user')->user()->id);
        if($user->business->kyc_status=="APPROVED"){
            return $next($request);
        }else{
            return redirect()->route('user.compliance', ['type' => 'personal']);
        }
    }
}
