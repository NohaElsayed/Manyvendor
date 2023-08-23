<?php

namespace App\Http\Middleware;

use App\Models\AffiliateAccount;
use Closure;
use Illuminate\Support\Facades\Auth;

class affiliateNonApprovedUser
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
        $user = AffiliateAccount::where('user_id', Auth::user()->id)->first();

        $auth_user_type = Auth::user()->user_type;
        if($auth_user_type != "Admin" && $auth_user_type != "Vendor") {
            if (!is_null($user)) {
                if ($user->is_approved == 0) {
                    return $next($request);
                } else {
                    return redirect()->route('customers.affiliate.productLink');
                }
            } else {
                return $next($request);
            }
        }else{
            return redirect()->route('homepage');
        }
    }
}
