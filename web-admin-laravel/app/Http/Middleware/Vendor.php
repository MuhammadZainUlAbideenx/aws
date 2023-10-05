<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Vendor
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
      if (auth('vendor-api')->check() && auth('vendor-api')->user()->tokenCan('vendor')) {
        return $next($request);
      }
      else{
        return response()->json(['message' => 'unauthenticated'],401);
      }
    }
}
