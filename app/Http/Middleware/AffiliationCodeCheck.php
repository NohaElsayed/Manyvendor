<?php

namespace App\Http\Middleware;

use App\Models\AffiliateAccount;
use Closure;
use Illuminate\Support\Facades\Auth;

class AffiliationCodeCheck
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
        if($request->has('ref')){
            $response = $next($request);
            /*here check the refer id and auth user is same or not*/
            $affiliate =  AffiliateAccount::where('affiliation_code',$request->ref)->where('user_id',Auth::id())->first();
            if ($affiliate){
                return $next($request);
            }else{
                return $response->withCookie(cookie('ref', $request->ref, cookiesLimit()));
            }
        }else{
            return $next($request);
        }
    }
}
