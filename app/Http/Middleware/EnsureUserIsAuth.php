<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\http\Controllers\CookieController;

class EnsureUserIsAuth
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

        if (! $request->user()) {

            $coockieObj = new CookieController();
            $coockieObj->checkCookie($request);

            return $next($request);
        }
        
        return $next($request);
    }
}
