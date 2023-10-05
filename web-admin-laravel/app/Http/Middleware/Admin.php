<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
      dd('coming');
      if (auth('admin-api')->check() && auth('admin-api')->user()->tokenCan('admin')) {
        return $next($request);
      }
      else{
        return response()->json(['message' => 'unauthenticated'],401);
      }
    }
}
