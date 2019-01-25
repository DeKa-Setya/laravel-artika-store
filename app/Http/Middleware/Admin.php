<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class Admin
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
        if (Auth::user()->role_id == 1) {
          return $next($request);
        }
        elseif (Auth::user()->role_id == 2){
          return redirect('/employee/dashboard');
        }
        elseif (Auth::user()->role_id == 3){
          return redirect('/dashboard');
        }
        else{
          abort(404);
        }

    }
}
