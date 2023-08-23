<?php

namespace App\Http\Middleware;

use Closure;

class PostRequestHandel
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (env('APP_ENV') == 'local'){
            if ($request->isMethod('post')) {
                return back()->with('info', translate('this is for demo purpose only'));
            } else {
                return $next($request);
            }
        }else{
            return $next($request);
        }

    }
}
