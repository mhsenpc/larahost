<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoUserCheckAction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->email == 'demo@lara-host.ir' && !\auth()->user()->is_admin ){
            abort(403,"Demo account is not permitted to access this function");
        }
        else{
            return $next($request);
        }
    }
}
