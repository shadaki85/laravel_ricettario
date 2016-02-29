<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Isadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     
     //checks if user is admin. return next request in true, redirect to home if false
    public function handle($request, Closure $next)
    {
        if (Auth::user()->isAdmin == 1){
            return $next($request);
        }
        else
        {
            return redirect()->route('home');
        }
    }
}
