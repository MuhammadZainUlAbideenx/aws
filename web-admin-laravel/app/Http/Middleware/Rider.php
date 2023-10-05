<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Rider
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
      if (auth('rider-api')->check() && auth('rider-api')->user()->tokenCan('rider')) {
        return $next($request);
      }
      else{
        return response()->json(['message' => 'unauthenticated'],401);
      }
    }
}
