<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use App\User;

class Token
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
        $check = User::where('token', $request->token)->get();

        if(count($check)){
          return $next($request);
        }

        else{
          return response()->json(['status' => 403, 'description' => 'Akses gagal !']);
        }
    }
}
