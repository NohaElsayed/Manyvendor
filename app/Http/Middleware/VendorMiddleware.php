<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Auth;
use Alert;

class VendorMiddleware
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
        return $next($request);
        //form data
        $addon_name = $request->addon_name;
        $token = '0eZScyN9HOoPHzKSJMtWI8U1d7VwkApX';
        $purchase_code = $request->purchase_code;
        $url = 'https://api.envato.com/v3/market/buyer/purchase?code='.$purchase_code;
        $response = Http::withToken($token)->get($url);

        
        
        try {

            /**
             * PAYTM
             */
                if ($addon_name == "paytm") {
                    if ($purchase_code == $response['code']) {
                        return $next($request);
                    }
                }

            /**
             * PRODUCT EXPORT IMPORT
             */

            if ($addon_name == "product_export_import") {
                if ($purchase_code == $response['code']) {
                    return $next($request);
                }
            }

            /**
             * SSL COMMERZ
             */

            if ($addon_name == "ssl_commerz") {
                if ($purchase_code == $response['code']) {
                    return $next($request);
                }
            }
        //END

        } catch (\Throwable $th) {
            Alert::toast(translate('Invalid purchase code'), translate('error'));
            return back();
        }

        //END
    }
}
